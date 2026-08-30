@extends('layouts.public')

@section('title', 'Tentang BK')

@section('content')

{{-- ===== HEADER HERO BANNER ===== --}}
<section class="bg-gradient-to-b from-[#ECFDF5]/80 via-white to-[#F8FAFC] dark:from-emerald-950/80 dark:via-slate-900 dark:to-slate-950 pt-24 sm:pt-28 pb-14 sm:pb-16 border-b border-slate-200/60 dark:border-slate-800 relative overflow-hidden">
    <div class="absolute top-0 right-1/4 w-96 h-96 hero-glow-1 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs font-semibold text-[#059669] dark:text-emerald-400 mb-4">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a>
            <span>/</span>
            <span class="text-slate-400 dark:text-slate-500">Tentang BK</span>
        </nav>

        <div class="max-w-3xl">
            <span class="pill-badge mb-4">Profil & Komitmen Kami</span>
            <h1 class="font-sora text-3xl sm:text-5xl font-extrabold text-[#0F172A] dark:text-white tracking-tight leading-tight mb-4">
                Tentang Bimbingan & Konseling<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#059669] to-[#10B981] dark:from-emerald-400 dark:to-teal-300">SMA Negeri 4 Jember</span>
            </h1>
            <p class="text-[#475569] dark:text-slate-300 text-base sm:text-lg leading-relaxed">
                Portal SAPA BK hadir sebagai ruang aman digital bagi siswa SMAN 4 Jember untuk berkonsultasi, menemukan minat bakat, serta mendapatkan pendampingan psikologi & akademik secara profesional.
            </p>
        </div>
    </div>
</section>

