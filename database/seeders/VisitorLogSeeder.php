<?php

namespace Database\Seeders;

use App\Models\VisitorLog;
use App\Services\VisitorStatistics;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

class VisitorLogSeeder extends Seeder
{
    public const int MONTHS = 6;

    public const int MIN_DAILY_VISITORS = 20;

    public const int MAX_DAILY_VISITORS = 50;

    private const int INSERT_CHUNK_SIZE = 500;

    /**
     * Seed visitor logs for the past 6 months with 20-50 random visitors per day.
     */
    public function run(): void
    {
        $now = now();
        $today = $now->copy()->startOfDay();
        $startDate = $today->copy()->subMonthsNoOverflow(self::MONTHS);

        $existingCounts = VisitorLog::query()
            ->whereBetween('visited_on', [$startDate->toDateString(), $today->toDateString()])
            ->selectRaw('visited_on, COUNT(*) as aggregate')
            ->groupBy('visited_on')
            ->pluck('aggregate', 'visited_on');

        $rows = [];

        foreach (CarbonPeriod::create($startDate, $today) as $date) {
            $visitedOn = $date->toDateString();
            $existing = (int) ($existingCounts[$visitedOn] ?? 0);

            if ($existing >= self::MIN_DAILY_VISITORS) {
                continue;
            }

            $target = random_int(self::MIN_DAILY_VISITORS, self::MAX_DAILY_VISITORS);
            $toCreate = $target - $existing;
            $maxSeconds = $date->isSameDay($now)
                ? max(0, (int) $today->diffInSeconds($now))
                : 86399;

            for ($i = 1; $i <= $toCreate; $i++) {
                $timestamp = $date->copy()->addSeconds(random_int(0, $maxSeconds))->toDateTimeString();

                $rows[] = [
                    'visitor_hash' => hash('sha256', "seed-visitor|{$visitedOn}|{$i}"),
                    'visited_on' => $visitedOn,
                    'last_seen_at' => $timestamp,
                    'hits' => random_int(1, 10),
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];

                if (count($rows) >= self::INSERT_CHUNK_SIZE) {
                    VisitorLog::query()->insertOrIgnore($rows);
                    $rows = [];
                }
            }
        }

        if ($rows !== []) {
            VisitorLog::query()->insertOrIgnore($rows);
        }

        app(VisitorStatistics::class)->forgetCache();
    }
}
