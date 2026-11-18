<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);

        $superAdmin = User::query()->firstOrCreate(
            ['email' => 'admin@madrasah.test'],
            ['name' => 'Super Admin', 'password' => 'password'],
        );

        $superAdmin->assignRole(config('filament-shield.super_admin.name'));

        $this->call(PkkmTemplateSeeder::class);

        if (app()->environment('local')) {
            $this->call(FullDemoSeeder::class);
        }
    }
}
