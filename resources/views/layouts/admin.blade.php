<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Atelier Admin Console')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-[#090B10] text-zinc-100 font-['Plus_Jakarta_Sans',sans-serif] antialiased">
    <div class="min-h-full flex flex-col md:flex-row">
        <!-- Sidebar Navigation -->
        <aside class="w-full md:w-64 bg-[#0F121B] border-r border-white/10 flex flex-col justify-between shrink-0">
            <div>
                <!-- Brand / Logo -->
                <div class="p-6 border-b border-white/10 flex items-center justify-between">
                    <div>
                        <span class="font-serif text-xl font-bold tracking-widest text-white">ATELIER<span class="text-amber-400">.</span></span>
                        <div class="text-[10px] uppercase tracking-wider text-amber-300/80 font-semibold">Management Console</div>
                    </div>
                    <span class="text-xs px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-mono">Live</span>
                </div>

                <!-- Nav Items -->
                <nav class="p-4 space-y-1.5 text-sm font-medium">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-amber-400 text-black font-semibold shadow-lg shadow-amber-400/20' : 'text-zinc-400 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('admin.orders') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.orders*') ? 'bg-amber-400 text-black font-semibold shadow-lg shadow-amber-400/20' : 'text-zinc-400 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            <span>Customer Orders</span>
                        </div>
                        <span class="text-xs px-2 py-0.5 rounded-full {{ request()->routeIs('admin.orders*') ? 'bg-black text-amber-300' : 'bg-white/10 text-zinc-300' }}">
                            {{ \App\Models\Order::count() }}
                        </span>
                    </a>

                    <a href="{{ route('admin.products') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.products*') ? 'bg-amber-400 text-black font-semibold shadow-lg shadow-amber-400/20' : 'text-zinc-400 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            <span>Products Catalog</span>
                        </div>
                        <span class="text-xs px-2 py-0.5 rounded-full {{ request()->routeIs('admin.products*') ? 'bg-black text-amber-300' : 'bg-white/10 text-zinc-300' }}">
                            {{ \App\Models\Product::count() }}
                        </span>
                    </a>

                    <a href="{{ route('admin.products.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-amber-300/90 hover:text-amber-200 hover:bg-amber-500/10 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span>Add New Garment</span>
                    </a>
                </nav>
            </div>

            <!-- Footer Return Link -->
            <div class="p-4 border-t border-white/10 space-y-2">
                <a href="{{ route('home') }}" class="flex items-center gap-2 px-3 py-2 rounded text-xs text-zinc-400 hover:text-white hover:bg-white/5 transition">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span>View Public Storefront</span>
                </a>
            </div>
        </aside>

        <!-- Main Workspace -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top Bar -->
            <header class="h-16 bg-[#0B0E16] border-b border-white/10 px-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <h1 class="text-lg font-semibold text-white">@yield('header_title', 'Admin Dashboard')</h1>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('cart.index') }}" class="text-xs text-zinc-400 hover:text-amber-300 transition">View Bag</a>
                    <a href="{{ route('products.index') }}" class="text-xs text-zinc-400 hover:text-amber-300 transition">Store Catalog</a>
                    <div class="w-8 h-8 rounded-full bg-amber-400/20 border border-amber-400/40 text-amber-300 flex items-center justify-center font-bold text-xs">
                        AD
                    </div>
                </div>
            </header>

            <!-- Alerts -->
            <div class="px-6 pt-4">
                @if (session('success'))
                    <div class="p-3 bg-emerald-950/80 border border-emerald-500/40 rounded-lg text-emerald-200 text-xs flex justify-between items-center mb-4">
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="p-3 bg-rose-950/80 border border-rose-500/40 rounded-lg text-rose-200 text-xs flex justify-between items-center mb-4">
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
            </div>

            <!-- Page Content -->
            <main class="flex-1 p-6 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
