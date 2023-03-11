<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrderItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productsCount = Product::count();
        $ordersCount = Order::count();

        for ($i = 1; $i < 200; $i++) {
            OrderItem::insert([
                'id' => $i,
                'order_id' => rand(1, $ordersCount),
                'product_id' => rand(1, $productsCount),
                'price' => 1231231,
                'quantity' => 12,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
