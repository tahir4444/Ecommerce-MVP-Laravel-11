<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 100, 1200);
        $tax = round($subtotal * 0.08, 2);
        $shipping = $subtotal > 150 ? 0.00 : 15.00;
        $total = $subtotal + $tax + $shipping;

        return [
            'order_number' => Order::generateOrderNumber(),
            'user_id' => null,
            'customer_name' => fake()->name(),
            'customer_email' => fake()->safeEmail(),
            'customer_phone' => fake()->phoneNumber(),
            'shipping_address' => fake()->streetAddress(),
            'shipping_city' => fake()->city(),
            'shipping_state' => fake()->stateAbbr(),
            'shipping_postal_code' => fake()->postcode(),
            'shipping_country' => 'US',
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping_cost' => $shipping,
            'total' => $total,
            'payment_method' => 'card_simulation',
            'payment_status' => 'paid',
            'order_status' => 'processing',
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
