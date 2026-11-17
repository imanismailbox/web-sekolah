<?php

namespace Tests\Feature\Filament;

use App\Enums\PostStatus;
use App\Filament\Resources\Posts\Pages\CreatePost;
use App\Filament\Resources\Posts\Pages\EditPost;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class PostResourceTest extends TestCase
{
    use RefreshDatabase;

    private User $editor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);

        $this->editor = User::factory()->create()->assignRole('editor');
        $this->actingAs($this->editor);
    }

    public function test_editor_creates_post_with_tags_as_author_and_logs_activity(): void
    {
        $category = Category::factory()->create();

        Livewire::test(CreatePost::class)
            ->fillForm([
                'title' => 'Wisuda Angkatan 2026',
                'slug' => 'wisuda-angkatan-2026',
                'content' => '<p>Isi berita</p>',
                'status' => PostStatus::Published,
                'published_at' => now(),
                'category_id' => $category->id,
                'tags' => ['wisuda', 'prestasi'],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $post = Post::query()->sole();

        $this->assertTrue($post->author->is($this->editor));
        $this->assertEqualsCanonicalizing(['wisuda', 'prestasi'], $post->tags->pluck('name')->all());
        $this->assertTrue(
            Activity::query()
                ->where('subject_type', $post->getMorphClass())
                ->where('subject_id', $post->id)
                ->where('event', 'created')
                ->where('causer_id', $this->editor->id)
                ->exists(),
        );
    }

    public function test_create_rejects_duplicate_slug(): void
    {
        Post::factory()->create(['slug' => 'sudah-ada']);

        Livewire::test(CreatePost::class)
            ->fillForm([
                'title' => 'Sudah Ada',
                'slug' => 'sudah-ada',
                'content' => '<p>x</p>',
                'status' => PostStatus::Draft,
            ])
            ->call('create')
            ->assertHasFormErrors(['slug' => 'unique']);
    }

    public function test_edit_page_renders_existing_tags(): void
    {
        $post = Post::factory()->create();
        $post->attachTag('kegiatan');

        Livewire::test(EditPost::class, ['record' => $post->getRouteKey()])
            ->assertOk()
            ->assertSchemaStateSet(['tags' => ['kegiatan']]);
    }
}
