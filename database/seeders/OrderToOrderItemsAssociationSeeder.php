<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderToOrderItemsAssociationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = Order::all();
        $orderItems = OrderItem::all();

        foreach ($orderItems as $orderItem) {
            $associatedOrder = $orders[rand(0, $orders->count() - 1)];

            $orderItem->order()->associate($associatedOrder->id)->save();
        }
    }
}
