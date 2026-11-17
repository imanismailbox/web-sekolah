<?php

namespace Tests\Feature\Filament;

use App\Enums\EvidenceType;
use App\Filament\Resources\PkkmYears\Pages\EditPkkmYear;
use App\Filament\Resources\PkkmYears\Pages\ListPkkmYears;
use App\Filament\Resources\PkkmYears\RelationManagers\ComponentsRelationManager;
use App\Models\PkkmComponent;
use App\Models\PkkmItem;
use App\Models\PkkmYear;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Filament\Actions\Testing\TestAction;
use Filament\Forms\Components\Repeater;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PkkmYearResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);

        $this->actingAs(User::factory()->create()->assignRole('editor_pkkm'));
    }

    public function test_duplicate_action_creates_new_year_from_source(): void
    {
        $source = PkkmYear::factory()->create(['year' => 2025, 'slug' => 'pkkm-2025', 'title' => 'PKKM 2025']);
        PkkmItem::factory()->for(PkkmComponent::factory()->for($source, 'year'), 'component')->create();

        Livewire::test(ListPkkmYears::class)
            ->callAction('duplicate', data: ['source_id' => $source->id, 'year' => 2026])
            ->assertHasNoActionErrors();

        $target = PkkmYear::query()->where('year', 2026)->sole();
        $this->assertSame(1, $target->components()->count());
    }

    public function test_duplicate_action_rejects_existing_year(): void
    {
        $source = PkkmYear::factory()->create(['year' => 2025]);

        Livewire::test(ListPkkmYears::class)
            ->callAction('duplicate', data: ['source_id' => $source->id, 'year' => 2025])
            ->assertHasActionErrors(['year' => 'unique']);
    }

    public function test_component_is_created_with_items_indicators_and_link_evidence(): void
    {
        Repeater::fake();
        $year = PkkmYear::factory()->create();

        Livewire::test(ComponentsRelationManager::class, ['ownerRecord' => $year, 'pageClass' => EditPkkmYear::class])
            ->assertOk()
            ->callAction(TestAction::make('create')->table(), data: [
                'code' => 'A',
                'name' => 'Usaha Pengembangan Madrasah',
                'items' => [[
                    'code' => '1.1',
                    'name' => 'Mengembangkan madrasah sesuai kebutuhan',
                    'indicators' => [[
                        'number' => '1',
                        'description' => 'Mampu mengembangkan struktur organisasi',
                        'expected_evidence' => 'Dokumen struktur madrasah',
                        'evidence' => [[
                            'label' => 'Lihat',
                            'type' => EvidenceType::Link->value,
                            'url' => 'https://drive.google.com/file/d/abc/view',
                        ]],
                    ]],
                ]],
            ])
            ->assertHasNoActionErrors();

        $indicator = $year->components()->sole()->items()->sole()->indicators()->sole();
        $evidence = $indicator->evidence()->sole();

        $this->assertSame(EvidenceType::Link, $evidence->type);
        $this->assertSame('https://drive.google.com/file/d/abc/view', $evidence->href());
    }

    public function test_link_evidence_requires_url(): void
    {
        Repeater::fake();
        $year = PkkmYear::factory()->create();

        Livewire::test(ComponentsRelationManager::class, ['ownerRecord' => $year, 'pageClass' => EditPkkmYear::class])
            ->callAction(TestAction::make('create')->table(), data: [
                'code' => 'A',
                'name' => 'Komponen',
                'items' => [[
                    'code' => '1.1',
                    'name' => 'Unsur',
                    'indicators' => [[
                        'description' => 'Indikator',
                        'evidence' => [[
                            'type' => EvidenceType::Link->value,
                            'url' => null,
                        ]],
                    ]],
                ]],
            ])
            ->assertHasActionErrors(['items.0.indicators.0.evidence.0.url' => 'required']);

        $this->assertSame(0, $year->components()->count());
    }

    public function test_edit_page_renders_for_seeded_template(): void
    {
        $year = PkkmYear::factory()->create();
        PkkmItem::factory()->count(2)->for(PkkmComponent::factory()->for($year, 'year'), 'component')->create();

        $this->get(EditPkkmYear::getUrl(['record' => $year]))->assertOk();
    }
}
