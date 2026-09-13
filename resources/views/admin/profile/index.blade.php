@extends('layouts.admin')

@section('title', 'Profil & ID Card - Raso Mandeh')
@section('header_title', 'Profil Pengguna')

@section('content')
<div class="p-6 lg:p-8 space-y-8">

    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
        
        <!-- Kolom Kiri: ID Card & Action Buttons -->
        <div class="md:col-span-5 lg:col-span-4 flex flex-col items-center space-y-4">
            
            <!-- ID Card Element -->
            <div id="id-card-element" class="w-full max-w-[320px] bg-white rounded-3xl shadow-xl relative flex flex-col border border-neutral-100 pb-8">
                <!-- Notch/Slot for lanyard -->
                <div class="absolute top-4 left-1/2 transform -translate-x-1/2 w-16 h-3 bg-white/40 rounded-full border border-white/60 shadow-inner z-20 backdrop-blur-sm"></div>

                <!-- Top Header Gradient -->
                <div class="h-36 bg-gradient-to-br from-[#7A1F2B] to-[#9A2A38] relative rounded-t-3xl overflow-hidden flex flex-col items-center justify-center">
                    <!-- Subtle curves -->
                    <div class="absolute -bottom-6 left-0 right-0 h-12 bg-white" style="border-top-left-radius: 50% 100%; border-top-right-radius: 50% 100%;"></div>
                    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/batik-stripes.png')] mix-blend-overlay"></div>
                </div>

                <!-- Profile Picture -->
                <div class="flex justify-center -mt-16 relative z-20">
                    <div class="w-[100px] h-[100px] rounded-full bg-white p-1 shadow-md">
                        <div class="w-full h-full bg-gradient-to-br from-neutral-200 to-neutral-300 rounded-full flex items-center justify-center overflow-hidden relative border-4 border-white shadow-inner">
                            <span class="text-4xl font-serif font-bold text-neutral-500 absolute">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Body Text -->
                <div class="pt-4 px-6 text-center">
                    <h1 class="font-black text-xl text-neutral-900 leading-tight mb-1 uppercase tracking-tight">{{ Auth::user()->name }}</h1>
                    <p class="text-xs font-bold text-[#C9A227] mb-4 italic font-serif">{{ Auth::user()->role ?? 'Administrator' }}</p>
                    <div class="w-20 h-[1px] bg-neutral-200 mx-auto mb-5"></div>
                </div>

                <!-- Details Grid -->
                <div class="px-8 pb-6 text-left space-y-3">
                    <div class="grid grid-cols-12 gap-2 items-start">
                        <span class="col-span-4 text-[10px] font-bold text-neutral-800 tracking-wider uppercase mt-0.5">Email</span>
                        <span class="col-span-8 text-[11px] font-semibold text-neutral-600 break-words">: {{ Auth::user()->email }}</span>
                    </div>
                    <div class="grid grid-cols-12 gap-2 items-center">
                        <span class="col-span-4 text-[10px] font-bold text-neutral-800 tracking-wider uppercase">Status</span>
                        <span class="col-span-8 text-[11px] font-bold text-emerald-600 flex items-center gap-1.5">
                            <span>:</span> 
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Aktif
                        </span>
                    </div>
                    <div class="grid grid-cols-12 gap-2 items-center">
                        <span class="col-span-4 text-[10px] font-bold text-neutral-800 tracking-wider uppercase">Role</span>
                        <span class="col-span-8 text-[11px] font-semibold text-neutral-600 capitalize">: {{ Auth::user()->role ?? 'Admin' }}</span>
                    </div>
                </div>

                <!-- QR Code (Tampil di layar dan juga akan dicapture html2canvas) -->
                @if(Auth::user()->login_token)
                <div class="px-8 flex justify-center mt-auto">
                    <div class="p-2 bg-white rounded-xl shadow-[0_0_15px_rgba(0,0,0,0.05)] border border-neutral-100 inline-block">
                        <img id="qr-image" src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ Auth::user()->login_token }}&color=241B16" crossorigin="anonymous" class="w-[140px] h-[140px] block" alt="Login QR">
                    </div>
                </div>
                @else
                <div class="px-8 flex justify-center mt-auto">
                    <div class="w-[140px] h-[140px] bg-rose-50 flex items-center justify-center rounded-xl border border-rose-100 text-center p-4">
                        <span class="text-[10px] font-bold text-rose-600 leading-tight">Token Login Belum Tersedia</span>
                    </div>
                </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="w-full max-w-[320px] space-y-3 pt-2">
                <button type="button" class="w-full py-3.5 bg-[#006A8E] hover:bg-[#005877] text-white text-sm font-bold rounded-xl shadow-md transition-all flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    <span>Edit Profil Saya</span>
                </button>
                
                @if(Auth::user()->login_token)
                <button onclick="downloadIDCard()" id="btnDownloadID" class="w-full py-3.5 bg-[#10B981] hover:bg-[#059669] text-white text-sm font-bold rounded-xl shadow-md transition-all flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Download ID Card</span>
                </button>
                <p class="text-[10px] text-neutral-500 text-center leading-relaxed mt-4 px-2">
                    Gunakan QR Code pada ID Card ini untuk login instan tanpa menggunakan password (Sign in with ID Card).
                </p>
                @endif
            </div>
        </div>

        <!-- Kolom Kanan: Detail Data -->
        <div class="md:col-span-7 lg:col-span-8 space-y-6">
            
            <!-- Keamanan 2FA Panel -->
            <div class="bg-white rounded-2xl border border-neutral-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-neutral-100 flex items-center space-x-2 bg-neutral-50/50">
                    <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <h3 class="font-bold text-sm text-neutral-800">Keamanan Dua Langkah (2FA)</h3>
                </div>
                
                @if(session('success'))
                <div class="px-6 py-3 bg-emerald-50 text-emerald-700 text-xs font-bold flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
                @endif
                
                @if(session('info'))
                <div class="px-6 py-3 bg-blue-50 text-blue-700 text-xs font-bold flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('info') }}</span>
                </div>
                @endif

                <div class="p-6 md:flex items-center justify-between gap-6">
                    <div class="flex-1 mb-4 md:mb-0">
                        <p class="text-[11px] text-neutral-500 leading-relaxed mb-3">
                            Tambahkan lapisan keamanan ekstra pada akun Anda. Setelah diaktifkan, masuk ke sistem memerlukan password dan kode verifikasi satu kali (OTP) dari aplikasi Google Authenticator di perangkat seluler Anda.
                        </p>
                        <div class="flex items-center space-x-2 text-[11px] font-bold">
                            <span class="text-neutral-500 uppercase tracking-wider">Status 2FA:</span>
                            @if(Auth::user()->two_factor_confirmed_at)
                                <span class="text-emerald-600">AKTIF</span>
                            @else
                                <span class="text-rose-600">TIDAK AKTIF</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 shrink-0">
                        @if(Auth::user()->two_factor_confirmed_at)
                            <form action="{{ route('admin.2fa.disable') }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('Yakin ingin menonaktifkan 2FA? Keamanan akun Anda akan menurun.')" class="px-4 py-2 bg-[#E14848] hover:bg-[#c93b3b] text-white text-xs font-semibold rounded-lg transition-colors shadow-sm flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                                    <span>Nonaktifkan 2FA</span>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('admin.2fa.setup') }}" class="px-4 py-2 bg-[#006A8E] hover:bg-[#005877] text-white text-xs font-semibold rounded-lg transition-colors shadow-sm flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <span>Aktifkan 2FA Sekarang</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Informasi Lengkap Panel -->
            <div class="bg-white rounded-2xl border border-neutral-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-neutral-100 bg-neutral-50/50">
                    <h3 class="font-bold text-sm text-neutral-800">Informasi Lengkap Administrator</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        <!-- Grid Items -->
                        <div class="p-4 border border-neutral-100 rounded-xl bg-white shadow-sm">
                            <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider mb-1">Nama Lengkap</p>
                            <p class="text-sm font-semibold text-neutral-800">{{ Auth::user()->name }}</p>
                        </div>
                        
                        <div class="p-4 border border-neutral-100 rounded-xl bg-white shadow-sm">
                            <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider mb-1">Email Utama</p>
                            <p class="text-sm font-semibold text-[#006A8E]">{{ Auth::user()->email }}</p>
                        </div>

                        <div class="p-4 border border-neutral-100 rounded-xl bg-white shadow-sm">
                            <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider mb-1">Role Jabatan</p>
                            <p class="text-sm font-semibold text-neutral-800 capitalize">{{ Auth::user()->role ?? 'Admin Pusat' }}</p>
                        </div>

                        <div class="p-4 border border-neutral-100 rounded-xl bg-white shadow-sm">
                            <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider mb-1">Terdaftar Sejak</p>
                            <p class="text-sm font-semibold text-neutral-800">{{ Auth::user()->created_at ? Auth::user()->created_at->format('d M Y') : '10 Aug 2026' }}</p>
                        </div>
                        
                        <div class="col-span-1 sm:col-span-2 p-4 border border-neutral-100 rounded-xl bg-white shadow-sm">
                            <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-wider mb-1">Hak Akses Sistem</p>
                            <p class="text-sm font-semibold text-neutral-800">Semua Fitur (Manajemen Pesanan, POS Kasir, Laporan Keuangan)</p>
                        </div>
                    </div>
                </div>
            </div>

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
    // Generate an off-screen clone for proper download formatting
    const downloadCard = card.cloneNode(true);
    // Make sure it has specific dimensions for high-quality export
    downloadCard.style.width = '320px';
    downloadCard.style.padding = '0';
    downloadCard.style.backgroundColor = 'white';
    downloadCard.style.borderRadius = '24px';
    downloadCard.style.overflow = 'hidden';

    // Hide it but put in DOM
    downloadCard.style.position = 'absolute';
    downloadCard.style.left = '-9999px';
    document.body.appendChild(downloadCard);

    // For html2canvas, scale up to make it crisp
    html2canvas(downloadCard, {
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
        downloadCard.remove();
    }).catch(err => {
        console.error(err);
        alert('Gagal mengunduh ID Card.');
        btn.innerHTML = originalText;
        btn.disabled = false;
        downloadCard.remove();
    });
}
</script>
@endsection
