<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'ATELIER ÉLITE — Luxury Fashion & Haute Prêt-à-Porter')</title>
    <meta name="description" content="@yield('meta_description', 'Discover handcrafted Italian outerwear, Grade-A cashmere knitwear, and timeless bespoke leather goods designed for modern elegance.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Tailwind CSS & App Bundle -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-serif-luxury {
            font-family: 'Playfair Display', Georgia, serif;
        }
        .font-sans-modern {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }
        .glass-nav {
            background: rgba(15, 17, 23, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .glass-card {
            background: rgba(23, 27, 38, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .text-gold {
            color: #d4af37;
        }
        .bg-gold {
            background-color: #d4af37;
        }
        .border-gold {
            border-color: #d4af37;
        }
        .hover-gold:hover {
            color: #e6c86e;
        }
    </style>
</head>
<body class="h-full bg-[#0B0D13] text-[#E2E8F0] font-sans-modern antialiased selection:bg-[#d4af37] selection:text-black flex flex-col">

    <!-- Top Announcement Bar -->
    <aside aria-label="Announcement" class="bg-gradient-to-r from-[#181a24] via-[#212433] to-[#181a24] border-b border-white/5 text-xs tracking-wider uppercase py-2 px-4 text-center font-medium text-amber-200/90 flex items-center justify-center gap-3">
        <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        <span>Autumn / Winter Atelier Collection Now Available • Complimentary Global Express Delivery Over $150</span>
        <a href="{{ route('products.index') }}" class="underline hover:text-white transition">Explore Collection</a>
    </aside>

    <!-- Header Navigation -->
    <header class="sticky top-0 z-40 glass-nav border-b border-white/10 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="group flex flex-col" id="nav-brand-logo">
                    <span class="font-serif-luxury text-2xl sm:text-3xl font-bold tracking-[0.2em] text-white group-hover:text-amber-200 transition-colors">
                        ATELIER<span class="text-amber-400 font-light">.</span>
                    </span>
                    <span class="text-[9px] tracking-[0.4em] uppercase text-zinc-400 -mt-1 font-medium">Haute Prêt-à-Porter</span>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center space-x-7 text-sm font-medium tracking-wide">
                    <a href="{{ route('home') }}" class="transition-colors hover:text-amber-300 {{ request()->routeIs('home') ? 'text-amber-300' : 'text-zinc-300' }}">Home</a>
                    <a href="{{ route('products.index') }}" class="transition-colors hover:text-amber-300 {{ request()->routeIs('products.*') ? 'text-amber-300' : 'text-zinc-300' }}">Catalog</a>
                    <a href="{{ route('products.index', ['category' => 'outerwear']) }}" class="text-zinc-400 hover:text-white transition">Outerwear</a>
                    <a href="{{ route('products.index', ['category' => 'knitwear']) }}" class="text-zinc-400 hover:text-white transition">Knitwear</a>
                    <a href="{{ route('products.index', ['category' => 'footwear']) }}" class="text-zinc-400 hover:text-white transition">Footwear</a>
                    <a href="{{ route('products.index', ['category' => 'leather-goods']) }}" class="text-zinc-400 hover:text-white transition">Leather</a>
                </nav>
            </div>

            <!-- Right Utilities (Search, Admin Portal, Cart) -->
            <div class="flex items-center gap-4">
                <!-- Search Form (Desktop) -->
                <form action="{{ route('products.index') }}" method="GET" class="hidden lg:flex items-center relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search curated garments..."
                           class="w-56 bg-white/5 border border-white/10 rounded-full px-4 py-1.5 pl-9 text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-amber-400/60 focus:ring-1 focus:ring-amber-400/50 transition">
                    <svg class="w-4 h-4 text-zinc-400 absolute left-3 top-2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </form>

                <!-- Admin Link -->
                <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center gap-1.5 text-xs text-zinc-400 hover:text-amber-300 py-1 px-2.5 rounded border border-white/10 hover:border-amber-400/40 transition">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Store Admin</span>
                </a>

                <!-- Cart Button -->
                @php
                    $cartCount = app(\App\Services\CartService::class)->getItemCount();
                @endphp
                <a href="{{ route('cart.index') }}" id="nav-cart-btn" class="relative inline-flex items-center gap-2 bg-gradient-to-r from-amber-500/20 to-amber-600/10 hover:from-amber-500/30 hover:to-amber-600/20 border border-amber-500/30 hover:border-amber-400 px-3.5 py-2 rounded-full text-amber-200 transition group shadow-lg shadow-black/20">
                    <svg class="w-5 h-5 text-amber-300 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span class="text-xs font-semibold tracking-wide hidden sm:inline">Bag</span>
                    <span id="nav-cart-count" class="inline-flex items-center justify-center w-5 h-5 text-[11px] font-bold bg-amber-400 text-black rounded-full shadow">
                        {{ $cartCount }}
                    </span>
                </a>
            </div>
        </div>
    </header>

    <!-- Global Flash Notification Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full z-50">
        @if (session('success'))
            <div id="flash-success" class="flex items-center justify-between p-4 bg-emerald-950/80 border border-emerald-500/40 rounded-xl text-emerald-200 shadow-xl backdrop-blur-md transition transform duration-300">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="document.getElementById('flash-success').remove()" class="text-emerald-400 hover:text-white text-sm font-bold ml-4">✕</button>
            </div>
        @endif

        @if (session('error'))
            <div id="flash-error" class="flex items-center justify-between p-4 bg-rose-950/80 border border-rose-500/40 rounded-xl text-rose-200 shadow-xl backdrop-blur-md transition transform duration-300">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
                <button type="button" onclick="document.getElementById('flash-error').remove()" class="text-rose-400 hover:text-white text-sm font-bold ml-4">✕</button>
            </div>
        @endif
    </div>

    <!-- Main Content Yield -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#07080c] border-t border-white/10 text-zinc-400 mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
                <!-- Brand Info -->
                <div class="lg:col-span-2 space-y-4">
                    <span class="font-serif-luxury text-2xl font-bold tracking-[0.2em] text-white">
                        ATELIER<span class="text-amber-400">.</span>
                    </span>
                    <p class="text-sm text-zinc-400 leading-relaxed pr-6">
                        Exquisite artisanal garments curated with uncompromising attention to provenance, texture, and tailored silhouettes. Rooted in traditional European mills and sustainable fine craft.
                    </p>
                    <div class="flex items-center gap-4 pt-2">
                        <span class="text-xs uppercase tracking-widest text-amber-300/80 font-semibold">Atelier Flagships:</span>
                        <span class="text-xs text-zinc-400">Milan • Paris • London • New York</span>
                    </div>
                </div>

                <!-- Navigation Collections -->
                <div>
                    <h3 class="text-white text-xs font-semibold tracking-widest uppercase mb-4">Collections</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('products.index', ['category' => 'outerwear']) }}" class="hover:text-amber-300 transition">Outerwear & Coats</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'tailored-essentials']) }}" class="hover:text-amber-300 transition">Tailored Essentials</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'knitwear']) }}" class="hover:text-amber-300 transition">Mongolian Cashmere</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'footwear']) }}" class="hover:text-amber-300 transition">Goodyear Boots</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'leather-goods']) }}" class="hover:text-amber-300 transition">Tuscan Leather Bags</a></li>
                    </ul>
                </div>

                <!-- Customer Care -->
                <div>
                    <h3 class="text-white text-xs font-semibold tracking-widest uppercase mb-4">Bespoke Care</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('cart.index') }}" class="hover:text-amber-300 transition">Shopping Bag</a></li>
                        <li><a href="{{ route('checkout.index') }}" class="hover:text-amber-300 transition">Express Checkout</a></li>
                        <li><a href="{{ route('admin.dashboard') }}" class="hover:text-amber-300 transition">Store Admin Panel</a></li>
                        <li><span class="text-zinc-500">Bespoke Alterations</span></li>
                        <li><span class="text-zinc-500">Care & Preservation</span></li>
                    </ul>
                </div>

                <!-- Newsletter / Concierge -->
                <div>
                    <h3 class="text-white text-xs font-semibold tracking-widest uppercase mb-4">Atelier Gazette</h3>
                    <p class="text-xs text-zinc-400 mb-3">Subscribe for private seasonal salon invitations and limited archival capsule drops.</p>
                    <div class="flex">
                        <input type="email" placeholder="Your email address" class="w-full bg-white/5 border border-white/10 rounded-l px-3 py-2 text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-amber-400">
                        <button class="bg-amber-400 text-black px-3 py-2 text-xs font-bold rounded-r hover:bg-amber-300 transition">Join</button>
                    </div>
                </div>
            </div>

            <!-- Bottom Legal Bar -->
            <div class="border-t border-white/5 mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-zinc-500">
                <p>&copy; {{ date('Y') }} ATELIER ÉLITE. All rights reserved. Built with Laravel 12 & Modern PHP 8.3.</p>
                <div class="flex items-center gap-6 mt-4 sm:mt-0">
                    <span class="inline-flex items-center gap-1.5 text-zinc-400">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        Encrypted 256-bit Checkout
                    </span>
                    <a href="{{ route('admin.dashboard') }}" class="text-amber-400/80 hover:text-amber-300 underline">Admin Console</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
