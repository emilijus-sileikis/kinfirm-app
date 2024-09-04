<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

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
            'sku' => $this->faker->unique()->word,
            'description' => $this->faker->sentence,
            'size' => $this->faker->randomElement(['XS', 'S', 'M', 'L', 'XL']),
            'photo' => $this->faker->imageUrl(),
            'stock' => $this->faker->numberBetween(0, 100),
        ];
    }
}
