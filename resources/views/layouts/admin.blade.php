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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ sidebarOpen: false }" class="bg-[#F8F6F0] text-[#241B16] font-sans antialiased">

    <div class="min-h-screen flex">
        
        <!-- Sidebar Backdrop for Mobile -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false" 
             class="fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

        <!-- Sidebar Navigation -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed inset-y-0 left-0 z-50 w-64 bg-[#241B16] text-white flex flex-col transition-transform duration-300 ease-in-out border-r border-[#C9A227]/20 shadow-2xl lg:static lg:translate-x-0">
            
            <!-- Brand Logo -->
            <div class="p-6 border-b border-white/10 flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#7A1F2B] to-[#3D0F15] flex items-center justify-center text-[#C9A227] font-serif font-bold text-lg border border-[#C9A227]/40 shadow">
                        RM
                    </div>
                    <div>
                        <span class="font-serif font-bold text-xl text-white tracking-wide block leading-none">Raso Minang</span>
                        <span class="text-[10px] text-[#C9A227] tracking-widest uppercase font-semibold block mt-1">Admin Panel</span>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-white/70 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl font-medium text-sm transition-all
                   {{ request()->routeIs('admin.dashboard') ? 'bg-[#7A1F2B] text-white shadow-lg shadow-[#7A1F2B]/30' : 'text-white/75 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-[#C9A227]' : 'text-white/60' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard Utama</span>
                </a>

                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center justify-between px-4 py-3 rounded-xl font-medium text-sm transition-all
                   {{ request()->routeIs('admin.orders.*') ? 'bg-[#7A1F2B] text-white shadow-lg shadow-[#7A1F2B]/30' : 'text-white/75 hover:bg-white/5 hover:text-white' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.orders.*') ? 'text-[#C9A227]' : 'text-white/60' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span>Kelola Pesanan</span>
                    </div>
                    @php
                        $pendingCount = \App\Models\Order::where('status', 'pending')->count();
                    @endphp
                    @if($pendingCount > 0)
                    <span class="bg-[#C9A227] text-[#241B16] text-xs font-bold px-2 py-0.5 rounded-full">
                        {{ $pendingCount }}
                    </span>
                    @endif
                </a>

                <a href="{{ route('admin.menu.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl font-medium text-sm transition-all
                   {{ request()->routeIs('admin.menu.*') ? 'bg-[#7A1F2B] text-white shadow-lg shadow-[#7A1F2B]/30' : 'text-white/75 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.menu.*') ? 'text-[#C9A227]' : 'text-white/60' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span>Daftar Menu Makanan</span>
                </a>

                <a href="{{ route('admin.branches.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl font-medium text-sm transition-all
                   {{ request()->routeIs('admin.branches.*') ? 'bg-[#7A1F2B] text-white shadow-lg shadow-[#7A1F2B]/30' : 'text-white/75 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.branches.*') ? 'text-[#C9A227]' : 'text-white/60' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Cabang Restoran</span>
                </a>

                <a href="{{ route('admin.reviews.index') }}" 
                   class="flex items-center justify-between px-4 py-3 rounded-xl font-medium text-sm transition-all
                   {{ request()->routeIs('admin.reviews.*') ? 'bg-[#7A1F2B] text-white shadow-lg shadow-[#7A1F2B]/30' : 'text-white/75 hover:bg-white/5 hover:text-white' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.reviews.*') ? 'text-[#C9A227]' : 'text-white/60' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        <span>Moderasi Ulasan</span>
                    </div>
                    @php
                        $unapprovedReviews = \App\Models\Review::where('is_approved', false)->count();
                    @endphp
                    @if($unapprovedReviews > 0)
                    <span class="bg-amber-400 text-amber-950 text-xs font-bold px-2 py-0.5 rounded-full">
                        {{ $unapprovedReviews }}
                    </span>
                    @endif
                </a>
            </nav>

            <!-- Bottom Website Link -->
            <div class="p-4 border-t border-white/10">
                <a href="{{ url('/') }}" target="_blank" 
                   class="flex items-center justify-center space-x-2 w-full py-2.5 px-4 rounded-xl bg-white/10 hover:bg-[#C9A227] hover:text-[#241B16] text-white text-xs font-bold transition-all">
                    <span>Lihat Website Publik</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <!-- Topbar -->
            <header class="bg-white border-b border-[#C9A227]/20 shadow-xs px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg hover:bg-stone-100 text-[#241B16]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <div>
                        <h1 class="font-serif font-bold text-xl sm:text-2xl text-[#241B16]">@yield('header_title', 'Dashboard')</h1>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="hidden sm:block text-right">
                        <span class="text-xs text-[#241B16]/60 block font-medium">{{ date('l, d F Y') }}</span>
                        <span class="text-xs font-bold text-[#7A1F2B]">Operasional Restoran Aktif</span>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-[#7A1F2B] text-white flex items-center justify-center font-bold text-sm shadow">
                        A
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            @if(session('success'))
            <div class="mx-4 sm:mx-6 lg:mx-8 mt-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mx-4 sm:mx-6 lg:mx-8 mt-4 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-semibold">{{ session('error') }}</span>
                </div>
            </div>
            @endif

            <!-- Main Scrollable Body -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>

    </div>

</body>
</html>
