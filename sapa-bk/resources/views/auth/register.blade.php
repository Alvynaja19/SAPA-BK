@extends('layouts.public')

@section('title', 'Daftar Akun')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center py-10 sm:py-12 px-4">
    <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-2 gap-0 rounded-3xl overflow-hidden shadow-2xl border"
         style="background: var(--bg-card); border-color: var(--border-color);">

        <!-- Kiri — Ilustrasi & Info -->
        <div class="hidden lg:flex flex-col justify-between px-12 py-16 bg-gradient-to-br from-[#047857] via-[#059669] to-[#10B981] text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-80 h-80 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10">
                <a href="{{ route('home') }}" class="flex items-center gap-3 mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <span class="font-sora font-extrabold text-2xl text-white">SAPA BK</span>
                </a>

                <h2 class="font-sora font-extrabold text-3xl mb-4 leading-snug">
                    Bergabung dengan Portal BK Digital
                </h2>
                <p class="text-emerald-100 text-sm leading-relaxed mb-8">
                    Dapatkan akses ke ekosistem pendampingan akademik, kesehatan mental, dan modul bimbingan karir resmi SMAN 4 Jember.
                </p>

                <div class="space-y-4 text-xs font-medium text-emerald-50">
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md p-3.5 rounded-2xl border border-white/15">
                        <span class="w-7 h-7 rounded-xl bg-white/20 flex items-center justify-center font-bold text-sm">🎓</span>
                        <span>Akses penuh konsultasi AI & Perpustakaan E-Book</span>
                    </div>
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md p-3.5 rounded-2xl border border-white/15">
                        <span class="w-7 h-7 rounded-xl bg-white/20 flex items-center justify-center font-bold text-sm">🔒</span>
                        <span>Kerahasiaan data & sesi konseling 100% aman</span>
                    </div>
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md p-3.5 rounded-2xl border border-white/15">
                        <span class="w-7 h-7 rounded-xl bg-white/20 flex items-center justify-center font-bold text-sm">⚡</span>
                        <span>Proses pendaftaran cepat & tanpa biaya</span>
                    </div>
                </div>
            </div>

            <p class="text-[11px] text-emerald-200/80 relative z-10 pt-6 border-t border-white/20">
                &copy; {{ date('Y') }} SAPA BK — SMA Negeri 4 Jember.
            </p>
        </div>

        <!-- Kanan — Form Registrasi Siswa -->
        <div class="flex flex-col justify-center px-6 sm:px-10 lg:px-12 py-10 sm:py-12"
             style="background: var(--bg-card);">
            <div class="max-w-md w-full mx-auto">
                
                <div class="mb-8 text-center">
                    <span class="pill-badge mb-3">🎓 Pendaftaran Akun Siswa</span>
                    <h1 class="font-sora font-extrabold text-2xl mb-1" style="color: var(--text-primary);">Buat Akun Siswa</h1>
                    <p class="text-xs" style="color: var(--text-body);">Isi data diri di bawah untuk mendaftar layanan SAPA BK SMAN 4 Jember</p>
                </div>

                <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-xs font-bold mb-1.5 uppercase tracking-wide" style="color: var(--text-primary);">Nama Lengkap Siswa</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required
                               class="form-input @error('name') border-red-400 @enderror"
                               placeholder="Contoh: Ahmad Rizki Pratama">
                        @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold mb-1.5 uppercase tracking-wide" style="color: var(--text-primary);">Email Terdaftar</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                               class="form-input @error('email') border-red-400 @enderror"
                               placeholder="nama@email.com">
                        @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-xs font-bold mb-1.5 uppercase tracking-wide" style="color: var(--text-primary);">Password</label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required
                                   class="form-input pr-10 @error('password') border-red-400 @enderror"
                                   placeholder="Minimal 8 karakter">
                            <button type="button" onclick="togglePasswordVisibility('password', 'eye-icon-password')"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-[#475569] hover:text-[#059669] focus:outline-none p-1">
                                <svg id="eye-icon-password" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold mb-1.5 uppercase tracking-wide" style="color: var(--text-primary);">Konfirmasi Password</label>
                        <div class="relative">
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                   class="form-input pr-10"
                                   placeholder="Ulangi password di atas">
                            <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'eye-icon-confirmation')"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-[#475569] hover:text-[#059669] focus:outline-none p-1">
                                <svg id="eye-icon-confirmation" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Syarat & Ketentuan -->
                    <div class="flex items-start gap-2 pt-2">
                        <input id="terms" type="checkbox" name="terms" required
                               class="mt-0.5 rounded border-[#E2E8F0] text-[#059669] focus:ring-[#059669]">
                        <label for="terms" class="text-xs leading-snug" style="color: var(--text-body);">
                            Saya menyetujui <a href="#" class="text-[#059669] font-semibold hover:underline">Syarat & Ketentuan</a> layanan SAPA BK SMAN 4 Jember.
                        </label>
                    </div>

                    <button type="submit" id="submit-btn" class="btn-primary w-full justify-center py-3.5 text-sm mt-2">
                        Daftar Sebagai Siswa
                    </button>
                </form>

                <!-- Note Guru BK -->
                <div class="mt-6 p-3 rounded-2xl border text-[11px] flex items-center gap-2"
                     style="background: rgba(217,119,6,0.08); border-color: rgba(217,119,6,0.3); color: #B45309;">
                    <span>👨‍🏫</span>
                    <span><strong>Anda Guru BK / Pendidik?</strong> Akun Guru BK dibuat dan dikelola langsung oleh Administrator Sekolah.</span>
                </div>

                <p class="text-center mt-6 text-xs" style="color: var(--text-body);">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-[#059669] font-bold hover:underline">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePasswordVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.018 10.018 0 014.122-.963c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-4.276-4.276a3 3 0 00-4.243-4.243M3 3l18 18" />`;
        } else {
            input.type = 'password';
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
        }
    }
</script>
@endpush


