<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
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
        $name = ucfirst(fake()->unique()->words(2, true));

        return [
            'category_id' => Category::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
            'price' => fake()->numberBetween(10000, 50000),
            'image' => null,
            'is_best_seller' => false,
        ];
    }

    /**
     * Indicate that the product is a best seller.
     */
    public function bestSeller(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_best_seller' => true,
        ]);
    }
}
