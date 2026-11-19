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
            'posts' => ['/kelola-portal-madrasah/posts', ['admin', 'editor']],
            'posts create' => ['/kelola-portal-madrasah/posts/create', ['admin', 'editor']],
            'categories' => ['/kelola-portal-madrasah/categories', ['admin', 'editor']],
            'pages' => ['/kelola-portal-madrasah/pages', ['admin']],
            'pages create' => ['/kelola-portal-madrasah/pages/create', ['admin']],
            'slides' => ['/kelola-portal-madrasah/slides', ['admin', 'editor']],
            'albums' => ['/kelola-portal-madrasah/albums', ['admin', 'editor']],
            'albums create' => ['/kelola-portal-madrasah/albums/create', ['admin', 'editor']],
            'staff' => ['/kelola-portal-madrasah/staff', ['admin']],
            'staff create' => ['/kelola-portal-madrasah/staff/create', ['admin']],
            'pkkm' => ['/kelola-portal-madrasah/pkkm-years', ['admin', 'editor_pkkm']],
            'pkkm create' => ['/kelola-portal-madrasah/pkkm-years/create', ['admin', 'editor_pkkm']],
            'menu' => ['/kelola-portal-madrasah/menu-items', ['admin']],
            'settings' => ['/kelola-portal-madrasah/manage-general-settings', ['admin']],
            'users' => ['/kelola-portal-madrasah/users', []],
            'users create' => ['/kelola-portal-madrasah/users/create', []],
            'roles' => ['/kelola-portal-madrasah/shield/roles', []],
            'activity log' => ['/kelola-portal-madrasah/activity-logs', []],
        ];
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/kelola-portal-madrasah')->assertRedirect('/kelola-portal-madrasah/login');
    }

    public function test_user_without_panel_role_is_forbidden(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/kelola-portal-madrasah')
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
