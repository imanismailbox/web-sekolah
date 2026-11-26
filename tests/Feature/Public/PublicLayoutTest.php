<?php

namespace Tests\Feature\Public;

use App\Enums\MenuItemType;
use App\Models\MenuItem;
use App\Settings\GeneralSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicLayoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_renders_site_name_and_footer_text(): void
    {
        $settings = app(GeneralSettings::class);
        $settings->site_name = 'MI Contoh';
        $settings->footer_text = 'Alamat sekolah contoh';
        $settings->save();

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('MI Contoh')
            ->assertSee('Alamat sekolah contoh');
    }

    public function test_home_renders_only_active_menu_items_with_children(): void
    {
        $parent = MenuItem::factory()->create([
            'label' => 'Profil',
            'type' => MenuItemType::Url,
            'url' => 'https://profil.example',
            'sort' => 1,
        ]);
        MenuItem::factory()->for($parent, 'parent')->create([
            'label' => 'Visi Misi',
            'type' => MenuItemType::Url,
            'url' => 'https://visi.example',
        ]);
        MenuItem::factory()->for($parent, 'parent')->create([
            'label' => 'Anak Nonaktif',
            'is_active' => false,
        ]);
        MenuItem::factory()->create(['label' => 'Menu Nonaktif', 'is_active' => false]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Profil')
            ->assertSee('https://profil.example')
            ->assertSee('Visi Misi')
            ->assertSee('https://visi.example')
            ->assertDontSee('Anak Nonaktif')
            ->assertDontSee('Menu Nonaktif');
    }

    public function test_menu_item_opens_in_new_tab_when_configured(): void
    {
        MenuItem::factory()->create([
            'label' => 'Tautan Luar',
            'type' => MenuItemType::Url,
            'url' => 'https://luar.example',
            'open_in_new_tab' => true,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('target="_blank"', false)
            ->assertSee('rel="noopener noreferrer"', false);
    }

    public function test_route_type_menu_item_resolves_to_named_route(): void
    {
        MenuItem::factory()->create([
            'label' => 'Beranda',
            'type' => MenuItemType::Route,
            'route_name' => 'home',
            'url' => null,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('href="'.route('home').'"', false);
    }

    public function test_header_and_footer_render_only_logo_image_when_logo_is_set(): void
    {
        $settings = app(GeneralSettings::class);
        $settings->site_name = 'MI Contoh';
        $settings->tagline = 'Madrasah Unggul Berprestasi';
        $settings->logo = 'settings/logo-memanjang.png';
        $settings->save();

        $response = $this->get(route('home'))->assertOk();
        $html = $response->getContent();

        preg_match('/<header\b.*?<\/header>/s', $html, $headerMatch);
        preg_match('/<footer\b.*?<\/footer>/s', $html, $footerMatch);

        $this->assertNotEmpty($headerMatch[0]);
        $this->assertNotEmpty($footerMatch[0]);

        $this->assertStringContainsString('settings/logo-memanjang.png', $headerMatch[0]);
        $this->assertStringContainsString('alt="MI Contoh"', $headerMatch[0]);
        $this->assertStringNotContainsString('Kementerian Agama Republik Indonesia', $headerMatch[0]);
        $this->assertStringNotContainsString('Madrasah Unggul Berprestasi', $headerMatch[0]);
        $this->assertStringNotContainsString('logo-kemenag.png', $headerMatch[0]);

        $this->assertStringContainsString('settings/logo-memanjang.png', $footerMatch[0]);
        $this->assertStringContainsString('alt="MI Contoh"', $footerMatch[0]);
        $this->assertStringNotContainsString('Madrasah Unggul Berprestasi', $footerMatch[0]);
        $this->assertStringNotContainsString('logo-kemenag.png', $footerMatch[0]);
    }

    public function test_header_and_footer_fallback_to_kemenag_logo_and_text_when_logo_is_empty(): void
    {
        $settings = app(GeneralSettings::class);
        $settings->site_name = 'MI Contoh';
        $settings->tagline = 'Madrasah Unggul Berprestasi';
        $settings->logo = null;
        $settings->save();

        $response = $this->get(route('home'))->assertOk();
        $html = $response->getContent();

        preg_match('/<header\b.*?<\/header>/s', $html, $headerMatch);
        preg_match('/<footer\b.*?<\/footer>/s', $html, $footerMatch);

        $this->assertNotEmpty($headerMatch[0]);
        $this->assertNotEmpty($footerMatch[0]);

        $this->assertStringContainsString('logo-kemenag.png', $headerMatch[0]);
        $this->assertStringContainsString('Kementerian Agama Republik Indonesia', $headerMatch[0]);
        $this->assertStringContainsString('MI Contoh', $headerMatch[0]);
        $this->assertStringContainsString('Madrasah Unggul Berprestasi', $headerMatch[0]);

        $this->assertStringContainsString('logo-kemenag.png', $footerMatch[0]);
        $this->assertStringContainsString('MI Contoh', $footerMatch[0]);
        $this->assertStringContainsString('Madrasah Unggul Berprestasi', $footerMatch[0]);
    }

    public function test_desktop_navigation_renders_priority_overflow_dropdown_markup(): void
    {
        $parent = MenuItem::factory()->create([
            'label' => 'Kurikulum',
            'type' => MenuItemType::None,
            'sort' => 1,
        ]);
        MenuItem::factory()->for($parent, 'parent')->create([
            'label' => 'Kalender Akademik',
            'type' => MenuItemType::Url,
            'url' => 'https://kalender.example',
        ]);

        $response = $this->get(route('home'))->assertOk();
        $html = $response->getContent();

        $this->assertStringContainsString('data-priority-nav', $html);
        $this->assertStringContainsString('data-priority-nav-more', $html);
        $this->assertStringContainsString('data-priority-nav-overflow-item', $html);
        $this->assertStringContainsString('Lainnya', $html);
        $this->assertStringContainsString('Kurikulum', $html);
        $this->assertStringContainsString('Kalender Akademik', $html);
    }
}
