<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::where("parent_id", "<>", 0)->get();

        $products = Product::all();

        foreach ($products as $key => $product) {

            $product->category()->associate($categories[$key % $categories->count()])->save();
        }
    }
}
