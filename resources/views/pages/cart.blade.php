@extends('layouts.app')

@section('title', 'Your Shopping Bag — ATELIER ÉLITE')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <span class="text-xs uppercase tracking-[0.3em] text-amber-400 font-semibold">Review Order</span>
        <h1 class="font-serif-luxury text-3xl sm:text-4xl font-bold text-white mt-1">Your Shopping Bag</h1>
    </div>

    @if (!empty($summary['items']) && count($summary['items']) > 0)
        <!-- Free Shipping Progress Indicator -->
        <div class="mb-10 p-5 rounded-2xl glass-card border border-white/10">
            <div class="flex items-center justify-between text-xs font-semibold mb-2">
                @if ($summary['remainingForFreeShipping'] > 0)
                    <span class="text-amber-200">
                        Add <strong class="text-amber-400">${{ number_format($summary['remainingForFreeShipping'], 2) }}</strong> more to unlock <strong class="text-white">Complimentary Global Express Delivery</strong>
                    </span>
                @else
                    <span class="text-emerald-300 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        You have unlocked Complimentary Global Express Delivery!
                    </span>
                @endif
                <span class="text-zinc-400 font-mono">{{ $summary['freeShippingProgress'] }}%</span>
            </div>
            <div class="w-full bg-white/10 rounded-full h-2 overflow-hidden">
                <div class="bg-gradient-to-r from-amber-500 to-amber-300 h-2 rounded-full transition-all duration-500" style="width: {{ $summary['freeShippingProgress'] }}%"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Items Table/List -->
            <div class="lg:col-span-2 space-y-6">
                @foreach ($summary['items'] as $item)
                    <div class="p-6 rounded-2xl glass-card border border-white/10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                        <div class="flex items-center gap-5">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-20 h-24 object-cover rounded-xl bg-zinc-900 border border-white/10 shrink-0">
                            <div>
                                <span class="text-[10px] font-mono uppercase tracking-widest text-zinc-500">SKU: {{ $item['sku'] }}</span>
                                <h2 class="font-serif-luxury text-base sm:text-lg font-bold text-white hover:text-amber-200 transition">
                                    <a href="{{ route('products.show', $item['slug']) }}">{{ $item['name'] }}</a>
                                </h2>
                                <div class="text-sm font-semibold text-amber-300 mt-1">
                                    ${{ number_format($item['price'], 2) }}
                                </div>
                            </div>
                        </div>

                        <!-- Quantity Stepper & Removal -->
                        <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto pt-4 sm:pt-0 border-t sm:border-t-0 border-white/10">
                            <!-- Stepper form -->
                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="flex items-center border border-white/20 rounded-xl bg-white/5 p-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="w-7 h-7 rounded-lg flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition">－</button>
                                <span class="w-10 text-center font-bold text-xs text-white">{{ $item['quantity'] }}</span>
                                <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" {{ $item['quantity'] >= $item['max_stock'] ? 'disabled' : '' }} class="w-7 h-7 rounded-lg flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/10 transition disabled:opacity-30">＋</button>
                            </form>

                            <div class="text-right min-w-[80px]">
                                <span class="block text-base font-bold text-white">${{ number_format($item['total'], 2) }}</span>
                                <span class="text-[10px] text-zinc-400">Total</span>
                            </div>

                            <!-- Remove item form -->
                            <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-zinc-500 hover:text-rose-400 transition p-2 rounded-lg hover:bg-white/5" title="Remove Garment">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

                <!-- Cart Management Actions -->
                <div class="flex items-center justify-between pt-4">
                    <a href="{{ route('products.index') }}" class="text-xs font-semibold text-zinc-400 hover:text-amber-300 inline-flex items-center gap-1 transition">
                        <span>← Continue Exploring Collection</span>
                    </a>

                    <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Empty entire shopping bag?')">
                        @csrf
                        <button type="submit" class="text-xs text-rose-400/80 hover:text-rose-300 underline transition">
                            Clear Entire Bag
                        </button>
                    </form>
                </div>
            </div>

            <!-- Order Summary Card -->
            <div class="lg:col-span-1">
                <div class="p-8 rounded-3xl glass-card border border-white/15 sticky top-28 shadow-2xl">
                    <h2 class="font-serif-luxury text-xl font-bold text-white mb-6 pb-4 border-b border-white/10">Order Summary</h2>

                    <div class="space-y-4 text-xs">
                        <div class="flex justify-between text-zinc-300">
                            <span>Subtotal ({{ $summary['itemCount'] }} {{ Str::plural('item', $summary['itemCount']) }})</span>
                            <span class="font-bold text-white">${{ number_format($summary['subtotal'], 2) }}</span>
                        </div>

                        <div class="flex justify-between text-zinc-300">
                            <span>Estimated Shipping</span>
                            @if ($summary['shipping'] === 0.0)
                                <span class="font-bold text-emerald-400 uppercase tracking-wider text-[11px]">Free</span>
                            @else
                                <span class="font-bold text-white">${{ number_format($summary['shipping'], 2) }}</span>
                            @endif
                        </div>

                        <div class="flex justify-between text-zinc-300">
                            <span>Estimated Taxes (8%)</span>
                            <span class="font-bold text-white">${{ number_format($summary['tax'], 2) }}</span>
                        </div>

                        <div class="pt-4 border-t border-white/10 flex justify-between items-baseline text-base">
                            <span class="font-bold text-white">Estimated Total</span>
                            <span class="font-bold text-2xl text-amber-300 font-serif-luxury">${{ number_format($summary['total'], 2) }}</span>
                        </div>
                    </div>

                    <div class="mt-8 space-y-3">
                        <a href="{{ route('checkout.index') }}" class="w-full py-4 bg-amber-400 hover:bg-amber-300 text-black font-bold text-sm tracking-wider uppercase rounded-xl shadow-xl shadow-amber-500/20 transition-all flex items-center justify-center gap-2">
                            <span>Proceed to Checkout</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>

                    <div class="mt-6 pt-6 border-t border-white/10 space-y-2.5 text-[11px] text-zinc-400">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Complimentary insured shipping & customs</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>White-glove 30-day garment return guarantee</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart State -->
        <div class="p-16 text-center glass-card rounded-3xl max-w-lg mx-auto my-12 border border-white/10">
            <div class="w-20 h-20 rounded-full bg-white/5 border border-white/10 flex items-center justify-center mx-auto mb-6 text-amber-300">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <h2 class="font-serif-luxury text-2xl font-bold text-white mb-2">Your Shopping Bag is Empty</h2>
            <p class="text-xs text-zinc-400 mb-8 max-w-sm mx-auto leading-relaxed">
                Discover the latest arrivals in luxury Italian outerwear, Grade-A cashmere knitwear, and handcrafted leather footwear.
            </p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-amber-400 hover:bg-amber-300 text-black text-xs font-bold uppercase tracking-wider rounded-xl transition">
                <span>Explore the Collection</span>
                <span>→</span>
            </a>
        </div>
    @endif
</div>
@endsection
