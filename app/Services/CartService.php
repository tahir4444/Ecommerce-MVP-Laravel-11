<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    private const SESSION_KEY = 'shopping_cart';

    private const FREE_SHIPPING_THRESHOLD = 150.00;

    private const STANDARD_SHIPPING = 15.00;

    private const TAX_RATE = 0.08;

    /**
     * Get all cart items.
     *
     * @return array<int, array{id: int, name: string, slug: string, price: float, original_price: ?float, quantity: int, image: ?string, sku: string, max_stock: int, total: float}>
     */
    public function getItems(): array
    {
        /** @var array<int, array{id: int, name: string, slug: string, price: float, original_price: ?float, quantity: int, image: ?string, sku: string, max_stock: int, total: float}> $cart */
        $cart = Session::get(self::SESSION_KEY, []);

        return $cart;
    }

    /**
     * Get the total number of physical units across all cart items.
     */
    public function getItemCount(): int
    {
        $count = 0;
        foreach ($this->getItems() as $item) {
            $count += $item['quantity'];
        }

        return $count;
    }

    /**
     * Add a product to the cart.
     */
    public function add(Product $product, int $quantity = 1): void
    {
        $cart = $this->getItems();
        $id = $product->id;

        $targetQuantity = $quantity;
        if (isset($cart[$id])) {
            $targetQuantity += $cart[$id]['quantity'];
        }

        if ($targetQuantity > $product->stock) {
            $targetQuantity = max(1, $product->stock);
        }

        $cart[$id] = [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'price' => (float) $product->price,
            'original_price' => $product->original_price !== null ? (float) $product->original_price : null,
            'quantity' => $targetQuantity,
            'image' => $product->featured_image,
            'sku' => $product->sku,
            'max_stock' => $product->stock,
            'total' => round(((float) $product->price) * $targetQuantity, 2),
        ];

        Session::put(self::SESSION_KEY, $cart);
    }

    /**
     * Update the quantity of a specific product.
     */
    public function update(int $productId, int $quantity): void
    {
        $cart = $this->getItems();

        if (! isset($cart[$productId])) {
            return;
        }

        if ($quantity <= 0) {
            $this->remove($productId);

            return;
        }

        $maxStock = $cart[$productId]['max_stock'];
        $validatedQuantity = min($quantity, $maxStock);

        $cart[$productId]['quantity'] = $validatedQuantity;
        $cart[$productId]['total'] = round($cart[$productId]['price'] * $validatedQuantity, 2);

        Session::put(self::SESSION_KEY, $cart);
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(int $productId): void
    {
        $cart = $this->getItems();

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put(self::SESSION_KEY, $cart);
        }
    }

    /**
     * Empty the shopping cart.
     */
    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    /**
     * Calculate subtotal of items.
     */
    public function getSubtotal(): float
    {
        $subtotal = 0.0;
        foreach ($this->getItems() as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return round($subtotal, 2);
    }

    /**
     * Calculate shipping charge based on threshold.
     */
    public function getShippingCost(): float
    {
        $subtotal = $this->getSubtotal();
        if ($subtotal === 0.0) {
            return 0.0;
        }

        if ($subtotal >= self::FREE_SHIPPING_THRESHOLD) {
            return 0.0;
        }

        return self::STANDARD_SHIPPING;
    }

    /**
     * Calculate tax amount.
     */
    public function getTax(): float
    {
        return round($this->getSubtotal() * self::TAX_RATE, 2);
    }

    /**
     * Calculate grand total.
     */
    public function getTotal(): float
    {
        return round($this->getSubtotal() + $this->getShippingCost() + $this->getTax(), 2);
    }

    /**
     * Get free shipping threshold amount.
     */
    public function getFreeShippingThreshold(): float
    {
        return self::FREE_SHIPPING_THRESHOLD;
    }

    /**
     * Percentage completed towards unlocking free shipping.
     */
    public function getProgressToFreeShipping(): float
    {
        $subtotal = $this->getSubtotal();
        if ($subtotal >= self::FREE_SHIPPING_THRESHOLD) {
            return 100.0;
        }

        return round(($subtotal / self::FREE_SHIPPING_THRESHOLD) * 100, 1);
    }

    /**
     * Get full aggregated summary array.
     *
     * @return array{items: array<int, mixed>, itemCount: int, subtotal: float, shipping: float, tax: float, total: float, freeShippingThreshold: float, freeShippingProgress: float, remainingForFreeShipping: float}
     */
    public function getSummary(): array
    {
        $subtotal = $this->getSubtotal();
        $remaining = max(0.0, round(self::FREE_SHIPPING_THRESHOLD - $subtotal, 2));

        return [
            'items' => $this->getItems(),
            'itemCount' => $this->getItemCount(),
            'subtotal' => $subtotal,
            'shipping' => $this->getShippingCost(),
            'tax' => $this->getTax(),
            'total' => $this->getTotal(),
            'freeShippingThreshold' => self::FREE_SHIPPING_THRESHOLD,
            'freeShippingProgress' => $this->getProgressToFreeShipping(),
            'remainingForFreeShipping' => $remaining,
        ];
    }
}
