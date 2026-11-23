<?php

namespace App\Services;

use App\Models\VisitorLog;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class VisitorStatistics
{
    public const int ONLINE_WINDOW_MINUTES = 5;

    public const string CACHE_KEY = 'visitor_statistics.summary';

    public const int CACHE_TTL_SECONDS = 60;

    private const string BOT_PATTERN = '/bot|crawl|spider|slurp|mediapartners|facebookexternalhit|whatsapp|telegrambot|curl|wget|python-requests|go-http-client|headlesschrome|lighthouse|pingdom|uptimerobot/i';

    public function record(Request $request): void
    {
        if (! $this->shouldTrack($request)) {
            return;
        }

        $now = now();
        $visitedOn = $now->toDateString();
        $visitorHash = $this->fingerprint($request);

        $existing = VisitorLog::query()
            ->where('visitor_hash', $visitorHash)
            ->where('visited_on', $visitedOn)
            ->first();

        if ($existing !== null) {
            $wasOffline = $existing->last_seen_at === null
                || $existing->last_seen_at->lt($now->copy()->subMinutes(self::ONLINE_WINDOW_MINUTES));

            $existing->forceFill([
                'last_seen_at' => $now,
                'hits' => $existing->hits + 1,
            ])->save();

            if ($wasOffline) {
                $this->forgetCache();
            }

            return;
        }

        try {
            VisitorLog::query()->create([
                'visitor_hash' => $visitorHash,
                'visited_on' => $visitedOn,
                'last_seen_at' => $now,
                'hits' => 1,
            ]);
        } catch (UniqueConstraintViolationException) {
            VisitorLog::query()
                ->where('visitor_hash', $visitorHash)
                ->where('visited_on', $visitedOn)
                ->update([
                    'last_seen_at' => $now,
                    'hits' => DB::raw('hits + 1'),
                ]);
        }

        $this->forgetCache();
    }

    /**
     * @return array{online: int, today: int, month: int, total: int}
     */
    public function summary(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL_SECONDS, function (): array {
            $now = now();
            $today = $now->toDateString();
            $monthStart = $now->copy()->startOfMonth()->toDateString();
            $monthEnd = $now->copy()->endOfMonth()->toDateString();
            $onlineSince = $now->copy()->subMinutes(self::ONLINE_WINDOW_MINUTES)->toDateTimeString();

            $row = VisitorLog::query()
                ->selectRaw('COUNT(*) as total')
                ->selectRaw('SUM(CASE WHEN visited_on = ? THEN 1 ELSE 0 END) as today', [$today])
                ->selectRaw('SUM(CASE WHEN visited_on BETWEEN ? AND ? THEN 1 ELSE 0 END) as month', [$monthStart, $monthEnd])
                ->selectRaw('SUM(CASE WHEN last_seen_at >= ? THEN 1 ELSE 0 END) as online', [$onlineSince])
                ->first();

            return [
                'online' => (int) ($row?->online ?? 0),
                'today' => (int) ($row?->today ?? 0),
                'month' => (int) ($row?->month ?? 0),
                'total' => (int) ($row?->total ?? 0),
            ];
        });
    }

    public function forgetCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    private function shouldTrack(Request $request): bool
    {
        if (! $request->isMethod('GET')) {
            return false;
        }

        if ($request->ajax() || $request->expectsJson() || $request->headers->has('X-Livewire')) {
            return false;
        }

        $purpose = strtolower((string) ($request->header('Sec-Purpose') ?? $request->header('Purpose') ?? ''));
        if (str_contains($purpose, 'prefetch')) {
            return false;
        }

        $userAgent = (string) $request->userAgent();
        if ($userAgent !== '' && preg_match(self::BOT_PATTERN, $userAgent) === 1) {
            return false;
        }

        return true;
    }

    private function fingerprint(Request $request): string
    {
        return hash('sha256', ($request->ip() ?? 'unknown').'|'.($request->userAgent() ?? '').'|'.config('app.key'));
    }
}
