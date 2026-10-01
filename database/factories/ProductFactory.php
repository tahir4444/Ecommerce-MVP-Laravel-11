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
        $name = fake()->unique()->words(3, true);

        return [
            'category_id' => Category::factory(),
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'short_description' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 50, 800),
            'original_price' => fake()->randomFloat(2, 850, 1000),
            'sku' => 'SKU-'.strtoupper(fake()->bothify('??-####')),
            'stock' => fake()->numberBetween(5, 50),
            'rating' => 4.8,
            'reviews_count' => fake()->numberBetween(5, 100),
            'badge' => 'SIGNATURE',
            'featured_image' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=900&q=80',
            'specs' => [
                'Material' => '100% Virgin Wool',
                'Origin' => 'Italy',
            ],
            'is_featured' => true,
            'is_active' => true,
        ];
    }
}
