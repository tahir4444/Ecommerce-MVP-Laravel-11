@extends('layouts.app')

@section('title', 'Atelier Collections — Haute Prêt-à-Porter')
@section('meta_description', 'Explore our curated catalog of handcrafted outerwear, cashmere knitwear, tailored trousers, and fine leather goods.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="mb-10 pb-8 border-b border-white/10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <span class="text-xs uppercase tracking-[0.3em] text-amber-400 font-semibold">The Wardrobe</span>
            <h1 class="font-serif-luxury text-3xl sm:text-5xl font-bold text-white mt-1">
                @if ($selectedCategory)
                    {{ $selectedCategory->name }}
                @else
                    All Atelier Creations
                @endif
            </h1>
            <p class="text-xs sm:text-sm text-zinc-400 mt-2 max-w-xl">
                @if ($selectedCategory)
                    {{ $selectedCategory->description }}
                @else
                    Showing {{ $products->total() }} handcrafted pieces spanning outerwear, cashmere knitwear, tailored garments, and artisanal footwear.
                @endif
            </p>
        </div>

        <!-- Search & Sort Controls -->
        <form method="GET" action="{{ route('products.index') }}" class="flex flex-wrap items-center gap-3">
            @if ($selectedCategory)
                <input type="hidden" name="category" value="{{ $selectedCategory->slug }}">
            @endif

            <!-- Search input -->
            <div class="relative">
                <input type="text" name="q" value="{{ $search }}" placeholder="Search collection..."
                       class="bg-white/5 border border-white/10 rounded-lg px-3 py-2 pl-8 text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-amber-400 w-44 sm:w-56">
                <svg class="w-3.5 h-3.5 text-zinc-400 absolute left-2.5 top-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <!-- Sort Select -->
            <select name="sort" onchange="this.form.submit()" class="bg-[#121622] border border-white/10 rounded-lg px-3 py-2 text-xs text-zinc-300 focus:outline-none focus:border-amber-400">
                <option value="featured" {{ $sort === 'featured' ? 'selected' : '' }}>Featured</option>
                <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest</option>
                <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="rating" {{ $sort === 'rating' ? 'selected' : '' }}>Customer Rating</option>
            </select>
        </form>
    </div>

    <!-- Category Filter Pills -->
    <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-8 text-xs scrollbar-none">
        <a href="{{ route('products.index', array_filter(['q' => $search, 'sort' => $sort])) }}"
           class="px-4 py-2 rounded-full font-medium transition whitespace-nowrap {{ !$selectedCategory ? 'bg-amber-400 text-black font-semibold' : 'bg-white/5 text-zinc-400 hover:text-white hover:bg-white/10' }}">
            All Pieces ({{ \App\Models\Product::count() }})
        </a>
        @foreach ($categories as $cat)
            <a href="{{ route('products.index', array_filter(['category' => $cat->slug, 'q' => $search, 'sort' => $sort])) }}"
               class="px-4 py-2 rounded-full font-medium transition whitespace-nowrap {{ optional($selectedCategory)->slug === $cat->slug ? 'bg-amber-400 text-black font-semibold' : 'bg-white/5 text-zinc-400 hover:text-white hover:bg-white/10' }}">
                {{ $cat->name }} ({{ $cat->products_count }})
            </a>
        @endforeach
    </div>

    <!-- Products Grid -->
    @if ($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($products as $product)
                <div class="group rounded-2xl glass-card overflow-hidden flex flex-col hover:border-amber-400/40 transition duration-300">
                    <!-- Image container -->
                    <div class="relative aspect-[4/5] bg-zinc-900 overflow-hidden">
                        <a href="{{ route('products.show', $product->slug) }}">
                            <img src="{{ $product->featured_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700 ease-out">
                        </a>

                        @if ($product->badge)
                            <div class="absolute top-4 left-4">
                                <span class="px-2.5 py-1 text-[10px] font-bold tracking-widest uppercase rounded-full bg-black/80 text-amber-300 border border-amber-400/30 backdrop-blur-md">
                                    {{ $product->badge }}
                                </span>
                            </div>
                        @endif

                        <div class="absolute top-4 right-4">
                            @if ($product->stock <= 5)
                                <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-rose-500/20 text-rose-300 border border-rose-500/30 backdrop-blur-md">
                                    Only {{ $product->stock }} Left
                                </span>
                            @else
                                <span class="px-2.5 py-1 text-[10px] font-medium rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 backdrop-blur-md">
                                    In Stock
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="text-[11px] uppercase tracking-wider text-amber-400 font-medium mb-1">
                                {{ $product->category->name }}
                            </div>
                            <h2 class="font-serif-luxury text-lg font-bold text-white group-hover:text-amber-200 transition-colors">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    {{ $product->name }}
                                </a>
                            </h2>
                            <p class="text-xs text-zinc-400 mt-2 line-clamp-2 leading-relaxed">
                                {{ $product->short_description }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-white/10 flex items-center justify-between">
                            <div>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-lg font-bold text-white">${{ number_format($product->price, 2) }}</span>
                                    @if ($product->hasDiscount())
                                        <span class="text-xs text-zinc-500 line-through">${{ number_format($product->original_price, 2) }}</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-1 mt-1 text-[11px] text-amber-400">
                                    <span>★ {{ $product->rating }}</span>
                                    <span class="text-zinc-500">({{ $product->reviews_count }})</span>
                                </div>
                            </div>

                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-400 hover:bg-amber-300 text-black text-xs font-bold rounded-lg transition shadow-md hover:shadow-amber-400/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    <span>Add</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $products->links() }}
        </div>
    @else
        <div class="p-16 text-center glass-card rounded-2xl max-w-md mx-auto my-12">
            <svg class="w-12 h-12 text-zinc-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h3 class="text-lg font-bold text-white mb-2">No garments found</h3>
            <p class="text-xs text-zinc-400 mb-6">We couldn't find any creations matching your search criteria.</p>
            <a href="{{ route('products.index') }}" class="px-5 py-2.5 bg-amber-400 text-black text-xs font-bold rounded-lg hover:bg-amber-300 transition">Reset All Filters</a>
        </div>
    @endif
</div>
@endsection
