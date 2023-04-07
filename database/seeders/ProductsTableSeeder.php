<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory(120)->create();

        $products = Product::all();
        $files = Storage::allFiles("/images/imagesToSeed");

        foreach ($products as $product) {
            for ($i = 0; $i < rand(1, 16); $i++) {
                $img = new Image(["filename" =>  "/storage/" . $files[rand(0, count($files) - 1)]]);
                $product->images()->save($img);
            }
        }
    }
}
