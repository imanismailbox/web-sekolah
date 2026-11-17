<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Permission subjects (the part after ":") granted per role.
     * `null` means every subject except the ones listed in EXCLUDED_FOR_ADMIN.
     *
     * @var array<string, list<string>|null>
     */
    private const ROLE_SUBJECTS = [
        'admin' => null,
        'editor' => ['Post', 'Category', 'Album', 'Slide'],
        'editor_pkkm' => ['PkkmYear'],
    ];

    /**
     * @var list<string>
     */
    private const EXCLUDED_FOR_ADMIN = ['Role', 'Activity', 'User'];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Artisan::call('shield:generate', [
            '--all' => true,
            '--option' => 'permissions',
            '--panel' => 'admin',
            '--no-interaction' => true,
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        Role::findOrCreate(config('filament-shield.super_admin.name'), 'web');

        $permissions = Permission::query()->where('guard_name', 'web')->pluck('name');

        foreach (self::ROLE_SUBJECTS as $roleName => $subjects) {
            $granted = $permissions->filter(function (string $permission) use ($subjects): bool {
                $subject = Str::after($permission, ':');

                return $subjects === null
                    ? ! in_array($subject, self::EXCLUDED_FOR_ADMIN, true)
                    : in_array($subject, $subjects, true);
            });

            Role::findOrCreate($roleName, 'web')->syncPermissions($granted);
        }
    }
}
