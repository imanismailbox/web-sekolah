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
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    public function test_link_evidence_allows_empty_url_for_checklist_and_validates_url_when_filled(): void
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
                            'label' => 'FILE Bagan/Struktur Organisasi Madrasah',
                            'type' => EvidenceType::Link->value,
                            'url' => null,
                        ]],
                    ]],
                ]],
            ])
            ->assertHasNoActionErrors();

        $evidence = $year->components()->sole()->items()->sole()->indicators()->sole()->evidence()->sole();
        $this->assertFalse($evidence->isFilled());

        Livewire::test(ComponentsRelationManager::class, ['ownerRecord' => $year, 'pageClass' => EditPkkmYear::class])
            ->callAction(TestAction::make('create')->table(), data: [
                'code' => 'B',
                'name' => 'Komponen B',
                'items' => [[
                    'code' => '2.1',
                    'name' => 'Unsur',
                    'indicators' => [[
                        'description' => 'Indikator',
                        'evidence' => [[
                            'label' => 'Berkas',
                            'type' => EvidenceType::Link->value,
                            'url' => 'bukan-url',
                        ]],
                    ]],
                ]],
            ])
            ->assertHasActionErrors(['items.0.indicators.0.evidence.0.url' => 'url']);
    }

    public function test_file_evidence_accepts_pdf_and_rejects_non_pdf_files(): void
    {
        Storage::fake('public');
        Repeater::fake();
        $year = PkkmYear::factory()->create(['year' => 2025]);

        Livewire::test(ComponentsRelationManager::class, ['ownerRecord' => $year, 'pageClass' => EditPkkmYear::class])
            ->callAction(TestAction::make('create')->table(), data: [
                'code' => 'A',
                'name' => 'Komponen PDF',
                'items' => [[
                    'code' => '1.1',
                    'name' => 'Unsur',
                    'indicators' => [[
                        'description' => 'Indikator',
                        'evidence' => [[
                            'label' => 'SK Kepala Madrasah',
                            'type' => EvidenceType::File->value,
                            'file_path' => [UploadedFile::fake()->create('sk.pdf', 100, 'application/pdf')],
                        ]],
                    ]],
                ]],
            ])
            ->assertHasNoActionErrors();

        $evidence = $year->components()->sole()->items()->sole()->indicators()->sole()->evidence()->sole();
        $this->assertSame(EvidenceType::File, $evidence->type);
        $this->assertNotNull($evidence->file_path);
        Storage::disk('public')->assertExists($evidence->file_path);

        Livewire::test(ComponentsRelationManager::class, ['ownerRecord' => $year, 'pageClass' => EditPkkmYear::class])
            ->callAction(TestAction::make('create')->table(), data: [
                'code' => 'B',
                'name' => 'Komponen Gambar',
                'items' => [[
                    'code' => '2.1',
                    'name' => 'Unsur',
                    'indicators' => [[
                        'description' => 'Indikator',
                        'evidence' => [[
                            'label' => 'Foto Kegiatan',
                            'type' => EvidenceType::File->value,
                            'file_path' => [UploadedFile::fake()->image('foto.png')],
                        ]],
                    ]],
                ]],
            ])
            ->assertHasActionErrors(['items.0.indicators.0.evidence.0.file_path']);
    }

    public function test_edit_page_renders_for_seeded_template(): void
    {
        $year = PkkmYear::factory()->create();
        PkkmItem::factory()->count(2)->for(PkkmComponent::factory()->for($year, 'year'), 'component')->create();

        $this->get(EditPkkmYear::getUrl(['record' => $year]))->assertOk();
    }
}
