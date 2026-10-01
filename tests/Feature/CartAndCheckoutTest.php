<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartAndCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_add_item_to_cart(): void
    {
        $product = Product::factory()->create([
            'price' => 300.00,
            'stock' => 10,
        ]);

        $response = $this->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals(2, session('shopping_cart')[$product->id]['quantity']);
    }

    public function test_can_update_item_quantity_in_cart(): void
    {
        $product = Product::factory()->create([
            'price' => 200.00,
            'stock' => 15,
        ]);

        $this->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->patch(route('cart.update', $product->id), [
            'quantity' => 4,
        ]);

        $response->assertRedirect(route('cart.index'));
        $this->assertEquals(4, session('shopping_cart')[$product->id]['quantity']);
    }

    public function test_can_remove_item_from_cart(): void
    {
        $product = Product::factory()->create(['stock' => 5]);

        $this->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $this->delete(route('cart.remove', $product->id));

        $this->assertArrayNotHasKey($product->id, session('shopping_cart', []));
    }

    public function test_can_checkout_and_place_order(): void
    {
        $product = Product::factory()->create([
            'price' => 450.00,
            'stock' => 10,
        ]);

        // Put item in session cart
        $this->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->post(route('checkout.store'), [
            'customer_name' => 'Eleanor Vance',
            'customer_email' => 'eleanor@vance.com',
            'customer_phone' => '+1 (555) 789-0123',
            'shipping_address' => '450 Park Avenue',
            'shipping_city' => 'New York',
            'shipping_state' => 'NY',
            'shipping_postal_code' => '10022',
            'shipping_country' => 'US',
            'payment_method' => 'card_simulation',
            'notes' => 'Please leave with doorman.',
        ]);

        $order = Order::where('customer_email', 'eleanor@vance.com')->first();
        $this->assertNotNull($order);
        $this->assertEquals('paid', $order->payment_status);
        $this->assertEquals('processing', $order->order_status);

        // Verify OrderItem
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        // Stock should be decremented from 10 to 9
        $this->assertEquals(9, $product->fresh()->stock);

        // Cart should now be empty
        $this->assertEmpty(session('shopping_cart', []));

        // Should redirect to confirmation page
        $response->assertRedirect(route('checkout.confirmation', $order->order_number));

        // Confirmation page should load
        $confirmResponse = $this->get(route('checkout.confirmation', $order->order_number));
        $confirmResponse->assertStatus(200);
        $confirmResponse->assertSee($order->order_number);
        $confirmResponse->assertSee('Eleanor Vance');

        // Dedicated luxury invoice should load
        $invoiceResponse = $this->get(route('checkout.invoice', $order->order_number));
        $invoiceResponse->assertStatus(200);
        $invoiceResponse->assertSee('ATELIER ÉLITE');
        $invoiceResponse->assertSee('Official Invoice');
        $invoiceResponse->assertSee($order->order_number);
        $invoiceResponse->assertSee('Eleanor Vance');
    }

    public function test_can_checkout_with_razorpay_gateway(): void
    {
        $product = Product::factory()->create([
            'price' => 520.00,
            'stock' => 5,
        ]);

        $this->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $fakeRazorpayId = 'pay_test_'.bin2hex(random_bytes(6));

        $response = $this->post(route('checkout.store'), [
            'customer_name' => 'Sophia Rossi',
            'customer_email' => 'sophia@rossi.it',
            'shipping_address' => 'Via del Corso 12',
            'shipping_city' => 'Rome',
            'shipping_postal_code' => '00186',
            'shipping_country' => 'IT',
            'payment_method' => 'razorpay',
            'razorpay_payment_id' => $fakeRazorpayId,
        ]);

        $order = Order::where('customer_email', 'sophia@rossi.it')->first();
        $this->assertNotNull($order);
        $this->assertEquals('razorpay', $order->payment_method);
        $this->assertEquals('paid', $order->payment_status);
        $this->assertEquals($fakeRazorpayId, $order->transaction_id);

        $response->assertRedirect(route('checkout.confirmation', $order->order_number));
    }
}
