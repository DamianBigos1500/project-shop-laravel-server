<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class FeaturedProductsColumnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productsC = Product::all()->count();

        for ($i = 0; $i < 20; $i++) {
            $j = [rand(0, $productsC - 1)];
            $product = Product::find($j);
            $product->featured = true;
            $product->save();
        }
    }
}
