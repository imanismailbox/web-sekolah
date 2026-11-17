<?php

namespace Tests\Feature\Actions;

use App\Actions\DuplicatePkkmYear;
use App\Models\PkkmComponent;
use App\Models\PkkmEvidence;
use App\Models\PkkmIndicator;
use App\Models\PkkmItem;
use App\Models\PkkmYear;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DuplicatePkkmYearTest extends TestCase
{
    use RefreshDatabase;

    public function test_copies_instrument_structure_without_evidence(): void
    {
        $source = PkkmYear::factory()->create([
            'year' => 2025,
            'title' => 'PKKM Tahun 2025',
            'slug' => 'pkkm-tahun-2025',
            'is_published' => true,
        ]);
        $component = PkkmComponent::factory()->for($source, 'year')->create(['code' => 'A', 'name' => 'Usaha Pengembangan Madrasah']);
        $item = PkkmItem::factory()->for($component, 'component')->create(['code' => '1.1']);
        $indicator = PkkmIndicator::factory()->for($item, 'item')->create(['number' => '1', 'expected_evidence' => 'Dokumen struktur']);
        PkkmEvidence::factory()->for($indicator, 'indicator')->create();

        $target = app(DuplicatePkkmYear::class)->handle($source, 2026);

        $this->assertSame('PKKM Tahun 2026', $target->title);
        $this->assertSame('pkkm-tahun-2026', $target->slug);
        $this->assertFalse($target->is_published);

        $copiedIndicator = $target->components->sole()->items->sole()->indicators->sole();
        $this->assertSame('A', $target->components->sole()->code);
        $this->assertSame('1.1', $target->components->sole()->items->sole()->code);
        $this->assertSame('Dokumen struktur', $copiedIndicator->expected_evidence);
        $this->assertNotSame($indicator->id, $copiedIndicator->id);
        $this->assertSame(0, $copiedIndicator->evidence()->count());
        $this->assertSame(1, $indicator->evidence()->count());
    }
}
