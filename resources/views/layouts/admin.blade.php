<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - Raso Minang')</title>

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🍛</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ sidebarOpen: false }" class="bg-[#F9FAFB] text-neutral-800 font-sans antialiased">

    <div class="min-h-screen flex">
        
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false" 
             class="fixed inset-0 bg-neutral-900/60 backdrop-blur-xs z-40 lg:hidden"
             style="display: none;"
             x-cloak></div>

        <!-- Sleek Dark Fixed Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed inset-y-0 left-0 z-40 w-64 bg-[#18181B] text-neutral-300 flex flex-col transition-transform duration-250 ease-in-out border-r border-neutral-800">
            
            <!-- Brand Header -->
            <div class="h-16 px-6 border-b border-neutral-800/80 flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 group">
                    <div class="w-8 h-8 rounded-lg bg-[#7A1F2B] flex items-center justify-center text-[#C9A227] font-bold text-sm tracking-wider shadow-xs border border-[#C9A227]/30">
                        RM
                    </div>
                    <div>
                        <span class="font-bold text-base text-white tracking-tight block leading-tight">Raso Minang</span>
                        <span class="text-[10px] text-neutral-400 font-medium block">Dashboard Restoran</span>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-neutral-400 hover:text-white p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-3 py-5 space-y-6 overflow-y-auto">
                
                <!-- Main Section -->
                <div>
                    <span class="px-3 text-[10px] font-bold tracking-wider uppercase text-neutral-500 block mb-2">Utama</span>
                    <div class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center space-x-3 px-3 py-2.5 rounded-xl font-medium text-xs transition-all
                           {{ request()->routeIs('admin.dashboard') ? 'bg-[#7A1F2B] text-white shadow-xs font-semibold' : 'text-neutral-400 hover:bg-neutral-800/60 hover:text-neutral-100' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.dashboard') ? 'text-[#C9A227]' : 'text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('admin.orders.index') }}" 
                           class="flex items-center justify-between px-3 py-2.5 rounded-xl font-medium text-xs transition-all
                           {{ request()->routeIs('admin.orders.*') ? 'bg-[#7A1F2B] text-white shadow-xs font-semibold' : 'text-neutral-400 hover:bg-neutral-800/60 hover:text-neutral-100' }}">
                            <div class="flex items-center space-x-3">
                                <svg class="w-4 h-4 {{ request()->routeIs('admin.orders.*') ? 'text-[#C9A227]' : 'text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                <span>Pesanan Masuk</span>
                            </div>
                            @php
                                $pendingOrdersCount = \App\Models\Order::where('status', 'pending')->count();
                            @endphp
                            @if($pendingOrdersCount > 0)
                            <span class="bg-[#C9A227] text-neutral-900 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                {{ $pendingOrdersCount }}
                            </span>
                            @endif
                        </a>
                    </div>
                </div>

                <!-- Management Section -->
                <div>
                    <span class="px-3 text-[10px] font-bold tracking-wider uppercase text-neutral-500 block mb-2">Operasional</span>
                    <div class="space-y-1">
                        <a href="{{ route('admin.menu.index') }}" 
                           class="flex items-center space-x-3 px-3 py-2.5 rounded-xl font-medium text-xs transition-all
                           {{ request()->routeIs('admin.menu.*') ? 'bg-[#7A1F2B] text-white shadow-xs font-semibold' : 'text-neutral-400 hover:bg-neutral-800/60 hover:text-neutral-100' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.menu.*') ? 'text-[#C9A227]' : 'text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span>Menu Masakan</span>
                        </a>

                        <a href="{{ route('admin.branches.index') }}" 
                           class="flex items-center space-x-3 px-3 py-2.5 rounded-xl font-medium text-xs transition-all
                           {{ request()->routeIs('admin.branches.*') ? 'bg-[#7A1F2B] text-white shadow-xs font-semibold' : 'text-neutral-400 hover:bg-neutral-800/60 hover:text-neutral-100' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.branches.*') ? 'text-[#C9A227]' : 'text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span>Cabang Restoran</span>
                        </a>

                        <a href="{{ route('admin.reviews.index') }}" 
                           class="flex items-center justify-between px-3 py-2.5 rounded-xl font-medium text-xs transition-all
                           {{ request()->routeIs('admin.reviews.*') ? 'bg-[#7A1F2B] text-white shadow-xs font-semibold' : 'text-neutral-400 hover:bg-neutral-800/60 hover:text-neutral-100' }}">
                            <div class="flex items-center space-x-3">
                                <svg class="w-4 h-4 {{ request()->routeIs('admin.reviews.*') ? 'text-[#C9A227]' : 'text-neutral-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                <span>Moderasi Ulasan</span>
                            </div>
                            @php
                                $unapprovedCount = \App\Models\Review::where('is_approved', false)->count();
                            @endphp
                            @if($unapprovedCount > 0)
                            <span class="bg-amber-500/20 text-amber-300 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                {{ $unapprovedCount }}
                            </span>
                            @endif
                        </a>
                    </div>
                </div>

            </nav>

            <!-- User Info & Logout Footer -->
            <div class="p-3 border-t border-neutral-800 bg-neutral-950/40 space-y-2">
                <div class="flex items-center justify-between p-2 rounded-xl bg-neutral-900/60 border border-neutral-800">
                    <div class="flex items-center space-x-2.5 min-w-0">
                        <div class="w-8 h-8 rounded-lg bg-[#7A1F2B] text-white font-bold text-xs flex items-center justify-center flex-shrink-0">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-semibold text-white truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                            <p class="text-[10px] text-neutral-400 truncate">{{ Auth::user()->email ?? 'admin@rasominang.com' }}</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="p-1.5 text-neutral-400 hover:text-rose-400 hover:bg-neutral-800 rounded-lg transition-colors" 
                                title="Keluar">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>

                <a href="{{ url('/') }}" target="_blank" 
                   class="flex items-center justify-center space-x-1.5 w-full py-2 px-3 rounded-lg text-neutral-400 hover:text-white hover:bg-neutral-800 text-[11px] font-medium transition-all">
                    <span>Lihat Website</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
            </div>
        </aside>

        <!-- Main Content Area with Fixed Sidebar Offset -->
        <div class="lg:pl-64 flex-1 flex flex-col min-w-0 min-h-screen">
            
            <!-- Clean White Sticky Topbar -->
            <header class="sticky top-0 z-30 bg-white/95 backdrop-blur-sm border-b border-neutral-200/80 h-16 px-6 lg:px-8 flex items-center justify-between flex-shrink-0">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = true" class="lg:hidden p-1.5 rounded-lg text-neutral-600 hover:bg-neutral-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <div>
                        <div class="flex items-center space-x-2 text-xs text-neutral-400 font-medium">
                            <span>Admin</span>
                            <span>/</span>
                            <span class="text-neutral-700 font-semibold">@yield('header_title', 'Dashboard')</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="hidden sm:flex items-center space-x-2 text-xs bg-emerald-50 border border-emerald-200/70 text-emerald-700 px-3 py-1.5 rounded-full font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Sistem Restoran Aktif</span>
                    </div>

                    <span class="text-xs text-neutral-400 hidden md:block">
                        {{ date('d M Y') }}
                    </span>
                </div>
            </header>

            <!-- Flash Alerts -->
            @if(session('success'))
            <div class="mx-6 lg:mx-8 mt-4 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-xs">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mx-6 lg:mx-8 mt-4 p-3.5 rounded-xl bg-rose-50 border border-rose-200/80 text-rose-800 text-xs font-semibold flex items-center justify-between shadow-xs">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
            @endif

            <!-- Main Scrollable Content -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-8">
                @yield('content')
            </main>
        </div>

    </div>

</body>
</html>
