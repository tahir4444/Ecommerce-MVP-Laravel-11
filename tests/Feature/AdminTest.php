<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_renders(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Storefront Overview & Metrics');
        $response->assertSee('Total Sales Volume');
    }

    public function test_admin_orders_list_renders(): void
    {
        $order = Order::factory()->create();

        $response = $this->get(route('admin.orders'));

        $response->assertStatus(200);
        $response->assertSee($order->order_number);
    }

    public function test_admin_can_update_order_status(): void
    {
        $order = Order::factory()->create([
            'order_status' => 'processing',
        ]);

        $response = $this->patch(route('admin.orders.update-status', $order->id), [
            'order_status' => 'shipped',
            'payment_status' => 'paid',
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals('shipped', $order->fresh()->order_status);
    }

    public function test_admin_can_create_product(): void
    {
        $category = Category::factory()->create();

        $response = $this->post(route('admin.products.store'), [
            'category_id' => $category->id,
            'sku' => 'TEST-BLZ-99',
            'name' => 'Italian Silk Velvet Dinner Jacket',
            'short_description' => 'Midnight blue silk velvet.',
            'description' => 'Woven in Como with peaked grosgrain lapels.',
            'price' => 750.00,
            'stock' => 12,
            'badge' => 'EXCLUSIVE',
        ]);

        $response->assertRedirect(route('admin.products'));
        $this->assertDatabaseHas('products', [
            'sku' => 'TEST-BLZ-99',
            'name' => 'Italian Silk Velvet Dinner Jacket',
        ]);
    }

    public function test_admin_can_toggle_product_status(): void
    {
        $product = Product::factory()->create(['is_active' => true]);

        $response = $this->patch(route('admin.products.toggle', $product->id));

        $response->assertSessionHas('success');
        $this->assertFalse($product->fresh()->is_active);
    }
}
