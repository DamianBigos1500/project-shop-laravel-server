<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $productName = $this->faker->unique()->words($nb = 6, $asText = true);
        $slug = Str::slug($productName, '-');

        return [
            'name' => $productName,
            'slug' => $slug,
            'code' => $this->faker->text(200),
            'short_description' => $this->faker->text(100),
            'long_description' => $this->faker->text(400),
            'regular_price' => $this->faker->numberBetween(100, 500),
            // 'discount_price' => 3343,
            'is_available' => true,
            'quantity' =>  $this->faker->numberBetween(10, 50),
            // 'deleted_by' => null,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