{{-- ===== VISI & MISI ===== --}}
<section class="py-16 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Visi Card -->
            <div class="card p-8 bg-gradient-to-br from-[#ECFDF5] to-white dark:from-emerald-950/80 dark:to-slate-800/90 border-[#6EE7B7] dark:border-emerald-700/50 relative overflow-hidden">
                <div class="w-12 h-12 rounded-2xl bg-[#059669] dark:bg-emerald-600 text-white flex items-center justify-center mb-6 shadow-md shadow-[#059669]/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <h2 class="font-sora font-extrabold text-2xl text-[#0F172A] dark:text-white mb-4">Visi BK SMAN 4 Jember</h2>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed text-sm sm:text-base">
                    "Terwujudnya pelayanan Bimbingan dan Konseling digital yang inklusif, responsif, dan berorientasi pada pembentukan karakter siswa SMAN 4 Jember yang mandiri, berprestasi, serta sehat secara mental."
                </p>
            </div>

            <!-- Misi Card -->
            <div class="card p-8 bg-white dark:bg-slate-800/90 border-slate-200 dark:border-slate-700/60">
                <div class="w-12 h-12 rounded-2xl bg-teal-50 dark:bg-teal-950/80 text-teal-600 dark:text-teal-400 flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h2 class="font-sora font-extrabold text-2xl text-[#0F172A] dark:text-white mb-4">Misi Pelayanan</h2>
                <ul class="space-y-3 text-sm text-slate-600 dark:text-slate-300">
                    <li class="flex items-start gap-3">
                        <span class="w-5 h-5 rounded-full bg-[#ECFDF5] dark:bg-emerald-950 text-[#059669] dark:text-emerald-400 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</span>
                        <span>Menyediakan konsultasi privat berbasis teknologi AI dan konselor profesional yang dapat diakses 24/7.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="w-5 h-5 rounded-full bg-[#ECFDF5] dark:bg-emerald-950 text-[#059669] dark:text-emerald-400 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</span>
                        <span>Mendukung kesiapan siswa menembus Perguruan Tinggi Negeri (PTN) melalui bimbingan karir terstruktur.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="w-5 h-5 rounded-full bg-[#ECFDF5] dark:bg-emerald-950 text-[#059669] dark:text-emerald-400 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</span>
                        <span>Menyediakan literasi e-book dan modul edukasi psikologi perkembangan remaja secara gratis.</span>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</section>

{{-- ===== NILAI UTAMA (CORE VALUES) ===== --}}
<section class="py-16 bg-[#F8FAFC] dark:bg-slate-950/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="badge-green text-xs font-bold mb-3 inline-block">Nilai Utama</span>
            <h2 class="font-sora text-3xl font-extrabold text-[#0F172A] dark:text-white">Mengapa Konsultasi di SAPA BK Aman?</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="card p-6 text-center group hover:-translate-y-1 transition-transform">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950 text-[#059669] dark:text-emerald-400 flex items-center justify-center mx-auto mb-4 font-bold text-xl">
                    🔒
                </div>
                <h3 class="font-sora font-bold text-base text-[#0F172A] dark:text-white mb-2">Privasi 100% Rahasia</h3>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    Setiap percakapan dan catatan konsultasi dilindungi kode etik kerahasiaan konseling SMAN 4 Jember.
                </p>
            </div>

            <div class="card p-6 text-center group hover:-translate-y-1 transition-transform">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950 text-[#059669] dark:text-emerald-400 flex items-center justify-center mx-auto mb-4 font-bold text-xl">
                    🤝
                </div>
                <h3 class="font-sora font-bold text-base text-[#0F172A] dark:text-white mb-2">Pendampingan Empatis</h3>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    Tim konselor mendengarkan masalahmu tanpa menghakimi dan siap memberikan solusi praktis.
                </p>
            </div>

            <div class="card p-6 text-center group hover:-translate-y-1 transition-transform">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950 text-[#059669] dark:text-emerald-400 flex items-center justify-center mx-auto mb-4 font-bold text-xl">
                    📱
                </div>
                <h3 class="font-sora font-bold text-base text-[#0F172A] dark:text-white mb-2">Akses Digital 24/7</h3>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    Didukung Asisten AI pintar yang siap menjawab pertanyaan dasar seputar sekolah dan persiapan kuliah kapan saja.
                </p>
            </div>

            <div class="card p-6 text-center group hover:-translate-y-1 transition-transform">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950 text-[#059669] dark:text-emerald-400 flex items-center justify-center mx-auto mb-4 font-bold text-xl">
                    🎯
                </div>
                <h3 class="font-sora font-bold text-base text-[#0F172A] dark:text-white mb-2">Berbasis Sains & Data</h3>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    Instrumen tes minat bakat dan modul edukasi disusun sesuai standar bimbingan konseling nasional.
                </p>
            </div>

        </div>
    </div>
</section>

{{-- ===== TIM GURU BK & KONSELOR SMAN 4 JEMBER ===== --}}
<section class="py-20 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="badge-green text-xs font-bold mb-3 inline-block">Tim Pengajar</span>
            <h2 class="font-sora text-3xl font-extrabold text-[#0F172A] dark:text-white">Tim Guru BK SMAN 4 Jember</h2>
            <p class="text-slate-600 dark:text-slate-300 text-sm mt-3">Konselor berpengalaman yang siap membimbing perkembangan akademik dan kepribadianmu.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- Counselor Card 1 -->
            <div class="card-hover p-6 text-center flex flex-col items-center">
                <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-[#047857] to-[#10B981] text-white flex items-center justify-center font-sora font-extrabold text-2xl mb-4 shadow-lg shadow-[#059669]/20 border-4 border-white dark:border-slate-800">
                    BK
                </div>
                <h3 class="font-sora font-bold text-lg text-[#0F172A] dark:text-white">Tim Guru BK Kelas X</h3>
                <p class="text-xs text-[#059669] dark:text-emerald-400 font-semibold mb-2">Spesialis Adaptasi & Potensi Diri</p>
                <span class="badge-green text-[10px] mb-3">Tersedia untuk Sesi BK</span>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed max-w-xs">
                    Mendampingi siswa baru dalam proses adaptasi lingkungan sekolah dan pengenalan potensi bakat dasar.
                </p>
            </div>

            <!-- Counselor Card 2 -->
            <div class="card-hover p-6 text-center flex flex-col items-center">
                <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-[#047857] to-[#10B981] text-white flex items-center justify-center font-sora font-extrabold text-2xl mb-4 shadow-lg shadow-[#059669]/20 border-4 border-white dark:border-slate-800">
                    BK
                </div>
                <h3 class="font-sora font-bold text-lg text-[#0F172A] dark:text-white">Tim Guru BK Kelas XI</h3>
                <p class="text-xs text-[#059669] dark:text-emerald-400 font-semibold mb-2">Spesialis Motivasi & Akademik</p>
                <span class="badge-green text-[10px] mb-3">Tersedia untuk Sesi BK</span>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed max-w-xs">
                    Fokus pada peningkatan efektivitas cara belajar, manajemen stres ujian, dan dinamika sosial antarteman.
                </p>
            </div>

            <!-- Counselor Card 3 -->
            <div class="card-hover p-6 text-center flex flex-col items-center">
                <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-[#047857] to-[#10B981] text-white flex items-center justify-center font-sora font-extrabold text-2xl mb-4 shadow-lg shadow-[#059669]/20 border-4 border-white dark:border-slate-800">
                    BK
                </div>
                <h3 class="font-sora font-bold text-lg text-[#0F172A] dark:text-white">Tim Guru BK Kelas XII</h3>
                <p class="text-xs text-[#059669] dark:text-emerald-400 font-semibold mb-2">Spesialis Karir & Perguruan Tinggi</p>
                <span class="badge-green text-[10px] mb-3">Tersedia untuk Sesi BK</span>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed max-w-xs">
                    Membimbing konsultasi intensif pemilihan jurusan SNBP/SNBT, kedinasan, dan perencanaan karir tingkat lanjut.
                </p>
            </div>

        </div>
    </div>
</section>

{{-- ===== 4 BIDANG LAYANAN BK ===== --}}
<section class="py-16 bg-[#F8FAFC] dark:bg-slate-950/80 border-t border-slate-200/80 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="badge-green text-xs font-bold mb-3 inline-block">Cakupan Bimbingan</span>
            <h2 class="font-sora text-3xl font-extrabold text-[#0F172A] dark:text-white">4 Bidang Layanan BK</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="card p-6 flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-[#ECFDF5] dark:bg-emerald-950 text-[#059669] dark:text-emerald-400 font-bold text-base flex items-center justify-center shrink-0">1</div>
                <div>
                    <h3 class="font-sora font-bold text-base text-[#0F172A] dark:text-white mb-1">Bimbingan Pribadi</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">Membantu pemahaman diri, penerimaan diri, kepercayaan diri, serta pengelolaan emosi dan kesehatan mental siswa.</p>
                </div>
            </div>

            <div class="card p-6 flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-[#ECFDF5] dark:bg-emerald-950 text-[#059669] dark:text-emerald-400 font-bold text-base flex items-center justify-center shrink-0">2</div>
                <div>
                    <h3 class="font-sora font-bold text-base text-[#0F172A] dark:text-white mb-1">Bimbingan Sosial</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">Mengembangkan keterampilan berkomunikasi, etika berteman, resolusi konflik, dan kemampuan beradaptasi di lingkungan sekolah.</p>
                </div>
            </div>

            <div class="card p-6 flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-[#ECFDF5] dark:bg-emerald-950 text-[#059669] dark:text-emerald-400 font-bold text-base flex items-center justify-center shrink-0">3</div>
                <div>
                    <h3 class="font-sora font-bold text-base text-[#0F172A] dark:text-white mb-1">Bimbingan Belajar</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">Mendampingi pemahaman gaya belajar, manajemen waktu belajar, penanganan kesulitan belajar, dan strategi ujian.</p>
                </div>
            </div>

            <div class="card p-6 flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-[#ECFDF5] dark:bg-emerald-950 text-[#059669] dark:text-emerald-400 font-bold text-base flex items-center justify-center shrink-0">4</div>
                <div>
                    <h3 class="font-sora font-bold text-base text-[#0F172A] dark:text-white mb-1">Bimbingan Karir</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">Memberikan informasi perguruan tinggi, eksplorasi profesi, pemetaan minat bakat, serta persiapan masa depan setelah lulus.</p>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
