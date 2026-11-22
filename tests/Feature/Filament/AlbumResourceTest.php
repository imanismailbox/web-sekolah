<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Albums\Pages\EditAlbum;
use App\Filament\Resources\Albums\RelationManagers\PhotosRelationManager;
use App\Models\Album;
use App\Models\AlbumPhoto;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AlbumResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        $this->actingAs(User::factory()->create()->assignRole('editor'));
    }

    public function test_bulk_upload_appends_photos_after_existing_ones(): void
    {
        Storage::fake('public');
        $album = Album::factory()->create();
        AlbumPhoto::factory()->for($album)->create(['sort' => 3]);

        Livewire::test(PhotosRelationManager::class, ['ownerRecord' => $album, 'pageClass' => EditAlbum::class])
            ->callTableAction('uploadPhotos', data: [
                'images' => [
                    UploadedFile::fake()->image('a.jpg'),
                    UploadedFile::fake()->image('b.jpg'),
                ],
            ])
            ->assertHasNoTableActionErrors();

        $this->assertSame([3, 4, 5], $album->photos()->pluck('sort')->all());
        Storage::disk('public')->assertExists($album->photos()->reorder()->latest('id')->value('image'));
    }

    public function test_bulk_upload_accepts_images_and_mp4_videos(): void
    {
        Storage::fake('public');
        $album = Album::factory()->create();

        Livewire::test(PhotosRelationManager::class, ['ownerRecord' => $album, 'pageClass' => EditAlbum::class])
            ->callTableAction('uploadPhotos', data: [
                'images' => [
                    UploadedFile::fake()->image('kegiatan.jpg'),
                    UploadedFile::fake()->create('dokumentasi.mp4', 512, 'video/mp4'),
                ],
            ])
            ->assertHasNoTableActionErrors();

        $media = $album->photos()->get();
        $this->assertCount(2, $media);
        $this->assertFalse($media[0]->isVideo());
        $this->assertTrue($media[1]->isVideo());
        Storage::disk('public')->assertExists($media[0]->image);
        Storage::disk('public')->assertExists($media[1]->image);
    }

    public function test_bulk_upload_rejects_unsupported_file_types(): void
    {
        Storage::fake('public');
        $album = Album::factory()->create();

        Livewire::test(PhotosRelationManager::class, ['ownerRecord' => $album, 'pageClass' => EditAlbum::class])
            ->callTableAction('uploadPhotos', data: [
                'images' => [
                    UploadedFile::fake()->create('dokumen.pdf', 100, 'application/pdf'),
                ],
            ])
            ->assertHasTableActionErrors();

        $this->assertCount(0, $album->photos);
    }
}
