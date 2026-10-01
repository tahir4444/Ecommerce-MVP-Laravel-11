<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Outerwear & Coats',
                'slug' => 'outerwear',
                'description' => 'Italian wool overcoats, weatherproof trench coats, and tailored blazers.',
                'icon' => 'coat',
                'is_featured' => true,
            ],
            [
                'name' => 'Tailored Essentials',
                'slug' => 'tailored-essentials',
                'description' => 'Structured linen shirts, Japanese cotton tees, and pleated trousers.',
                'icon' => 'shirt',
                'is_featured' => true,
            ],
            [
                'name' => 'Knitwear & Sweaters',
                'slug' => 'knitwear',
                'description' => 'Grade-A Mongolian cashmere, merino wool crews, and chunky ribbed cardigans.',
                'icon' => 'sparkles',
                'is_featured' => true,
            ],
            [
                'name' => 'Footwear & Boots',
                'slug' => 'footwear',
                'description' => 'Goodyear welted Chelsea boots, minimalist leather sneakers, and suede loafers.',
                'icon' => 'footwear',
                'is_featured' => true,
            ],
            [
                'name' => 'Leather Bags & Goods',
                'slug' => 'leather-goods',
                'description' => 'Full-grain vegetable-tanned leather totes, weekenders, and crossbody bags.',
                'icon' => 'briefcase',
                'is_featured' => true,
            ],
            [
                'name' => 'Accessories & Accents',
                'slug' => 'accessories',
                'description' => 'Silk scarves, handcrafted sunglasses, and minimalist brass jewelry.',
                'icon' => 'glasses',
                'is_featured' => false,
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
