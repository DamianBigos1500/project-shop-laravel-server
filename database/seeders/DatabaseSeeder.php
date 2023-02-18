<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\PermissionsTableSeeder;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\PermissionRoleTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\RoleUserTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
        ]);
    }
}
