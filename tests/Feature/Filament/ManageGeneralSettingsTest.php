<?php

namespace Tests\Feature\Filament;

use App\Filament\Pages\ManageGeneralSettings;
use App\Models\User;
use App\Settings\GeneralSettings;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ManageGeneralSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        $this->actingAs(User::factory()->create()->assignRole('admin'));
    }

    public function test_admin_saves_settings(): void
    {
        Livewire::test(ManageGeneralSettings::class)
            ->fillForm([
                'site_name' => 'MTs Negeri 1 Contoh',
                'email' => 'info@mtsn1.sch.id',
                'instagram' => 'https://instagram.com/mtsn1',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $settings = app(GeneralSettings::class)->refresh();
        $this->assertSame('MTs Negeri 1 Contoh', $settings->site_name);
        $this->assertSame('info@mtsn1.sch.id', $settings->email);
    }

    public function test_site_name_is_required(): void
    {
        Livewire::test(ManageGeneralSettings::class)
            ->fillForm(['site_name' => ''])
            ->call('save')
            ->assertHasFormErrors(['site_name' => 'required']);
    }
}
