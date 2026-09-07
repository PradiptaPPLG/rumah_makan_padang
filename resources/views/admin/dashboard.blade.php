@extends('layouts.admin')

@section('title', 'Dashboard Utama - Admin Raso Minang')
@section('header_title', 'Ringkasan Restoran')

@section('content')
<div class="space-y-8">
    
    <!-- 4 Key Stat Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Total Revenue -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-[#C9A227]/20 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-[#241B16]/60">Total Pendapatan</span>
                <h3 class="text-2xl font-bold font-serif text-[#7A1F2B] mt-1">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </h3>
                <span class="text-[11px] text-emerald-600 font-medium mt-1 inline-block">Transaksi Berhasil</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#7A1F2B]/10 text-[#7A1F2B] flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-[#C9A227]/20 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-[#241B16]/60">Total Pesanan</span>
                <h3 class="text-2xl font-bold font-serif text-[#241B16] mt-1">
                    {{ $totalOrders }} Pesanan
                </h3>
                <span class="text-[11px] text-[#241B16]/60 font-medium mt-1 inline-block">Semua Cabang</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-[#C9A227]/15 text-[#C9A227] flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-[#C9A227]/20 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-[#241B16]/60">Perlu Diproses</span>
                <h3 class="text-2xl font-bold font-serif text-amber-600 mt-1">
                    {{ $pendingOrders }} Menunggu
                </h3>
                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="text-[11px] text-[#7A1F2B] hover:underline font-semibold mt-1 inline-block">
                    Lihat antrian &rarr;
                </a>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Active Menu Items -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-[#C9A227]/20 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-[#241B16]/60">Menu Aktif</span>
                <h3 class="text-2xl font-bold font-serif text-[#241B16] mt-1">
                    {{ $totalMenuItems }} Lauk
                </h3>
                <span class="text-[11px] text-emerald-600 font-medium mt-1 inline-block">Dari {{ $totalBranches }} Cabang</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

    </div>

    <!-- Status Pipeline Grid -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-[#C9A227]/20">
        <h3 class="font-serif font-bold text-lg text-[#241B16] mb-4">Pipeline Status Pesanan Dapur</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-center hover:shadow-md transition-all">
                <span class="text-xs font-bold text-amber-800 uppercase tracking-wider block">Pending</span>
                <span class="text-2xl font-bold text-amber-900 mt-1 block">{{ $statusCounts['pending'] }}</span>
                <span class="text-[10px] text-amber-700">Baru Masuk</span>
            </a>

            <a href="{{ route('admin.orders.index', ['status' => 'confirmed']) }}" class="p-3.5 rounded-xl bg-blue-50 border border-blue-200 text-center hover:shadow-md transition-all">
                <span class="text-xs font-bold text-blue-800 uppercase tracking-wider block">Confirmed</span>
                <span class="text-2xl font-bold text-blue-900 mt-1 block">{{ $statusCounts['confirmed'] }}</span>
                <span class="text-[10px] text-blue-700">Dikonfirmasi</span>
            </a>

            <a href="{{ route('admin.orders.index', ['status' => 'cooking']) }}" class="p-3.5 rounded-xl bg-orange-50 border border-orange-200 text-center hover:shadow-md transition-all">
                <span class="text-xs font-bold text-orange-800 uppercase tracking-wider block">Cooking</span>
                <span class="text-2xl font-bold text-orange-900 mt-1 block">{{ $statusCounts['cooking'] }}</span>
                <span class="text-[10px] text-orange-700">Sedang Dimasak</span>
            </a>

            <a href="{{ route('admin.orders.index', ['status' => 'ready']) }}" class="p-3.5 rounded-xl bg-purple-50 border border-purple-200 text-center hover:shadow-md transition-all">
                <span class="text-xs font-bold text-purple-800 uppercase tracking-wider block">Ready</span>
                <span class="text-2xl font-bold text-purple-900 mt-1 block">{{ $statusCounts['ready'] }}</span>
                <span class="text-[10px] text-purple-700">Siap Disajikan</span>
            </a>

            <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-center hover:shadow-md transition-all">
                <span class="text-xs font-bold text-emerald-800 uppercase tracking-wider block">Completed</span>
                <span class="text-2xl font-bold text-emerald-900 mt-1 block">{{ $statusCounts['completed'] }}</span>
                <span class="text-[10px] text-emerald-700">Selesai</span>
            </a>

            <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-center hover:shadow-md transition-all">
                <span class="text-xs font-bold text-rose-800 uppercase tracking-wider block">Cancelled</span>
                <span class="text-2xl font-bold text-rose-900 mt-1 block">{{ $statusCounts['cancelled'] }}</span>
                <span class="text-[10px] text-rose-700">Dibatalkan</span>
            </a>

        </div>
    </div>

    <!-- 2 Column Section: Recent Orders & Top Dishes -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Recent Orders (8 cols) -->
        <div class="lg:col-span-8 bg-white rounded-2xl shadow-sm border border-[#C9A227]/20 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-serif font-bold text-lg text-[#241B16]">Pesanan Terbaru</h3>
                    <p class="text-xs text-[#241B16]/60">Daftar transaksi masuk terkini</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-[#7A1F2B] hover:underline">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-stone-200 text-xs font-bold text-[#241B16]/60 uppercase tracking-wider">
                            <th class="pb-3">ID & Pelanggan</th>
                            <th class="pb-3">Cabang</th>
                            <th class="pb-3">Total</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse($recentOrders as $order)
                        <tr class="hover:bg-stone-50/80 transition-colors">
                            <td class="py-3.5">
                                <span class="font-bold text-[#241B16]">#{{ $order->id }}</span> - {{ $order->customer_name ?? 'Pelanggan Walk-in' }}
                                <span class="text-xs text-[#241B16]/50 block">{{ $order->created_at->diffForHumans() }} ({{ ucfirst($order->method) }})</span>
                            </td>
                            <td class="py-3.5 text-xs font-medium text-[#241B16]/80">
                                {{ $order->branch ? $order->branch->kota : '-' }}
                            </td>
                            <td class="py-3.5 font-bold text-[#7A1F2B]">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold
                                    @if($order->status === 'pending') bg-amber-100 text-amber-800
                                    @elseif($order->status === 'confirmed') bg-blue-100 text-blue-800
                                    @elseif($order->status === 'cooking') bg-orange-100 text-orange-800
                                    @elseif($order->status === 'ready') bg-purple-100 text-purple-800
                                    @elseif($order->status === 'completed') bg-emerald-100 text-emerald-800
                                    @else bg-rose-100 text-rose-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="py-3.5 text-right">
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="text-xs py-1 px-2 rounded-lg border border-stone-300 bg-white font-medium focus:ring-1 focus:ring-[#7A1F2B]">
                                        @foreach(\App\Models\Order::STATUSES as $st)
                                            <option value="{{ $st }}" {{ $order->status === $st ? 'selected' : '' }}>
                                                {{ ucfirst($st) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-[#241B16]/60">Belum ada pesanan masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Dishes & Quick Actions (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Top Dishes Widget -->
            <div class="bg-white rounded-2xl shadow-sm border border-[#C9A227]/20 p-6">
                <h3 class="font-serif font-bold text-lg text-[#241B16] mb-4">Hidangan Terlaris</h3>
                <div class="space-y-3.5">
                    @forelse($topDishes as $top)
                    <div class="flex items-center space-x-3">
                        <img src="{{ $top->menuItem->foto ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=100' }}" 
                             alt="{{ $top->menuItem->nama ?? '-' }}" 
                             class="w-12 h-12 rounded-xl object-cover flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-xs text-[#241B16] truncate">{{ $top->menuItem->nama ?? '-' }}</h4>
                            <span class="text-[11px] text-[#241B16]/60">{{ $top->menuItem->kategori ?? '-' }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-bold text-[#7A1F2B]">{{ $top->total_qty }} porsi</span>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-[#241B16]/60 text-center py-4">Belum ada data penjualan.</p>
                    @endforelse
                </div>
            </div>

            <!-- Quick Action Box -->
            <div class="bg-gradient-to-br from-[#7A1F2B] to-[#3D0F15] text-white rounded-2xl p-6 shadow-xl space-y-3">
                <h4 class="font-serif font-bold text-lg text-[#C9A227]">Aksi Cepat Admin</h4>
                <p class="text-xs text-white/80 leading-relaxed">
                    Kelola menu masakan, tambahkan hidangan musiman, atau atur jam operasional cabang.
                </p>
                <div class="space-y-2 pt-2">
                    <a href="{{ route('admin.menu.index') }}" class="block text-center py-2.5 px-4 rounded-xl bg-white text-[#7A1F2B] text-xs font-bold hover:bg-[#C9A227] hover:text-[#241B16] transition-all">
                        + Tambah Menu Masakan Baru
                    </a>
                    <a href="{{ route('admin.branches.index') }}" class="block text-center py-2.5 px-4 rounded-xl bg-white/10 text-white text-xs font-semibold hover:bg-white/20 transition-all">
                        Kelola Jam & Kontak Cabang
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
