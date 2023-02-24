<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                "title" => "Computers and Laptops",
                "category_code" => "dad",
                "parent_id" => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "title" => "Smartphones",
                "category_code" => "ads",
                "parent_id" => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "title" => "Gaming and streaming",
                "category_code" => "asdfs",
                "parent_id" => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "title" => "Devices",
                "category_code" => "asdasd",
                "parent_id" => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "title" => "TV and audio",
                "category_code" => "asdadsasd",
                "parent_id" => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "title" => "Smarthome",
                "category_code" => "fdsd",
                "parent_id" => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "title" => "Lifestyle",
                "category_code" => "fdsdasd",
                "parent_id" => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "title" => "Trends & News",
                "category_code" => "fdsdasdty",
                "parent_id" => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "title" => "Gaming Laptops",
                "category_code" => "tytsa",
                "parent_id" => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "title" => "Ultrabooks",
                "category_code" => "tytsaasd",
                "parent_id" => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "title" => "Tablets",
                "category_code" => "tytsaasda",
                "parent_id" => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "title" => "Storages",
                "category_code" => "weras",
                "parent_id" => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "title" => "Programs",
                "category_code" => "werass",
                "parent_id" => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "title" => "Desktops",
                "category_code" => "werassasd",
                "parent_id" => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "title" => "Desktops",
                "category_code" => "trt",
                "parent_id" => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "title" => "Desktops",
                "category_code" => "asdxzc",
                "parent_id" => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "title" => "Desktops",
                "category_code" => "vb",
                "parent_id" => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "title" => "Desktops",
                "category_code" => "vbas",
                "parent_id" => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "title" => "Desktops",
                "category_code" => "vbaass",
                "parent_id" => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        
        Category::insert($categories);
    }
}
