<?php

namespace Database\Seeders;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i = 1; $i < 20; $i++) {

            Order::insert([
                'id' => $i,
                'order_code' => Str::orderedUuid(),
                'name' => "Damian",
                'surname' => "Bigos",
                'total_price' => 123.32,
                'email' => "w@w.com",
                'address' => "Kacwin, Kowolówka 3",
                'zip_code' => "34-441",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
