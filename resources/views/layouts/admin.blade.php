<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - Raso Mandeh')</title>

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

        <!-- Premium Light Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed inset-y-0 left-0 z-40 w-72 bg-white flex flex-col transition-transform duration-300 ease-in-out border-r border-[#C9A227]/20 shadow-[4px_0_24px_rgba(122,31,43,0.05)] relative overflow-hidden">
            
            <!-- Subtle background pattern -->
            <div class="absolute inset-0 opacity-[0.03] bg-[url('https://www.transparenttextures.com/patterns/batik-stripes.png')] mix-blend-multiply pointer-events-none"></div>
            
            <!-- Brand Header -->
            <div class="h-24 px-8 border-b border-[#C9A227]/10 flex items-center justify-between relative z-10 bg-white/50 backdrop-blur-sm">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 group w-full pt-4">
                    <img src="/logo/Logo_Final.png" alt="Raso Mandeh Logo" class="w-40 object-contain drop-shadow-sm transition-transform duration-300 group-hover:scale-105">
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-[#7A1F2B] hover:text-[#C9A227] p-2 bg-[#7A1F2B]/5 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-5 py-6 space-y-8 overflow-y-auto relative z-10 scrollbar-hide">
                
                <!-- Main Section -->
                <div>
                    <span class="px-4 text-[10px] font-bold tracking-widest uppercase text-[#C9A227] block mb-3 font-serif">Utama</span>
                    <div class="space-y-1.5">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-2xl font-medium text-sm transition-all duration-200
                           {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-[#7A1F2B] to-[#9A2A38] text-white shadow-md shadow-[#7A1F2B]/20 font-semibold' : 'text-neutral-600 hover:bg-[#F5EFE2] hover:text-[#7A1F2B]' }}">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-[#C9A227]' : 'text-neutral-400' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('admin.orders.index') }}" 
                           class="flex items-center justify-between px-4 py-3 rounded-2xl font-medium text-sm transition-all duration-200
                           {{ request()->routeIs('admin.orders.*') ? 'bg-gradient-to-r from-[#7A1F2B] to-[#9A2A38] text-white shadow-md shadow-[#7A1F2B]/20 font-semibold' : 'text-neutral-600 hover:bg-[#F5EFE2] hover:text-[#7A1F2B]' }}">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 {{ request()->routeIs('admin.orders.*') ? 'text-[#C9A227]' : 'text-neutral-400' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                <span>Pesanan Masuk</span>
                            </div>
                            @php
                                $pendingOrdersCount = \App\Models\Order::where('status', 'pending')->count();
                            @endphp
                            @if($pendingOrdersCount > 0)
                            <span class="bg-[#C9A227] text-white shadow-sm text-[10px] font-bold px-2.5 py-0.5 rounded-full border border-[#C9A227]/50">
                                {{ $pendingOrdersCount }}
                            </span>
                            @endif
                        </a>
                    </div>
                </div>

                <!-- Management Section -->
                <div>
                    <span class="px-4 text-[10px] font-bold tracking-widest uppercase text-[#C9A227] block mb-3 font-serif">Operasional</span>
                    <div class="space-y-1.5">
                        <a href="{{ route('admin.menu.index') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-2xl font-medium text-sm transition-all duration-200
                           {{ request()->routeIs('admin.menu.*') ? 'bg-gradient-to-r from-[#7A1F2B] to-[#9A2A38] text-white shadow-md shadow-[#7A1F2B]/20 font-semibold' : 'text-neutral-600 hover:bg-[#F5EFE2] hover:text-[#7A1F2B]' }}">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.menu.*') ? 'text-[#C9A227]' : 'text-neutral-400' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span>Menu Masakan</span>
                        </a>

                        <a href="{{ route('admin.branches.index') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-2xl font-medium text-sm transition-all duration-200
                           {{ request()->routeIs('admin.branches.*') ? 'bg-gradient-to-r from-[#7A1F2B] to-[#9A2A38] text-white shadow-md shadow-[#7A1F2B]/20 font-semibold' : 'text-neutral-600 hover:bg-[#F5EFE2] hover:text-[#7A1F2B]' }}">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.branches.*') ? 'text-[#C9A227]' : 'text-neutral-400' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span>Cabang Restoran</span>
                        </a>

                        <a href="{{ route('admin.reviews.index') }}" 
                           class="flex items-center justify-between px-4 py-3 rounded-2xl font-medium text-sm transition-all duration-200
                           {{ request()->routeIs('admin.reviews.*') ? 'bg-gradient-to-r from-[#7A1F2B] to-[#9A2A38] text-white shadow-md shadow-[#7A1F2B]/20 font-semibold' : 'text-neutral-600 hover:bg-[#F5EFE2] hover:text-[#7A1F2B]' }}">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 {{ request()->routeIs('admin.reviews.*') ? 'text-[#C9A227]' : 'text-neutral-400' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                <span>Moderasi Ulasan</span>
                            </div>
                            @php
                                $unapprovedCount = \App\Models\Review::where('is_approved', false)->count();
                            @endphp
                            @if($unapprovedCount > 0)
                            <span class="bg-[#C9A227] text-white shadow-sm text-[10px] font-bold px-2.5 py-0.5 rounded-full border border-[#C9A227]/50">
                                {{ $unapprovedCount }}
                            </span>
                            @endif
                        </a>
                    </div>
                </div>

            </nav>

            <!-- User Info & Logout Footer -->
            <div class="p-5 border-t border-[#C9A227]/20 bg-[#F5EFE2]/50 relative z-10 space-y-3">
                <div class="flex items-center justify-between p-3 rounded-2xl bg-white shadow-sm border border-[#C9A227]/20">
                    <div class="flex items-center space-x-3 min-w-0">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#7A1F2B] to-[#9A2A38] text-[#C9A227] font-serif font-bold text-lg flex items-center justify-center flex-shrink-0 shadow-inner">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-bold text-neutral-800 truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                            <p class="text-[11px] text-neutral-500 truncate">{{ Auth::user()->email ?? 'admin@rasomandeh.com' }}</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="p-2 text-neutral-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all" 
                                title="Keluar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>

                <a href="{{ url('/') }}" target="_blank" 
                   class="flex items-center justify-center space-x-2 w-full py-2.5 px-3 rounded-xl border border-[#C9A227]/30 text-[#7A1F2B] hover:bg-[#7A1F2B] hover:text-white text-xs font-semibold transition-all">
                    <span>Lihat Halaman Restoran</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
            </div>
        </aside>

        <!-- Main Content Area with Fixed Sidebar Offset -->
        <div class="lg:pl-72 flex-1 flex flex-col min-w-0 min-h-screen bg-[#F5EFE2]/30">
            
            <!-- Premium Topbar -->
            <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-[#C9A227]/20 h-20 px-8 flex items-center justify-between flex-shrink-0 shadow-sm">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-xl text-[#7A1F2B] bg-[#7A1F2B]/5 hover:bg-[#7A1F2B]/10 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <div>
                        <div class="flex items-center space-x-2 text-sm text-neutral-500 font-medium font-serif">
                            <span>Admin</span>
                            <span class="text-[#C9A227]">•</span>
                            <span class="text-[#7A1F2B] font-bold text-lg">@yield('header_title', 'Dashboard')</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="hidden sm:flex items-center space-x-2.5 text-xs bg-emerald-50/80 border border-emerald-200 text-emerald-700 px-4 py-2 rounded-full font-bold shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.8)]"></span>
                        <span>Sistem Kasir Aktif</span>
                    </div>

                    <div class="text-sm font-bold text-neutral-700 hidden md:block border-l border-neutral-200 pl-4 font-serif">
                        {{ date('d M Y') }}
                    </div>
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
