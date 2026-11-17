<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Activities\Pages\ViewActivity;
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Models\Page;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        $this->actingAs(User::factory()->create()->assignRole('super_admin'));
    }

    public function test_creates_user_with_role(): void
    {
        Livewire::test(CreateUser::class)
            ->fillForm([
                'name' => 'Operator PKKM',
                'email' => 'pkkm@madrasah.test',
                'password' => 'rahasia123',
                'roles' => [Role::findByName('editor_pkkm')->id],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $user = User::query()->where('email', 'pkkm@madrasah.test')->sole();
        $this->assertTrue($user->hasRole('editor_pkkm'));
        $this->assertTrue(Hash::check('rahasia123', $user->password));
    }

    public function test_blank_password_on_edit_keeps_current_password(): void
    {
        $user = User::factory()->create(['password' => 'lama12345']);
        $user->assignRole('editor');

        Livewire::test(EditUser::class, ['record' => $user->getRouteKey()])
            ->fillForm(['name' => 'Nama Baru', 'password' => ''])
            ->call('save')
            ->assertHasNoFormErrors();

        $user->refresh();
        $this->assertSame('Nama Baru', $user->name);
        $this->assertTrue(Hash::check('lama12345', $user->password));
    }

    public function test_activity_detail_shows_changed_attributes(): void
    {
        $page = Page::factory()->create(['title' => 'Profil']);
        $page->update(['title' => 'Profil Madrasah']);
        $activity = Activity::query()->where('event', 'updated')->sole();

        Livewire::test(ViewActivity::class, ['record' => $activity->getRouteKey()])
            ->assertOk()
            ->assertSee('Profil Madrasah');
    }
}
