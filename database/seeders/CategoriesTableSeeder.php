<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryNames = [
            [
                "title" => "Computers and Laptops",
            ],
            [
                "title" => "Smartphones",
            ],
            [
                "title" => "Gaming and streaming",
            ],
            [
                "title" => "Devices",
            ],
            [
                "title" => "TV and audio",
            ],
            [
                "title" => "Smarthome",
            ],
            [
                "title" => "Lifestyle",
            ],
            [
                "title" => "Trends & News",
            ],
            [
                "title" => "Gaming Laptops",
                "parent_id" => 1,
            ],
            [
                "title" => "Ultrabooks",
                "parent_id" => 1,
            ],
            [
                "title" => "Tablets",
                "parent_id" => 1,
            ],
            [
                "title" => "Storages",
                "parent_id" => 1,
            ],
            [
                "title" => "Programs",
                "parent_id" => 1,
            ],
            [
                "title" => "Desktops",
                "parent_id" => 2,
            ],
            [
                "title" => "Desktops",
                "parent_id" => 2,
            ],
            [
                "title" => "Desktops",
                "parent_id" => 2,
            ],
            [
                "title" => "Desktops",
                "parent_id" => 2,
            ],
            [
                "title" => "Desktops",
                "parent_id" => 3,
            ],
            [
                "title" => "Desktops",
                "parent_id" => 3,
            ],
            [
                "title" => "Desktops",
                "parent_id" => 3,
            ],
            [
                "title" => "Desktops",
                "parent_id" => 3,
            ],
            [
                "title" => "Desktops",
                "parent_id" => 3,
            ],
        ];


        array_map(function ($category) {
            $category = new Category([
                "title" => $category["title"],
                "category_slug" => Str::slug($category["title"]),
                "parent_id" =>  isset($category["parent_id"]) ? $category["parent_id"] : 0,
            ]);
            $category->save();
        }, $categoryNames);
    }
}
