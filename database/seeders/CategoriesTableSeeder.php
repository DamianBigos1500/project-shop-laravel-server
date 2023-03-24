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
                "title" => "Samsung",
                "parent_id" => 2,
            ],
            [
                "title" => "Apple",
                "parent_id" => 2,
            ],
            [
                "title" => "Huawei",
                "parent_id" => 2,
            ],
            [
                "title" => "Cat",
                "parent_id" => 2,
            ],
            [
                "title" => "Microphones",
                "parent_id" => 3,
            ],
            [
                "title" => "Mouses",
                "parent_id" => 3,
            ],
            [
                "title" => "Keyboards",
                "parent_id" => 3,
            ],
            [
                "title" => "Motherboards",
                "parent_id" => 4,
            ],
            [
                "title" => "Disc",
                "parent_id" => 4,
            ],
            [
                "title" => "Cameras",
                "parent_id" => 4,
            ],
            [
                "title" => "Cables",
                "parent_id" => 4,
            ],
            [
                "title" => "DVD",
                "parent_id" => 5,
            ],
            [
                "title" => "Spotify License",
                "parent_id" => 5,
            ],
            [
                "title" => "Gift Cards",
                "parent_id" => 5,
            ],
            [
                "title" => "Raspberry pi",
                "parent_id" => 6,
            ],
            [
                "title" => "LED LIGHTS",
                "parent_id" => 6,
            ],
            [
                "title" => "Tables",
                "parent_id" => 6,
            ],
            [
                "title" => "Vacuum cleaner",
                "parent_id" => 6,
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
