<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        public CartService $cartService
    ) {}

    /**
     * Display the shopping cart review page.
     */
    public function index(): View
    {
        $summary = $this->cartService->getSummary();

        return view('pages.cart', [
            'summary' => $summary,
        ]);
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);

        $product = Product::active()->findOrFail($validated['product_id']);
        $quantity = (int) ($validated['quantity'] ?? 1);

        $this->cartService->add($product, $quantity);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "{$product->name} added to cart.",
                'summary' => $this->cartService->getSummary(),
            ]);
        }

        return redirect()->back()->with('success', "{$product->name} added to cart.");
    }

    /**
     * Update quantity of an item in the cart.
     */
    public function update(Request $request, int $productId): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:50'],
        ]);

        $this->cartService->update($productId, (int) $validated['quantity']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated.',
                'summary' => $this->cartService->getSummary(),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(Request $request, int $productId): RedirectResponse|JsonResponse
    {
        $this->cartService->remove($productId);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart.',
                'summary' => $this->cartService->getSummary(),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from your cart.');
    }

    /**
     * Clear all items in the cart.
     */
    public function clear(): RedirectResponse
    {
        $this->cartService->clear();

        return redirect()->route('cart.index')->with('success', 'Your cart has been cleared.');
    }
}
