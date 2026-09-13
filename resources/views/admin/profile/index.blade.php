@extends('layouts.admin')

@section('title', 'Profil & ID Card - Raso Mandeh')
@section('header_title', 'Profil Pengguna')

@section('content')
<div class="p-6 lg:p-8 space-y-8">

    <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
        
        <!-- Kolom Kiri: Profil Data -->
        <div class="md:col-span-7 space-y-6">
            <div class="bg-white p-8 rounded-3xl border border-[#C9A227]/20 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-[#F5EFE2] to-transparent rounded-bl-full opacity-50 pointer-events-none"></div>
                
                <h3 class="font-serif font-bold text-xl text-[#7A1F2B] mb-6 border-b border-neutral-100 pb-4">
                    Informasi Akun
                </h3>
                
                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-neutral-500 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                        <div class="font-medium text-neutral-900 bg-neutral-50 px-4 py-3 rounded-xl border border-neutral-100">
                            {{ Auth::user()->name }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-neutral-500 uppercase tracking-wider mb-1.5">Alamat Email</label>
                        <div class="font-medium text-neutral-900 bg-neutral-50 px-4 py-3 rounded-xl border border-neutral-100">
                            {{ Auth::user()->email }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-neutral-500 uppercase tracking-wider mb-1.5">Role / Jabatan</label>
                        <div class="font-medium text-neutral-900 bg-neutral-50 px-4 py-3 rounded-xl border border-neutral-100 flex items-center space-x-2">
                            <span class="w-2 h-2 rounded-full bg-[#C9A227]"></span>
                            <span class="capitalize">{{ Auth::user()->role ?? 'Administrator' }}</span>
                        </div>
                    </div>
                </div>
        </div>

        <!-- Kolom Kanan: ID Card Gamification / QR -->
        <div class="md:col-span-5 flex flex-col items-center">
            
            <h3 class="font-serif font-bold text-lg text-neutral-800 mb-6 text-center">
                ID Card Anda
            </h3>

            <!-- ID Card Element (Visible, style like physical card) -->
            <div id="id-card-element" class="w-[280px] h-[440px] bg-white rounded-[24px] shadow-2xl relative overflow-hidden flex flex-col mb-8 border border-neutral-200">
                
                <!-- Notch/Slot for lanyard -->
                <div class="absolute top-3 left-1/2 transform -translate-x-1/2 w-16 h-3 bg-neutral-100 rounded-full border border-neutral-200 shadow-inner z-20"></div>

                <!-- Top Red Header -->
                <div class="h-32 bg-[#7A1F2B] relative flex flex-col items-center justify-center pt-4">
                    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/batik-stripes.png')] mix-blend-overlay"></div>
                    <h2 class="font-serif font-black text-2xl text-white tracking-wide z-10">Raso Mandeh</h2>
                    <p class="text-[#C9A227] text-[10px] font-bold uppercase tracking-widest mt-0.5 z-10">Staff ID Card</p>
                </div>

                <!-- Profile Picture placeholder -->
                <div class="flex justify-center -mt-10 relative z-20">
                    <div class="w-20 h-20 rounded-2xl bg-white p-1 shadow-lg transform rotate-3">
                        <div class="w-full h-full bg-gradient-to-br from-neutral-200 to-neutral-300 rounded-xl flex items-center justify-center overflow-hidden relative">
                            <!-- Avatar Letter -->
                            <span class="text-3xl font-serif font-bold text-neutral-500 absolute">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Body -->
                <div class="pt-6 px-6 text-center flex-1 flex flex-col">
                    <h1 class="font-bold text-lg text-neutral-900 leading-tight mb-1">{{ Auth::user()->name }}</h1>
                    <p class="text-xs font-semibold text-[#7A1F2B] uppercase tracking-wider mb-4">{{ Auth::user()->role ?? 'Administrator' }}</p>

                    <!-- QR Code -->
                    @if(Auth::user()->login_token)
                        <div class="p-2 bg-white rounded-xl shadow-sm border border-neutral-100 mx-auto w-fit mb-4">
                            <img id="qr-image" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ Auth::user()->login_token }}&color=241B16" crossorigin="anonymous" class="w-[100px] h-[100px]" alt="Login QR">
                        </div>
                        <p class="text-[9px] text-neutral-400 leading-tight px-2">Gunakan QR Code ini untuk fitur <strong>Sign in with ID Card</strong> pada halaman Login.</p>
                    @else
                        <div class="p-4 bg-neutral-100 rounded-xl mx-auto w-full mb-4 text-center">
                            <p class="text-xs text-rose-600 font-bold">Token Login Belum Tersedia</p>
                            <p class="text-[10px] text-neutral-500 mt-1">Harap hubungi Superadmin.</p>
                        </div>
                    @endif
                </div>

                <!-- Footer -->
                <div class="h-10 bg-[#241B16] flex items-center justify-center">
                    <p class="text-[8px] text-neutral-400 tracking-widest uppercase">Valid untuk akses internal</p>
                </div>
            </div>

            @if(Auth::user()->login_token)
            <button onclick="downloadIDCard()" id="btnDownloadID" class="px-6 py-3 bg-[#C9A227] hover:bg-[#b38e1e] text-white font-bold rounded-xl shadow-md transition-all flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span>Unduh ID Card</span>
            </button>
            @endif

        </div>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
function downloadIDCard() {
    const btn = document.getElementById('btnDownloadID');
    const card = document.getElementById('id-card-element');
    const qrImg = document.getElementById('qr-image');
    
    const originalText = btn.innerHTML;
    btn.innerHTML = '<span class="animate-pulse">Menyiapkan...</span>';
    btn.disabled = true;

    if (qrImg && !qrImg.complete) {
        qrImg.onload = () => generateIDCanvas(card, btn, originalText);
    } else {
        generateIDCanvas(card, btn, originalText);
    }
}

function generateIDCanvas(card, btn, originalText) {
    // For html2canvas, scale up to make it crisp
    html2canvas(card, {
        scale: 3,
        useCORS: true,
        backgroundColor: null
    }).then(canvas => {
        const link = document.createElement('a');
        link.download = 'ID-Card-RasoMandeh-{{ str_replace(' ', '', Auth::user()->name) }}.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
        
        btn.innerHTML = originalText;
        btn.disabled = false;
    }).catch(err => {
        console.error(err);
        alert('Gagal mengunduh ID Card.');
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}
</script>
@endsection
