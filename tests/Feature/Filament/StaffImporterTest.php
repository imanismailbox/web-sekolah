<?php

namespace Tests\Feature\Filament;

use App\Enums\StaffType;
use App\Filament\Resources\Staff\Imports\StaffImporter;
use App\Filament\Resources\Staff\Pages\ListStaff;
use App\Models\Staff;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class StaffImporterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);

        $this->actingAs(User::factory()->create()->assignRole('admin'));
    }

    public function test_imports_teachers_and_employees_from_type_labels(): void
    {
        StaffImporter::test()
            ->import(['name' => 'Ahmad Fauzi, S.Pd', 'type' => 'Guru', 'subject' => 'Matematika', 'is_active' => '1'])
            ->assertImported();

        StaffImporter::test()
            ->import(['name' => 'Siti Aminah', 'type' => 'karyawan', 'position' => 'Tata Usaha', 'is_active' => '1'])
            ->assertImported();

        $this->assertSame(StaffType::Teacher, Staff::where('name', 'Ahmad Fauzi, S.Pd')->sole()->type);
        $this->assertSame(StaffType::Employee, Staff::where('name', 'Siti Aminah')->sole()->type);
    }

    public function test_reimport_with_same_nip_updates_existing_staff(): void
    {
        $staff = Staff::factory()->create(['nip' => '198001012005011001', 'name' => 'Nama Lama', 'type' => StaffType::Teacher]);

        StaffImporter::test()
            ->import(['name' => 'Nama Baru', 'type' => 'guru', 'nip' => '198001012005011001'])
            ->assertImported();

        $this->assertSame(1, Staff::count());
        $this->assertSame('Nama Baru', $staff->refresh()->name);
    }

    public function test_rejects_unknown_type_without_creating_staff(): void
    {
        $test = StaffImporter::test()->import(['name' => 'Budi', 'type' => 'dosen']);

        $this->assertTrue($test->errors()->has('type'));
        $this->assertSame(0, Staff::count());
    }

    public function test_list_page_exposes_import_action_to_users_who_can_create_staff(): void
    {
        Livewire::test(ListStaff::class)
            ->assertActionHasLabel('import', 'Import Guru/Pegawai');
    }
}
