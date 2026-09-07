@extends('layouts.admin')

@section('title', 'Moderasi Ulasan - Admin Raso Minang')
@section('header_title', 'Moderasi Ulasan Pelanggan')

@section('content')
<div class="space-y-5">
    
    <!-- Clean Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-neutral-200/80 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.reviews.index') }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-colors
               {{ !request('status') ? 'bg-[#7A1F2B] text-white shadow-xs' : 'bg-neutral-100 text-neutral-600 hover:bg-neutral-200' }}">
                Semua Ulasan
            </a>
            <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-colors
               {{ request('status') === 'pending' ? 'bg-[#7A1F2B] text-white shadow-xs' : 'bg-neutral-100 text-neutral-600 hover:bg-neutral-200' }}">
                Menunggu
            </a>
            <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-colors
               {{ request('status') === 'approved' ? 'bg-[#7A1F2B] text-white shadow-xs' : 'bg-neutral-100 text-neutral-600 hover:bg-neutral-200' }}">
                Disetujui
            </a>
        </div>

        <span class="text-xs text-neutral-400">
            Total: <strong class="text-neutral-800">{{ $reviews->total() }}</strong> ulasan
        </span>
    </div>

    <!-- Clean Reviews Table -->
    <div class="bg-white rounded-2xl border border-neutral-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-neutral-50/70 border-b border-neutral-200/80 text-[11px] font-semibold text-neutral-500 uppercase tracking-wider">
                    <tr>
                        <th class="py-3 px-5">Pelanggan</th>
                        <th class="py-3 px-5">Cabang</th>
                        <th class="py-3 px-5">Rating</th>
                        <th class="py-3 px-5">Ulasan</th>
                        <th class="py-3 px-5">Status Web</th>
                        <th class="py-3 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse($reviews as $review)
                    <tr class="hover:bg-neutral-50/50 transition-colors">
                        <td class="py-3.5 px-5 whitespace-nowrap">
                            <span class="font-semibold text-neutral-900 block">{{ $review->nama_pelanggan }}</span>
                            <span class="text-[10px] text-neutral-400">{{ $review->created_at->format('d M Y') }}</span>
                        </td>
                        <td class="py-3.5 px-5 text-neutral-600 font-medium whitespace-nowrap">
                            {{ $review->branch->kota ?? 'Umum' }}
                        </td>
                        <td class="py-3.5 px-5 whitespace-nowrap">
                            <div class="flex items-center space-x-0.5 text-amber-400">
                                @for($i = 0; $i < $review->rating; $i++)
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                @endfor
                            </div>
                        </td>
                        <td class="py-3.5 px-5">
                            <p class="text-neutral-700 max-w-md line-clamp-2 leading-relaxed">
                                "{{ $review->komentar }}"
                            </p>
                        </td>
                        <td class="py-3.5 px-5 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold
                                {{ $review->is_approved ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-amber-50 text-amber-700 border border-amber-200/60' }}">
                                {{ $review->is_approved ? '● Tampil' : '○ Menunggu' }}
                            </span>
                        </td>
                        <td class="py-3.5 px-5 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end space-x-1.5">
                                <form action="{{ route('admin.reviews.toggleApprove', $review->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-[11px] font-semibold py-1 px-2.5 rounded-lg transition-colors
                                        {{ $review->is_approved ? 'bg-neutral-100 text-neutral-600 hover:bg-neutral-200' : 'bg-emerald-50 text-emerald-700 border border-emerald-200/60 hover:bg-emerald-100' }}">
                                        {{ $review->is_approved ? 'Sembunyikan' : 'Setujui' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 rounded-lg text-neutral-400 hover:text-rose-600 hover:bg-rose-50 transition-colors" title="Hapus">
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
                            Tidak ada ulasan pada kategori ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-neutral-100">
            {{ $reviews->links() }}
        </div>
    </div>

</div>
@endsection
