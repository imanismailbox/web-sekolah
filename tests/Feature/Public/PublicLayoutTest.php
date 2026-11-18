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
}
