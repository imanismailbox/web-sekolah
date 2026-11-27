<?php

namespace Tests\Feature\Filament;

use App\Enums\StaffType;
use App\Filament\Resources\Staff\Exports\StaffExporter;
use App\Filament\Resources\Staff\Pages\ListStaff;
use App\Filament\Resources\Staff\Pages\ListStaffExports;
use App\Models\Staff;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class StaffExporterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);

        $this->actingAs(User::factory()->create()->assignRole('admin'));
    }

    public function test_exports_type_label_and_active_status_in_readable_form(): void
    {
        $staff = Staff::factory()->create([
            'name' => 'Ahmad Fauzi',
            'type' => StaffType::Teacher,
            'is_active' => false,
        ]);

        $row = StaffExporter::test(['name' => 'name', 'type' => 'type', 'is_active' => 'is_active'])
            ->export($staff);

        $this->assertSame(['Ahmad Fauzi', 'Guru', 'Nonaktif'], $row);
    }

    public function test_list_page_exposes_export_action(): void
    {
        Livewire::test(ListStaff::class)
            ->assertActionHasLabel('export', 'Export Guru/Pegawai');
    }

    public function test_history_lists_only_own_staff_exports(): void
    {
        $ownExport = Export::create([
            'file_disk' => 'local',
            'exporter' => StaffExporter::class,
            'user_id' => auth()->id(),
            'total_rows' => 3,
            'successful_rows' => 3,
            'completed_at' => now(),
        ]);

        $otherExport = Export::create([
            'file_disk' => 'local',
            'exporter' => StaffExporter::class,
            'user_id' => User::factory()->create()->id,
            'total_rows' => 1,
            'successful_rows' => 1,
            'completed_at' => now(),
        ]);

        Livewire::test(ListStaffExports::class)
            ->assertCanSeeTableRecords([$ownExport])
            ->assertCanNotSeeTableRecords([$otherExport]);
    }
}
