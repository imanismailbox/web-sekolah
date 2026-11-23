<?php

namespace Tests\Feature;

use App\Models\VisitorLog;
use App\Services\VisitorStatistics;
use Carbon\CarbonPeriod;
use Database\Seeders\VisitorLogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class VisitorLogSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_generates_20_to_50_daily_visitors_for_six_months(): void
    {
        $now = Carbon::parse('2026-11-23 13:30:00');
        $this->travelTo($now);

        $this->seed(VisitorLogSeeder::class);

        $startDate = $now->copy()->startOfDay()->subMonthsNoOverflow(VisitorLogSeeder::MONTHS);
        $endDate = $now->copy()->startOfDay();

        $dailyCounts = VisitorLog::query()
            ->selectRaw('visited_on, COUNT(*) as aggregate')
            ->groupBy('visited_on')
            ->pluck('aggregate', 'visited_on');

        $expectedDays = iterator_count(CarbonPeriod::create($startDate, $endDate));
        $this->assertCount($expectedDays, $dailyCounts);

        foreach (CarbonPeriod::create($startDate, $endDate) as $date) {
            $count = (int) ($dailyCounts[$date->toDateString()] ?? 0);

            $this->assertGreaterThanOrEqual(VisitorLogSeeder::MIN_DAILY_VISITORS, $count);
            $this->assertLessThanOrEqual(VisitorLogSeeder::MAX_DAILY_VISITORS, $count);
        }

        $this->assertSame(
            0,
            VisitorLog::query()->where('last_seen_at', '>', $now)->count(),
        );

        $summary = app(VisitorStatistics::class)->summary();

        $this->assertSame(VisitorLog::query()->count(), $summary['total']);
        $this->assertGreaterThanOrEqual(VisitorLogSeeder::MIN_DAILY_VISITORS, $summary['today']);
        $this->assertLessThanOrEqual(VisitorLogSeeder::MAX_DAILY_VISITORS, $summary['today']);
    }

    public function test_seeder_is_idempotent_when_run_multiple_times(): void
    {
        $this->travelTo(Carbon::parse('2026-11-23 13:30:00'));

        $this->seed(VisitorLogSeeder::class);
        $initialCount = VisitorLog::query()->count();

        $this->seed(VisitorLogSeeder::class);

        $this->assertSame($initialCount, VisitorLog::query()->count());
    }
}
