<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct(
        public CartService $cartService
    ) {}

    /**
     * Display the checkout page.
     */
    public function index(): View|RedirectResponse
    {
        $items = $this->cartService->getItems();

        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'Your shopping cart is empty.');
        }

        return view('pages.checkout', [
            'summary' => $this->cartService->getSummary(),
            'razorpayKeyId' => config('services.razorpay.key_id', 'rzp_test_1DP5mmOlF5G5ag'),
        ]);
    }

    /**
     * Process order submission and payment simulation.
     */
    public function store(Request $request): RedirectResponse
    {
        $items = $this->cartService->getItems();

        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:30'],
            'shipping_address' => ['required', 'string', 'max:255'],
            'shipping_city' => ['required', 'string', 'max:100'],
            'shipping_state' => ['nullable', 'string', 'max:100'],
            'shipping_postal_code' => ['required', 'string', 'max:20'],
            'shipping_country' => ['required', 'string', 'max:100'],
            'payment_method' => ['required', 'string', 'in:card_simulation,razorpay,cod'],
            'razorpay_payment_id' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $summary = $this->cartService->getSummary();

        $order = DB::transaction(function () use ($validated, $summary, $items) {
            $paymentMethod = $validated['payment_method'];
            $isPaid = in_array($paymentMethod, ['card_simulation', 'razorpay'], true);
            $transactionId = match ($paymentMethod) {
                'razorpay' => $validated['razorpay_payment_id'] ?? ('pay_'.Str::random(14)),
                'card_simulation' => 'sim_'.Str::random(14),
                default => null,
            };

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => auth()->id(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'] ?? null,
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_state' => $validated['shipping_state'] ?? null,
                'shipping_postal_code' => $validated['shipping_postal_code'],
                'shipping_country' => $validated['shipping_country'],
                'subtotal' => $summary['subtotal'],
                'tax' => $summary['tax'],
                'shipping_cost' => $summary['shipping'],
                'total' => $summary['total'],
                'payment_method' => $paymentMethod,
                'payment_status' => $isPaid ? 'paid' : 'pending',
                'transaction_id' => $transactionId,
                'order_status' => 'processing',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'product_sku' => $item['sku'],
                    'unit_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total_price' => $item['total'],
                ]);

                // Decrement stock gracefully
                $product = Product::find($item['id']);
                if ($product && $product->stock >= $item['quantity']) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            return $order;
        });

        $this->cartService->clear();

        return redirect()->route('checkout.confirmation', ['orderNumber' => $order->order_number])
            ->with('success', 'Thank you! Your order has been placed successfully.');
    }

    /**
     * Display order confirmation page.
     */
    public function confirmation(string $orderNumber): View
    {
        $order = Order::with(['items.product', 'user'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return view('pages.order-confirmation', [
            'order' => $order,
        ]);
    }

    /**
     * Display a dedicated, print-perfect luxury invoice & acquisition certificate.
     */
    public function invoice(string $orderNumber): View
    {
        $order = Order::with(['items.product', 'user'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return view('pages.invoice', [
            'order' => $order,
        ]);
    }
}
