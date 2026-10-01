<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Display the storefront landing page.
     */
    public function index(): View
    {
        $categories = Category::withCount('products')->get();
        $featuredProducts = Product::active()
            ->featured()
            ->with('category')
            ->take(6)
            ->get();

        $heroProduct = Product::active()
            ->where('slug', 'l-hiver-double-breasted-wool-overcoat')
            ->first() ?? $featuredProducts->first();

        $latestProducts = Product::active()
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        return view('pages.home', [
            'categories' => $categories,
            'featuredProducts' => $featuredProducts,
            'heroProduct' => $heroProduct,
            'latestProducts' => $latestProducts,
        ]);
    }
}
