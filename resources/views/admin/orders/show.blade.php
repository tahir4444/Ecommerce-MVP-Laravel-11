@extends('layouts.admin')

@section('title', 'Manage Order #' . $order->order_number . ' — Atelier Admin')
@section('header_title', 'Order Management #' . $order->order_number)

@section('content')
<div class="space-y-8 max-w-5xl">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.orders') }}" class="text-xs text-zinc-400 hover:text-white transition">← Return to Orders List</a>
            <h2 class="text-2xl font-bold text-white font-serif mt-1">Order {{ $order->order_number }}</h2>
            <p class="text-xs text-zinc-400">Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('checkout.invoice', $order->order_number) }}" target="_blank" class="px-3.5 py-2 bg-amber-400 hover:bg-amber-300 text-black rounded-lg text-xs font-bold uppercase tracking-wider transition flex items-center gap-2 shadow">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Print Official Invoice</span>
            </a>
            <span class="px-3 py-1 rounded-full uppercase tracking-wider text-xs font-bold {{ $order->order_status === 'delivered' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-amber-400/20 text-amber-300' }}">
                Status: {{ ucfirst($order->order_status) }}
            </span>
        </div>
    </div>

    <!-- Status Management Form -->
    <div class="p-6 rounded-2xl bg-[#111420] border border-white/10">
        <h3 class="text-xs font-semibold uppercase tracking-wider text-amber-400 mb-4">Update Fulfillment State</h3>
        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="flex flex-wrap items-end gap-4">
            @csrf
            @method('PATCH')

            <div class="text-xs">
                <label for="order_status" class="block text-zinc-300 font-medium mb-1.5">Fulfillment Status</label>
                <select id="order_status" name="order_status" class="bg-[#181D2B] border border-white/10 rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-amber-400">
                    <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Processing / Tailoring</option>
                    <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>Dispatched via Courier</option>
                    <option value="delivered" {{ $order->order_status === 'delivered' ? 'selected' : '' }}>Delivered to Client</option>
                    <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="text-xs">
                <label for="payment_status" class="block text-zinc-300 font-medium mb-1.5">Payment Status</label>
                <select id="payment_status" name="payment_status" class="bg-[#181D2B] border border-white/10 rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-amber-400">
                    <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid / Authorized</option>
                    <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>

            <button type="submit" class="px-5 py-2 bg-amber-400 hover:bg-amber-300 text-black text-xs font-bold rounded-lg transition uppercase tracking-wider">
                Save Status Changes
            </button>
        </form>
    </div>

    <!-- Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Client Details -->
        <div class="p-6 rounded-2xl bg-[#111420] border border-white/10 space-y-4 text-xs">
            <h3 class="font-bold text-white uppercase tracking-wider text-xs">Client Profile</h3>
            <div class="space-y-1 text-zinc-300">
                <p class="text-sm font-bold text-white">{{ $order->customer_name }}</p>
                <p>Email: <a href="mailto:{{ $order->customer_email }}" class="text-amber-300 underline">{{ $order->customer_email }}</a></p>
                <p>Phone: {{ $order->customer_phone ?? 'None specified' }}</p>
            </div>

            <div class="pt-4 border-t border-white/5 space-y-1 text-zinc-300">
                <h4 class="font-bold text-white uppercase tracking-wider text-[11px] mb-1">Courier Destination</h4>
                <p>{{ $order->shipping_address }}</p>
                <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                <p>{{ $order->shipping_country }}</p>
            </div>

            @if ($order->notes)
                <div class="pt-4 border-t border-white/5 text-amber-200/90">
                    <strong class="block text-[11px] uppercase tracking-wider text-amber-400 mb-1">Concierge Notes:</strong>
                    {{ $order->notes }}
                </div>
            @endif
        </div>

        <!-- Financial Summary -->
        <div class="p-6 rounded-2xl bg-[#111420] border border-white/10 space-y-4 text-xs">
            <h3 class="font-bold text-white uppercase tracking-wider text-xs">Payment & Ledger</h3>
            <div class="space-y-2 text-zinc-300">
                <div class="flex justify-between">
                    <span>Subtotal:</span>
                    <span class="font-bold text-white font-mono">${{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Courier Shipping:</span>
                    <span class="font-bold text-white font-mono">${{ number_format($order->shipping_cost, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Duties / Taxes (8%):</span>
                    <span class="font-bold text-white font-mono">${{ number_format($order->tax, 2) }}</span>
                </div>
                <div class="flex justify-between pt-3 border-t border-white/10 text-base font-bold text-white">
                    <span>Grand Total:</span>
                    <span class="text-amber-300 font-mono">${{ number_format($order->total, 2) }}</span>
                </div>
                <div class="pt-2 text-zinc-400">
                    Gateway: <span class="uppercase font-semibold text-white">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Garments in Order -->
    <div class="bg-[#111420] border border-white/10 rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-white/10">
            <h3 class="font-bold text-white font-serif">Ordered Pieces ({{ $order->items->count() }})</h3>
        </div>
        <div class="divide-y divide-white/5">
            @foreach ($order->items as $item)
                <div class="p-6 flex items-center justify-between gap-4 text-xs">
                    <div class="flex items-center gap-4">
                        @if ($item->product)
                            <img src="{{ $item->product->featured_image }}" alt="{{ $item->product_name }}" class="w-16 h-20 object-cover rounded-xl bg-zinc-900 border border-white/10">
                        @endif
                        <div>
                            <h4 class="font-bold text-white text-sm font-serif">{{ $item->product_name }}</h4>
                            <p class="text-zinc-400 text-xs mt-0.5">SKU: <span class="font-mono">{{ $item->product_sku }}</span> • ${{ number_format($item->unit_price, 2) }} each</p>
                        </div>
                    </div>

                    <div class="text-right">
                        <div class="font-mono text-sm font-bold text-white">${{ number_format($item->total_price, 2) }}</div>
                        <div class="text-[10px] text-zinc-500">Qty: {{ $item->quantity }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
