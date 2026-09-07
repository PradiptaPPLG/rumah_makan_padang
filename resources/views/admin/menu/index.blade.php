@extends('layouts.admin')

@section('title', 'Kelola Menu Masakan - Admin Raso Minang')
@section('header_title', 'Daftar Menu Hidangan Minang')

@section('content')
<div x-data="{ 
        isAddModalOpen: false, 
        isEditModalOpen: false, 
        editItem: { id: null, nama: '', kategori: 'daging', deskripsi: '', foto: '', badge: '', rating: 5.0, harga: 30000 } 
     }" 
     class="space-y-6">
    
    <!-- Action Bar & Filter -->
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-[#C9A227]/20 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.menu.index') }}" class="flex flex-wrap items-center gap-3">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Cari hidangan..." 
                   class="text-xs py-2 px-3.5 rounded-xl border border-stone-300 w-52 focus:ring-1 focus:ring-[#7A1F2B]">

            <select name="kategori" onchange="this.form.submit()" class="text-xs py-2 px-3 rounded-xl border border-stone-300 bg-white font-medium">
                <option value="all">Semua Kategori</option>
                @foreach($categories as $key => $name)
                <option value="{{ $key }}" {{ request('kategori') === $key ? 'selected' : '' }}>
                    {{ $name }}
                </option>
                @endforeach
            </select>

            <button type="submit" class="bg-[#7A1F2B] text-white text-xs font-bold py-2 px-3.5 rounded-xl shadow">
                Cari
            </button>
            @if(request('search') || request('kategori'))
            <a href="{{ route('admin.menu.index') }}" class="text-xs text-stone-500 hover:text-stone-800 underline">
                Reset
            </a>
            @endif
        </form>

        <button @click="isAddModalOpen = true" 
                class="bg-[#7A1F2B] hover:bg-[#3D0F15] text-white text-xs font-bold py-2.5 px-4 rounded-xl shadow flex items-center justify-center space-x-1.5 transition-all">
            <svg class="w-4 h-4 text-[#C9A227]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            <span>Tambah Hidangan Baru</span>
        </button>
    </div>

    <!-- Menu Items Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-[#C9A227]/20 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-stone-50 border-b border-stone-200 text-xs font-bold text-[#241B16]/70 uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-5">Foto & Nama</th>
                        <th class="py-3.5 px-5">Kategori</th>
                        <th class="py-3.5 px-5">Badge & Rating</th>
                        <th class="py-3.5 px-5">Estimasi Harga</th>
                        <th class="py-3.5 px-5">Status</th>
                        <th class="py-3.5 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($menuItems as $item)
                    @php
                        $basePrice = $item->branchPrices->first()->harga ?? 25000;
                    @endphp
                    <tr class="hover:bg-stone-50/70 transition-colors">
                        <td class="py-3.5 px-5">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $item->foto }}" alt="{{ $item->nama }}" class="w-12 h-12 rounded-xl object-cover flex-shrink-0 shadow-xs">
                                <div>
                                    <h4 class="font-bold text-[#241B16] text-sm">{{ $item->nama }}</h4>
                                    <p class="text-xs text-[#241B16]/60 line-clamp-1 max-w-xs">{{ $item->deskripsi }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-5">
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-stone-100 text-stone-700">
                                {{ $item->kategori }}
                            </span>
                        </td>
                        <td class="py-3.5 px-5">
                            <div class="flex items-center space-x-2">
                                @if($item->badge)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold text-white
                                    @if($item->badge === 'Signature') bg-[#7A1F2B]
                                    @elseif($item->badge === 'Favorit') bg-[#C9A227] text-[#241B16]
                                    @else bg-emerald-600 @endif">
                                    {{ $item->badge }}
                                </span>
                                @endif
                                <span class="text-xs font-bold text-[#C9A227] flex items-center">
                                    ★ {{ $item->rating }}
                                </span>
                            </div>
                        </td>
                        <td class="py-3.5 px-5 font-bold text-[#7A1F2B]">
                            Rp {{ number_format($basePrice, 0, ',', '.') }}
                        </td>
                        <td class="py-3.5 px-5">
                            <form action="{{ route('admin.menu.toggleActive', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-2.5 py-1 rounded-full text-xs font-bold transition-colors
                                    {{ $item->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-stone-200 text-stone-600 hover:bg-stone-300' }}"
                                    title="Klik untuk mengubah status">
                                    {{ $item->is_active ? 'Aktif' : 'Non-aktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="py-3.5 px-5 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end space-x-2">
                                <button @click="editItem = {
                                            id: {{ $item->id }},
                                            nama: '{{ addslashes($item->nama) }}',
                                            kategori: '{{ $item->kategori }}',
                                            deskripsi: '{{ addslashes($item->deskripsi) }}',
                                            foto: '{{ $item->foto }}',
                                            badge: '{{ $item->badge }}',
                                            rating: {{ $item->rating }},
                                            harga: {{ $basePrice }}
                                        }; isEditModalOpen = true" 
                                        class="p-1.5 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors"
                                        title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </button>
                                <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors" title="Hapus">
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
                        <td colspan="6" class="py-12 text-center text-[#241B16]/60">
                            Belum ada menu dengan pencarian tersebut.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-stone-100">
            {{ $menuItems->links() }}
        </div>
    </div>

    <!-- Modal Tambah Menu Baru -->
    <div x-show="isAddModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-black/50 backdrop-blur-xs" @click="isAddModalOpen = false"></div>
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 space-y-4 border border-[#C9A227]/30">
                <div class="flex items-center justify-between border-b border-stone-200 pb-3">
                    <h3 class="font-serif font-bold text-xl text-[#241B16]">Tambah Hidangan Baru</h3>
                    <button @click="isAddModalOpen = false" class="text-stone-400 hover:text-stone-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('admin.menu.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-[#241B16]/70 mb-1">Nama Hidangan *</label>
                        <input type="text" name="nama" required placeholder="Contoh: Gulai Tunjang" class="w-full text-xs p-2.5 rounded-xl border border-stone-300">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-[#241B16]/70 mb-1">Kategori *</label>
                            <select name="kategori" required class="w-full text-xs p-2.5 rounded-xl border border-stone-300 bg-white">
                                <option value="daging">Lauk Daging</option>
                                <option value="ayam">Lauk Ayam</option>
                                <option value="ikan">Lauk Ikan</option>
                                <option value="sayur">Sayur & Sambal</option>
                                <option value="minuman">Minuman Tradisional</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#241B16]/70 mb-1">Harga Dasar (Rp) *</label>
                            <input type="number" name="harga" required value="30000" class="w-full text-xs p-2.5 rounded-xl border border-stone-300">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-[#241B16]/70 mb-1">Badge Spesial</label>
                            <select name="badge" class="w-full text-xs p-2.5 rounded-xl border border-stone-300 bg-white">
                                <option value="">Tanpa Badge</option>
                                <option value="Signature">Signature</option>
                                <option value="Favorit">Favorit</option>
                                <option value="Baru">Baru</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#241B16]/70 mb-1">Rating Awal</label>
                            <input type="number" step="0.1" min="1" max="5" name="rating" value="4.8" class="w-full text-xs p-2.5 rounded-xl border border-stone-300">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#241B16]/70 mb-1">URL Foto Hidangan</label>
                        <input type="url" name="foto" placeholder="https://images.unsplash.com/..." class="w-full text-xs p-2.5 rounded-xl border border-stone-300">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#241B16]/70 mb-1">Deskripsi & Kelezatan</label>
                        <textarea name="deskripsi" rows="2" placeholder="Jelaskan kelezatan masakan..." class="w-full text-xs p-2.5 rounded-xl border border-stone-300"></textarea>
                    </div>

                    <div class="pt-2 flex justify-end space-x-2">
                        <button type="button" @click="isAddModalOpen = false" class="py-2 px-4 rounded-xl bg-stone-100 text-stone-700 text-xs font-bold">
                            Batal
                        </button>
                        <button type="submit" class="py-2 px-5 rounded-xl bg-[#7A1F2B] text-white text-xs font-bold shadow">
                            Simpan Menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Menu -->
    <div x-show="isEditModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-black/50 backdrop-blur-xs" @click="isEditModalOpen = false"></div>
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 space-y-4 border border-[#C9A227]/30">
                <div class="flex items-center justify-between border-b border-stone-200 pb-3">
                    <h3 class="font-serif font-bold text-xl text-[#241B16]">Edit Hidangan</h3>
                    <button @click="isEditModalOpen = false" class="text-stone-400 hover:text-stone-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form :action="'/admin/menu/' + editItem.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-[#241B16]/70 mb-1">Nama Hidangan *</label>
                        <input type="text" name="nama" required x-model="editItem.nama" class="w-full text-xs p-2.5 rounded-xl border border-stone-300">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-[#241B16]/70 mb-1">Kategori *</label>
                            <select name="kategori" required x-model="editItem.kategori" class="w-full text-xs p-2.5 rounded-xl border border-stone-300 bg-white">
                                <option value="daging">Lauk Daging</option>
                                <option value="ayam">Lauk Ayam</option>
                                <option value="ikan">Lauk Ikan</option>
                                <option value="sayur">Sayur & Sambal</option>
                                <option value="minuman">Minuman Tradisional</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#241B16]/70 mb-1">Harga (Rp) *</label>
                            <input type="number" name="harga" required x-model="editItem.harga" class="w-full text-xs p-2.5 rounded-xl border border-stone-300">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-[#241B16]/70 mb-1">Badge Spesial</label>
                            <select name="badge" x-model="editItem.badge" class="w-full text-xs p-2.5 rounded-xl border border-stone-300 bg-white">
                                <option value="">Tanpa Badge</option>
                                <option value="Signature">Signature</option>
                                <option value="Favorit">Favorit</option>
                                <option value="Baru">Baru</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#241B16]/70 mb-1">Rating</label>
                            <input type="number" step="0.1" min="1" max="5" name="rating" x-model="editItem.rating" class="w-full text-xs p-2.5 rounded-xl border border-stone-300">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#241B16]/70 mb-1">URL Foto Hidangan</label>
                        <input type="url" name="foto" x-model="editItem.foto" class="w-full text-xs p-2.5 rounded-xl border border-stone-300">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#241B16]/70 mb-1">Deskripsi & Kelezatan</label>
                        <textarea name="deskripsi" rows="2" x-model="editItem.deskripsi" class="w-full text-xs p-2.5 rounded-xl border border-stone-300"></textarea>
                    </div>

                    <div class="pt-2 flex justify-end space-x-2">
                        <button type="button" @click="isEditModalOpen = false" class="py-2 px-4 rounded-xl bg-stone-100 text-stone-700 text-xs font-bold">
                            Batal
                        </button>
                        <button type="submit" class="py-2 px-5 rounded-xl bg-[#7A1F2B] text-white text-xs font-bold shadow">
                            Perbarui Menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
