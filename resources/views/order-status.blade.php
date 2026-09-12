@extends('layouts.app')

@section('title', 'Status Pesanan - Raso Mandeh')

@section('content')
<div class="pt-32 pb-20 px-4 min-h-[80vh] flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl overflow-hidden border border-[#C9A227]/20">
        <div class="bg-[#7A1F2B] p-6 text-center text-white relative">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/batik-stripes.png')] mix-blend-overlay"></div>
            <div class="relative z-10">
                <svg class="w-16 h-16 mx-auto mb-4 text-[#C9A227]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h2 class="font-serif font-bold text-2xl mb-1">Pesanan Diterima!</h2>
                <p class="text-white/80 text-sm">Silakan tunjukkan QR ini ke Kasir</p>
            </div>
        </div>

        <div class="p-8 text-center">
            <div class="inline-block p-4 bg-white rounded-2xl shadow-sm border border-neutral-100 mb-6">
                <!-- QR Code generated via free API for MVP -->
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $order->qr_code_token }}&color=7A1F2B" alt="QR Order" class="w-48 h-48 mx-auto">
            </div>

            <div class="space-y-4 mb-8">
                <div>
                    <p class="text-xs text-neutral-500 font-medium uppercase tracking-wider mb-1">Nomor Pesanan</p>
                    <p class="font-bold text-xl text-[#241B16]">{{ $order->order_number }}</p>
                </div>
                
                <div class="flex items-center justify-between py-3 border-t border-b border-neutral-100">
                    <div class="text-left">
                        <p class="text-xs text-neutral-500 font-medium uppercase tracking-wider mb-1">Status</p>
                        <p class="font-bold text-[#C9A227] capitalize">{{ $order->status }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-neutral-500 font-medium uppercase tracking-wider mb-1">Total Bayar</p>
                        <p class="font-bold text-[#7A1F2B] text-lg">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <a href="{{ route('home') }}" class="block w-full py-3.5 px-4 bg-neutral-100 hover:bg-neutral-200 text-[#241B16] font-semibold rounded-xl transition-colors">
                Kembali ke Menu
            </a>
        </div>
    </div>
</div>
@endsection
