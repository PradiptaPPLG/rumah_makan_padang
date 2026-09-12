@extends('layouts.admin')

@section('title', 'Pesanan Masuk - Admin Raso Mandeh')
@section('header_title', 'Kelola Pesanan Masuk')

@section('content')
<div x-data="{ selectedOrder: null, isDetailModalOpen: false }" class="space-y-5">
    
    <!-- Clean Filter Bar -->
    <div class="bg-white p-5 rounded-3xl border border-[#C9A227]/20 shadow-[0_4px_20px_rgba(201,162,39,0.05)] relative overflow-hidden">
        <div class="absolute inset-0 opacity-5 bg-[url('https://www.transparenttextures.com/patterns/batik-stripes.png')] pointer-events-none"></div>
        <form method="GET" action="{{ route('admin.orders.index') }}" class="relative z-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-[11px] font-semibold text-neutral-500 mb-1 uppercase tracking-wider">Status Pesanan</label>
                <select name="status" class="w-full text-xs py-2 px-3 rounded-xl border border-neutral-300 bg-white font-medium focus:ring-1 focus:ring-[#7A1F2B] outline-none">
                    <option value="">Semua Status</option>
                    @foreach(\App\Models\Order::STATUSES as $st)
                    <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>
                        {{ ucfirst($st) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-neutral-500 mb-1 uppercase tracking-wider">Cabang Restoran</label>
                <select name="branch_id" class="w-full text-xs py-2 px-3 rounded-xl border border-neutral-300 bg-white font-medium focus:ring-1 focus:ring-[#7A1F2B] outline-none">
                    <option value="">Semua Cabang</option>
                    @foreach($branches as $b)
                    <option value="{{ $b->id }}" {{ request('branch_id') == $b->id ? 'selected' : '' }}>
                        {{ $b->kota }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-neutral-500 mb-1 uppercase tracking-wider">Metode Layanan</label>
                <select name="method" class="w-full text-xs py-2 px-3 rounded-xl border border-neutral-300 bg-white font-medium focus:ring-1 focus:ring-[#7A1F2B] outline-none">
                    <option value="">Semua Metode</option>
                    <option value="dine-in" {{ request('method') === 'dine-in' ? 'selected' : '' }}>Makan di Tempat (Dine-in)</option>
                    <option value="delivery" {{ request('method') === 'delivery' ? 'selected' : '' }}>Pesan Antar (Delivery)</option>
                    <option value="online" {{ request('method') === 'online' ? 'selected' : '' }}>Online Pickup</option>
                </select>
            </div>

            <div class="flex items-center space-x-2">
                <button type="submit" class="w-full bg-[#7A1F2B] hover:bg-[#611922] text-white text-xs font-semibold py-2 px-4 rounded-xl shadow-xs transition-colors">
                    Filter
                </button>
                <a href="{{ route('admin.orders.index') }}" class="py-2 px-3 rounded-xl bg-neutral-100 hover:bg-neutral-200 text-neutral-600 text-xs font-semibold transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-3xl border border-[#C9A227]/20 shadow-[0_4px_20px_rgba(201,162,39,0.05)] overflow-hidden">
        <div class="p-4 border-b border-neutral-200/80 flex items-center justify-between">
            <span class="text-xs font-semibold text-neutral-500">
                Menampilkan <strong class="text-neutral-900">{{ $orders->total() }}</strong> total pesanan
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#F5EFE2]/50 border-b border-[#C9A227]/20 text-xs font-bold text-[#7A1F2B] uppercase tracking-widest font-serif">
                    <tr>
                        <th class="py-4 px-6">ID & Waktu</th>
                        <th class="py-4 px-6">Pelanggan</th>
                        <th class="py-4 px-6">Cabang & Metode</th>
                        <th class="py-4 px-6">Menu Dipesan</th>
                        <th class="py-4 px-6">Total Tagihan</th>
                        <th class="py-4 px-6">Status Dapur</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-neutral-50/50 transition-colors">
                        <td class="py-3.5 px-5">
                            <span class="font-semibold text-neutral-900">#{{ $order->id }}</span>
                            <span class="text-[10px] text-neutral-400 block mt-0.5">{{ $order->created_at->format('d M Y, H:i') }}</span>
                        </td>
                        <td class="py-3.5 px-5">
                            <span class="font-medium text-neutral-900 block">{{ $order->customer_name ?? 'Walk-in' }}</span>
                            <span class="text-[10px] text-neutral-400">{{ $order->customer_phone ?? '-' }}</span>
                        </td>
                        <td class="py-3.5 px-5">
                            <span class="font-medium text-neutral-800 block">{{ $order->branch->kota ?? '-' }}</span>
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium uppercase mt-0.5
                                @if($order->method === 'dine-in') bg-purple-50 text-purple-700
                                @elseif($order->method === 'delivery') bg-blue-50 text-blue-700
                                @else bg-teal-50 text-teal-700 @endif">
                                {{ $order->method }}
                            </span>
                        </td>
                        <td class="py-4 px-6 max-w-xs">
                            <p class="truncate text-neutral-600 font-normal">
                                @foreach($order->items as $idx => $it)
                                    {{ $it->quantity }}x {{ $it->menuItem->nama ?? 'Item' }}{{ !$loop->last ? ',' : '' }}
                                @endforeach
                            </p>
                            @if($order->notes)
                            <span class="text-[11px] text-[#7A1F2B] font-medium block truncate mt-1">
                                Catatan: {{ $order->notes }}
                            </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 font-bold text-[#7A1F2B] text-base whitespace-nowrap">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                <select name="status" onchange="this.form.submit()" class="text-xs font-bold py-1.5 px-3 rounded-full border cursor-pointer outline-none shadow-sm transition-all
                                    @if($order->status === 'pending') bg-amber-50 text-amber-700 border-amber-200 hover:bg-amber-100
                                    @elseif($order->status === 'confirmed') bg-blue-50 text-blue-700 border-blue-200 hover:bg-blue-100
                                    @elseif($order->status === 'cooking') bg-orange-50 text-orange-700 border-orange-200 hover:bg-orange-100
                                    @elseif($order->status === 'ready') bg-purple-50 text-purple-700 border-purple-200 hover:bg-purple-100
                                    @elseif($order->status === 'completed') bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100
                                    @else bg-rose-50 text-rose-700 border-rose-200 hover:bg-rose-100 @endif">
                                    @foreach(\App\Models\Order::STATUSES as $st)
                                        <option value="{{ $st }}" {{ $order->status === $st ? 'selected' : '' }}>
                                            {{ ucfirst($st) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="py-4 px-6 text-right whitespace-nowrap relative">
                            <div x-data="{ openMenu: false }" class="inline-block text-left relative">
                                <button @click="openMenu = !openMenu" @click.away="openMenu = false" 
                                        class="p-2 rounded-xl text-neutral-400 hover:text-[#7A1F2B] hover:bg-[#F5EFE2] transition-colors focus:outline-none"
                                        title="Opsi Aksi">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                    </svg>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div x-show="openMenu" 
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute right-0 mt-1 w-36 bg-white rounded-xl shadow-lg border border-[#C9A227]/20 z-50 py-1.5 overflow-hidden"
                                     style="display: none;"
                                     x-cloak>
                                     
                                    <button @click="selectedOrder = {{ json_encode($order) }}; isDetailModalOpen = true; openMenu = false" 
                                            class="w-full text-left px-4 py-2 text-xs font-medium text-neutral-700 hover:bg-[#F5EFE2] hover:text-[#7A1F2B] transition-colors">
                                        Lihat Rincian
                                    </button>
                                    
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Hapus pesanan #{{ $order->id }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full text-left px-4 py-2 text-xs font-medium text-rose-600 hover:bg-rose-50 transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-10 text-center text-neutral-400">
                            Tidak ditemukan pesanan dengan filter tersebut.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-neutral-100">
            {{ $orders->links() }}
        </div>
    </div>

    <!-- Clean Detail Order Modal -->
    <div x-show="isDetailModalOpen" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;"
         x-cloak>
        <div class="fixed inset-0 bg-neutral-900/50 backdrop-blur-xs" @click="isDetailModalOpen = false"></div>
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative w-full max-w-md bg-white rounded-2xl shadow-xl p-5 space-y-4 border border-neutral-200">
                <div class="flex items-center justify-between border-b border-neutral-100 pb-3">
                    <h3 class="font-bold text-base text-neutral-900">
                        Rincian Pesanan #<span x-text="selectedOrder?.id"></span>
                    </h3>
                    <button @click="isDetailModalOpen = false" class="text-neutral-400 hover:text-neutral-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <template x-if="selectedOrder">
                    <div class="space-y-3 text-xs">
                        <div class="grid grid-cols-2 gap-2 bg-neutral-50 p-3 rounded-xl border border-neutral-100">
                            <div>
                                <span class="text-neutral-400 block text-[10px] uppercase font-semibold">Pelanggan</span>
                                <strong class="text-neutral-800" x-text="selectedOrder.customer_name || 'Walk-in'"></strong>
                            </div>
                            <div>
                                <span class="text-neutral-400 block text-[10px] uppercase font-semibold">Telepon</span>
                                <strong class="text-neutral-800" x-text="selectedOrder.customer_phone || '-'"></strong>
                            </div>
                            <div class="mt-2">
                                <span class="text-neutral-400 block text-[10px] uppercase font-semibold">Cabang</span>
                                <strong class="text-neutral-800" x-text="selectedOrder.branch?.kota || '-'"></strong>
                            </div>
                            <div class="mt-2">
                                <span class="text-neutral-400 block text-[10px] uppercase font-semibold">Metode</span>
                                <strong class="uppercase text-neutral-800" x-text="selectedOrder.method"></strong>
                            </div>
                        </div>

                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-neutral-400 block mb-2">Item Masakan</span>
                            <div class="space-y-1.5 max-h-48 overflow-y-auto">
                                <template x-for="item in selectedOrder.items" :key="item.id">
                                    <div class="flex justify-between items-center py-1.5 px-2.5 bg-neutral-50 rounded-lg">
                                        <span class="font-medium text-neutral-800" x-text="item.quantity + 'x ' + (item.menu_item?.nama || 'Item')"></span>
                                        <span class="font-semibold text-neutral-900" x-text="'Rp ' + Number(item.price * item.quantity).toLocaleString('id-ID')"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="border-t border-neutral-100 pt-3 flex justify-between items-center">
                            <span class="text-xs text-neutral-500 font-medium">Total Pembayaran:</span>
                            <span class="text-lg font-bold text-[#7A1F2B]" x-text="'Rp ' + Number(selectedOrder.total).toLocaleString('id-ID')"></span>
                        </div>

                        <template x-if="selectedOrder.notes">
                            <div class="p-2.5 bg-amber-50 rounded-xl border border-amber-200/60 text-amber-800 text-[11px]">
                                <strong>Catatan:</strong> <span x-text="selectedOrder.notes"></span>
                            </div>
                        </template>
                    </div>
                </template>

                <div class="pt-2">
                    <button @click="isDetailModalOpen = false" class="w-full bg-neutral-100 hover:bg-neutral-200 text-neutral-700 py-2.5 rounded-xl font-semibold text-xs transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
