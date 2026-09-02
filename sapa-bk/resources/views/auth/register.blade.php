@extends('layouts.public')

@section('title', 'Daftar Akun')

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
                         alt="Ilustrasi Registrasi SAPA BK SMAN 4 Jember" 
                         class="w-full object-contain rounded-2xl drop-shadow-lg">
                </div>

                <!-- Teks Wujudkan Potensi Diri -->
                <h2 class="font-sora font-extrabold text-3xl sm:text-4xl text-white dark:text-emerald-100 leading-tight mb-3">
                    Gabung Ekosistem BK Digital.
                </h2>
                <p class="text-sm text-emerald-100/90 dark:text-slate-300 max-w-sm mx-auto leading-relaxed">
                    Dapatkan akses ke fitur Konsultasi AI, Pemetaan Minat Bakat, dan Perpustakaan E-Book SMAN 4 Jember.
                </p>
            </div>
        </div>

        <!-- KOLOM KANAN: Panel Putih dengan Form & Animasi Load -->
        <!-- Memiliki class animate-fade-in-up untuk animasi Slide-up -->
        <div class="p-8 sm:p-12 flex flex-col justify-center relative animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="max-w-md w-full mx-auto">
                
                <div class="mb-6 text-center">
                    <span class="pill-badge mb-2">🎓 Pendaftaran Siswa SMAN 4 Jember</span>
                    <h1 class="font-sora font-bold text-2xl text-slate-900 dark:text-white">Buat Akun Siswa Baru</h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Lengkapi formulir di bawah untuk mendaftar akun</p>
                </div>

                <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-xs font-bold mb-1.5 uppercase tracking-wide text-slate-700 dark:text-slate-300">Nama Lengkap Siswa</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-xs sm:text-sm text-slate-900 dark:text-white input-glow-focus outline-none transition-all duration-300 @error('name') border-red-400 @enderror"
                               placeholder="Contoh: Ahmad Rizki Pratama">
                        @error('name') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email & Phone Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="email" class="block text-xs font-bold mb-1.5 uppercase tracking-wide text-slate-700 dark:text-slate-300">Email Sekolah</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-xs sm:text-sm text-slate-900 dark:text-white input-glow-focus outline-none transition-all duration-300 @error('email') border-red-400 @enderror"
                                   placeholder="nama@email.com">
                            @error('email') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-xs font-bold mb-1.5 uppercase tracking-wide text-slate-700 dark:text-slate-300">No. WhatsApp</label>
                            <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-xs sm:text-sm text-slate-900 dark:text-white input-glow-focus outline-none transition-all duration-300 @error('phone') border-red-400 @enderror"
                                   placeholder="081234567890">
                            @error('phone') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- NISN, Kelas, Jurusan Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label for="nisn" class="block text-xs font-bold mb-1.5 uppercase tracking-wide text-slate-700 dark:text-slate-300">NISN</label>
                            <input id="nisn" type="text" name="nisn" value="{{ old('nisn') }}"
                                   class="w-full px-3 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-xs text-slate-900 dark:text-white input-glow-focus outline-none transition-all duration-300 @error('nisn') border-red-400 @enderror"
                                   placeholder="0012345678">
                            @error('nisn') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="kelas" class="block text-xs font-bold mb-1.5 uppercase tracking-wide text-slate-700 dark:text-slate-300">Kelas</label>
                            <select id="kelas" name="kelas" class="w-full px-3 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-xs text-slate-900 dark:text-white input-glow-focus outline-none transition-all duration-300 @error('kelas') border-red-400 @enderror">
                                <option value="">Pilih</option>
                                <option value="X" {{ old('kelas') == 'X' ? 'selected' : '' }}>Kelas X</option>
                                <option value="XI" {{ old('kelas') == 'XI' ? 'selected' : '' }}>Kelas XI</option>
                                <option value="XII" {{ old('kelas') == 'XII' ? 'selected' : '' }}>Kelas XII</option>
                            </select>
                            @error('kelas') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="jurusan" class="block text-xs font-bold mb-1.5 uppercase tracking-wide text-slate-700 dark:text-slate-300">Jurusan</label>
                            <input id="jurusan" type="text" name="jurusan" value="{{ old('jurusan') ?? 'MIPA' }}"
                                   class="w-full px-3 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-xs text-slate-900 dark:text-white input-glow-focus outline-none transition-all duration-300 @error('jurusan') border-red-400 @enderror"
                                   placeholder="IPA/IPS/Merdeka">
                            @error('jurusan') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-xs font-bold mb-1.5 uppercase tracking-wide text-slate-700 dark:text-slate-300">Password</label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required
                                   class="w-full px-4 py-3 pr-10 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-xs sm:text-sm text-slate-900 dark:text-white input-glow-focus outline-none transition-all duration-300 @error('password') border-red-400 @enderror"
                                   placeholder="Minimal 8 karakter">
                            <button type="button" onclick="togglePasswordVisibility('password', 'eye-icon-password')"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#059669] dark:hover:text-emerald-400 p-1">
                                <svg id="eye-icon-password" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold mb-1.5 uppercase tracking-wide text-slate-700 dark:text-slate-300">Konfirmasi Password</label>
                        <div class="relative">
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                   class="w-full px-4 py-3 pr-10 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/80 text-xs sm:text-sm text-slate-900 dark:text-white input-glow-focus outline-none transition-all duration-300"
                                   placeholder="Ulangi password di atas">
                            <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'eye-icon-confirmation')"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#059669] dark:hover:text-emerald-400 p-1">
                                <svg id="eye-icon-confirmation" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Syarat & Ketentuan -->
                    <div class="flex items-start gap-2 pt-1">
                        <input id="terms" type="checkbox" name="terms" required
                               class="mt-0.5 rounded border-slate-300 dark:border-slate-600 text-[#059669] focus:ring-[#059669]">
                        <label for="terms" class="text-xs text-slate-600 dark:text-slate-300 leading-snug">
                            Saya menyetujui <a href="#" class="text-[#059669] dark:text-emerald-400 font-semibold hover:underline">Syarat & Ketentuan</a> layanan SAPA BK.
                        </label>
                    </div>

                    <button type="submit" id="submit-btn" class="w-full inline-flex items-center justify-center py-3.5 rounded-xl font-bold text-sm text-white bg-[#059669] hover:bg-[#047857] shadow-lg shadow-emerald-600/25 mt-2 transition-transform duration-300 hover:scale-105">
                        Daftar Sebagai Siswa
                    </button>
                </form>

                <!-- Note Guru BK -->
                <div class="mt-5 p-3 rounded-2xl border text-[11px] flex items-center gap-2 bg-amber-50 dark:bg-amber-950/40 border-amber-200 dark:border-amber-800/40 text-amber-800 dark:text-amber-300">
                    <span>👨‍🏫</span>
                    <span><strong>Guru BK / Admin?</strong> Akun pendidik dikelola langsung oleh Administrator Sekolah.</span>
                </div>

                <p class="text-center mt-5 text-xs text-slate-500 dark:text-slate-400">
                    Sudah Memiliki Akun?
                    <a href="{{ route('login') }}" class="text-[#059669] dark:text-emerald-400 font-bold hover:underline ml-1">
                        Masuk di Sini
                    </a>
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
