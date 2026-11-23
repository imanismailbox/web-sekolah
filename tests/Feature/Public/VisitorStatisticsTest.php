<?php

namespace Tests\Feature\Public;

use App\Models\VisitorLog;
use App\Services\VisitorStatistics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class VisitorStatisticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_page_records_visit_and_renders_footer_widget(): void
    {
        $response = $this->withHeader('User-Agent', 'Mozilla/5.0 TestBrowser')
            ->get(route('home'));

        $response->assertOk()
            ->assertSee('Statistik Pengunjung')
            ->assertSee('Online')
            ->assertSee('Hari Ini')
            ->assertSee('Bulan Ini')
            ->assertSee('Total')
            ->assertSeeInOrder([
                'data-visitor-stat="online"',
                '1',
                'data-visitor-stat="today"',
                '1',
                'data-visitor-stat="month"',
                '1',
                'data-visitor-stat="total"',
                '1',
            ], false);

        $this->assertDatabaseCount('visitor_logs', 1);
    }

    public function test_same_visitor_on_same_day_is_deduplicated_and_increments_hits(): void
    {
        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.10'])
            ->withHeader('User-Agent', 'Mozilla/5.0 SameVisitor')
            ->get(route('home'))
            ->assertOk();

        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.10'])
            ->withHeader('User-Agent', 'Mozilla/5.0 SameVisitor')
            ->get(route('contact'))
            ->assertOk();

        $this->assertDatabaseCount('visitor_logs', 1);
        $this->assertSame(2, VisitorLog::query()->first()?->hits);
    }

    public function test_summary_calculates_online_today_month_and_total_accurately(): void
    {
        $this->travelTo(Carbon::parse('2026-11-23 12:00:00'));

        // Active online visitor (2 minutes ago, today)
        VisitorLog::factory()->create([
            'visited_on' => '2026-11-23',
            'last_seen_at' => now()->subMinutes(2),
        ]);

        // Offline visitor from earlier today (20 minutes ago)
        VisitorLog::factory()->create([
            'visited_on' => '2026-11-23',
            'last_seen_at' => now()->subMinutes(20),
        ]);

        // Visitor from earlier this month
        VisitorLog::factory()->create([
            'visited_on' => '2026-11-05',
            'last_seen_at' => Carbon::parse('2026-11-05 09:00:00'),
        ]);

        // Visitor from a previous month
        VisitorLog::factory()->create([
            'visited_on' => '2026-10-15',
            'last_seen_at' => Carbon::parse('2026-10-15 10:00:00'),
        ]);

        $summary = app(VisitorStatistics::class)->summary();

        $this->assertSame([
            'online' => 1,
            'today' => 2,
            'month' => 3,
            'total' => 4,
        ], $summary);
    }

    public function test_bots_and_sitemap_requests_are_not_recorded(): void
    {
        $this->withHeader('User-Agent', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)')
            ->get(route('home'))
            ->assertOk();

        $this->withHeader('User-Agent', 'Mozilla/5.0 RegularBrowser')
            ->get(route('sitemap'))
            ->assertOk();

        $this->assertDatabaseCount('visitor_logs', 0);
    }

    public function test_returning_offline_visitor_updates_online_count(): void
    {
        $this->travelTo(Carbon::parse('2026-11-23 12:00:00'));

        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.25'])
            ->withHeader('User-Agent', 'Mozilla/5.0 ReturningUser')
            ->get(route('home'))
            ->assertOk();

        $this->travel(10)->minutes();
        app(VisitorStatistics::class)->forgetCache();

        $this->assertSame(0, app(VisitorStatistics::class)->summary()['online']);

        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.25'])
            ->withHeader('User-Agent', 'Mozilla/5.0 ReturningUser')
            ->get(route('contact'))
            ->assertOk();

        $summary = app(VisitorStatistics::class)->summary();

        $this->assertSame(1, $summary['online']);
        $this->assertSame(1, $summary['today']);
        $this->assertSame(1, $summary['total']);
    }
}
