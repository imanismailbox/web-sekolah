<?php

namespace Tests\Feature\Filament;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminPanelAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
    }

    /**
     * Every admin index/create page with the roles that may open it (super_admin can open all).
     *
     * @return array<string, array{0: string, 1: list<string>}>
     */
    public static function adminPages(): array
    {
        return [
            'posts' => ['/admin/posts', ['admin', 'editor']],
            'posts create' => ['/admin/posts/create', ['admin', 'editor']],
            'categories' => ['/admin/categories', ['admin', 'editor']],
            'pages' => ['/admin/pages', ['admin']],
            'pages create' => ['/admin/pages/create', ['admin']],
            'slides' => ['/admin/slides', ['admin', 'editor']],
            'albums' => ['/admin/albums', ['admin', 'editor']],
            'albums create' => ['/admin/albums/create', ['admin', 'editor']],
            'staff' => ['/admin/staff', ['admin']],
            'staff create' => ['/admin/staff/create', ['admin']],
            'pkkm' => ['/admin/pkkm-years', ['admin', 'editor_pkkm']],
            'pkkm create' => ['/admin/pkkm-years/create', ['admin', 'editor_pkkm']],
            'menu' => ['/admin/menu-items', ['admin']],
            'settings' => ['/admin/manage-general-settings', ['admin']],
            'users' => ['/admin/users', []],
            'users create' => ['/admin/users/create', []],
            'roles' => ['/admin/shield/roles', []],
            'activity log' => ['/admin/activity-logs', []],
        ];
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_user_without_panel_role_is_forbidden(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/admin')
            ->assertForbidden();
    }

    /**
     * @param  list<string>  $allowedRoles
     */
    #[DataProvider('adminPages')]
    public function test_page_access_follows_role_permissions(string $url, array $allowedRoles): void
    {
        foreach (['super_admin', 'admin', 'editor', 'editor_pkkm'] as $role) {
            $user = User::factory()->create()->assignRole($role);
            $expectedStatus = $role === 'super_admin' || in_array($role, $allowedRoles, true) ? 200 : 403;

            $this->actingAs($user)
                ->get($url)
                ->assertStatus($expectedStatus);
        }
    }
}
