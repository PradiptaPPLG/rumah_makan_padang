<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kasir POS - Raso Mandeh</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#F5EFE2] text-[#241B16] h-screen overflow-hidden font-sans">
    <div x-data="kasirApp()" class="flex h-full">
        
        <!-- Kolom Kiri: Menu Grid -->
        <div class="flex-1 flex flex-col h-full bg-white relative shadow-xl z-10">
            <!-- Header -->
            <div class="p-4 border-b border-[#C9A227]/30 flex items-center justify-between bg-[#7A1F2B] text-white">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.dashboard') }}" class="p-2 bg-black/20 hover:bg-black/40 rounded-lg transition-colors" title="Kembali ke Dashboard">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <h1 class="font-serif font-bold text-xl tracking-wide">Kasir Raso Mandeh</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-black/20 px-3 py-1.5 rounded-lg text-sm font-medium flex items-center space-x-2">
                        <svg class="w-4 h-4 text-[#C9A227]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span>{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </div>

            <!-- Categories & Search -->
            <div class="p-4 border-b border-neutral-100 flex items-center justify-between space-x-4 bg-white z-10 shadow-sm">
                <div class="flex space-x-2 overflow-x-auto scrollbar-hide pb-1 flex-1">
                    <button @click="activeCategory = 'all'" :class="activeCategory === 'all' ? 'bg-[#7A1F2B] text-white shadow' : 'bg-neutral-100 text-neutral-600 hover:bg-neutral-200'" class="px-5 py-2 rounded-lg text-sm font-bold whitespace-nowrap transition-all">Semua</button>
                    @php
                        $categories = $menuItems->pluck('category')->unique();
                    @endphp
                    @foreach($categories as $cat)
                        <button @click="activeCategory = '{{ $cat }}'" :class="activeCategory === '{{ $cat }}' ? 'bg-[#7A1F2B] text-white shadow' : 'bg-neutral-100 text-neutral-600 hover:bg-neutral-200'" class="px-5 py-2 rounded-lg text-sm font-bold whitespace-nowrap transition-all capitalize">{{ $cat }}</button>
                    @endforeach
                </div>
                <div class="relative w-72 flex-shrink-0">
                    <svg class="w-5 h-5 absolute left-3 top-2.5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" x-model="searchQuery" placeholder="Cari menu (cth: Rendang)..." class="w-full pl-10 pr-4 py-2.5 bg-neutral-100 border-transparent focus:bg-white focus:border-[#C9A227] focus:ring-1 focus:ring-[#C9A227] rounded-xl text-sm transition-all shadow-inner outline-none">
                </div>
            </div>

            <!-- Menu Grid -->
            <div class="flex-1 overflow-y-auto p-5 bg-neutral-50">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
                    <template x-for="item in filteredMenus" :key="item.id">
                        <div @click="addToCart(item)" class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden cursor-pointer hover:shadow-lg hover:-translate-y-1 hover:border-[#C9A227]/50 transition-all group flex flex-col h-full relative">
                            <!-- Overlay Out of Stock -->
                            <div x-show="item.stock_quantity !== null && item.stock_quantity <= 0" class="absolute inset-0 bg-white/60 backdrop-blur-[2px] z-20 flex items-center justify-center">
                                <span class="bg-rose-600 text-white font-bold text-xs px-3 py-1.5 rounded-lg shadow-lg rotate-[-10deg]">HABIS</span>
                            </div>

                            <div class="h-36 bg-neutral-200 relative overflow-hidden">
                                <img :src="item.image_url || 'https://ui-avatars.com/api/?name=' + item.name + '&background=F5EFE2&color=7A1F2B'" :alt="item.name" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                
                                <div x-show="item.stock_quantity !== null && item.stock_quantity > 0 && item.stock_quantity <= 10" class="absolute top-2 left-2 z-10">
                                    <span class="bg-rose-500 text-white text-[10px] font-bold px-2 py-1 rounded-md shadow-md flex items-center space-x-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span>Sisa <span x-text="item.stock_quantity"></span></span>
                                    </span>
                                </div>
                            </div>
                            <div class="p-3.5 flex flex-col flex-1 border-t border-neutral-100/50">
                                <h3 class="font-bold text-sm text-[#241B16] leading-tight mb-2 group-hover:text-[#7A1F2B] transition-colors" x-text="item.name"></h3>
                                <div class="mt-auto flex justify-between items-end">
                                    <span class="text-[#C9A227] font-black text-[15px]" x-text="formatRupiah(item.price)"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                
                <div x-show="filteredMenus.length === 0" class="flex flex-col items-center justify-center h-full text-neutral-400">
                    <div class="w-20 h-20 bg-neutral-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <p class="font-bold text-[#241B16]">Tidak ada menu ditemukan</p>
                    <p class="text-xs mt-1">Coba kata kunci lain atau ubah kategori.</p>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Cart / Scanner -->
        <div class="w-[420px] flex-shrink-0 bg-white border-l border-[#C9A227]/30 flex flex-col h-full z-20 shadow-[-10px_0_30px_rgba(0,0,0,0.05)] relative">
            
            <!-- Tabs -->
            <div class="flex p-2 bg-neutral-50 border-b border-neutral-200">
                <button @click="switchMode('walkin')" :class="mode === 'walkin' ? 'bg-white shadow text-[#7A1F2B] border border-neutral-200/50' : 'text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100'" class="flex-1 py-2.5 text-sm font-bold rounded-lg transition-all flex items-center justify-center space-x-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <span>Walk-in Order</span>
                </button>
                <button @click="switchMode('scan')" :class="mode === 'scan' ? 'bg-white shadow text-[#7A1F2B] border border-neutral-200/50' : 'text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100'" class="flex-1 py-2.5 text-sm font-bold rounded-lg transition-all flex items-center justify-center space-x-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    <span>Scan QR Web</span>
                </button>
            </div>

            <!-- SCAN MODE -->
            <div x-show="mode === 'scan'" class="flex-1 flex flex-col" style="display: none;" x-transition.opacity>
                <div class="p-5 flex-1 flex flex-col space-y-5 bg-[#F5EFE2]/20">
                    <div id="qr-reader" class="w-full bg-[#1b1b18] rounded-2xl overflow-hidden border-[6px] border-[#C9A227]/20 shadow-lg relative min-h-[250px] flex items-center justify-center"></div>
                    
                    <div class="flex space-x-2">
                        <input type="text" x-model="manualCode" @keyup.enter="findOrder(manualCode)" placeholder="Ketik kode (RM-...)" class="flex-1 px-4 py-3 bg-white border border-neutral-200 rounded-xl focus:ring-1 focus:ring-[#7A1F2B] text-sm outline-none font-mono shadow-sm">
                        <button @click="findOrder(manualCode)" class="px-5 py-3 bg-[#7A1F2B] text-white rounded-xl text-sm font-bold shadow-md hover:bg-[#5a1620] transition-colors">Cari</button>
                    </div>

                    <!-- Scanned Order Result -->
                    <div x-show="scannedOrder" class="flex-1 overflow-y-auto bg-white border border-neutral-200 shadow-md p-4 rounded-xl flex flex-col mt-2" style="display:none;" x-transition>
                        <div class="flex justify-between items-center mb-3 pb-3 border-b border-neutral-100">
                            <span class="font-serif font-bold text-lg text-[#241B16]" x-text="scannedOrder?.order_number"></span>
                            <span class="text-[10px] px-2.5 py-1 rounded bg-amber-100 text-amber-800 font-bold uppercase tracking-wider" x-text="scannedOrder?.status"></span>
                        </div>
                        <div class="text-xs mb-4 grid grid-cols-2 gap-2 bg-neutral-50 p-3 rounded-lg border border-neutral-100">
                            <div>
                                <span class="block text-[10px] text-neutral-400 font-bold uppercase mb-0.5">Pelanggan</span>
                                <span class="font-bold text-sm text-[#241B16]" x-text="scannedOrder?.customer_name"></span>
                            </div>
                            <div>
                                <span class="block text-[10px] text-neutral-400 font-bold uppercase mb-0.5">Tipe Pesanan</span>
                                <span class="font-bold text-sm text-[#241B16] capitalize" x-text="scannedOrder?.service_type"></span>
                            </div>
                        </div>
                        <div class="flex-1 overflow-y-auto space-y-2 mb-4">
                            <p class="text-[10px] font-bold text-[#C9A227] uppercase tracking-wider mb-2">Item Pesanan</p>
                            <template x-for="item in scannedOrder?.items" :key="item.id">
                                <div class="flex justify-between text-sm border-b border-neutral-50 pb-2">
                                    <div class="flex space-x-2">
                                        <span class="font-bold text-[#7A1F2B]" x-text="item.quantity + 'x'"></span> 
                                        <span class="font-medium text-[#241B16]" x-text="item.name"></span>
                                    </div>
                                    <div class="font-bold" x-text="item.subtotal_formatted"></div>
                                </div>
                            </template>
                        </div>
                        <div class="mt-auto border-t border-dashed border-neutral-200 pt-3 flex justify-between items-end mb-4">
                            <span class="font-bold text-neutral-500 uppercase text-xs">Total Tagihan</span>
                            <span class="font-serif font-black text-2xl text-[#7A1F2B]" x-text="scannedOrder?.total_formatted"></span>
                        </div>
                        <button @click="payScannedOrder()" :disabled="paying || scannedOrder?.status === 'completed'" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 disabled:bg-neutral-300 disabled:text-neutral-500 text-white font-bold rounded-xl shadow transition-colors flex items-center justify-center space-x-2 text-sm">
                            <svg x-show="paying" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <span x-text="scannedOrder?.status === 'completed' ? 'Sudah Lunas' : 'Terima Pembayaran & Selesai'"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- WALKIN MODE -->
            <div x-show="mode === 'walkin'" class="flex-1 flex flex-col relative" x-transition.opacity>
                
                <!-- Customer Details -->
                <div class="p-4 border-b border-neutral-200 bg-white shadow-sm z-10">
                    <div class="space-y-3">
                        <div class="relative">
                            <svg class="w-4 h-4 absolute left-3 top-2.5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <input type="text" x-model="walkin.customer_name" placeholder="Nama Pelanggan (Wajib)" class="w-full text-sm pl-9 pr-3 py-2 bg-neutral-50 border border-neutral-200 rounded-lg focus:bg-white focus:border-[#C9A227] focus:ring-1 focus:ring-[#C9A227] outline-none transition-colors">
                        </div>
                        <div class="flex space-x-2">
                            <select x-model="walkin.service_type" class="flex-1 text-sm px-3 py-2 bg-neutral-50 border border-neutral-200 rounded-lg focus:bg-white focus:border-[#C9A227] focus:ring-1 focus:ring-[#C9A227] outline-none transition-colors">
                                <option value="dine-in">Dine In (Makan Sini)</option>
                                <option value="takeaway">Takeaway (Bungkus)</option>
                            </select>
                            <input x-show="walkin.service_type === 'dine-in'" type="text" x-model="walkin.table_number" placeholder="Meja (opsional)" class="w-32 text-sm px-3 py-2 bg-neutral-50 border border-neutral-200 rounded-lg focus:bg-white focus:border-[#C9A227] focus:ring-1 focus:ring-[#C9A227] outline-none text-center transition-colors">
                        </div>
                        <select x-model="walkin.branch_id" class="w-full text-sm px-3 py-2 bg-neutral-50 border border-neutral-200 rounded-lg focus:bg-white focus:border-[#C9A227] focus:ring-1 focus:ring-[#C9A227] outline-none transition-colors">
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Cart Items -->
                <div class="flex-1 overflow-y-auto p-4 bg-[#F5EFE2]/30">
                    <template x-if="cart.length === 0">
                        <div class="h-full flex flex-col items-center justify-center text-neutral-400 space-y-3">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm border border-neutral-100 text-neutral-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                            <p class="text-sm font-medium">Pilih menu dari panel kiri</p>
                        </div>
                    </template>
                    
                    <div class="space-y-3">
                        <template x-for="item in cart" :key="item.id">
                            <div class="bg-white p-3 rounded-xl border border-neutral-100 shadow-sm flex items-center space-x-3 group relative overflow-hidden">
                                <!-- Hapus btn hover -->
                                <button @click="updateCart(item.id, -item.quantity)" class="absolute top-0 right-0 p-1.5 text-rose-500 hover:text-white hover:bg-rose-500 bg-rose-50 rounded-bl-lg transition-colors opacity-0 group-hover:opacity-100">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                                
                                <div class="flex-1 min-w-0 pr-4">
                                    <h4 class="font-bold text-sm text-[#241B16] truncate" x-text="item.name"></h4>
                                    <div class="text-[#7A1F2B] text-xs font-bold" x-text="formatRupiah(item.price)"></div>
                                </div>
                                <div class="flex items-center space-x-1.5 bg-neutral-50 border border-neutral-200 rounded-lg p-1 relative z-10">
                                    <button @click="updateCart(item.id, -1)" class="w-7 h-7 flex items-center justify-center bg-white rounded shadow-sm text-neutral-600 font-bold hover:text-[#7A1F2B] hover:border-[#7A1F2B] border border-transparent transition-colors">-</button>
                                    <span class="w-6 text-center text-sm font-bold text-[#241B16]" x-text="item.quantity"></span>
                                    <button @click="updateCart(item.id, 1)" class="w-7 h-7 flex items-center justify-center bg-white rounded shadow-sm text-neutral-600 font-bold hover:text-[#7A1F2B] hover:border-[#7A1F2B] border border-transparent transition-colors">+</button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Checkout Footer -->
                <div class="p-5 bg-white border-t border-[#C9A227]/30 shadow-[0_-10px_30px_rgba(0,0,0,0.04)] z-10">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-xs text-neutral-500 font-bold uppercase tracking-wider">Item</span>
                        <span class="text-sm font-bold text-[#241B16]" x-text="cart.reduce((total, item) => total + item.quantity, 0) + ' porsi'"></span>
                    </div>
                    <div class="flex justify-between items-end mb-4 border-b border-neutral-100 pb-4">
                        <span class="text-sm text-neutral-600 font-bold uppercase tracking-wider">Total</span>
                        <span class="text-3xl font-serif font-black text-[#7A1F2B] leading-none" x-text="formatRupiah(cartTotal)"></span>
                    </div>
                    
                    <button @click="checkoutWalkin()" :disabled="cart.length === 0 || !walkin.customer_name || paying" class="w-full py-4 bg-[#C9A227] hover:bg-[#B38F23] disabled:bg-neutral-200 disabled:text-neutral-400 text-[#241B16] font-bold rounded-xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center space-x-2 text-[15px]">
                        <svg x-show="paying" class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <svg x-show="!paying" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span x-text="paying ? 'Memproses...' : 'Proses & Terima Pembayaran'"></span>
                    </button>
                    <button @click="cart = []" x-show="cart.length > 0 && !paying" class="w-full mt-3 py-2 text-xs font-bold text-rose-500 hover:bg-rose-50 rounded-lg transition-colors">
                        Batalkan Order
                    </button>
                </div>
                
            </div>

            <!-- Overlay Loading Global -->
            <div x-show="successMessage" class="absolute inset-0 z-50 bg-white/95 backdrop-blur-md flex flex-col items-center justify-center p-8 text-center shadow-2xl" style="display: none;" x-transition>
                <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mb-5 ring-8 ring-emerald-50">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 class="font-serif font-black text-2xl text-[#241B16] mb-2" x-text="successMessage"></h3>
                <p class="text-[15px] text-neutral-500 mb-8 font-medium">Pesanan telah disimpan ke sistem dan ditandai lunas.</p>
                <button @click="resetAll()" class="px-8 py-3.5 bg-[#241B16] hover:bg-black text-white rounded-xl font-bold shadow-lg transition-all transform hover:-translate-y-1 w-full">Lanjut Pesanan Baru</button>
            </div>

        </div>
    </div>

    <script>
    const allMenuItems = @json($menuItems);
    const defaultBranchId = {{ $branches->first()->id ?? 1 }};
    
    document.addEventListener('alpine:init', () => {
        Alpine.data('kasirApp', () => ({
            menus: allMenuItems,
            activeCategory: 'all',
            searchQuery: '',
            
            // Mode UI
            mode: 'walkin', // 'walkin' or 'scan'
            
            // Walk-in Cart State
            cart: [],
            walkin: {
                customer_name: '',
                service_type: 'dine-in',
                table_number: '',
                branch_id: defaultBranchId
            },
            
            // Scan State
            html5QrcodeScanner: null,
            manualCode: '',
            scannedOrder: null,
            
            // Global State
            paying: false,
            successMessage: '',
            
            init() {
                this.$watch('mode', value => {
                    if(value === 'scan') {
                        setTimeout(() => this.startScanner(), 300);
                    } else {
                        this.stopScanner();
                    }
                });
            },
            
            get filteredMenus() {
                return this.menus.filter(item => {
                    const matchCategory = this.activeCategory === 'all' || item.category === this.activeCategory;
                    const matchSearch = item.name.toLowerCase().includes(this.searchQuery.toLowerCase());
                    return matchCategory && matchSearch;
                });
            },
            
            get cartTotal() {
                return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
            },
            
            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
            },
            
            addToCart(menu) {
                if(menu.stock_quantity !== null && menu.stock_quantity <= 0) {
                    alert('Stok habis!');
                    return;
                }
                
                const existing = this.cart.find(item => item.id === menu.id);
                if (existing) {
                    if (menu.stock_quantity !== null && existing.quantity >= menu.stock_quantity) {
                        alert('Melebihi sisa stok!');
                        return;
                    }
                    existing.quantity++;
                } else {
                    this.cart.unshift({
                        id: menu.id,
                        name: menu.name,
                        price: menu.price,
                        quantity: 1
                    });
                }
            },
            
            updateCart(id, change) {
                const index = this.cart.findIndex(item => item.id === id);
                if (index !== -1) {
                    const newQty = this.cart[index].quantity + change;
                    if (newQty <= 0) {
                        this.cart.splice(index, 1);
                    } else {
                        const menu = this.menus.find(m => m.id === id);
                        if (menu && menu.stock_quantity !== null && newQty > menu.stock_quantity) {
                            alert('Melebihi sisa stok!');
                            return;
                        }
                        this.cart[index].quantity = newQty;
                    }
                }
            },
            
            checkoutWalkin() {
                if(this.cart.length === 0 || !this.walkin.customer_name) return;
                
                this.paying = true;
                
                const payload = {
                    customer_name: this.walkin.customer_name,
                    customer_phone: 'Walk-in Kasir',
                    service_type: this.walkin.service_type,
                    table_number: this.walkin.service_type === 'dine-in' ? this.walkin.table_number : null,
                    notes: 'Diproses dari kasir (Walk-in)',
                    branch_id: this.walkin.branch_id,
                    items: this.cart.map(item => ({
                        menu_item_id: item.id,
                        quantity: item.quantity,
                        notes: ''
                    }))
                };
                
                fetch('{{ route('orders.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                })
                .then(res => {
                    if(!res.ok) throw new Error('Gagal mengirim pesanan');
                    return res.json();
                })
                .then(data => {
                    if(data.success) {
                        // Mark as paid instantly because this is POS walkin
                        const formData = new FormData();
                        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                        formData.append('status', 'completed');
                        
                        return fetch('/admin/orders/' + data.order.id + '/status', {
                            method: 'POST',
                            body: formData
                        }).then(r => r.json()).then(() => data.order);
                    } else {
                        throw new Error(data.message);
                    }
                })
                .then(order => {
                    this.paying = false;
                    this.successMessage = 'Pembayaran Berhasil!';
                })
                .catch(err => {
                    this.paying = false;
                    alert('Gagal: ' + err.message);
                });
            },
            
            switchMode(newMode) {
                this.mode = newMode;
            },
            
            startScanner() {
                if(this.html5QrcodeScanner) return;
                
                this.html5QrcodeScanner = new Html5QrcodeScanner(
                    "qr-reader", { fps: 10, qrbox: 250, aspectRatio: 1.0 }
                );
                
                this.html5QrcodeScanner.render(
                    (decodedText, decodedResult) => {
                        this.html5QrcodeScanner.clear();
                        this.findOrder(decodedText);
                    },
                    (errorMessage) => {}
                );
            },
            
            stopScanner() {
                if(this.html5QrcodeScanner) {
                    this.html5QrcodeScanner.clear();
                    this.html5QrcodeScanner = null;
                }
            },
            
            findOrder(code) {
                if(!code) return;
                fetch('{{ route('admin.pos.findOrder') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ order_code: code })
                })
                .then(r => r.json())
                .then(data => {
                    if(data.success) {
                        this.scannedOrder = data.order;
                        this.stopScanner();
                    } else {
                        alert(data.message);
                        this.startScanner();
                    }
                })
                .catch(e => {
                    alert('Error jaringan atau kode tidak ditemukan');
                    this.startScanner();
                });
            },
            
            payScannedOrder() {
                if(!this.scannedOrder) return;
                this.paying = true;
                
                const formData = new FormData();
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                formData.append('status', 'completed');

                fetch('/admin/orders/' + this.scannedOrder.id + '/status', {
                    method: 'POST',
                    body: formData
                })
                .then(r => r.json())
                .then(() => {
                    this.paying = false;
                    this.successMessage = 'Pembayaran QR Web Berhasil!';
                })
                .catch(e => {
                    this.paying = false;
                    alert('Gagal menyelesaikan pembayaran.');
                });
            },
            
            resetAll() {
                this.successMessage = '';
                this.cart = [];
                this.walkin.customer_name = '';
                this.scannedOrder = null;
                this.manualCode = '';
                if(this.mode === 'scan') {
                    this.startScanner();
                }
            }
        }));
    });
    </script>

    <style>
    /* Override default styling of html5-qrcode */
    #qr-reader { border: none !important; }
    #qr-reader__scan_region { background-color: #1b1b18; }
    #qr-reader__dashboard_section_csr span { color: #fff !important; font-size: 12px; }
    #qr-reader button { background-color: #C9A227; color: #241B16; border: none; padding: 8px 16px; border-radius: 8px; font-weight: bold; cursor: pointer; margin-top: 10px; font-size: 13px; transition: background 0.3s;}
    #qr-reader button:hover { background-color: #B38F23; }
    #qr-reader select { padding: 8px; border-radius: 8px; margin-bottom: 10px; width: 100%; font-size: 13px; }
    #qr-reader__dashboard_section_swaplink { color: #C9A227 !important; font-weight: bold; }
    </style>
</body>
</html>
