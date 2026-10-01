@extends('layouts.app')

@section('title', $product->name . ' — ATELIER ÉLITE')
@section('meta_description', $product->short_description)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs text-zinc-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
        <span>/</span>
        <a href="{{ route('products.index') }}" class="hover:text-white transition">Catalog</a>
        <span>/</span>
        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-white transition">{{ $product->category->name }}</a>
        <span>/</span>
        <span class="text-zinc-200 truncate">{{ $product->name }}</span>
    </nav>

    <!-- Main Product Showcase -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
        <!-- Visual Gallery -->
        <div class="space-y-4">
            <div class="relative aspect-[4/5] rounded-3xl overflow-hidden glass-card border border-white/10 group">
                <img src="{{ $product->featured_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700 ease-out">
                
                @if ($product->badge)
                    <div class="absolute top-6 left-6">
                        <span class="px-3 py-1.5 text-xs font-bold tracking-widest uppercase rounded-full bg-black/80 text-amber-300 border border-amber-400/40 backdrop-blur-md">
                            {{ $product->badge }}
                        </span>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-3 gap-4 text-center text-xs text-zinc-400">
                <div class="p-3 rounded-xl bg-white/5 border border-white/5">
                    <span class="block text-white font-semibold mb-0.5">Origin</span>
                    <span>European Mills</span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/5">
                    <span class="block text-white font-semibold mb-0.5">Shipping</span>
                    <span>Free Over $150</span>
                </div>
                <div class="p-3 rounded-xl bg-white/5 border border-white/5">
                    <span class="block text-white font-semibold mb-0.5">Returns</span>
                    <span>30-Day Bespoke</span>
                </div>
            </div>
        </div>

        <!-- Product Purchase Information -->
        <div class="flex flex-col justify-between">
            <div>
                <!-- Category & SKU -->
                <div class="flex items-center justify-between text-xs uppercase tracking-widest text-amber-400 font-semibold mb-2">
                    <span>{{ $product->category->name }}</span>
                    <span class="text-zinc-500 font-mono">SKU: {{ $product->sku }}</span>
                </div>

                <!-- Product Name -->
                <h1 class="font-serif-luxury text-3xl sm:text-4xl lg:text-5xl font-bold text-white tracking-tight leading-tight">
                    {{ $product->name }}
                </h1>

                <!-- Rating & Reviews -->
                <div class="flex items-center gap-3 mt-4 text-xs">
                    <div class="flex items-center text-amber-400">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        @endfor
                        <span class="ml-1.5 font-bold text-white">{{ $product->rating }}</span>
                    </div>
                    <span class="text-zinc-500">•</span>
                    <span class="text-zinc-400">{{ $product->reviews_count }} Verified Patron Reviews</span>
                </div>

                <!-- Price Box -->
                <div class="mt-6 p-5 rounded-2xl glass-card border border-white/10 flex items-baseline gap-4">
                    <span class="text-3xl sm:text-4xl font-bold text-white tracking-tight">
                        ${{ number_format($product->price, 2) }}
                    </span>
                    @if ($product->hasDiscount())
                        <span class="text-base text-zinc-500 line-through">
                            ${{ number_format($product->original_price, 2) }}
                        </span>
                        <span class="px-2 py-0.5 text-xs font-bold rounded bg-amber-400/20 text-amber-300 border border-amber-400/30">
                            Save {{ $product->discountPercentage() }}%
                        </span>
                    @endif
                </div>

                <!-- Short Description -->
                <div class="mt-6 text-sm text-zinc-300 leading-relaxed">
                    {{ $product->description }}
                </div>

                <!-- Size & Fit Notice -->
                <div class="mt-6 p-4 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-200 text-xs flex items-center gap-3">
                    <svg class="w-5 h-5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Tailored for true-to-size draping. Order your standard bespoke jacket or trouser sizing.</span>
                </div>

                <!-- Add to Bag Form -->
                <form action="{{ route('cart.add') }}" method="POST" class="mt-8 space-y-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="flex items-center gap-4">
                        <!-- Quantity Stepper -->
                        <div class="flex items-center border border-white/20 rounded-xl bg-white/5 p-1 text-sm">
                            <label for="quantity" class="sr-only">Quantity</label>
                            <button type="button" onclick="decrementQty()" class="w-8 h-8 rounded-lg flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition">－</button>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-12 text-center bg-transparent text-white font-bold text-sm focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            <button type="button" onclick="incrementQty({{ $product->stock }})" class="w-8 h-8 rounded-lg flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition">＋</button>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="flex-1 py-4 px-8 bg-amber-400 hover:bg-amber-300 text-black font-bold text-sm tracking-wider uppercase rounded-xl shadow-xl shadow-amber-500/20 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            <span>Add to Shopping Bag</span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between text-xs text-zinc-400 pt-2">
                        <span>Availability: <strong class="text-white">{{ $product->stock }} garments remaining in atelier</strong></span>
                        <a href="{{ route('checkout.index') }}" class="underline text-amber-300 hover:text-white">Proceed straight to Checkout →</a>
                    </div>
                </form>
            </div>

            <!-- Material & Craft Specifications Accordion -->
            @if ($product->specs && is_array($product->specs))
                <div class="mt-10 border-t border-white/10 pt-8">
                    <h3 class="text-xs uppercase tracking-widest text-white font-semibold mb-4">Fabrication & Artisanal Specifications</h3>
                    <dl class="divide-y divide-white/5 text-xs">
                        @foreach ($product->specs as $key => $val)
                            <div class="py-2.5 flex justify-between">
                                <dt class="text-zinc-400">{{ $key }}</dt>
                                <dd class="font-medium text-white text-right">{{ $val }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            @endif
        </div>
    </div>

    <!-- Related Creations -->
    @if ($relatedProducts->count() > 0)
        <section class="mt-24 pt-16 border-t border-white/10">
            <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-white mb-8">Complementary Creations</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($relatedProducts as $rel)
                    <div class="group rounded-xl glass-card overflow-hidden flex flex-col hover:border-amber-400/40 transition">
                        <div class="aspect-[4/5] bg-zinc-900 overflow-hidden relative">
                            <a href="{{ route('products.show', $rel->slug) }}">
                                <img src="{{ $rel->featured_image }}" alt="{{ $rel->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </a>
                        </div>
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-serif-luxury text-sm font-bold text-white group-hover:text-amber-300 transition">
                                    <a href="{{ route('products.show', $rel->slug) }}">
                                        {{ $rel->name }}
                                    </a>
                                </h3>
                                <p class="text-xs text-zinc-400 mt-1 line-clamp-1">${{ number_format($rel->price, 2) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>

@push('scripts')
<script>
    function incrementQty(max) {
        const input = document.getElementById('quantity');
        let current = parseInt(input.value) || 1;
        if (current < max) {
            input.value = current + 1;
        }
    }
    function decrementQty() {
        const input = document.getElementById('quantity');
        let current = parseInt(input.value) || 1;
        if (current > 1) {
            input.value = current - 1;
        }
    }
</script>
@endpush
@endsection
