@extends('layouts.public')

@section('title', 'Login')

@section('content')
<!-- Custom CSS Animations (Keyframes) -->
<style>
    /* 1. Animasi Floating (Melayang) pada Ilustrasi */
    @keyframes float-illustration {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }
    .animate-float {
        animation: float-illustration 4s ease-in-out infinite;
    }

    /* 2. Animasi Fade-in dan Slide-up saat halaman load */
    @keyframes fade-in-up {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        opacity: 0; /* Mulai dari tidak terlihat */
        animation: fade-in-up 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* 3. Efek Glow/Menyala pada Input Field saat di-klik (Focus) */
    .input-glow-focus:focus {
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.25);
        border-color: #10b981;
    }
</style>

<div class="min-h-screen relative overflow-hidden bg-[#f0fdf4] dark:bg-slate-950 flex items-center justify-center pt-20 sm:pt-24 pb-8 sm:pb-12 px-4 sm:px-6">
    
    <!-- Premium Ambient Background Glow (Opsional) -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-emerald-300/30 dark:bg-emerald-900/20 blur-[100px] animate-[pulse_8s_ease-in-out_infinite_alternate]"></div>
        <div class="absolute top-[20%] right-[-10%] w-[35%] h-[40%] rounded-full bg-teal-200/40 dark:bg-teal-900/20 blur-[120px] animate-[pulse_10s_ease-in-out_infinite_alternate_reverse]"></div>
        <div class="absolute bottom-[-10%] left-[20%] w-[50%] h-[40%] rounded-full bg-emerald-200/30 dark:bg-emerald-800/20 blur-[100px] animate-[pulse_12s_ease-in-out_infinite_alternate]"></div>
    </div>

    <!-- MAIN CONTAINER: Split-Screen Dua Kolom -->
    <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-2 rounded-[32px] overflow-hidden shadow-2xl border border-emerald-200/60 dark:border-slate-800/80 bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl relative z-10">

        <!-- KOLOM KIRI: Panel Hijau dengan Teks & Animasi Ilustrasi -->
        <div class="bg-gradient-to-br from-[#047857] via-[#059669] to-[#10B981] dark:from-[#064E3B] dark:via-emerald-950 dark:to-slate-900 text-white p-8 sm:p-12 relative flex flex-col justify-center items-center overflow-hidden">
            
            <!-- Elemen Dekorasi Melingkar -->
            <div class="absolute -top-12 -left-12 w-56 h-56 rounded-full bg-white/10 dark:bg-emerald-500/10 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 text-center w-full">
                <!-- Elemen Ilustrasi dengan Animasi Floating -->
                <div class="p-4 rounded-3xl bg-white/10 dark:bg-slate-900/60 backdrop-blur-sm border border-white/20 dark:border-emerald-800/40 shadow-xl max-w-xs mx-auto mb-8 animate-float">
                    <img src="/images/school_login_hero.png" 
                         alt="Ilustrasi SAPA BK SMAN 4 Jember" 
                         class="w-full object-contain rounded-2xl drop-shadow-lg">
                </div>

                <!-- Teks Wujudkan Potensi Diri -->
                <h2 class="font-sora font-extrabold text-3xl sm:text-4xl text-white dark:text-emerald-100 leading-tight mb-3">
                    Wujudkan Potensi Diri.
                </h2>
                <p class="text-sm text-emerald-100/90 dark:text-slate-300 max-w-sm mx-auto leading-relaxed">
                    Ruang aman digital bimbingan konseling, pendampingan minat bakat, & karir SMAN 4 Jember.
                </p>
            </div>
        </div>

        <!-- KOLOM KANAN: Panel Putih dengan Form & Animasi Load -->
        <!-- Memiliki class animate-fade-in-up untuk animasi Slide-up -->
        <div class="p-8 sm:p-12 flex flex-col justify-center relative animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="max-w-sm w-full mx-auto">
                
                <h1 class="font-sora font-bold text-2xl text-center text-slate-900 dark:text-white">
                    Masuk ke Akun Anda
                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 text-center mt-1 mb-8">
                    Akses portal layanan Bimbingan & Konseling
                </p>

                <!-- Tombol Quick Fill -->
                <div class="mb-6 space-y-2">
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider text-center mb-3">
                        ⚡ Quick Fill Akun Demo:
                    </p>
                    <div class="grid grid-cols-3 gap-2">
                        <!-- Efek Hover Scale ditambahkan disini -->
                        <button type="button" onclick="quickFill('siswa@sapabk.sch.id', 'password')"
                                class="px-2 py-2.5 rounded-xl border border-emerald-200/80 dark:border-slate-700/80 bg-emerald-50/70 dark:bg-slate-800/90 hover:bg-emerald-100 dark:hover:bg-slate-700 text-[#047857] dark:text-emerald-400 font-semibold text-[11px] flex items-center justify-center gap-1.5 shadow-sm transition-transform duration-300 hover:scale-105">
                            <span>🎓</span> Siswa
                        </button>
                        <button type="button" onclick="quickFill('gurubk@sapabk.sch.id', 'password')"
                                class="px-2 py-2.5 rounded-xl border border-emerald-200/80 dark:border-slate-700/80 bg-emerald-50/70 dark:bg-slate-800/90 hover:bg-emerald-100 dark:hover:bg-slate-700 text-[#047857] dark:text-emerald-400 font-semibold text-[11px] flex items-center justify-center gap-1.5 shadow-sm transition-transform duration-300 hover:scale-105">
                            <span>👨‍🏫</span> Guru BK
                        </button>
                        <button type="button" onclick="quickFill('admin@sapabk.sch.id', 'password')"
                                class="px-2 py-2.5 rounded-xl border border-emerald-200/80 dark:border-slate-700/80 bg-emerald-50/70 dark:bg-slate-800/90 hover:bg-emerald-100 dark:hover:bg-slate-700 text-[#047857] dark:text-emerald-400 font-semibold text-[11px] flex items-center justify-center gap-1.5 shadow-sm transition-transform duration-300 hover:scale-105">
                            <span>🛠️</span> Admin
                        </button>
                    </div>
                </div>

                <div class="relative flex py-2 items-center mb-6">
                    <div class="flex-grow border-t border-slate-200 dark:border-slate-800"></div>
                    <span class="flex-shrink mx-3 text-[10px] text-slate-400 dark:text-slate-500 font-semibold uppercase">Atau Masuk Manual</span>
                    <div class="flex-grow border-t border-slate-200 dark:border-slate-800"></div>
                </div>

                <!-- Status Flash Messages -->
                @if (session('status'))
                    <div class="mb-4 p-3 rounded-xl bg-emerald-50 dark:bg-emerald-950/80 border border-emerald-200 dark:border-emerald-800 text-xs text-emerald-700 dark:text-emerald-300">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="mb-4 p-3 rounded-xl bg-emerald-50 dark:bg-emerald-950/80 border border-emerald-200 dark:border-emerald-800 text-xs text-emerald-700 dark:text-emerald-300">
                        {{ session('success') }}
                    </div>
                @endif
                @error('email')
                    <div class="mb-4 p-3 rounded-xl bg-red-50 dark:bg-red-950/80 border border-red-200 dark:border-red-800 text-xs text-red-700 dark:text-red-300">
                        {{ $message }}
                    </div>
                @enderror

                <!-- Form Login Utama -->
                <form method="POST" action="{{ route('login.post') }}" id="login-form" class="space-y-5">
                    @csrf
                    
                    <!-- Input Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold mb-1.5 uppercase tracking-wide text-slate-700 dark:text-slate-300">Email Sekolah</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-sm text-slate-900 dark:text-white input-glow-focus outline-none transition-all duration-300"
                               placeholder="nama@sapabk.sch.id">
                    </div>

                    <!-- Input Password -->
                    <div>
                        <label for="password" class="block text-xs font-bold mb-1.5 uppercase tracking-wide text-slate-700 dark:text-slate-300">Password</label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required
                                   class="w-full px-4 py-3.5 pr-10 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-sm text-slate-900 dark:text-white input-glow-focus outline-none transition-all duration-300"
                                   placeholder="••••••••">
                            <button type="button" id="toggle-password" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#059669]">
                                <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Checkbox Ingat Saya -->
                    <div class="flex items-center justify-between text-xs pt-1">
                        <label for="remember" class="flex items-center gap-2 cursor-pointer text-slate-600 dark:text-slate-300">
                            <input id="remember" type="checkbox" name="remember" class="rounded border-slate-300 dark:border-slate-600 text-[#059669] focus:ring-[#059669]">
                            <span>Ingat Saya</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-[#059669] dark:text-emerald-400 font-bold hover:underline">Lupa Password?</a>
                    </div>

                    <!-- Tombol Masuk (dengan transisi Scale hover) -->
                    <button type="submit" class="w-full inline-flex items-center justify-center py-3.5 rounded-xl font-bold text-sm text-white bg-[#059669] hover:bg-[#047857] shadow-lg shadow-emerald-600/25 mt-2 transition-transform duration-300 hover:scale-105">
                        Masuk ke Akun
                    </button>
                </form>

                <p class="text-center mt-6 text-xs text-slate-500 dark:text-slate-400">
                    Belum Memiliki Akun Siswa?
                    <a href="{{ route('register') }}" class="text-[#059669] dark:text-emerald-400 font-bold hover:underline ml-1">
                        Daftar Akun Baru
                    </a>
                </p>

            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle Password
    document.getElementById('toggle-password')?.addEventListener('click', () => {
        const input = document.getElementById('password');
        const icon = document.getElementById('eye-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.018 10.018 0 014.122-.963c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-4.276-4.276a3 3 0 00-4.243-4.243M3 3l18 18" />`;
        } else {
            input.type = 'password';
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
        }
    });

    // Quick Fill
    function quickFill(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
        document.getElementById('login-form').submit();
    }
</script>
@endpush
