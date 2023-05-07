<?php

namespace Database\Seeders;

use Database\Seeders\UsersTableSeeder;
use Database\Seeders\ProductsTableSeeder;
use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\CategoryImageSeeder;
use Database\Seeders\ProductCategoryTableSeeder;
use Database\Seeders\RatingsTableSeeder;
use Database\Seeders\OrdersTableSeeder;
use Database\Seeders\OrderItemsTableSeeder;
use Database\Seeders\OrderToOrderItemsAssociationSeeder;
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
            ProductsTableSeeder::class,
            CategoriesTableSeeder::class,
            CategoryImageSeeder::class,
            ProductCategoryTableSeeder::class,
            RatingsTableSeeder::class,
            OrdersTableSeeder::class,
            OrderItemsTableSeeder::class,
            OrderToOrderItemsAssociationSeeder::class,
            AdvertiseCarouselSeeder::class
        ]);
    }
}
