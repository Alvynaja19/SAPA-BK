@extends('layouts.public')

@section('title', 'Beranda')

@section('content')

{{-- ===== HERO SECTION ===== --}}
<section class="relative overflow-hidden bg-gradient-to-b from-[#ECFDF5]/80 via-white to-[#F8FAFC] pt-12 pb-24 lg:pt-20 lg:pb-32">
    <!-- Floating background glow circles -->
    <div class="absolute top-10 left-1/2 -translate-x-1/2 w-[700px] h-[350px] hero-glow-1 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-40 right-10 w-96 h-96 hero-glow-2 rounded-full blur-2xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
            
            <!-- Left Text Column -->
            <div class="lg:col-span-7 text-center lg:text-left">
                <!-- Pill Badge -->
                <div class="pill-badge mb-6 inline-flex">
                    <span class="w-2 h-2 rounded-full bg-[#059669] animate-pulse"></span>
                    <span>Platform Kesehatan Mental & Potensi Siswa SMAN 4 Jember</span>
                </div>

                <h1 class="font-sora text-3xl sm:text-5xl lg:text-6xl font-extrabold text-[#0F172A] leading-[1.15] tracking-tight mb-6">
                    Konsultasi & Temukan
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#059669] via-[#10B981] to-[#047857]">Potensi Diri</span><br class="hidden sm:block">
                    Kapan Saja & Di Mana Saja
                </h1>

                <p class="text-[#475569] text-base sm:text-lg leading-relaxed mb-8 max-w-2xl mx-auto lg:mx-0">
                    SAPA BK hadir sebagai asisten digital pintar Bimbingan & Konseling yang siap mendampingi perjalanan akademik, karir, dan kesehatan mental siswa SMAN 4 Jember secara <strong>aman & 100% rahasia</strong>.
                </p>

                <!-- Dual Action CTA -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 mb-12">
                    @auth
                        <a href="{{ route('student.chat') }}" class="btn-primary text-base w-full sm:w-auto px-8 py-3.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            Mulai Konsultasi AI
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary text-base w-full sm:w-auto px-8 py-3.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            Mulai Konsultasi Gratis
                        </a>
                    @endauth
                    
                    <a href="{{ route('ebook.public') }}" class="btn-secondary text-base w-full sm:w-auto px-8 py-3.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Jelajahi E-Book BK
                    </a>
                </div>

                <!-- Trust Stats Counters -->
                <div class="grid grid-cols-3 gap-4 pt-8 border-t border-slate-200/80 max-w-lg mx-auto lg:mx-0">
                    <div>
                        <p class="font-sora text-2xl sm:text-3xl font-extrabold text-[#059669]">24/7</p>
                        <p class="text-xs text-[#475569] font-medium mt-0.5">Asisten AI Ready</p>
                    </div>
                    <div>
                        <p class="font-sora text-2xl sm:text-3xl font-extrabold text-[#059669]">100%</p>
                        <p class="text-xs text-[#475569] font-medium mt-0.5">Kerahasiaan Privasi</p>
                    </div>
                    <div>
                        <p class="font-sora text-2xl sm:text-3xl font-extrabold text-[#059669]">100+</p>
                        <p class="text-xs text-[#475569] font-medium mt-0.5">E-Book & Modul BK</p>
                    </div>
                </div>
            </div>

            <!-- Right Graphic / Interactive Showcase Container -->
            <div class="lg:col-span-5 flex justify-center items-center relative mt-6 lg:mt-0">
                <div class="relative w-full max-w-md">

                    <!-- Central High-End Card -->
                    <div class="w-full bg-gradient-to-br from-[#047857] via-[#059669] to-[#10B981] p-7 rounded-3xl shadow-2xl shadow-[#059669]/25 text-white relative overflow-hidden border border-emerald-400/30">
                        <div class="absolute -right-8 -bottom-8 w-44 h-44 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                        
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-sora font-bold text-base">Asisten Digital SAPA BK</h3>
                                    <span class="text-xs text-emerald-100/90 flex items-center gap-1.5 mt-0.5">
                                        <span class="w-2 h-2 rounded-full bg-emerald-300"></span> Online & Siap Menjawab
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Chat Simulation Bubbles -->
                        <div class="space-y-3 mb-6 text-xs">
                            <div class="bg-white/15 backdrop-blur-md rounded-2xl rounded-tl-xs p-3.5 border border-white/20">
                                <p class="leading-relaxed font-medium">"Halo! Bingung menentukan jurusan kuliah setelah lulus dari SMAN 4 Jember?"</p>
                            </div>
                            <div class="bg-white text-[#0F172A] rounded-2xl rounded-tr-xs p-3.5 shadow-md ml-4 font-medium">
                                <p class="leading-relaxed">"Iya nih, saya butuh rekomendasi e-book dan tes minat bakat..."</p>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-white/20 flex items-center justify-between text-xs text-emerald-100">
                            <span>SISTEM BK DIGITAL</span>
                            <span class="font-semibold">SMAN 4 JEMBER</span>
                        </div>
                    </div>

                    <!-- Floating Badge Top Right -->
                    <div class="absolute -top-6 -right-4 bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-slate-200/80 px-4 py-3 flex items-center gap-3 animate-bounce-slow">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-[#059669] flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 002-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-[#0F172A]">Privasi 100% Terjamin</p>
                            <p class="text-[10px] text-[#475569]">Konsultasi Aman & Nyaman</p>
                        </div>
                    </div>

                    <!-- Floating Badge Bottom Left -->
                    <div class="absolute -bottom-6 -left-4 bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-slate-200/80 px-4 py-3 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-[#0F172A]">Pustaka E-Book BK</p>
                            <p class="text-[10px] text-[#475569]">Gratis Dibaca Kapan Saja</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

{{-- ===== LAYANAN UTAMA (PILLARS OF BK) ===== --}}
<section class="py-20 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="badge-green text-sm font-bold mb-4 inline-block px-4 py-1.5">Layanan Utama</span>
            <h2 class="font-sora text-4xl sm:text-5xl font-extrabold text-[#0F172A] tracking-tight mt-2">
                Layanan Digital BK SMAN 4 Jember
            </h2>
            <p class="text-[#475569] mt-5 text-lg sm:text-xl leading-relaxed">
                Dirancang khusus untuk membantu setiap siswa berkembang di bidang akademik, pengembangan karakter, hingga persiapan karir masa depan.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <!-- Card 1: AI Chatbot -->
            <div class="card-hover p-8 flex flex-col justify-between group">
                <div>
                    <div class="w-16 h-16 rounded-2xl bg-[#ECFDF5] text-[#059669] flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-[#059669] group-hover:text-white transition-all duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    </div>
                    <h3 class="font-sora font-bold text-xl text-[#0F172A] mb-3 group-hover:text-[#059669] transition-colors">
                        Asisten AI Chatbot BK
                    </h3>
                    <p class="text-base text-[#475569] leading-relaxed">
                        Tanyakan keluh kesah, tips belajar, atau info universitas 24/7. Dijawab instan berdasarkan pedoman resmi BK SMAN 4 Jember.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center text-sm font-bold text-[#059669]">
                    <span>Konsultasi AI</span>
                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </div>
            </div>

            <!-- Card 2: E-Book Digital -->
            <div class="card-hover p-8 flex flex-col justify-between group">
                <div>
                    <div class="w-16 h-16 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-teal-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h3 class="font-sora font-bold text-xl text-[#0F172A] mb-3 group-hover:text-[#059669] transition-colors">
                        Perpustakaan E-Book
                    </h3>
                    <p class="text-base text-[#475569] leading-relaxed">
                        Akses gratis modul bimbingan karir, buku kesehatan mental remaja, serta strategi sukses menembus PTN impian.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center text-sm font-bold text-[#059669]">
                    <span>Buka Perpustakaan</span>
                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </div>
            </div>

            <!-- Card 3: Artikel & Edukasi -->
            <div class="card-hover p-8 flex flex-col justify-between group">
                <div>
                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    <h3 class="font-sora font-bold text-xl text-[#0F172A] mb-3 group-hover:text-[#059669] transition-colors">
                        Artikel & Edukasi BK
                    </h3>
                    <p class="text-base text-[#475569] leading-relaxed">
                        Kumpulan artikel dan jurnal inspiratif karya Guru BK profesional mengenai manajemen stres dan efektivitas belajar.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center text-sm font-bold text-[#059669]">
                    <span>Baca Artikel</span>
                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </div>
            </div>

            <!-- Card 4: Tes Mandiri -->
            <div class="card-hover p-8 flex flex-col justify-between group">
                <div>
                    <div class="w-16 h-16 rounded-2xl bg-[#ECFDF5] text-[#059669] flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-[#059669] group-hover:text-white transition-all duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <h3 class="font-sora font-bold text-xl text-[#0F172A] mb-3 group-hover:text-[#059669] transition-colors">
                        Tes Minat & Bakat
                    </h3>
                    <p class="text-base text-[#475569] leading-relaxed">
                        Evaluasi kepribadian dan rekomendasi jurusan yang disesuaikan dengan profil bakat ilmiah setiap siswa SMAN 4 Jember.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center text-sm font-bold text-[#059669]">
                    <span>Ikuti Tes</span>
                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ===== CARA KERJA (HOW IT WORKS - 3 STEPS) ===== --}}
<section class="py-20 bg-[#F8FAFC] border-y border-slate-200/80 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="badge-green text-sm font-bold mb-4 inline-block px-4 py-1.5">Alur Mudah</span>
            <h2 class="font-sora text-4xl sm:text-5xl font-extrabold text-[#0F172A] mt-2">
                3 Langkah Mudah Konsultasi
            </h2>
            <p class="text-[#475569] mt-5 text-lg sm:text-xl">
                Proses cepat dan praktis untuk mendapatkan bantuan bimbingan konseling kapan saja.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Step 1 -->
            <div class="card p-10 relative overflow-hidden text-center group">
                <div class="w-14 h-14 rounded-2xl bg-[#059669] text-white font-sora font-bold text-xl flex items-center justify-center mx-auto mb-6 shadow-md shadow-[#059669]/20">
                    1
                </div>
                <h3 class="font-sora font-bold text-xl text-[#0F172A] mb-3">Registrasi Akun Siswa</h3>
                <p class="text-base text-[#475569] leading-relaxed">
                    Masuk menggunakan akun NISN atau email siswa SMAN 4 Jember untuk mulai membuka akses konsultasi privat.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="card p-10 relative overflow-hidden text-center group">
                <div class="w-14 h-14 rounded-2xl bg-[#059669] text-white font-sora font-bold text-xl flex items-center justify-center mx-auto mb-6 shadow-md shadow-[#059669]/20">
                    2
                </div>
                <h3 class="font-sora font-bold text-xl text-[#0F172A] mb-3">Tanyakan atau Pilih Konselor</h3>
                <p class="text-base text-[#475569] leading-relaxed">
                    Tuliskan pertanyaanmu ke Asisten Chatbot AI atau pilih jadwal temu langsung dengan Guru BK SMAN 4 Jember.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="card p-10 relative overflow-hidden text-center group">
                <div class="w-14 h-14 rounded-2xl bg-[#059669] text-white font-sora font-bold text-xl flex items-center justify-center mx-auto mb-6 shadow-md shadow-[#059669]/20">
                    3
                </div>
                <h3 class="font-sora font-bold text-xl text-[#0F172A] mb-3">Dapatkan Solusi & Panduan</h3>
                <p class="text-base text-[#475569] leading-relaxed">
                    Dapatkan rekomendasi solusi, akses e-book relevan, dan pendampingan berkelanjutan hingga tuntas.
                </p>
            </div>

        </div>
    </div>
</section>

{{-- ===== SHOWCASE E-BOOK UNGGULAN ===== --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <span class="badge-green text-sm font-bold mb-3 inline-block px-4 py-1.5">Pustaka Digital</span>
                <h2 class="font-sora text-4xl sm:text-5xl font-extrabold text-[#0F172A] mt-2">E-Book BK Pilihan</h2>
            </div>
            <a href="{{ route('ebook.public') }}" class="btn-secondary text-sm hidden sm:inline-flex">
                Lihat Semua E-Book
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

        @if($ebooks->isEmpty())
            <div class="card p-12 text-center">
                <p class="text-[#475569]">Belum ada e-book tersedia saat ini.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($ebooks as $ebook)
                <div class="card-hover overflow-hidden flex flex-col justify-between group">
                    <div>
                        <!-- Cover Container -->
                        <div class="h-48 bg-gradient-to-tr from-[#047857] to-[#10B981] p-5 flex flex-col justify-between relative overflow-hidden">
                            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full blur-md"></div>
                            <span class="badge-green text-[10px] uppercase font-bold self-start backdrop-blur-md">E-Book BK</span>
                            <div class="text-white relative z-10">
                                <svg class="w-10 h-10 text-white/80 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-5">
                            <h3 class="font-sora font-bold text-[#0F172A] text-sm mb-2 group-hover:text-[#059669] transition-colors line-clamp-2">
                                {{ $ebook->title }}
                            </h3>
                            <p class="text-xs text-[#475569] leading-relaxed line-clamp-2 mb-4">
                                {{ $ebook->description }}
                            </p>
                        </div>
                    </div>

                    <div class="px-5 pb-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] font-semibold text-[#059669] bg-[#ECFDF5] px-2.5 py-1 rounded-full">Akses Gratis</span>
                        @auth
                            <a href="{{ route('student.ebook') }}" class="btn-primary text-xs px-4 py-1.5">Baca E-Book</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-primary text-xs px-4 py-1.5">Baca E-Book</a>
                        @endauth
                    </div>
                </div>
                @endforeach
            </div>
        @endif

        <div class="text-center mt-10 sm:hidden">
            <a href="{{ route('ebook.public') }}" class="btn-secondary text-sm w-full justify-center">Lihat Semua E-Book →</a>
        </div>
    </div>
</section>

{{-- ===== ARTIKEL TERBARU ===== --}}
@if($articles->isNotEmpty())
<section class="py-20 bg-[#F8FAFC]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-end justify-between mb-12">
            <div>
                <span class="badge-green text-sm font-bold mb-3 inline-block px-4 py-1.5">Informasi & Edukasi</span>
                <h2 class="font-sora text-4xl sm:text-5xl font-extrabold text-[#0F172A] mt-2">Artikel Edukasi Terbaru</h2>
            </div>
            <a href="{{ route('artikel.list') }}" class="btn-secondary text-sm hidden sm:inline-flex">Lihat Semua Artikel →</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($articles as $article)
            <a href="{{ route('artikel.detail', $article->slug) }}" class="card-hover overflow-hidden block group">
                <div class="h-48 bg-gradient-to-tr from-slate-200 to-slate-100 flex items-center justify-center p-6 text-slate-400 group-hover:scale-105 transition-transform duration-500">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="badge-green text-[10px]">Artikel BK</span>
                        <span class="text-xs text-slate-400">• {{ $article->created_at->format('d M Y') }}</span>
                    </div>
                    <h3 class="font-sora font-bold text-[#0F172A] text-lg mb-2 group-hover:text-[#059669] transition-colors line-clamp-2">
                        {{ $article->title }}
                    </h3>
                    <p class="text-sm text-[#475569] leading-relaxed line-clamp-3 mb-4">
                        {{ Str::limit(strip_tags($article->content), 120) }}
                    </p>
                    <span class="text-xs font-bold text-[#059669] inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        Baca Selengkapnya →
                    </span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== FAQ SECTION ===== --}}
@if($faqs->isNotEmpty())
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12">
            <span class="badge-green text-sm font-bold mb-4 inline-block px-4 py-1.5">Pertanyaan Umum</span>
            <h2 class="font-sora text-4xl sm:text-5xl font-extrabold text-[#0F172A] mt-2">Pertanyaan Yang Sering Ditanyakan</h2>
        </div>

        <div class="space-y-4" id="faq-list">
            @foreach($faqs as $i => $faq)
            <div class="card overflow-hidden" x-data="{ open: {{ $i === 0 ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between p-5 text-left hover:bg-[#F8FAFC] transition-colors">
                    <span class="font-sora font-bold text-[#0F172A] text-base pr-4">{{ $faq->question }}</span>
                    <div class="w-8 h-8 rounded-full bg-[#ECFDF5] text-[#059669] flex items-center justify-center shrink-0 transition-transform duration-300"
                         :class="{ 'rotate-180 bg-[#059669] text-white': open }">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </button>
                <div x-show="open" x-collapse class="px-5 pb-5 text-sm sm:text-base text-[#475569] leading-relaxed border-t border-slate-100 pt-4">
                    {{ $faq->answer }}
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('faq') }}" class="btn-secondary text-sm">Lihat Semua FAQ →</a>
        </div>
    </div>
</section>
@endif

{{-- ===== HIGH IMPACT BOTTOM CTA BANNER ===== --}}
<section class="py-16 bg-gradient-to-r from-[#047857] via-[#059669] to-[#10B981] relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="font-sora text-4xl sm:text-5xl font-extrabold text-white mb-4">
            Siap Memulai Konsultasi & Belajar?
        </h2>
        <p class="text-emerald-100 text-lg sm:text-xl mb-8 max-w-xl mx-auto">
            Daftar gratis sekarang dan nikmati seluruh kemudahan asisten digital Bimbingan Konseling SMAN 4 Jember.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @auth
                <a href="{{ route('student.chat') }}" class="btn-white text-base px-8 py-3.5">
                    Mulai Chat Sekarang
                </a>
            @else
                <a href="{{ route('register') }}" class="btn-white text-base px-8 py-3.5">
                    Daftar Akun Gratis
                </a>
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full border-2 border-white text-white font-semibold text-sm hover:bg-white/10 transition-all">
                    Sudah Punya Akun? Masuk
                </a>
            @endauth
        </div>
    </div>
</section>

@endsection

{{-- ===== FLOATING CHAT WIDGET ===== --}}
@section('chat-widget')
<div id="chat-widget" class="fixed bottom-6 right-6 z-50">
    <button id="chat-widget-btn"
            class="w-14 h-14 rounded-2xl bg-[#059669] text-white shadow-2xl shadow-[#059669]/50
                   flex items-center justify-center hover:bg-[#047857] hover:scale-105 active:scale-95 transition-all duration-200 group">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
        <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-red-500 text-white text-[9px] font-extrabold flex items-center justify-center animate-ping"></span>
        <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-red-500 text-white text-[9px] font-extrabold flex items-center justify-center">1</span>
    </button>

    <!-- Popup -->
    <div id="chat-popup" class="hidden absolute bottom-20 right-0 w-80 card shadow-2xl overflow-hidden border border-slate-200 animate-fade-in">
        <div class="bg-gradient-to-r from-[#047857] to-[#059669] p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            </div>
            <div>
                <p class="font-sora font-bold text-white text-sm">Asisten Digital SAPA BK</p>
                <p class="text-emerald-100 text-xs flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-300"></span> Online
                </p>
            </div>
        </div>
        <div class="p-5 bg-[#F8FAFC]">
            <div class="bg-white rounded-2xl rounded-tl-none p-3.5 shadow-sm border border-slate-100 mb-4 text-xs text-[#0F172A] leading-relaxed">
                <p class="font-semibold mb-1">Halo Siswa SMAN 4 Jember! 👋</p>
                <p class="text-slate-600">Ada hal seputar minat karir, akademik, atau masalah sekolah yang ingin didiskusikan?</p>
            </div>
            @auth
                <a href="{{ route('student.chat') }}" class="btn-primary w-full justify-center text-xs py-2.5">Mulai Konsultasi AI</a>
            @else
                <a href="{{ route('login') }}" class="btn-primary w-full justify-center text-xs py-2.5">Login untuk Chat</a>
            @endauth
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('chat-widget-btn')?.addEventListener('click', () => {
        document.getElementById('chat-popup').classList.toggle('hidden');
    });
</script>
@endpush

