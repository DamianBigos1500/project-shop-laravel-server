<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table("users")->insert();
        User::insert([
            ['name' => 'Damian', 'email' => 'w@w.com', 'password' => Hash::make("12345678"), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Damian', 'email' => 'd@d.com', 'password' => Hash::make("12345678"), 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
