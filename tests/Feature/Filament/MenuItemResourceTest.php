<?php

namespace Tests\Feature\Filament;

use App\Enums\MenuItemType;
use App\Filament\Resources\MenuItems\Pages\EditMenuItem;
use App\Filament\Resources\MenuItems\Pages\ListMenuItems;
use App\Filament\Resources\MenuItems\RelationManagers\ChildrenRelationManager;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MenuItemResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        $this->actingAs(User::factory()->create()->assignRole('admin'));
    }

    public function test_list_shows_only_top_level_items(): void
    {
        $root = MenuItem::factory()->create();
        $child = MenuItem::factory()->for($root, 'parent')->create();

        Livewire::test(ListMenuItems::class)
            ->assertCanSeeTableRecords([$root])
            ->assertCanNotSeeTableRecords([$child]);
    }

    public function test_creates_page_menu_item(): void
    {
        $page = Page::factory()->create();

        Livewire::test(ListMenuItems::class)
            ->callAction('create', data: [
                'label' => 'Profil',
                'type' => MenuItemType::Page->value,
                'target_id' => $page->id,
            ])
            ->assertHasNoActionErrors();

        $item = MenuItem::query()->sole();
        $this->assertSame(MenuItemType::Page, $item->type);
        $this->assertSame($page->id, $item->target_id);
    }

    public function test_creates_sub_menu_under_parent(): void
    {
        $root = MenuItem::factory()->create();

        Livewire::test(ChildrenRelationManager::class, ['ownerRecord' => $root, 'pageClass' => EditMenuItem::class])
            ->callAction(TestAction::make('create')->table(), data: [
                'label' => 'Visi Misi',
                'type' => MenuItemType::Url->value,
                'url' => '/visi-misi',
            ])
            ->assertHasNoActionErrors();

        $this->assertSame(['Visi Misi'], $root->children()->pluck('label')->all());
    }

    public function test_sub_menu_manager_is_hidden_for_child_items(): void
    {
        $child = MenuItem::factory()->for(MenuItem::factory(), 'parent')->create();

        $this->assertFalse(ChildrenRelationManager::canViewForRecord($child, EditMenuItem::class));
    }
}
