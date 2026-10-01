<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontTest extends TestCase
{
    use RefreshDatabase;

    public function test_storefront_homepage_loads_successfully(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'is_featured' => true,
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('ATELIER');
        $response->assertSee($product->name);
    }

    public function test_catalog_page_filters_by_category(): void
    {
        $catA = Category::factory()->create(['name' => 'Outerwear', 'slug' => 'outerwear']);
        $catB = Category::factory()->create(['name' => 'Knitwear', 'slug' => 'knitwear']);

        $productA = Product::factory()->create(['category_id' => $catA->id, 'name' => 'Cashmere Peacoat']);
        $productB = Product::factory()->create(['category_id' => $catB->id, 'name' => 'Ribbed Cardigan']);

        $response = $this->get(route('products.index', ['category' => 'outerwear']));

        $response->assertStatus(200);
        $response->assertSee('Cashmere Peacoat');
    }

    public function test_product_detail_page_renders(): void
    {
        $product = Product::factory()->create([
            'name' => 'Bespoke Double-Breasted Blazer',
            'slug' => 'bespoke-double-breasted-blazer',
        ]);

        $response = $this->get(route('products.show', $product->slug));

        $response->assertStatus(200);
        $response->assertSee('Bespoke Double-Breasted Blazer');
        $response->assertSee('Add to Shopping Bag');
    }
}
