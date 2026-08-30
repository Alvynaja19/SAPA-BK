@extends('layouts.public')

@section('title', 'Login')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#ECFDF5] via-[#F0FDF4] to-[#E6F4EA] dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 flex items-center justify-center pt-20 sm:pt-24 pb-8 sm:pb-12 px-4 sm:px-6">
    
    <!-- Card Utama (Dual Column Layout dengan Hijau Identitas Sekolah SMAN 4 Jember) -->
    <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-12 rounded-[32px] overflow-hidden shadow-2xl border border-emerald-200/60 dark:border-slate-800/80 bg-white dark:bg-slate-900">

        <!-- KIRI — Visual Hero & Warna Dasar Hijau Sekolah -->
        <div class="lg:col-span-6 bg-gradient-to-br from-[#047857] via-[#059669] to-[#10B981] dark:from-[#064E3B] dark:via-emerald-950 dark:to-slate-900 text-white p-8 sm:p-12 relative flex flex-col justify-between overflow-hidden">
            
            <!-- Ornamen Blur Dekoratif Berwarna Hijau Mint & Putih Glow -->
            <div class="absolute -top-12 -left-12 w-56 h-56 rounded-full bg-white/10 dark:bg-emerald-500/10 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -right-16 w-64 h-64 rounded-full bg-teal-300/20 dark:bg-emerald-400/10 blur-3xl pointer-events-none"></div>
            
            <!-- Floating School Badge -->
            <div class="absolute top-8 right-8 px-3.5 py-1.5 rounded-full bg-white/15 dark:bg-slate-900/40 backdrop-blur-md border border-white/20 dark:border-emerald-700/50 text-white font-bold text-[11px] shadow-sm flex items-center gap-2 z-10">
                <span class="w-2 h-2 rounded-full bg-emerald-300 dark:bg-emerald-400 animate-pulse"></span>
                <span>SMAN 4 Jember</span>
            </div>

            <!-- Frame & Ilustrasi Sekolah -->
            <div class="my-auto py-4 relative z-10 text-center">
                <div class="p-3 sm:p-4 rounded-3xl bg-white/10 dark:bg-slate-900/60 backdrop-blur-sm border border-white/20 dark:border-emerald-800/40 shadow-xl max-w-xs sm:max-w-sm mx-auto">
                    <img src="/images/school_login_hero.png"
                         alt="Ilustrasi SAPA BK SMAN 4 Jember"
                         class="w-full object-contain rounded-2xl drop-shadow-md hover:scale-105 transition-transform duration-500">
                </div>
            </div>

            <!-- Headline Hero Bawah -->
            <div class="relative z-10 text-center pt-4">
                <h2 class="font-sora font-extrabold text-2xl sm:text-3xl text-white dark:text-emerald-100 leading-tight">
                    Wujudkan Potensi Diri.
                </h2>
                <p class="text-xs sm:text-sm text-emerald-100/90 dark:text-slate-300 mt-2 max-w-sm mx-auto leading-relaxed">
                    Ruang aman digital bimbingan konseling, pendampingan minat bakat, & karir SMAN 4 Jember.
                </p>
            </div>
        </div>

        <!-- KANAN — Form Login & Quick Roles -->
        <div class="lg:col-span-6 p-8 sm:p-12 flex flex-col justify-center bg-white dark:bg-slate-900 relative">
            <div class="max-w-sm w-full mx-auto">
                
                <!-- Icon Emblem Top Header -->
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 dark:bg-emerald-950/80 text-[#059669] dark:text-emerald-400 flex items-center justify-center mx-auto mb-4 border border-emerald-500/20 dark:border-emerald-800/60 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </div>

                <!-- Judul & Subtitle Login -->
                <h1 class="font-sora font-bold text-2xl text-center text-slate-900 dark:text-white">
                    Masuk ke Akun Anda
                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 text-center mt-1 mb-6">
                    Akses portal layanan Bimbingan & Konseling SMAN 4 Jember
                </p>

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

                <!-- Quick Login Selector -->
                <div class="mb-5 space-y-2">
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider text-center mb-2">
                        ⚡ Quick Fill Akun Demo:
                    </p>
                    <div class="grid grid-cols-3 gap-2">
                        <button type="button" onclick="quickFill('siswa@sapabk.sch.id', 'password')"
                                class="px-2.5 py-2 rounded-xl border border-emerald-200/80 dark:border-slate-700/80 bg-emerald-50/70 dark:bg-slate-800/90 hover:bg-emerald-100 dark:hover:bg-slate-700 text-[#047857] dark:text-emerald-400 font-semibold text-[11px] transition-all flex items-center justify-center gap-1.5 shadow-sm">
                            <span>🎓</span> Siswa
                        </button>
                        <button type="button" onclick="quickFill('gurubk@sapabk.sch.id', 'password')"
                                class="px-2.5 py-2 rounded-xl border border-emerald-200/80 dark:border-slate-700/80 bg-emerald-50/70 dark:bg-slate-800/90 hover:bg-emerald-100 dark:hover:bg-slate-700 text-[#047857] dark:text-emerald-400 font-semibold text-[11px] transition-all flex items-center justify-center gap-1.5 shadow-sm">
                            <span>👨‍🏫</span> Guru BK
                        </button>
                        <button type="button" onclick="quickFill('admin@sapabk.sch.id', 'password')"
                                class="px-2.5 py-2 rounded-xl border border-emerald-200/80 dark:border-slate-700/80 bg-emerald-50/70 dark:bg-slate-800/90 hover:bg-emerald-100 dark:hover:bg-slate-700 text-[#047857] dark:text-emerald-400 font-semibold text-[11px] transition-all flex items-center justify-center gap-1.5 shadow-sm">
                            <span>🛠️</span> Admin
                        </button>
                    </div>
                </div>

                <!-- Pembatas Garis (Divider) -->
                <div class="relative flex py-2 items-center mb-5">
                    <div class="flex-grow border-t border-slate-200 dark:border-slate-800"></div>
                    <span class="flex-shrink mx-3 text-[10px] text-slate-400 dark:text-slate-500 font-semibold uppercase tracking-wider">atau Masuk Email</span>
                    <div class="flex-grow border-t border-slate-200 dark:border-slate-800"></div>
                </div>

                <!-- Form Login -->
                <form method="POST" action="{{ route('login.post') }}" id="login-form" class="space-y-4">
                    @csrf

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-xs font-bold mb-1.5 uppercase tracking-wide text-slate-700 dark:text-slate-300">
                            Email Sekolah / Terdaftar
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-xs sm:text-sm text-slate-900 dark:text-white focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all @error('email') border-red-400 @enderror"
                               placeholder="nama@sapabk.sch.id">
                        @error('email')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <label for="password" class="block text-xs font-bold uppercase tracking-wide text-slate-700 dark:text-slate-300">
                                Password
                            </label>
                        </div>
                        <div class="relative">
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                   class="w-full px-4 py-3 pr-10 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-xs sm:text-sm text-slate-900 dark:text-white focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all @error('password') border-red-400 @enderror"
                                   placeholder="••••••••">
                            <button type="button" id="toggle-password"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#059669] dark:hover:text-emerald-400 p-1">
                                <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember & Forgot Password Grid -->
                    <div class="flex items-center justify-between text-xs pt-1">
                        <label for="remember" class="flex items-center gap-2 cursor-pointer text-slate-600 dark:text-slate-300">
                            <input id="remember" type="checkbox" name="remember" class="rounded border-slate-300 dark:border-slate-600 text-[#059669] focus:ring-[#059669]">
                            <span>Ingat Saya</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-[#059669] dark:text-emerald-400 font-bold hover:underline">
                            Lupa Password?
                        </a>
                    </div>

                    <!-- Tombol Utama Submit -->
                    <button type="submit" class="w-full btn-primary justify-center py-3.5 rounded-xl font-bold text-sm shadow-lg shadow-emerald-600/25 mt-2">
                        Masuk ke Akun
                    </button>
                </form>

                <!-- Link Registrasi Bawah -->
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

    function quickFill(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
        document.getElementById('login-form').submit();
    }
</script>
@endpush
