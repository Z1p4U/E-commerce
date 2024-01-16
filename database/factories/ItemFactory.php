<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $sizes = ["5 ml", "10 ml", "15 ml", "20 ml", "25 ml", "50 ml", "75 ml", "100 ml"];
        return [
            'name' => $this->faker->word,
            "product_id" => rand(1, 500),
            "sku" => Str::random(10),
            "size" => $this->faker->randomElement($sizes),
            "sale" => rand(0, 1),
            "price" => rand(100000, 500000),
            "discount_price" => rand(100000, 500000),
            "description" => fake()->realText(200),
            "total_stock" => 0,
            "photo" => fake()->realText(10)
        ];
    }
}
