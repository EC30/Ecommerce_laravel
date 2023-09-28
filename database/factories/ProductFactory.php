<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'slug' => fake()->slug(),
            'price' => fake()->price(),
            'status' => fake()->status()->rand(1,2),
            'category'=>fake()->category(),
            'sku'=>fake()->sku(),
            'track_quantity'=>fake()->track_quantity(),
            'is_featured'=>'required|in:Yes,No'
        ];
    }
}
