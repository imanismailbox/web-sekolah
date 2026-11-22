<?php

namespace Tests\Feature\Public;

use App\Enums\EvidenceType;
use App\Enums\StaffType;
use App\Models\Album;
use App\Models\AlbumPhoto;
use App\Models\Category;
use App\Models\Page;
use App\Models\PkkmComponent;
use App\Models\PkkmEvidence;
use App\Models\PkkmIndicator;
use App\Models\PkkmItem;
use App\Models\PkkmYear;
use App\Models\Post;
use App\Models\Slide;
use App\Models\Staff;
use App\Settings\GeneralSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_shows_active_slides_headmaster_greeting_and_latest_published_posts(): void
    {
        Slide::factory()->create(['title' => 'Slide Aktif']);
        Slide::factory()->create(['title' => 'Slide Mati', 'is_active' => false]);

        $settings = app(GeneralSettings::class);
        $settings->headmaster_name = 'Drs. Ahmad';
        $settings->headmaster_greeting = 'Selamat datang di madrasah kami.';
        $settings->save();

        Post::factory()->create(['title' => 'Berita Tampil']);
        Post::factory()->draft()->create(['title' => 'Berita Draf']);
        Post::factory()->create(['title' => 'Berita Nanti', 'published_at' => now()->addDay()]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Slide Aktif')
            ->assertDontSee('Slide Mati')
            ->assertSee('Drs. Ahmad')
            ->assertSee('Selamat datang di madrasah kami.')
            ->assertSee('Berita Tampil')
            ->assertDontSee('Berita Draf')
            ->assertDontSee('Berita Nanti');
    }

    public function test_post_index_lists_only_published_posts_and_filters_by_tag(): void
    {
        Post::factory()->create(['title' => 'Berita Lomba'])->attachTag('lomba');
        Post::factory()->create(['title' => 'Berita Umum']);
        Post::factory()->draft()->create(['title' => 'Berita Draf']);

        $this->get(route('posts.index'))
            ->assertOk()
            ->assertSee('Berita Lomba')
            ->assertSee('Berita Umum')
            ->assertDontSee('Berita Draf');

        $this->get(route('posts.index', ['tag' => 'lomba']))
            ->assertOk()
            ->assertViewHas('posts', fn ($posts): bool => $posts->pluck('title')->all() === ['Berita Lomba']);
    }

    public function test_post_category_page_shows_only_that_category(): void
    {
        $category = Category::factory()->create(['name' => 'Prestasi', 'slug' => 'prestasi']);
        Post::factory()->create(['title' => 'Juara Lomba', 'category_id' => $category->id]);
        Post::factory()->create(['title' => 'Kegiatan Lain']);

        $this->get(route('posts.category', 'prestasi'))
            ->assertOk()
            ->assertSee('Juara Lomba')
            ->assertViewHas('posts', fn ($posts): bool => $posts->pluck('title')->all() === ['Juara Lomba']);

        $this->get(route('posts.category', 'tidak-ada'))->assertNotFound();
    }

    public function test_post_detail_shows_published_post_and_increments_views(): void
    {
        $post = Post::factory()->create(['slug' => 'berita-uji', 'title' => 'Judul Uji', 'views' => 3]);

        $this->get(route('posts.show', 'berita-uji'))
            ->assertOk()
            ->assertSee('Judul Uji');

        $this->assertSame(4, $post->fresh()->views);
    }

    public function test_draft_post_detail_is_not_found(): void
    {
        Post::factory()->draft()->create(['slug' => 'draf-rahasia']);

        $this->get(route('posts.show', 'draf-rahasia'))->assertNotFound();
    }

    public function test_album_index_and_detail_show_only_published_albums(): void
    {
        $album = Album::factory()->create(['title' => 'Album Pentas', 'slug' => 'album-pentas']);
        AlbumPhoto::factory()->create(['album_id' => $album->id, 'caption' => 'Foto Pembukaan']);
        AlbumPhoto::factory()->video()->create(['album_id' => $album->id, 'caption' => 'Video Sambutan']);
        Album::factory()->create(['title' => 'Album Tersembunyi', 'slug' => 'album-tersembunyi', 'is_published' => false]);

        $this->get(route('albums.index'))
            ->assertOk()
            ->assertSee('Album Pentas')
            ->assertDontSee('Album Tersembunyi');

        $this->get(route('albums.show', 'album-pentas'))
            ->assertOk()
            ->assertSee('Foto Pembukaan')
            ->assertSee('Video Sambutan')
            ->assertSee('1 foto · 1 video')
            ->assertSee('data-media-type="image"', false)
            ->assertSee('data-media-type="video"', false)
            ->assertSee('data-lightbox-video', false);

        $this->get(route('albums.show', 'album-tersembunyi'))->assertNotFound();
    }

    public function test_staff_page_shows_only_active_people_grouped_by_type(): void
    {
        Staff::factory()->create(['name' => 'Siti Guru', 'type' => StaffType::Teacher, 'position' => 'Guru Kelas']);
        Staff::factory()->create(['name' => 'Budi Pegawai', 'type' => StaffType::Employee, 'position' => 'Tata Usaha']);
        Staff::factory()->create(['name' => 'Nonaktif Sekali', 'type' => StaffType::Teacher, 'is_active' => false]);

        $this->get(route('staff.index'))
            ->assertOk()
            ->assertSee('Siti Guru')
            ->assertSee('Budi Pegawai')
            ->assertDontSee('Nonaktif Sekali');
    }

    public function test_static_page_shows_published_content_and_hides_unpublished(): void
    {
        Page::factory()->create(['title' => 'Profil Madrasah', 'slug' => 'profil']);
        Page::factory()->create(['title' => 'Halaman Rahasia', 'slug' => 'rahasia', 'is_published' => false]);

        $this->get('/profil')
            ->assertOk()
            ->assertSee('Profil Madrasah');

        $this->get('/rahasia')->assertNotFound();
    }

    public function test_page_header_uses_page_image_then_falls_back_to_site_setting(): void
    {
        Page::factory()->create(['slug' => 'polos']);
        Page::factory()->create(['slug' => 'khusus', 'header_image' => 'pages/headers/khusus.jpg']);

        $this->get('/polos')->assertOk()->assertDontSee('data-page-header-image', false);

        $settings = app(GeneralSettings::class);
        $settings->page_header_image = 'settings/header-umum.jpg';
        $settings->save();

        $this->get('/polos')->assertOk()->assertSee('settings/header-umum.jpg');
        $this->get(route('staff.index'))->assertOk()->assertSee('settings/header-umum.jpg');
        $this->get('/khusus')
            ->assertOk()
            ->assertSee('pages/headers/khusus.jpg')
            ->assertDontSee('settings/header-umum.jpg');
    }

    public function test_pkkm_index_and_detail_show_published_year_with_evidence(): void
    {
        $year = PkkmYear::factory()->create(['year' => 2025, 'slug' => 'pkkm-tahun-2025', 'title' => 'PKKM 2025']);
        $component = PkkmComponent::factory()->create(['pkkm_year_id' => $year->id, 'code' => 'A', 'name' => 'Kompetensi']);
        $item = PkkmItem::factory()->create(['pkkm_component_id' => $component->id, 'code' => '1.1', 'name' => 'Perencanaan']);
        $indicator = PkkmIndicator::factory()->create(['pkkm_item_id' => $item->id, 'number' => 1, 'description' => 'Menyusun RPP']);
        PkkmEvidence::factory()->create([
            'pkkm_indicator_id' => $indicator->id,
            'label' => 'Dokumen RPP Semester 1',
            'type' => EvidenceType::Link,
            'url' => 'https://drive.example/rpp',
        ]);
        PkkmYear::factory()->create(['year' => 2019, 'slug' => 'pkkm-tahun-2019', 'title' => 'PKKM 2019', 'is_published' => false]);

        $this->get(route('pkkm.index'))
            ->assertOk()
            ->assertSee('PKKM 2025')
            ->assertDontSee('PKKM 2019');

        $this->get(route('pkkm.show', 'pkkm-tahun-2025'))
            ->assertOk()
            ->assertSee('Menyusun RPP')
            ->assertSee('Dokumen RPP Semester 1')
            ->assertSee('https://drive.example/rpp');

        $this->get(route('pkkm.show', 'pkkm-tahun-2019'))->assertNotFound();
    }

    public function test_contact_page_shows_settings_and_whatsapp_link(): void
    {
        $settings = app(GeneralSettings::class);
        $settings->address = 'Jl. Merdeka No. 1';
        $settings->whatsapp = '0812-3456-7890';
        $settings->save();

        $this->get(route('contact'))
            ->assertOk()
            ->assertSee('Jl. Merdeka No. 1')
            ->assertSee('https://wa.me/6281234567890', false);
    }

    public function test_menu_falls_back_to_default_links_when_admin_has_no_menu(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('href="'.route('pkkm.index').'"', false)
            ->assertSee('href="'.route('contact').'"', false);
    }

    public function test_home_renders_gracefully_without_any_content(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Belum ada berita')
            ->assertSee('Belum ada album')
            ->assertSee('Dokumen PKKM segera terbit');
    }

    public function test_unknown_url_renders_custom_not_found_page(): void
    {
        $this->get('/tidak-ada-halaman-ini/x')
            ->assertNotFound()
            ->assertSee('Halaman tidak ditemukan');
    }

    public function test_admin_panel_is_still_reachable_after_public_catch_all_route(): void
    {
        $this->get('/kelola-portal-madrasah/login')->assertOk();
    }

    public function test_sitemap_lists_only_published_content(): void
    {
        Post::factory()->create(['slug' => 'berita-terbit']);
        Post::factory()->draft()->create(['slug' => 'berita-draf']);
        Page::factory()->create(['slug' => 'profil-sitemap', 'is_published' => true]);

        $response = $this->get(route('sitemap'));

        $response->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee(route('posts.show', 'berita-terbit'), false)
            ->assertSee(route('pages.show', 'profil-sitemap'), false)
            ->assertDontSee('berita-draf');
    }
}
