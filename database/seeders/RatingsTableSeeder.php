<?php

namespace Database\Seeders;

use App\Models\Rating;
use Illuminate\Database\Seeder;

class RatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ratings = [
            [
                "id" => 1, "user_id" => 1, "product_id" => 1, "review" => "Very good product", "rating" => 4, "status" => 0,   'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "id" => 2, "user_id" => 1, "product_id" => 1, "review" => "Very good product", "rating" => 8, "status" => 0,   'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "id" => 3, "user_id" => 1, "product_id" => 1, "review" => "Very good product", "rating" => 9, "status" => 0,   'created_at' => now(),
                'updated_at' => now()
            ],
            [
                "id" => 4, "user_id" => 1, "product_id" => 1, "review" => "Very good product", "rating" => 10, "status" => 0,   'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        Rating::insert($ratings);
    }
}
