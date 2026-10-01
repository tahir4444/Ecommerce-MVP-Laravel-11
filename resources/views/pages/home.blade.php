@extends('layouts.app')

@section('title', 'ATELIER ÉLITE — Haute Prêt-à-Porter & Modern Sartorial Excellence')

@section('content')
    <!-- Hero Spotlight Section -->
    <section class="relative min-h-[85vh] flex items-center justify-center overflow-hidden border-b border-white/10">
        <!-- Ambient Background Glow & Gradients -->
        <div class="absolute inset-0 bg-gradient-to-t from-[#0B0D13] via-[#0B0D13]/70 to-transparent z-10"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-900/20 via-[#0B0D13] to-[#0B0D13] z-0"></div>
        
        @if ($heroProduct)
            <img src="{{ $heroProduct->featured_image }}" alt="{{ $heroProduct->name }}" class="absolute inset-0 w-full h-full object-cover object-center opacity-35 scale-105 transform hover:scale-100 transition-transform duration-1000 ease-out">
        @endif

        <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center flex flex-col items-center">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                <span class="text-xs uppercase tracking-[0.25em] text-amber-200 font-semibold">Autumn / Winter Atelier Capsule</span>
            </div>

            <!-- Title -->
            <h1 class="font-serif-luxury text-4xl sm:text-6xl lg:text-7xl font-bold tracking-tight text-white max-w-4xl leading-[1.1] mb-6">
                Artisanal Form.<br>
                <span class="italic font-normal text-amber-200/90">Timeless Modernity.</span>
            </h1>

            <!-- Subtitle -->
            <p class="text-base sm:text-lg text-zinc-300 max-w-2xl font-light tracking-wide mb-10 leading-relaxed">
                Handcrafted Italian virgin melton wools, Grade-A Mongolian cashmere knitwear, and benchmade Goodyear boots designed for discerning sartorialists.
            </p>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-6 w-full sm:w-auto">
                <a href="{{ route('products.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 bg-amber-400 hover:bg-amber-300 text-black font-semibold text-sm tracking-wider uppercase rounded-full shadow-2xl shadow-amber-500/25 transition-all transform hover:-translate-y-0.5">
                    <span>Explore Atelier Collection</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>

                @if ($heroProduct)
                    <a href="{{ route('products.show', $heroProduct->slug) }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-4 bg-white/10 hover:bg-white/15 border border-white/20 text-white font-medium text-sm tracking-wide rounded-full backdrop-blur-md transition">
                        <span>Spotlight: {{ Str::limit($heroProduct->name, 28) }}</span>
                        <span class="text-amber-300 font-semibold">${{ number_format($heroProduct->price, 2) }}</span>
                    </a>
                @endif
            </div>

            <!-- Micro Stats / Features -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-16 pt-10 border-t border-white/10 w-full max-w-4xl text-left">
                <div class="flex flex-col">
                    <span class="text-xs uppercase tracking-widest text-zinc-400">Provenance</span>
                    <span class="text-sm font-semibold text-white mt-1">Florence & Almansa</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-xs uppercase tracking-widest text-zinc-400">Raw Fiber</span>
                    <span class="text-sm font-semibold text-white mt-1">100% Virgin Melton & Cashmere</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-xs uppercase tracking-widest text-zinc-400">Delivery</span>
                    <span class="text-sm font-semibold text-white mt-1">Global Express Courier</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-xs uppercase tracking-widest text-zinc-400">Satisfaction</span>
                    <span class="text-sm font-semibold text-white mt-1">30-Day Bespoke Returns</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Curated Categories Section -->
    <section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <span class="text-xs uppercase tracking-[0.3em] text-amber-400 font-semibold">Wardrobe Pillars</span>
                <h2 class="font-serif-luxury text-3xl sm:text-4xl font-bold text-white mt-2">Curated Categories</h2>
            </div>
            <a href="{{ route('products.index') }}" class="mt-4 md:mt-0 text-sm font-semibold text-amber-300 hover:text-amber-200 inline-flex items-center gap-1 group">
                <span>View Full Catalog</span>
                <span class="transform group-hover:translate-x-1 transition-transform">→</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="group relative rounded-2xl overflow-hidden glass-card p-8 min-h-[220px] flex flex-col justify-end hover:border-amber-400/50 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute -top-12 -right-12 w-40 h-40 bg-amber-500/5 rounded-full blur-2xl group-hover:bg-amber-500/15 transition-all"></div>
                    
                    <div class="relative z-10">
                        <div class="text-xs uppercase tracking-widest text-amber-400/90 font-medium mb-1">
                            {{ $category->products_count }} {{ Str::plural('Garment', $category->products_count) }}
                        </div>
                        <h3 class="font-serif-luxury text-2xl font-bold text-white group-hover:text-amber-200 transition-colors">
                            {{ $category->name }}
                        </h3>
                        <p class="text-xs text-zinc-400 mt-2 line-clamp-2 leading-relaxed">
                            {{ $category->description }}
                        </p>
                    </div>

                    <div class="mt-4 pt-4 border-t border-white/5 flex items-center justify-between text-xs text-zinc-400 group-hover:text-white">
                        <span>Explore Pieces</span>
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Featured Collection Grid -->
    <section class="py-20 bg-[#07080C] border-y border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs uppercase tracking-[0.3em] text-amber-400 font-semibold">Seasonal Highlights</span>
                <h2 class="font-serif-luxury text-3xl sm:text-5xl font-bold text-white mt-2">The Autumn Atelier</h2>
                <p class="text-sm text-zinc-400 mt-3">Tailored silhouettes, tactile textures, and heritage fabrics engineered for longevity.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($featuredProducts as $product)
                    <div class="group rounded-2xl glass-card overflow-hidden flex flex-col hover:border-amber-400/40 transition duration-300">
                        <!-- Product Image Box -->
                        <div class="relative aspect-[4/5] bg-zinc-900 overflow-hidden">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <img src="{{ $product->featured_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700 ease-out">
                            </a>

                            <!-- Badge -->
                            @if ($product->badge)
                                <div class="absolute top-4 left-4">
                                    <span class="px-2.5 py-1 text-[10px] font-bold tracking-widest uppercase rounded-full bg-black/80 text-amber-300 border border-amber-400/30 backdrop-blur-md">
                                        {{ $product->badge }}
                                    </span>
                                </div>
                            @endif

                            <!-- Stock Indicator -->
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

                        <!-- Product Information -->
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="text-[11px] uppercase tracking-wider text-amber-400 font-medium mb-1">
                                    {{ $product->category->name }}
                                </div>
                                <h3 class="font-serif-luxury text-lg font-bold text-white group-hover:text-amber-200 transition-colors">
                                    <a href="{{ route('products.show', $product->slug) }}">
                                        {{ $product->name }}
                                    </a>
                                </h3>
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

                                <!-- Add to Cart Form -->
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-400 hover:bg-amber-300 text-black text-xs font-bold rounded-lg transition shadow-md hover:shadow-amber-400/20">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                        <span>Add to Bag</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Lookbook & Brand Essence Banner -->
    <section class="py-28 relative overflow-hidden bg-gradient-to-b from-[#07080C] via-[#0F121B] to-[#0B0D13]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <span class="text-xs uppercase tracking-[0.35em] text-amber-400 font-semibold">The Philosophy</span>
            <blockquote class="font-serif-luxury text-3xl sm:text-5xl font-light italic text-white mt-6 leading-tight">
                "True luxury is not defined by excess, but by the quiet certainty of enduring craftsmanship, honest fiber, and uncompromised form."
            </blockquote>
            <p class="text-xs uppercase tracking-[0.25em] text-zinc-400 mt-6 font-medium">— Alessandro Moretti, Master Tailor & Founder</p>

            <div class="mt-12 flex justify-center">
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-8 py-3.5 border border-amber-400/40 hover:border-amber-400 text-amber-300 hover:text-white rounded-full text-xs uppercase tracking-widest font-semibold transition">
                    <span>Explore All Creations</span>
                    <span>→</span>
                </a>
            </div>
        </div>
    </section>
@endsection
