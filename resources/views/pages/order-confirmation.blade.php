@extends('layouts.app')

@section('title', 'Order Confirmed #' . $order->order_number . ' — ATELIER ÉLITE')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Success Celebration Header -->
    <div class="text-center mb-12">
        <div class="w-20 h-20 rounded-full bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 flex items-center justify-center mx-auto mb-6 shadow-xl shadow-emerald-500/10">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <span class="text-xs uppercase tracking-[0.35em] text-amber-400 font-semibold">Gratitude From Our Atelier</span>
        <h1 class="font-serif-luxury text-3xl sm:text-5xl font-bold text-white mt-2">Your Order is Confirmed</h1>
        <p class="text-xs sm:text-sm text-zinc-400 mt-3">
            Order Reference: <span class="font-mono text-amber-300 font-bold tracking-wider">{{ $order->order_number }}</span>
        </p>
    </div>

    <!-- Fulfillment Journey Status Indicator -->
    <div class="p-8 rounded-3xl glass-card border border-white/10 mb-10">
        <div class="flex items-center justify-between text-xs font-semibold text-zinc-400 mb-6">
            <span class="text-white">Fulfillment Status</span>
            <span class="px-3 py-1 rounded-full uppercase tracking-wider text-[10px] font-bold {{ $order->order_status === 'delivered' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-amber-400/20 text-amber-300 border border-amber-400/30' }}">
                {{ ucfirst($order->order_status) }}
            </span>
        </div>

        <div class="grid grid-cols-4 gap-2 text-center text-[11px]">
            <div class="flex flex-col items-center">
                <div class="w-7 h-7 rounded-full bg-emerald-400 text-black flex items-center justify-center font-bold text-xs mb-2">✓</div>
                <span class="text-white font-medium">Order Placed</span>
                <span class="text-[10px] text-zinc-400 mt-0.5">Payment Verified</span>
            </div>
            <div class="flex flex-col items-center">
                <div class="w-7 h-7 rounded-full bg-amber-400 text-black flex items-center justify-center font-bold text-xs mb-2">2</div>
                <span class="text-white font-medium">Atelier Packing</span>
                <span class="text-[10px] text-zinc-400 mt-0.5">Signature Gift Box</span>
            </div>
            <div class="flex flex-col items-center opacity-60">
                <div class="w-7 h-7 rounded-full bg-white/10 text-zinc-400 flex items-center justify-center font-bold text-xs mb-2">3</div>
                <span class="text-zinc-400 font-medium">Courier Dispatch</span>
                <span class="text-[10px] text-zinc-500 mt-0.5">Air Express</span>
            </div>
            <div class="flex flex-col items-center opacity-60">
                <div class="w-7 h-7 rounded-full bg-white/10 text-zinc-400 flex items-center justify-center font-bold text-xs mb-2">4</div>
                <span class="text-zinc-400 font-medium">Delivered</span>
                <span class="text-[10px] text-zinc-500 mt-0.5">White-Glove</span>
            </div>
        </div>
    </div>

    <!-- Order Items & Billing Summary Card -->
    <div class="p-8 rounded-3xl glass-card border border-white/10 space-y-8">
        <div>
            <h2 class="font-serif-luxury text-xl font-bold text-white mb-6">Acquired Garments</h2>
            <div class="divide-y divide-white/5">
                @foreach ($order->items as $item)
                    <div class="py-4 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            @if ($item->product)
                                <img src="{{ $item->product->featured_image }}" alt="{{ $item->product_name }}" class="w-16 h-20 object-cover rounded-xl bg-zinc-900 border border-white/10">
                            @else
                                <div class="w-16 h-20 rounded-xl bg-zinc-800 flex items-center justify-center text-zinc-500 text-xs">Atelier</div>
                            @endif
                            <div>
                                <h3 class="font-serif-luxury text-sm font-bold text-white">{{ $item->product_name }}</h3>
                                <p class="text-xs text-zinc-400 mt-0.5">SKU: <span class="font-mono">{{ $item->product_sku }}</span> • Qty: {{ $item->quantity }}</p>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-white font-mono">${{ number_format($item->total_price, 2) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Addresses & Payment breakdown -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-6 border-t border-white/10 text-xs">
            <div>
                <h3 class="uppercase tracking-widest text-zinc-400 font-semibold mb-3">Shipping Destination</h3>
                <div class="text-zinc-300 leading-relaxed space-y-0.5">
                    <p class="font-bold text-white">{{ $order->customer_name }}</p>
                    <p>{{ $order->shipping_address }}</p>
                    <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                    <p>{{ $order->shipping_country }}</p>
                    @if ($order->customer_phone)
                        <p class="pt-1 text-zinc-400">Tel: {{ $order->customer_phone }}</p>
                    @endif
                </div>
            </div>

            <div>
                <h3 class="uppercase tracking-widest text-zinc-400 font-semibold mb-3">Financial Receipt</h3>
                <div class="space-y-2 text-zinc-300">
                    <div class="flex justify-between">
                        <span>Subtotal:</span>
                        <span class="font-bold text-white">${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Courier Delivery:</span>
                        <span class="font-bold text-white">${{ number_format($order->shipping_cost, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Taxes (8%):</span>
                        <span class="font-bold text-white">${{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-white/10 text-sm font-bold text-white">
                        <span>Total Paid:</span>
                        <span class="text-amber-300 font-serif-luxury text-lg">${{ number_format($order->total, 2) }}</span>
                    </div>
                    <div class="pt-2 text-[11px] text-zinc-400">
                        Payment Mode: <strong class="text-zinc-200 uppercase">{{ str_replace('_', ' ', $order->payment_method) }}</strong>
                    </div>
                    @if ($order->transaction_id)
                        <div class="text-[11px] text-zinc-400 font-mono">
                            Gateway Ref: <span class="text-amber-300">{{ $order->transaction_id }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="pt-6 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4 no-print">
            <a href="{{ route('checkout.invoice', $order->order_number) }}" target="_blank" class="w-full sm:w-auto px-6 py-3.5 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-200 text-black rounded-xl text-xs font-bold tracking-wider uppercase transition shadow-lg shadow-amber-400/20 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Download / Print Official Invoice</span>
            </a>

            <div class="flex items-center gap-4 w-full sm:w-auto">
                <a href="{{ route('admin.orders.show', $order->id) }}" class="w-full sm:w-auto text-center px-6 py-3.5 bg-white/5 hover:bg-white/10 border border-white/10 text-amber-300 rounded-xl text-xs font-semibold tracking-wider uppercase transition">
                    View in Admin
                </a>
                <a href="{{ route('products.index') }}" class="w-full sm:w-auto text-center px-6 py-3.5 bg-white/10 hover:bg-white/15 border border-white/20 text-white rounded-xl text-xs font-bold tracking-wider uppercase transition">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        aside, header, footer, .no-print, #flash-success, #flash-error {
            display: none !important;
        }

        body {
            background: #ffffff !important;
            color: #111827 !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .glass-card {
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            color: #111827 !important;
            box-shadow: none !important;
        }

        h1, h2, h3, h4, .text-white {
            color: #111827 !important;
        }

        .text-zinc-400, .text-zinc-300 {
            color: #4b5563 !important;
        }

        .text-amber-300, .text-amber-400 {
            color: #92400e !important;
        }

        @page {
            size: A4 portrait;
            margin: 15mm;
        }
    }
</style>
@endsection
