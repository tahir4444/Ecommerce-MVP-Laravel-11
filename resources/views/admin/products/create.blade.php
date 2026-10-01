@extends('layouts.admin')

@section('title', 'Add New Garment — Atelier Admin')
@section('header_title', 'Add New Garment to Collection')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.products') }}" class="text-xs text-zinc-400 hover:text-white transition">← Return to Inventory</a>
            <h2 class="text-2xl font-bold text-white font-serif mt-1">Catalog New Garment</h2>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-rose-950/80 border border-rose-500/40 rounded-xl text-rose-200 text-xs">
            <span class="font-bold block mb-1">Please fix the following validation errors:</span>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" class="p-8 rounded-2xl bg-[#111420] border border-white/10 space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs">
            <!-- Category -->
            <div>
                <label for="category_id" class="block text-zinc-300 font-medium mb-1.5">Collection Category *</label>
                <select id="category_id" name="category_id" required class="w-full bg-[#181D2B] border border-white/10 rounded-lg px-3.5 py-2.5 text-white focus:outline-none focus:border-amber-400 transition">
                    <option value="">Select Category</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- SKU -->
            <div>
                <label for="sku" class="block text-zinc-300 font-medium mb-1.5">Garment SKU *</label>
                <input type="text" id="sku" name="sku" value="{{ old('sku', 'ATL-'.rand(100,999)) }}" required
                       class="w-full bg-white/5 border border-white/10 rounded-lg px-3.5 py-2.5 text-white font-mono placeholder-zinc-500 focus:outline-none focus:border-amber-400 transition">
            </div>

            <!-- Name -->
            <div class="sm:col-span-2">
                <label for="name" class="block text-zinc-300 font-medium mb-1.5">Garment Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Como Silk-Wool Peak Lapel Tuxedo" required
                       class="w-full bg-white/5 border border-white/10 rounded-lg px-3.5 py-2.5 text-white placeholder-zinc-500 focus:outline-none focus:border-amber-400 transition">
            </div>

            <!-- Short Description -->
            <div class="sm:col-span-2">
                <label for="short_description" class="block text-zinc-300 font-medium mb-1.5">Headline Summary</label>
                <input type="text" id="short_description" name="short_description" value="{{ old('short_description') }}" placeholder="e.g. Hand-spun Como silk woven with 250 GSM super 150s merino wool."
                       class="w-full bg-white/5 border border-white/10 rounded-lg px-3.5 py-2.5 text-white placeholder-zinc-500 focus:outline-none focus:border-amber-400 transition">
            </div>

            <!-- Full Description -->
            <div class="sm:col-span-2">
                <label for="description" class="block text-zinc-300 font-medium mb-1.5">Artisanal Story & Details *</label>
                <textarea id="description" name="description" rows="4" required placeholder="Describe provenance, fiber grade, tailoring technique, and styling notes..."
                          class="w-full bg-white/5 border border-white/10 rounded-lg px-3.5 py-2.5 text-white placeholder-zinc-500 focus:outline-none focus:border-amber-400 transition">{{ old('description') }}</textarea>
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-zinc-300 font-medium mb-1.5">Acquisition Price ($) *</label>
                <input type="number" step="0.01" id="price" name="price" value="{{ old('price', '420.00') }}" required
                       class="w-full bg-white/5 border border-white/10 rounded-lg px-3.5 py-2.5 text-white font-mono placeholder-zinc-500 focus:outline-none focus:border-amber-400 transition">
            </div>

            <!-- Original Price -->
            <div>
                <label for="original_price" class="block text-zinc-300 font-medium mb-1.5">Original / Comparison Price ($)</label>
                <input type="number" step="0.01" id="original_price" name="original_price" value="{{ old('original_price') }}" placeholder="Optional price strike"
                       class="w-full bg-white/5 border border-white/10 rounded-lg px-3.5 py-2.5 text-white font-mono placeholder-zinc-500 focus:outline-none focus:border-amber-400 transition">
            </div>

            <!-- Stock -->
            <div>
                <label for="stock" class="block text-zinc-300 font-medium mb-1.5">Available Stock (Units) *</label>
                <input type="number" id="stock" name="stock" value="{{ old('stock', '15') }}" min="0" required
                       class="w-full bg-white/5 border border-white/10 rounded-lg px-3.5 py-2.5 text-white placeholder-zinc-500 focus:outline-none focus:border-amber-400 transition">
            </div>

            <!-- Badge -->
            <div>
                <label for="badge" class="block text-zinc-300 font-medium mb-1.5">Spotlight Badge</label>
                <input type="text" id="badge" name="badge" value="{{ old('badge', 'NEW RELEASE') }}" placeholder="e.g. BESTSELLER, LIMITED, ARCHIVAL"
                       class="w-full bg-white/5 border border-white/10 rounded-lg px-3.5 py-2.5 text-white placeholder-zinc-500 focus:outline-none focus:border-amber-400 transition">
            </div>

            <!-- Image URL -->
            <div class="sm:col-span-2">
                <label for="featured_image" class="block text-zinc-300 font-medium mb-1.5">Editorial Photo URL</label>
                <input type="url" id="featured_image" name="featured_image" value="{{ old('featured_image', 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=900&q=80') }}"
                       class="w-full bg-white/5 border border-white/10 rounded-lg px-3.5 py-2.5 text-white placeholder-zinc-500 focus:outline-none focus:border-amber-400 transition">
                <span class="text-[10px] text-zinc-500 mt-1 block">Leave default or supply any high-resolution fashion photograph link.</span>
            </div>

            <!-- Featured Checkbox -->
            <div class="sm:col-span-2 flex items-center gap-3 pt-2">
                <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                       class="w-4 h-4 rounded text-amber-400 bg-white/5 border-white/20 focus:ring-amber-400">
                <label for="is_featured" class="text-zinc-300 font-medium">Highlight on Storefront Homepage Featured Carousel</label>
            </div>
        </div>

        <div class="pt-6 border-t border-white/10 flex items-center justify-end gap-4">
            <a href="{{ route('admin.products') }}" class="px-5 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg text-xs font-semibold text-zinc-300 transition">Cancel</a>
            <button type="submit" class="px-6 py-2.5 bg-amber-400 hover:bg-amber-300 text-black rounded-lg text-xs font-bold uppercase tracking-wider transition shadow-lg shadow-amber-400/20">
                Save & Publish Garment
            </button>
        </div>
    </form>
</div>
@endsection
