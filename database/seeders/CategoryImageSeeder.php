<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CategoryImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::where("parent_id", 0)->with("children")->get();
        $files = Storage::allFiles("/images/imagesToSeed");

        foreach ($categories as $category) {
            foreach ($category->children as $subCategory) {

                $img = new Image(["filename" =>  "/storage/" . $files[rand(0, count($files) - 1)]]);
                $subCategory->categoryImage()->save($img);
            }
        }
    }
}
