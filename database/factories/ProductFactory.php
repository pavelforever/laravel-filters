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
        $name = fake()->name();
        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'published' => fake()->boolean(),
            'fileName' => fake()->image(),
            'image' => fake()->image(),
            'description' => \Illuminate\Support\Str::random(40),
            'price' => fake()->numberBetween(1,10000),
        ];
    }
}
