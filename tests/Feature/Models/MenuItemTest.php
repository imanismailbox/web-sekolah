<?php

namespace Tests\Feature\Models;

use App\Enums\MenuItemType;
use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_url_type_returns_custom_url(): void
    {
        $item = MenuItem::factory()->make(['type' => MenuItemType::Url, 'url' => 'https://kemenag.go.id']);

        $this->assertSame('https://kemenag.go.id', $item->url());
    }

    public function test_none_type_resolves_to_placeholder_url_for_dropdown_parent(): void
    {
        $item = MenuItem::factory()->make(['type' => MenuItemType::None, 'url' => null]);

        $this->assertSame('#', $item->url());
    }

    public function test_route_type_resolves_named_route(): void
    {
        $item = MenuItem::factory()->make(['type' => MenuItemType::Route, 'route_name' => 'posts.index', 'url' => null]);

        $this->assertSame(route('posts.index'), $item->url());
    }

    public function test_page_type_resolves_slug_of_target(): void
    {
        $page = Page::factory()->create(['slug' => 'profil']);
        $item = MenuItem::factory()->make(['type' => MenuItemType::Page, 'target_id' => $page->id, 'url' => null]);

        $this->assertSame(route('pages.show', 'profil'), $item->url());
    }

    public function test_falls_back_to_hash_when_route_or_target_is_missing(): void
    {

        $missingRoute = MenuItem::factory()->make(['type' => MenuItemType::Route, 'route_name' => 'tidak.ada', 'url' => null]);
        $missingTarget = MenuItem::factory()->make(['type' => MenuItemType::Page, 'target_id' => 999]);

        $this->assertSame('#', $missingRoute->url());
        $this->assertSame('#', $missingTarget->url());
    }

    public function test_tree_returns_active_roots_with_active_children_in_order(): void
    {
        $second = MenuItem::factory()->create(['label' => 'Kedua', 'sort' => 2]);
        $first = MenuItem::factory()->create(['label' => 'Pertama', 'sort' => 1]);
        MenuItem::factory()->create(['label' => 'Nonaktif', 'is_active' => false]);
        MenuItem::factory()->for($first, 'parent')->create(['label' => 'Anak']);
        MenuItem::factory()->for($first, 'parent')->create(['label' => 'Anak Nonaktif', 'is_active' => false]);

        $tree = MenuItem::tree();

        $this->assertSame(['Pertama', 'Kedua'], $tree->pluck('label')->all());
        $this->assertSame(['Anak'], $tree->first()->children->pluck('label')->all());
        $this->assertTrue($tree->last()->is($second));
    }
}
