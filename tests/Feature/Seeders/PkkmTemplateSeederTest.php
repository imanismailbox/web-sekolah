<?php

namespace Tests\Feature\Seeders;

use App\Models\PkkmComponent;
use App\Models\PkkmIndicator;
use App\Models\PkkmItem;
use App\Models\PkkmYear;
use Database\Seeders\PkkmTemplateSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PkkmTemplateSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeds_complete_pkkm_instrument_structure(): void
    {
        $this->seed(PkkmTemplateSeeder::class);

        $year = PkkmYear::query()->where('year', now()->year)->sole();
        $year->load('components.items.indicators');

        $this->assertFalse($year->is_published);
        $this->assertCount(5, $year->components);
        $this->assertSame(29, PkkmItem::query()->count());
        $this->assertSame(108, PkkmIndicator::query()->count());

        $expectedCounts = [
            'A' => ['items' => 7, 'indicators' => 25],
            'B' => ['items' => 10, 'indicators' => 41],
            'C' => ['items' => 5, 'indicators' => 19],
            'D' => ['items' => 3, 'indicators' => 10],
            'E' => ['items' => 4, 'indicators' => 13],
        ];

        foreach ($expectedCounts as $code => $counts) {
            $component = $year->components->firstWhere('code', $code);

            $this->assertNotNull($component, "Component {$code} should exist.");
            $this->assertCount($counts['items'], $component->items, "Component {$code} item count mismatch.");
            $this->assertSame(
                $counts['indicators'],
                $component->items->sum(fn (PkkmItem $item): int => $item->indicators->count()),
                "Component {$code} indicator count mismatch.",
            );
        }

        $this->assertSame(
            0,
            PkkmIndicator::query()->where(function ($query): void {
                $query->whereNull('description')
                    ->orWhere('description', '')
                    ->orWhereNull('expected_evidence')
                    ->orWhere('expected_evidence', '');
            })->count(),
        );
    }

    public function test_seeder_is_idempotent_and_backfills_missing_indicators(): void
    {
        $year = PkkmYear::factory()->create(['year' => now()->year]);
        $component = PkkmComponent::factory()->for($year, 'year')->create([
            'code' => 'A',
            'name' => 'Usaha Pengembangan Madrasah',
            'sort' => 1,
        ]);
        PkkmItem::factory()->for($component, 'component')->create([
            'code' => '1.1',
            'name' => 'Mengembangkan madrasah sesuai dengan kebutuhan',
            'sort' => 1,
        ]);

        $this->seed(PkkmTemplateSeeder::class);
        $this->seed(PkkmTemplateSeeder::class);

        $this->assertSame(1, PkkmYear::query()->count());
        $this->assertSame(5, PkkmComponent::query()->count());
        $this->assertSame(29, PkkmItem::query()->count());
        $this->assertSame(108, PkkmIndicator::query()->count());
    }
}
