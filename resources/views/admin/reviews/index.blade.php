@extends('layouts.admin')

@section('title', 'Moderasi Ulasan - Admin Raso Minang')
@section('header_title', 'Moderasi Ulasan Pelanggan')

@section('content')
<div class="space-y-6">
    
    <!-- Filter Bar -->
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-[#C9A227]/20 flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.reviews.index') }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition-all
               {{ !request('status') ? 'bg-[#7A1F2B] text-white shadow' : 'bg-stone-100 text-[#241B16] hover:bg-stone-200' }}">
                Semua Ulasan
            </a>
            <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition-all
               {{ request('status') === 'pending' ? 'bg-[#7A1F2B] text-white shadow' : 'bg-stone-100 text-[#241B16] hover:bg-stone-200' }}">
                Menunggu Persetujuan
            </a>
            <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition-all
               {{ request('status') === 'approved' ? 'bg-[#7A1F2B] text-white shadow' : 'bg-stone-100 text-[#241B16] hover:bg-stone-200' }}">
                Sudah Disetujui
            </a>
        </div>

        <span class="text-xs text-[#241B16]/60">
            Total: {{ $reviews->total() }} Ulasan
        </span>
    </div>

    <!-- Reviews Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-[#C9A227]/20 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-stone-50 border-b border-stone-200 text-xs font-bold text-[#241B16]/70 uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-5">Pelanggan</th>
                        <th class="py-3.5 px-5">Cabang</th>
                        <th class="py-3.5 px-5">Rating</th>
                        <th class="py-3.5 px-5">Komentar Ulasan</th>
                        <th class="py-3.5 px-5">Status Web</th>
                        <th class="py-3.5 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($reviews as $review)
                    <tr class="hover:bg-stone-50/70 transition-colors">
                        <td class="py-4 px-5">
                            <span class="font-bold text-[#241B16]">{{ $review->nama_pelanggan }}</span>
                            <span class="text-xs text-[#241B16]/50 block">{{ $review->created_at->format('d M Y') }}</span>
                        </td>
                        <td class="py-4 px-5 text-xs text-[#241B16]/80 font-medium">
                            {{ $review->branch ? $review->branch->kota : 'Umum' }}
                        </td>
                        <td class="py-4 px-5">
                            <div class="flex items-center space-x-0.5 text-[#C9A227]">
                                @for($i = 0; $i < $review->rating; $i++)
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                @endfor
                            </div>
                        </td>
                        <td class="py-4 px-5">
                            <p class="text-xs text-[#241B16]/80 italic max-w-md leading-relaxed">
                                "{{ $review->komentar }}"
                            </p>
                        </td>
                        <td class="py-4 px-5 whitespace-nowrap">
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold
                                {{ $review->is_approved ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $review->is_approved ? 'Ditampilkan' : 'Menunggu' }}
                            </span>
                        </td>
                        <td class="py-4 px-5 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end space-x-2">
                                <form action="{{ route('admin.reviews.toggleApprove', $review->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs font-bold py-1.5 px-3 rounded-lg transition-colors
                                        {{ $review->is_approved ? 'bg-amber-50 text-amber-800 hover:bg-amber-100' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}">
                                        {{ $review->is_approved ? 'Tolak / Sembunyikan' : 'Setujui & Tampilkan' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini?')">
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
                            Tidak ada ulasan pada kategori ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-stone-100">
            {{ $reviews->links() }}
        </div>
    </div>

</div>
@endsection
