<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'alex@example.com'],
            [
                'name' => 'Alex Mercer',
                'password' => bcrypt('password'),
            ]
        );

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);

        $overcoat = Product::where('slug', 'l-hiver-double-breasted-wool-overcoat')->first();
        $sweater = Product::where('slug', 'mongolian-cashmere-turtleneck-sweater')->first();

        if ($overcoat && $sweater) {
            $order = Order::firstOrCreate(
                ['order_number' => 'ORD-2026-8842'],
                [
                    'user_id' => $user->id,
                    'customer_name' => 'Alex Mercer',
                    'customer_email' => 'alex@example.com',
                    'customer_phone' => '+1 (555) 234-5678',
                    'shipping_address' => '742 Evergreen Terrace',
                    'shipping_city' => 'San Francisco',
                    'shipping_state' => 'CA',
                    'shipping_postal_code' => '94107',
                    'shipping_country' => 'US',
                    'subtotal' => 900.00,
                    'tax' => 72.00,
                    'shipping_cost' => 0.00,
                    'total' => 972.00,
                    'payment_method' => 'card_simulation',
                    'payment_status' => 'paid',
                    'order_status' => 'processing',
                    'notes' => 'Please ring bell upon delivery.',
                ]
            );

            OrderItem::firstOrCreate(
                ['order_id' => $order->id, 'product_id' => $overcoat->id],
                [
                    'product_name' => $overcoat->name,
                    'product_sku' => $overcoat->sku,
                    'unit_price' => $overcoat->price,
                    'quantity' => 1,
                    'total_price' => $overcoat->price,
                ]
            );

            OrderItem::firstOrCreate(
                ['order_id' => $order->id, 'product_id' => $sweater->id],
                [
                    'product_name' => $sweater->name,
                    'product_sku' => $sweater->sku,
                    'unit_price' => $sweater->price,
                    'quantity' => 1,
                    'total_price' => $sweater->price,
                ]
            );
        }
    }
}
