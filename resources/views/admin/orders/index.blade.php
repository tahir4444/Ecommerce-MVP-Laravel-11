@extends('layouts.admin')

@section('title', 'Client Orders — Atelier Admin')
@section('header_title', 'Client Orders Management')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-white font-serif">Customer Order Register</h2>
            <p class="text-xs text-zinc-400 mt-1">Review shipments, client information, and fulfillment lifecycles.</p>
        </div>

        <!-- Filter tabs -->
        <div class="flex items-center gap-2 overflow-x-auto text-xs">
            <a href="{{ route('admin.orders') }}" class="px-3 py-1.5 rounded-lg {{ !$currentStatus ? 'bg-amber-400 text-black font-bold' : 'bg-white/5 text-zinc-400 hover:text-white' }}">
                All ({{ \App\Models\Order::count() }})
            </a>
            <a href="{{ route('admin.orders', ['status' => 'processing']) }}" class="px-3 py-1.5 rounded-lg {{ $currentStatus === 'processing' ? 'bg-amber-400 text-black font-bold' : 'bg-white/5 text-zinc-400 hover:text-white' }}">
                Processing
            </a>
            <a href="{{ route('admin.orders', ['status' => 'shipped']) }}" class="px-3 py-1.5 rounded-lg {{ $currentStatus === 'shipped' ? 'bg-amber-400 text-black font-bold' : 'bg-white/5 text-zinc-400 hover:text-white' }}">
                Shipped
            </a>
            <a href="{{ route('admin.orders', ['status' => 'delivered']) }}" class="px-3 py-1.5 rounded-lg {{ $currentStatus === 'delivered' ? 'bg-amber-400 text-black font-bold' : 'bg-white/5 text-zinc-400 hover:text-white' }}">
                Delivered
            </a>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-[#111420] border border-white/10 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-zinc-300">
                <thead class="bg-white/5 uppercase tracking-wider text-[10px] text-zinc-400 border-b border-white/5">
                    <tr>
                        <th class="p-4">Order Reference</th>
                        <th class="p-4">Client</th>
                        <th class="p-4">Shipping Destination</th>
                        <th class="p-4">Garments</th>
                        <th class="p-4">Total Amount</th>
                        <th class="p-4">Payment</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Details</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($orders as $order)
                        <tr class="hover:bg-white/5 transition">
                            <td class="p-4 font-mono font-bold text-amber-300">
                                <a href="{{ route('admin.orders.show', $order->id) }}">{{ $order->order_number }}</a>
                            </td>
                            <td class="p-4">
                                <div class="font-bold text-white">{{ $order->customer_name }}</div>
                                <div class="text-[10px] text-zinc-500">{{ $order->customer_email }}</div>
                            </td>
                            <td class="p-4 text-zinc-400">
                                {{ $order->shipping_city }}, {{ $order->shipping_country }}
                            </td>
                            <td class="p-4">
                                {{ $order->items->sum('quantity') }} items
                            </td>
                            <td class="p-4 font-bold text-white font-mono">
                                ${{ number_format($order->total, 2) }}
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $order->payment_status === 'paid' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-amber-500/20 text-amber-300' }}">
                                    {{ $order->payment_status }}
                                </span>
                            </td>
                            <td class="p-4">
                                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="order_status" onchange="this.form.submit()" class="bg-[#181D2B] border border-white/10 rounded px-2 py-1 text-[11px] text-zinc-200 focus:outline-none focus:border-amber-400">
                                        <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ $order->order_status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-amber-300 hover:text-white font-semibold">
                                    Manage →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-12 text-center text-zinc-500">
                                No customer orders found under this view.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-white/5">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
