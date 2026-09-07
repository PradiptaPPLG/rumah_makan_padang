<section id="ulasan" class="py-20 bg-[#F5EFE2]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-[#7A1F2B] font-semibold text-xs uppercase tracking-widest block mb-2">Suara Pelanggan</span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-[#241B16]">
                Kata Mereka Tentang Raso Minang
            </h2>
            <p class="text-sm sm:text-base text-[#241B16]/75 mt-3">
                Kisah kepuasan dari pecinta kuliner Minang di berbagai pelosok kota.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($reviews as $review)
            <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-200 border border-[#C9A227]/20 flex flex-col justify-between space-y-4">
                <div>
                    <!-- Star Rating -->
                    <div class="flex items-center space-x-1 text-[#C9A227] mb-3">
                        @for($i = 0; $i < $review->rating; $i++)
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        @endfor
                    </div>

                    <!-- Comment Quote -->
                    <p class="text-sm text-[#241B16]/80 italic leading-relaxed">
                        "{{ $review->komentar }}"
                    </p>
                </div>

                <!-- Customer Info -->
                <div class="pt-4 border-t border-[#C9A227]/15 flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-[#7A1F2B]/10 text-[#7A1F2B] font-bold text-sm flex items-center justify-center flex-shrink-0 border border-[#7A1F2B]/20">
                        {{ strtoupper(substr($review->nama_pelanggan, 0, 2)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <h5 class="font-bold text-sm text-[#241B16] truncate">{{ $review->nama_pelanggan }}</h5>
                        <span class="text-xs text-[#241B16]/60 block truncate">
                            {{ $review->branch ? $review->branch->kota : 'Pelanggan Setia' }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
