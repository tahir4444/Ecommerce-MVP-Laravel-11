@extends('layouts.admin')

@section('title', 'Executive Overview — Atelier Admin')
@section('header_title', 'Storefront Overview & Metrics')

@section('content')
<div class="space-y-8">
    <!-- Stat KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Revenue Card -->
        <div class="p-6 rounded-2xl bg-[#111420] border border-white/10 relative overflow-hidden">
            <div class="flex items-center justify-between text-xs text-zinc-400 mb-2">
                <span class="font-medium uppercase tracking-wider">Total Sales Volume</span>
                <span class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center font-bold">$</span>
            </div>
            <div class="text-3xl font-bold text-white font-serif tracking-tight">
                ${{ number_format($totalRevenue, 2) }}
            </div>
            <div class="mt-3 flex items-center text-xs text-emerald-400 gap-1 font-medium">
                <span>↑ 14.2%</span>
                <span class="text-zinc-500">vs last month</span>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="p-6 rounded-2xl bg-[#111420] border border-white/10 relative overflow-hidden">
            <div class="flex items-center justify-between text-xs text-zinc-400 mb-2">
                <span class="font-medium uppercase tracking-wider">Processed Orders</span>
                <span class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-400 flex items-center justify-center font-bold">#</span>
            </div>
            <div class="text-3xl font-bold text-white font-serif tracking-tight">
                {{ $totalOrders }}
            </div>
            <div class="mt-3 text-xs text-zinc-400">
                100% fulfillable via courier
            </div>
        </div>

        <!-- Catalog Items -->
        <div class="p-6 rounded-2xl bg-[#111420] border border-white/10 relative overflow-hidden">
            <div class="flex items-center justify-between text-xs text-zinc-400 mb-2">
                <span class="font-medium uppercase tracking-wider">Atelier Garments</span>
                <span class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-400 flex items-center justify-center font-bold">👔</span>
            </div>
            <div class="text-3xl font-bold text-white font-serif tracking-tight">
                {{ $totalProducts }}
            </div>
            <div class="mt-3 text-xs text-zinc-400">
                Across {{ $categories->count() }} collections
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="p-6 rounded-2xl bg-[#111420] border border-white/10 relative overflow-hidden">
            <div class="flex items-center justify-between text-xs text-zinc-400 mb-2">
                <span class="font-medium uppercase tracking-wider">Low Stock Pieces</span>
                <span class="w-8 h-8 rounded-lg bg-rose-500/10 text-rose-400 flex items-center justify-center font-bold">!</span>
            </div>
            <div class="text-3xl font-bold text-white font-serif tracking-tight">
                {{ $lowStockCount }}
            </div>
            <div class="mt-3 text-xs {{ $lowStockCount > 0 ? 'text-amber-400' : 'text-zinc-500' }}">
                {{ $lowStockCount > 0 ? 'Requires mill reorder' : 'All inventory healthy' }}
            </div>
        </div>
    </div>

    <!-- Quick Actions Banner -->
    <div class="p-6 rounded-2xl bg-gradient-to-r from-amber-500/15 via-[#141926] to-[#111420] border border-amber-500/30 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-white font-serif">Atelier Operations Hub</h2>
            <p class="text-xs text-zinc-300 mt-1">Manage luxury catalogue collections, review client orders, and fulfill shipments with instant real-time updates.</p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('admin.products.create') }}" class="px-4 py-2.5 bg-amber-400 hover:bg-amber-300 text-black rounded-lg text-xs font-bold uppercase tracking-wider transition">
                + Add New Garment
            </a>
            <a href="{{ route('admin.orders') }}" class="px-4 py-2.5 bg-white/10 hover:bg-white/15 border border-white/20 text-white rounded-lg text-xs font-semibold tracking-wider uppercase transition">
                All Orders
            </a>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-[#111420] border border-white/10 rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-white/10 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-white font-serif">Recent Customer Acquisitions</h2>
                <p class="text-xs text-zinc-400 mt-0.5">Live orders placed through the online storefront.</p>
            </div>
            <a href="{{ route('admin.orders') }}" class="text-xs text-amber-300 hover:text-white transition">View All Orders →</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-zinc-300">
                <thead class="bg-white/5 uppercase tracking-wider text-[10px] text-zinc-400 border-b border-white/5">
                    <tr>
                        <th class="p-4">Reference</th>
                        <th class="p-4">Client</th>
                        <th class="p-4">Garments</th>
                        <th class="p-4">Total</th>
                        <th class="p-4">Payment</th>
                        <th class="p-4">Fulfillment</th>
                        <th class="p-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($recentOrders as $order)
                        <tr class="hover:bg-white/5 transition">
                            <td class="p-4 font-mono font-bold text-amber-300">
                                <a href="{{ route('admin.orders.show', $order->id) }}">{{ $order->order_number }}</a>
                            </td>
                            <td class="p-4">
                                <div class="font-bold text-white">{{ $order->customer_name }}</div>
                                <div class="text-[10px] text-zinc-500">{{ $order->customer_email }}</div>
                            </td>
                            <td class="p-4">
                                {{ $order->items->sum('quantity') }} items
                            </td>
                            <td class="p-4 font-bold text-white">
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
                                    Details →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-zinc-500">
                                No orders recorded yet. Place an order on the public storefront to view it here!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
