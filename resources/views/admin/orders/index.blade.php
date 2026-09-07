@extends('layouts.admin')

@section('title', 'Kelola Pesanan - Admin Raso Minang')
@section('header_title', 'Daftar Pesanan Masuk')

@section('content')
<div x-data="{ selectedOrder: null, isDetailModalOpen: false }" class="space-y-6">
    
    <!-- Filter & Search Bar -->
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-[#C9A227]/20">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-[#241B16]/70 mb-1.5">Status Pesanan</label>
                <select name="status" class="w-full text-xs py-2.5 px-3 rounded-xl border border-stone-300 bg-white font-medium focus:ring-1 focus:ring-[#7A1F2B]">
                    <option value="">Semua Status</option>
                    @foreach(\App\Models\Order::STATUSES as $st)
                    <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>
                        {{ ucfirst($st) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-[#241B16]/70 mb-1.5">Cabang Restoran</label>
                <select name="branch_id" class="w-full text-xs py-2.5 px-3 rounded-xl border border-stone-300 bg-white font-medium focus:ring-1 focus:ring-[#7A1F2B]">
                    <option value="">Semua Cabang</option>
                    @foreach($branches as $b)
                    <option value="{{ $b->id }}" {{ request('branch_id') == $b->id ? 'selected' : '' }}>
                        {{ $b->kota }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-[#241B16]/70 mb-1.5">Metode Layanan</label>
                <select name="method" class="w-full text-xs py-2.5 px-3 rounded-xl border border-stone-300 bg-white font-medium focus:ring-1 focus:ring-[#7A1F2B]">
                    <option value="">Semua Metode</option>
                    <option value="dine-in" {{ request('method') === 'dine-in' ? 'selected' : '' }}>Makan di Tempat (Dine-in)</option>
                    <option value="delivery" {{ request('method') === 'delivery' ? 'selected' : '' }}>Pesan Antar (Delivery)</option>
                    <option value="online" {{ request('method') === 'online' ? 'selected' : '' }}>Online Pickup</option>
                </select>
            </div>

            <div class="flex items-center space-x-2">
                <button type="submit" class="w-full bg-[#7A1F2B] hover:bg-[#3D0F15] text-white text-xs font-bold py-2.5 px-4 rounded-xl shadow transition-all">
                    Terapkan Filter
                </button>
                <a href="{{ route('admin.orders.index') }}" class="py-2.5 px-3 rounded-xl bg-stone-100 hover:bg-stone-200 text-[#241B16] text-xs font-semibold">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-[#C9A227]/20 overflow-hidden">
        <div class="p-5 border-b border-stone-100 flex items-center justify-between">
            <h3 class="font-serif font-bold text-lg text-[#241B16]">
                Total: {{ $orders->total() }} Pesanan
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-stone-50 border-b border-stone-200 text-xs font-bold text-[#241B16]/70 uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-5">ID & Waktu</th>
                        <th class="py-3.5 px-5">Pelanggan</th>
                        <th class="py-3.5 px-5">Cabang & Metode</th>
                        <th class="py-3.5 px-5">Lauk Dipesan</th>
                        <th class="py-3.5 px-5">Total Tagihan</th>
                        <th class="py-3.5 px-5">Status</th>
                        <th class="py-3.5 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-stone-50/70 transition-colors">
                        <td class="py-4 px-5">
                            <span class="font-bold text-[#7A1F2B]">#{{ $order->id }}</span>
                            <span class="text-xs text-[#241B16]/50 block">{{ $order->created_at->format('d M Y, H:i') }}</span>
                        </td>
                        <td class="py-4 px-5">
                            <span class="font-bold text-[#241B16]">{{ $order->customer_name ?? 'Pelanggan Umum' }}</span>
                            <span class="text-xs text-[#241B16]/60 block">{{ $order->customer_phone ?? '-' }}</span>
                        </td>
                        <td class="py-4 px-5">
                            <span class="font-semibold text-xs text-[#241B16] block">{{ $order->branch->kota ?? '-' }}</span>
                            <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[10px] font-bold uppercase
                                @if($order->method === 'dine-in') bg-purple-100 text-purple-800
                                @elseif($order->method === 'delivery') bg-blue-100 text-blue-800
                                @else bg-teal-100 text-teal-800 @endif">
                                {{ $order->method }}
                            </span>
                        </td>
                        <td class="py-4 px-5">
                            <div class="text-xs text-[#241B16]/80 max-w-xs truncate">
                                @foreach($order->items as $idx => $it)
                                    {{ $it->quantity }}x {{ $it->menuItem->nama ?? 'Item' }}{{ !$loop->last ? ',' : '' }}
                                @endforeach
                            </div>
                            @if($order->notes)
                            <span class="text-[11px] text-amber-700 italic block truncate mt-0.5">
                                Catatan: {{ $order->notes }}
                            </span>
                            @endif
                        </td>
                        <td class="py-4 px-5 font-bold text-[#7A1F2B] whitespace-nowrap">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-5 whitespace-nowrap">
                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                <select name="status" onchange="this.form.submit()" class="text-xs font-bold py-1 px-2.5 rounded-full border border-stone-300
                                    @if($order->status === 'pending') bg-amber-50 text-amber-800 border-amber-300
                                    @elseif($order->status === 'confirmed') bg-blue-50 text-blue-800 border-blue-300
                                    @elseif($order->status === 'cooking') bg-orange-50 text-orange-800 border-orange-300
                                    @elseif($order->status === 'ready') bg-purple-50 text-purple-800 border-purple-300
                                    @elseif($order->status === 'completed') bg-emerald-50 text-emerald-800 border-emerald-300
                                    @else bg-rose-50 text-rose-800 border-rose-300 @endif">
                                    @foreach(\App\Models\Order::STATUSES as $st)
                                        <option value="{{ $st }}" {{ $order->status === $st ? 'selected' : '' }}>
                                            {{ ucfirst($st) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="py-4 px-5 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end space-x-2">
                                <button @click="selectedOrder = {{ json_encode($order) }}; isDetailModalOpen = true" 
                                        class="p-1.5 rounded-lg bg-[#C9A227]/15 hover:bg-[#C9A227]/30 text-[#7A1F2B] transition-colors"
                                        title="Detail Pesanan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan #{{ $order->id }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-[#241B16]/60">
                            Tidak ditemukan pesanan dengan kriteria filter tersebut.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-stone-100">
            {{ $orders->links() }}
        </div>
    </div>

    <!-- Detail Order Modal -->
    <div x-show="isDetailModalOpen" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;"
         x-cloak>
        <div class="fixed inset-0 bg-black/50 backdrop-blur-xs" @click="isDetailModalOpen = false"></div>
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 space-y-4 border border-[#C9A227]/30">
                <div class="flex items-center justify-between border-b border-stone-200 pb-3">
                    <h3 class="font-serif font-bold text-xl text-[#241B16]">
                        Rincian Pesanan #<span x-text="selectedOrder?.id"></span>
                    </h3>
                    <button @click="isDetailModalOpen = false" class="text-stone-400 hover:text-stone-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <template x-if="selectedOrder">
                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div>
                                <span class="text-stone-500 block">Pelanggan:</span>
                                <strong x-text="selectedOrder.customer_name || 'Walk-in'"></strong>
                            </div>
                            <div>
                                <span class="text-stone-500 block">No. Telepon / WA:</span>
                                <strong x-text="selectedOrder.customer_phone || '-'"></strong>
                            </div>
                            <div>
                                <span class="text-stone-500 block">Cabang:</span>
                                <strong x-text="selectedOrder.branch?.kota || '-'"></strong>
                            </div>
                            <div>
                                <span class="text-stone-500 block">Metode:</span>
                                <strong class="uppercase" x-text="selectedOrder.method"></strong>
                            </div>
                        </div>

                        <div class="border-t border-stone-100 pt-3">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-stone-600 mb-2">Item Hidangan:</h4>
                            <div class="space-y-2 max-h-56 overflow-y-auto">
                                <template x-for="item in selectedOrder.items" :key="item.id">
                                    <div class="flex justify-between items-center text-xs p-2 bg-stone-50 rounded-lg">
                                        <div>
                                            <span class="font-bold text-[#241B16]" x-text="item.quantity + 'x ' + (item.menu_item?.nama || 'Menu Item')"></span>
                                        </div>
                                        <span class="font-bold text-[#7A1F2B]" x-text="'Rp ' + Number(item.price * item.quantity).toLocaleString('id-ID')"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="border-t border-stone-100 pt-3 flex justify-between items-center">
                            <span class="font-bold text-sm text-[#241B16]">Total Tagihan:</span>
                            <span class="font-bold text-xl text-[#7A1F2B]" x-text="'Rp ' + Number(selectedOrder.total).toLocaleString('id-ID')"></span>
                        </div>

                        <template x-if="selectedOrder.notes">
                            <div class="p-3 bg-amber-50 rounded-xl border border-amber-200 text-xs text-amber-900">
                                <strong>Catatan Khusus:</strong>
                                <p x-text="selectedOrder.notes" class="mt-0.5"></p>
                            </div>
                        </template>
                    </div>
                </template>

                <div class="pt-2">
                    <button @click="isDetailModalOpen = false" class="w-full bg-[#7A1F2B] text-white py-2.5 rounded-xl font-bold text-xs">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
