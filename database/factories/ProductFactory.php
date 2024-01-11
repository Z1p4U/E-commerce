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
        // $categories = Category::inRandomOrder()->take(4)->pluck('id')->toArray();
        // $tags = Tags::inRandomOrder()->take(4)->pluck('id')->toArray();

        // $product = Product::get();
        // $product->categories()->attach($categories);
        // $product->tags()->attach($tags);

        return [
            "name" => $this->faker->word,
            "short_description" => $this->faker->realText(50),
            "description" => $this->faker->realText(100),
            "photo" => $this->faker->realText(10),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            // Attach categories
            $categories = Category::inRandomOrder()->take(4)->pluck('id')->toArray();
            $product->categories()->attach($categories);

            // Attach tags
            $tags = Tags::inRandomOrder()->take(4)->pluck('id')->toArray();
            $product->tags()->attach($tags);
        });
    }
}
