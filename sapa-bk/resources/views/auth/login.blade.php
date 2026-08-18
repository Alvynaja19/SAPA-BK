@extends('layouts.public')

@section('title', 'Login')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center py-10 sm:py-12 px-4">
    <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-2 gap-0 rounded-3xl overflow-hidden shadow-2xl border"
         style="background: var(--bg-card); border-color: var(--border-color);">

        <!-- Kiri — Ilustrasi & Info Brand -->
        <div class="hidden lg:flex flex-col justify-between px-12 py-16 bg-gradient-to-br from-[#047857] via-[#059669] to-[#10B981] text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-80 h-80 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10">
                <a href="{{ route('home') }}" class="flex items-center gap-3 mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>
                    <span class="font-sora font-extrabold text-2xl text-white">SAPA BK</span>
                </a>

                <h2 class="font-sora font-extrabold text-3xl mb-4 leading-snug">
                    Selamat Datang Kembali!
                </h2>
                <p class="text-emerald-100 text-sm leading-relaxed mb-8">
                    Masuk ke akun Anda untuk mengakses asisten digital BK, melihat riwayat konsultasi, dan modul e-book SMAN 4 Jember.
                </p>

                <div class="space-y-3">
                    <p class="text-xs font-bold uppercase tracking-wider text-emerald-200 mb-2">⚡ Quick Login Akun Demo:</p>
                    
                    <button type="button" onclick="quickFill('siswa@sapabk.sch.id', 'password')"
                            class="w-full flex items-center justify-between bg-white/10 hover:bg-white/20 backdrop-blur-md p-3 rounded-2xl border border-white/20 text-left transition-all group">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center font-bold text-sm">🎓</span>
                            <div>
                                <p class="text-xs font-bold text-white">Siswa Demo</p>
                                <p class="text-[10px] text-emerald-100/80">siswa@sapabk.sch.id</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold bg-white text-[#059669] px-3 py-1 rounded-full group-hover:scale-105 transition-transform">Masuk →</span>
                    </button>

                    <button type="button" onclick="quickFill('gurubk@sapabk.sch.id', 'password')"
                            class="w-full flex items-center justify-between bg-white/10 hover:bg-white/20 backdrop-blur-md p-3 rounded-2xl border border-white/20 text-left transition-all group">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center font-bold text-sm">👨‍🏫</span>
                            <div>
                                <p class="text-xs font-bold text-white">Guru BK Demo</p>
                                <p class="text-[10px] text-emerald-100/80">gurubk@sapabk.sch.id</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold bg-white text-[#059669] px-3 py-1 rounded-full group-hover:scale-105 transition-transform">Masuk →</span>
                    </button>

                    <button type="button" onclick="quickFill('admin@sapabk.sch.id', 'password')"
                            class="w-full flex items-center justify-between bg-white/10 hover:bg-white/20 backdrop-blur-md p-3 rounded-2xl border border-white/20 text-left transition-all group">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center font-bold text-sm">🛠️</span>
                            <div>
                                <p class="text-xs font-bold text-white">Admin Demo</p>
                                <p class="text-[10px] text-emerald-100/80">admin@sapabk.sch.id</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold bg-white text-[#059669] px-3 py-1 rounded-full group-hover:scale-105 transition-transform">Masuk →</span>
                    </button>
                </div>
            </div>

            <p class="text-[11px] text-emerald-200/80 relative z-10 pt-6 border-t border-white/20">
                &copy; {{ date('Y') }} SAPA BK — SMA Negeri 4 Jember.
            </p>
        </div>

        <!-- Kanan — Form Login -->
        <div class="flex flex-col justify-center px-6 sm:px-10 lg:px-12 py-10 sm:py-12"
             style="background: var(--bg-card);">
            <div class="max-w-md w-full mx-auto">
                <div class="mb-8 text-center">
                    <span class="pill-badge mb-3">Portal Masuk Pengguna</span>
                    <h1 class="font-sora font-extrabold text-2xl mb-1" style="color: var(--text-primary);">Masuk ke Akun</h1>
                    <p class="text-xs" style="color: var(--text-body);">Masukkan email dan password terdaftar Anda</p>
                </div>

                @if (session('status'))
                    <div class="mb-4 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="mb-4 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" id="login-form" class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold mb-1.5 uppercase tracking-wide" style="color: var(--text-primary);">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                               class="form-input @error('email') border-red-400 @enderror"
                               placeholder="nama@email.com">
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <label for="password" class="block text-xs font-bold uppercase tracking-wide" style="color: var(--text-primary);">Password</label>
                            <a href="{{ route('password.request') }}" class="text-xs text-[#059669] hover:underline font-semibold">Lupa password?</a>
                        </div>
                        <div class="relative">
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                   class="form-input pr-10 @error('password') border-red-400 @enderror"
                                   placeholder="••••••••">
                            <button type="button" id="toggle-password"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-[#475569] hover:text-[#059669]">
                                <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember -->
                    <div class="flex items-center gap-2 pt-1">
                        <input id="remember" type="checkbox" name="remember" class="rounded border-[#E2E8F0] text-[#059669] focus:ring-[#059669]">
                        <label for="remember" class="text-xs" style="color: var(--text-body);">Ingat saya di perangkat ini</label>
                    </div>

                    <button type="submit" class="btn-primary w-full justify-center py-3.5 text-sm">
                        Masuk ke Akun
                    </button>
                </form>

                <!-- Mobile Quick Login (If on small screens) -->
                <div class="mt-8 pt-6 border-t lg:hidden" style="border-color: var(--border-color);">
                    <p class="text-xs font-bold text-center mb-3" style="color: var(--text-muted);">Quick Login Akun Demo:</p>
                    <div class="grid grid-cols-3 gap-2">
                        <button type="button" onclick="quickFill('siswa@sapabk.sch.id', 'password')" class="btn-secondary text-[10px] px-2 py-2">Siswa</button>
                        <button type="button" onclick="quickFill('gurubk@sapabk.sch.id', 'password')" class="btn-secondary text-[10px] px-2 py-2">Guru BK</button>
                        <button type="button" onclick="quickFill('admin@sapabk.sch.id', 'password')" class="btn-secondary text-[10px] px-2 py-2">Admin</button>
                    </div>
                </div>

                <p class="text-center mt-6 text-xs" style="color: var(--text-body);">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-[#059669] font-bold hover:underline">Daftar akun baru</a>
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

