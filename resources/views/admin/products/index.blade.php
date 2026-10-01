@extends('layouts.admin')

@section('title', 'Product Inventory — Atelier Admin')
@section('header_title', 'Product Catalog & Inventory')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-white font-serif">Atelier Garment Inventory</h2>
            <p class="text-xs text-zinc-400 mt-1">Manage product details, stock allocations, and catalog availability.</p>
        </div>

        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-400 hover:bg-amber-300 text-black rounded-lg text-xs font-bold uppercase tracking-wider transition shadow-lg shadow-amber-400/20">
            <span>+ Add New Garment</span>
        </a>
    </div>

    <!-- Products Table -->
    <div class="bg-[#111420] border border-white/10 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-zinc-300">
                <thead class="bg-white/5 uppercase tracking-wider text-[10px] text-zinc-400 border-b border-white/5">
                    <tr>
                        <th class="p-4">Garment</th>
                        <th class="p-4">Category</th>
                        <th class="p-4">SKU</th>
                        <th class="p-4">Price</th>
                        <th class="p-4">Stock</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach ($products as $product)
                        <tr class="hover:bg-white/5 transition">
                            <td class="p-4 flex items-center gap-3">
                                <img src="{{ $product->featured_image }}" alt="{{ $product->name }}" class="w-12 h-14 object-cover rounded-lg bg-zinc-900 border border-white/10 shrink-0">
                                <div>
                                    <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="font-bold text-white hover:text-amber-300 transition block">
                                        {{ $product->name }}
                                    </a>
                                    @if ($product->badge)
                                        <span class="text-[9px] uppercase tracking-wider font-semibold text-amber-400">
                                            {{ $product->badge }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4 text-zinc-400">
                                {{ $product->category->name }}
                            </td>
                            <td class="p-4 font-mono text-zinc-400">
                                {{ $product->sku }}
                            </td>
                            <td class="p-4 font-bold text-white font-mono">
                                ${{ number_format($product->price, 2) }}
                                @if ($product->hasDiscount())
                                    <span class="block text-[10px] text-zinc-500 line-through">${{ number_format($product->original_price, 2) }}</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded text-[11px] font-bold {{ $product->stock <= 5 ? 'bg-rose-500/20 text-rose-300' : 'bg-emerald-500/20 text-emerald-300' }}">
                                    {{ $product->stock }} units
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $product->is_active ? 'bg-emerald-500/20 text-emerald-300' : 'bg-zinc-700 text-zinc-400' }}">
                                    {{ $product->is_active ? 'Active' : 'Draft / Inactive' }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <form action="{{ route('admin.products.toggle', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-xs {{ $product->is_active ? 'text-zinc-400 hover:text-rose-400' : 'text-emerald-400 hover:text-emerald-300' }} underline font-semibold transition">
                                        {{ $product->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-white/5">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
