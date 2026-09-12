<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Khusus Admin - Raso Mandeh</title>

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🍛</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F5EFE2] text-[#241B16] font-sans antialiased min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Ambient Minang Glow Aura -->
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-[#C9A227]/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-[#7A1F2B]/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border-t-4 border-[#7A1F2B] border-x border-b border-[#C9A227]/30 p-8 space-y-6">
        
        <!-- Brand Header -->
        <div class="text-center space-y-2">
            <div class="w-14 h-14 mx-auto rounded-full bg-gradient-to-br from-[#7A1F2B] to-[#3D0F15] flex items-center justify-center text-[#C9A227] font-serif font-bold text-2xl border-2 border-[#C9A227]/40 shadow-lg">
                RM
            </div>
            <h1 class="font-serif font-bold text-2xl text-[#7A1F2B] tracking-tight pt-1">
                Portal Admin Raso Mandeh
            </h1>
            <p class="text-xs text-[#241B16]/70 max-w-xs mx-auto">
                Masuk untuk mengelola pesanan, hidangan masakan Minang, dan operasional cabang.
            </p>
        </div>

        <!-- Flash Alert -->
        @if(session('success'))
        <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold space-y-1">
            @foreach($errors->all() as $err)
                <p>• {{ $err }}</p>
            @endforeach
        </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
            @csrf

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-xs font-bold text-[#241B16]/80 mb-1.5 uppercase tracking-wider">
                    Alamat Email Admin
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#7A1F2B]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"/>
                        </svg>
                    </div>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           required 
                           autofocus
                           value="{{ old('email', 'admin@rasomandeh.com') }}" 
                           placeholder="admin@rasomandeh.com" 
                           class="w-full pl-10 pr-4 py-3 rounded-xl border border-stone-300 text-sm focus:ring-2 focus:ring-[#7A1F2B] focus:border-transparent outline-none transition-all">
                </div>
            </div>

            <!-- Password Field -->
            <div x-data="{ showPass: false }">
                <label for="password" class="block text-xs font-bold text-[#241B16]/80 mb-1.5 uppercase tracking-wider">
                    Kata Sandi (Password)
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#7A1F2B]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input :type="showPass ? 'text' : 'password'" 
                           name="password" 
                           id="password" 
                           required 
                           value="password"
                           placeholder="••••••••" 
                           class="w-full pl-10 pr-10 py-3 rounded-xl border border-stone-300 text-sm focus:ring-2 focus:ring-[#7A1F2B] focus:border-transparent outline-none transition-all">
                    <button type="button" 
                            @click="showPass = !showPass" 
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-stone-400 hover:text-stone-700">
                        <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg x-show="showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center space-x-2 text-[#241B16]/80 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-stone-300 text-[#7A1F2B] focus:ring-[#7A1F2B]">
                    <span>Ingat sesi saya</span>
                </label>
                <span class="text-[11px] text-[#C9A227] font-semibold">Akses Terenkripsi</span>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full bg-[#7A1F2B] hover:bg-[#3D0F15] text-white font-bold py-3.5 px-4 rounded-xl shadow-lg hover:shadow-xl transition-all transform active:scale-98 text-sm flex items-center justify-center space-x-2">
                <span>Masuk ke Dashboard</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>
        </form>

        <!-- Demo Credentials Box -->
        <div class="p-3.5 rounded-2xl bg-[#C9A227]/10 border border-[#C9A227]/30 text-xs text-[#241B16]/80 space-y-1">
            <div class="flex items-center space-x-1.5 font-bold text-[#7A1F2B]">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <span>Akun Administrator Default:</span>
            </div>
            <p>Email: <strong class="text-[#241B16]">admin@rasomandeh.com</strong></p>
            <p>Password: <strong class="text-[#241B16]">password</strong></p>
        </div>

        <!-- Back to Public Site -->
        <div class="pt-2 text-center border-t border-stone-100">
            <a href="{{ url('/') }}" class="text-xs text-[#241B16]/60 hover:text-[#7A1F2B] transition-colors inline-flex items-center space-x-1">
                <span>&larr; Kembali ke Website Raso Mandeh</span>
            </a>
        </div>

    </div>

</body>
</html>
