<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Display the admin overview dashboard with KPI metrics.
     */
    public function dashboard(): View
    {
        $totalRevenue = (float) Order::where('payment_status', 'paid')->sum('total');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $lowStockCount = Product::where('stock', '<=', 5)->count();

        $recentOrders = Order::with('items')
            ->latest()
            ->take(5)
            ->get();

        $categories = Category::withCount('products')->get();

        return view('admin.dashboard', [
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'totalProducts' => $totalProducts,
            'lowStockCount' => $lowStockCount,
            'recentOrders' => $recentOrders,
            'categories' => $categories,
        ]);
    }

    /**
     * Display orders list with optional status filter.
     */
    public function orders(Request $request): View
    {
        $status = $request->query('status');

        $query = Order::with('items')->latest();
        if ($status) {
            $query->where('order_status', $status);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'currentStatus' => $status,
        ]);
    }

    /**
     * View detailed order breakdown.
     */
    public function showOrder(Order $order): View
    {
        $order->load(['items.product', 'user']);

        return view('admin.orders.show', [
            'order' => $order,
        ]);
    }

    /**
     * Update order status.
     */
    public function updateOrderStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'order_status' => ['required', 'string', 'in:processing,shipped,delivered,cancelled'],
            'payment_status' => ['nullable', 'string', 'in:paid,pending,failed,refunded'],
        ]);

        $order->update($validated);

        return redirect()->back()->with('success', "Order #{$order->order_number} status updated.");
    }

    /**
     * Display product catalog management list.
     */
    public function products(): View
    {
        $products = Product::with('category')->latest()->paginate(12);

        return view('admin.products.index', [
            'products' => $products,
        ]);
    }

    /**
     * Show form to add a new product.
     */
    public function createProduct(): View
    {
        $categories = Category::all();

        return view('admin.products.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Save a new product to catalog.
     */
    public function storeProduct(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'original_price' => ['nullable', 'numeric', 'gt:price'],
            'sku' => ['required', 'string', 'max:50', 'unique:products,sku'],
            'stock' => ['required', 'integer', 'min:0'],
            'badge' => ['nullable', 'string', 'max:50'],
            'featured_image' => ['nullable', 'url', 'max:500'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['name']).'-'.strtolower(Str::random(4));
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = true;
        $validated['rating'] = 5.0;
        $validated['reviews_count'] = 1;

        if (empty($validated['featured_image'])) {
            $validated['featured_image'] = 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=900&q=80';
        }

        Product::create($validated);

        return redirect()->route('admin.products')->with('success', 'Product added successfully.');
    }

    /**
     * Toggle active visibility of product.
     */
    public function toggleProductStatus(Product $product): RedirectResponse
    {
        $product->update([
            'is_active' => ! $product->is_active,
        ]);

        $statusStr = $product->is_active ? 'activated' : 'deactivated';

        return redirect()->back()->with('success', "Product \"{$product->name}\" {$statusStr}.");
    }
}
