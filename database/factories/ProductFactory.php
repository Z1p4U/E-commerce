<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tags;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $photos = [
            "https://pebblely.com/ideas/perfume/use-water.jpg",
            "https://pebblely.com/ideas/perfume/masculinity.jpg",
            "https://pebblely.com/ideas/perfume/black-white.jpg",
            "https://pebblely.com/ideas/perfume/use-sunlight.jpg",
            "https://pebblely.com/ideas/perfume/green.jpg",
            "https://pebblely.com/ideas/perfume/reflection.jpg",
            "https://pebblely.com/ideas/perfume/black.jpg",
        ];

        return [
            "name" => $this->faker->word,
            "short_description" => $this->faker->realText(50),
            "description" => $this->faker->realText(100),
            "photo" => Arr::random($photos),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            // Attach categories
            $categories = Category::inRandomOrder()->take(rand(5, 15))->pluck('id')->toArray();
            $product->categories()->attach($categories);

            // Attach tags
            $tags = Tags::inRandomOrder()->take(rand(5, 15))->pluck('id')->toArray();
            $product->tags()->attach($tags);
        });
    }
}
