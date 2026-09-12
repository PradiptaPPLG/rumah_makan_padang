@extends('layouts.admin')

@section('title', 'Menu Masakan - Admin Raso Mandeh')
@section('header_title', 'Kelola Menu Masakan')

@section('content')
<div x-data="{ 
        isAddModalOpen: false, 
        isEditModalOpen: false, 
        editItem: { id: null, nama: '', kategori: 'daging', deskripsi: '', foto: '', badge: '', rating: 5.0, harga: 30000 } 
     }" 
     class="space-y-5">
    
    <!-- Clean Action & Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-neutral-200/80 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <form method="GET" action="{{ route('admin.menu.index') }}" class="flex flex-wrap items-center gap-2.5">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Cari hidangan..." 
                   class="text-xs py-2 px-3 rounded-xl border border-neutral-300 w-48 focus:ring-1 focus:ring-[#7A1F2B] outline-none">

            <select name="kategori" onchange="this.form.submit()" class="text-xs py-2 px-3 rounded-xl border border-neutral-300 bg-white font-medium outline-none">
                <option value="all">Semua Kategori</option>
                @foreach($categories as $key => $name)
                <option value="{{ $key }}" {{ request('kategori') === $key ? 'selected' : '' }}>
                    {{ $name }}
                </option>
                @endforeach
            </select>

            <button type="submit" class="bg-[#7A1F2B] hover:bg-[#611922] text-white text-xs font-semibold py-2 px-3.5 rounded-xl shadow-xs transition-colors">
                Cari
            </button>
            @if(request('search') || request('kategori'))
            <a href="{{ route('admin.menu.index') }}" class="text-xs text-neutral-400 hover:text-neutral-700 underline">
                Reset
            </a>
            @endif
        </form>

        <button @click="isAddModalOpen = true" 
                class="bg-[#7A1F2B] hover:bg-[#611922] text-white text-xs font-semibold py-2.5 px-4 rounded-xl shadow-xs flex items-center justify-center space-x-1.5 transition-colors whitespace-nowrap">
            <svg class="w-4 h-4 text-[#C9A227]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            <span>Tambah Hidangan Baru</span>
        </button>
    </div>

    <!-- Clean Menu Table -->
    <div class="bg-white rounded-2xl border border-neutral-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-neutral-50/70 border-b border-neutral-200/80 text-[11px] font-semibold text-neutral-500 uppercase tracking-wider">
                    <tr>
                        <th class="py-3 px-5">Hidangan</th>
                        <th class="py-3 px-5">Kategori</th>
                        <th class="py-3 px-5">Badge & Rating</th>
                        <th class="py-3 px-5">Harga Porsi</th>
                        <th class="py-3 px-5">Ketersediaan</th>
                        <th class="py-3 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse($menuItems as $item)
                    @php
                        $basePrice = $item->branchPrices->first()->harga ?? 25000;
                    @endphp
                    <tr class="hover:bg-neutral-50/50 transition-colors">
                        <td class="py-3 px-5">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $item->foto }}" alt="{{ $item->nama }}" class="w-11 h-11 rounded-xl object-cover flex-shrink-0 bg-neutral-100">
                                <div>
                                    <h4 class="font-semibold text-neutral-900 text-xs">{{ $item->nama }}</h4>
                                    <p class="text-[11px] text-neutral-500 line-clamp-1 max-w-xs">{{ $item->deskripsi }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wider bg-neutral-100 text-neutral-700">
                                {{ $item->kategori }}
                            </span>
                        </td>
                        <td class="py-3 px-5 whitespace-nowrap">
                            <div class="flex items-center space-x-1.5">
                                @if($item->badge)
                                <span class="px-1.5 py-0.5 rounded text-[10px] font-bold text-white
                                    @if($item->badge === 'Signature') bg-[#7A1F2B]
                                    @elseif($item->badge === 'Favorit') bg-[#C9A227] text-neutral-900
                                    @else bg-emerald-600 @endif">
                                    {{ $item->badge }}
                                </span>
                                @endif
                                <span class="text-xs font-semibold text-amber-500 flex items-center">
                                    ★ {{ $item->rating }}
                                </span>
                            </div>
                        </td>
                        <td class="py-3 px-5 font-bold text-neutral-900 whitespace-nowrap">
                            Rp {{ number_format($basePrice, 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-5 whitespace-nowrap">
                            <form action="{{ route('admin.menu.toggleActive', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold transition-colors
                                    {{ $item->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60 hover:bg-emerald-100' : 'bg-neutral-100 text-neutral-500 border border-neutral-200 hover:bg-neutral-200' }}"
                                    title="Klik untuk mengubah ketersediaan">
                                    {{ $item->is_active ? '● Aktif' : '○ Non-aktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="py-3 px-5 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end space-x-1.5">
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
                                        class="p-1.5 rounded-lg text-neutral-500 hover:text-neutral-900 hover:bg-neutral-100 transition-colors"
                                        title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </button>
                                <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus hidangan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg text-neutral-400 hover:text-rose-600 hover:bg-rose-50 transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center text-neutral-400">
                            Tidak ditemukan menu dengan filter tersebut.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-neutral-100">
            {{ $menuItems->links() }}
        </div>
    </div>

    <!-- Modal Tambah Menu Baru -->
    <div x-show="isAddModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-neutral-900/50 backdrop-blur-xs" @click="isAddModalOpen = false"></div>
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative w-full max-w-md bg-white rounded-2xl shadow-xl p-5 space-y-4 border border-neutral-200">
                <div class="flex items-center justify-between border-b border-neutral-100 pb-3">
                    <h3 class="font-bold text-base text-neutral-900">Tambah Hidangan Baru</h3>
                    <button @click="isAddModalOpen = false" class="text-neutral-400 hover:text-neutral-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('admin.menu.store') }}" method="POST" class="space-y-3 text-xs">
                    @csrf
                    <div>
                        <label class="block font-semibold text-neutral-700 mb-1">Nama Hidangan *</label>
                        <input type="text" name="nama" required placeholder="Contoh: Gulai Tunjang" class="w-full text-xs p-2.5 rounded-xl border border-neutral-300 focus:ring-1 focus:ring-[#7A1F2B] outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-semibold text-neutral-700 mb-1">Kategori *</label>
                            <select name="kategori" required class="w-full text-xs p-2.5 rounded-xl border border-neutral-300 bg-white outline-none">
                                <option value="daging">Lauk Daging</option>
                                <option value="ayam">Lauk Ayam</option>
                                <option value="ikan">Lauk Ikan</option>
                                <option value="sayur">Sayur & Sambal</option>
                                <option value="minuman">Minuman Tradisional</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold text-neutral-700 mb-1">Harga (Rp) *</label>
                            <input type="number" name="harga" required value="30000" class="w-full text-xs p-2.5 rounded-xl border border-neutral-300 outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-semibold text-neutral-700 mb-1">Badge</label>
                            <select name="badge" class="w-full text-xs p-2.5 rounded-xl border border-neutral-300 bg-white outline-none">
                                <option value="">Tanpa Badge</option>
                                <option value="Signature">Signature</option>
                                <option value="Favorit">Favorit</option>
                                <option value="Baru">Baru</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold text-neutral-700 mb-1">Rating</label>
                            <input type="number" step="0.1" min="1" max="5" name="rating" value="4.8" class="w-full text-xs p-2.5 rounded-xl border border-neutral-300 outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold text-neutral-700 mb-1">URL Foto Masakan</label>
                        <input type="url" name="foto" placeholder="https://images.unsplash.com/..." class="w-full text-xs p-2.5 rounded-xl border border-neutral-300 outline-none">
                    </div>

                    <div>
                        <label class="block font-semibold text-neutral-700 mb-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="2" placeholder="Rasa dan kelezatan hidangan..." class="w-full text-xs p-2.5 rounded-xl border border-neutral-300 outline-none"></textarea>
                    </div>

                    <div class="pt-2 flex justify-end space-x-2">
                        <button type="button" @click="isAddModalOpen = false" class="py-2 px-3.5 rounded-xl bg-neutral-100 hover:bg-neutral-200 text-neutral-700 font-semibold transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="py-2 px-4 rounded-xl bg-[#7A1F2B] hover:bg-[#611922] text-white font-semibold shadow-xs transition-colors">
                            Simpan Hidangan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Menu -->
    <div x-show="isEditModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-neutral-900/50 backdrop-blur-xs" @click="isEditModalOpen = false"></div>
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative w-full max-w-md bg-white rounded-2xl shadow-xl p-5 space-y-4 border border-neutral-200">
                <div class="flex items-center justify-between border-b border-neutral-100 pb-3">
                    <h3 class="font-bold text-base text-neutral-900">Edit Hidangan</h3>
                    <button @click="isEditModalOpen = false" class="text-neutral-400 hover:text-neutral-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form :action="'/admin/menu/' + editItem.id" method="POST" class="space-y-3 text-xs">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block font-semibold text-neutral-700 mb-1">Nama Hidangan *</label>
                        <input type="text" name="nama" required x-model="editItem.nama" class="w-full text-xs p-2.5 rounded-xl border border-neutral-300 focus:ring-1 focus:ring-[#7A1F2B] outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-semibold text-neutral-700 mb-1">Kategori *</label>
                            <select name="kategori" required x-model="editItem.kategori" class="w-full text-xs p-2.5 rounded-xl border border-neutral-300 bg-white outline-none">
                                <option value="daging">Lauk Daging</option>
                                <option value="ayam">Lauk Ayam</option>
                                <option value="ikan">Lauk Ikan</option>
                                <option value="sayur">Sayur & Sambal</option>
                                <option value="minuman">Minuman Tradisional</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold text-neutral-700 mb-1">Harga (Rp) *</label>
                            <input type="number" name="harga" required x-model="editItem.harga" class="w-full text-xs p-2.5 rounded-xl border border-neutral-300 outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-semibold text-neutral-700 mb-1">Badge</label>
                            <select name="badge" x-model="editItem.badge" class="w-full text-xs p-2.5 rounded-xl border border-neutral-300 bg-white outline-none">
                                <option value="">Tanpa Badge</option>
                                <option value="Signature">Signature</option>
                                <option value="Favorit">Favorit</option>
                                <option value="Baru">Baru</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold text-neutral-700 mb-1">Rating</label>
                            <input type="number" step="0.1" min="1" max="5" name="rating" x-model="editItem.rating" class="w-full text-xs p-2.5 rounded-xl border border-neutral-300 outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold text-neutral-700 mb-1">URL Foto Masakan</label>
                        <input type="url" name="foto" x-model="editItem.foto" class="w-full text-xs p-2.5 rounded-xl border border-neutral-300 outline-none">
                    </div>

                    <div>
                        <label class="block font-semibold text-neutral-700 mb-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="2" x-model="editItem.deskripsi" class="w-full text-xs p-2.5 rounded-xl border border-neutral-300 outline-none"></textarea>
                    </div>

                    <div class="pt-2 flex justify-end space-x-2">
                        <button type="button" @click="isEditModalOpen = false" class="py-2 px-3.5 rounded-xl bg-neutral-100 hover:bg-neutral-200 text-neutral-700 font-semibold transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="py-2 px-4 rounded-xl bg-[#7A1F2B] hover:bg-[#611922] text-white font-semibold shadow-xs transition-colors">
                            Perbarui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
