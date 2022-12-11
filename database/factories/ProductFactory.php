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
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'price' => fake()->randomFloat(2,0,999),
            'image' => 'product-'.rand(1,12).'.jpg',
            'des' => fake()->sentence(),
            'qty' => fake()->randomDigit(),
            'weight' => fake()->randomFloat(2, 0, 999),
            'active' => 1,
            'category_id' => rand(1, 5),
        ];
    }
}
