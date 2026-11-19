<?php

namespace Tests\Feature\Filament;

use App\Filament\Pages\ManageGeneralSettings;
use App\Models\User;
use App\Settings\GeneralSettings;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class BackgroundMusicSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->seed(RolePermissionSeeder::class);
        $this->actingAs(User::factory()->create()->assignRole('admin'));
    }

    public function test_admin_uploads_background_music(): void
    {
        Livewire::test(ManageGeneralSettings::class)
            ->fillForm([
                'background_music_enabled' => true,
                'background_music' => UploadedFile::fake()->create('musik.mp3', 1024, 'audio/mpeg'),
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $settings = app(GeneralSettings::class)->refresh();
        $this->assertTrue($settings->background_music_enabled);
        $this->assertNotNull($settings->background_music);
        Storage::disk('public')->assertExists($settings->background_music);
    }

    public function test_background_music_rejects_non_audio_file(): void
    {
        Livewire::test(ManageGeneralSettings::class)
            ->fillForm([
                'background_music' => UploadedFile::fake()->image('gambar.jpg'),
            ])
            ->call('save')
            ->assertHasFormErrors(['background_music']);
    }
}
