@extends('layouts.public')

@section('title', 'Beranda')

@push('head')
<style>
/* ===== LANDING PAGE CUSTOM STYLES ===== */

/* Hero gradient animation */
@keyframes gradientShift {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}
@keyframes floatUp {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}
@keyframes pulseSlow {
    0%, 100% { opacity: 0.6; transform: scale(1); }
    50% { opacity: 1; transform: scale(1.05); }
}
@keyframes slideInLeft {
    from { opacity: 0; transform: translateX(-30px); }
    to { opacity: 1; transform: translateX(0); }
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes countUp {
    from { opacity: 0; }
    to { opacity: 1; }
}

.hero-animated-bg {
    background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 25%, #d1fae5 50%, #ecfdf5 75%, #f8fafc 100%);
    background-size: 400% 400%;
    animation: gradientShift 8s ease infinite;
}
.float-badge { animation: floatUp 3s ease-in-out infinite; }
.float-badge-2 { animation: floatUp 3s ease-in-out infinite 1.5s; }

.section-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #059669;
    background: rgba(5, 150, 105, 0.08);
    border: 1px solid rgba(5, 150, 105, 0.2);
    border-radius: 100px;
    padding: 5px 14px;
    margin-bottom: 16px;
}

/* UAD-style section divider bar */
.section-accent-bar {
    width: 48px;
    height: 4px;
    background: linear-gradient(90deg, #059669, #10b981);
    border-radius: 4px;
    margin: 12px 0 20px 0;
}

/* News card like BK UAD */
.news-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid rgba(226, 232, 240, 0.8);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}
.news-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(5, 150, 105, 0.12);
    border-color: rgba(5, 150, 105, 0.2);
}
.dark .news-card {
    background: rgba(30, 41, 59, 0.8);
    border-color: rgba(51, 65, 85, 0.6);
}
.dark .news-card:hover {
    border-color: rgba(5, 150, 105, 0.4);
}

/* News featured large card */
.news-card-featured {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid rgba(226, 232, 240, 0.8);
    transition: all 0.35s ease;
}
.news-card-featured:hover {
    transform: translateY(-6px);
    box-shadow: 0 24px 48px rgba(5, 150, 105, 0.15);
    border-color: rgba(5, 150, 105, 0.25);
}
.dark .news-card-featured {
    background: rgba(30, 41, 59, 0.8);
    border-color: rgba(51, 65, 85, 0.6);
}

/* Service pillars card */
.pillar-card {
    background: white;
    border-radius: 20px;
    padding: 28px;
    border: 1px solid rgba(226, 232, 240, 0.8);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
}
.pillar-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #059669, #10b981);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.35s ease;
}
.pillar-card:hover { transform: translateY(-5px); box-shadow: 0 24px 40px rgba(5,150,105,0.13); border-color: rgba(5,150,105,0.2); }
.pillar-card:hover::before { transform: scaleX(1); }
.dark .pillar-card { background: rgba(30,41,59,0.8); border-color: rgba(51,65,85,0.6); }

/* Pengumuman list item */
.announcement-item {
    display: flex;
    gap: 16px;
    padding: 16px 0;
    border-bottom: 1px solid rgba(226, 232, 240, 0.7);
    align-items: flex-start;
    transition: all 0.2s;
}
.announcement-item:last-child { border-bottom: none; }
.announcement-item:hover { padding-left: 4px; }
.dark .announcement-item { border-color: rgba(51,65,85,0.5); }

/* Trust / stat cards */
.stat-card {
    background: white;
    border-radius: 16px;
    padding: 24px 20px;
    text-align: center;
    border: 1px solid rgba(226,232,240,0.8);
    transition: all 0.3s ease;
}
.stat-card:hover { box-shadow: 0 12px 32px rgba(5,150,105,0.12); transform: translateY(-3px); }
.dark .stat-card { background: rgba(30,41,59,0.8); border-color: rgba(51,65,85,0.6); }

/* Contact / Find Us map card */
.contact-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid rgba(226,232,240,0.8);
}
.dark .contact-card { background: rgba(30,41,59,0.8); border-color: rgba(51,65,85,0.6); }

/* Accolades row */
.accreditation-badge {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px 16px;
    background: white;
    border-radius: 16px;
    border: 1px solid rgba(226,232,240,0.8);
    text-align: center;
    transition: all 0.3s ease;
}
.accreditation-badge:hover { transform: translateY(-3px); box-shadow: 0 12px 28px rgba(5,150,105,0.12); }
.dark .accreditation-badge { background: rgba(30,41,59,0.8); border-color: rgba(51,65,85,0.6); }

/* dark/light text helpers */
.text-primary-color { color: var(--text-primary, #0F172A); }
.text-body-color { color: var(--text-body, #475569); }
</style>
@endpush

@section('content')

{{-- ===== 1. HERO SECTION ===== --}}
<section class="relative bg-slate-50/90 dark:bg-slate-900 pt-32 sm:pt-40 lg:pt-44 pb-16 sm:pb-20 lg:pb-20 overflow-hidden">
    <!-- Background grid pattern -->
    <div class="absolute inset-0 bg-[linear-gradient(to_bottom,#f1f5f9_1px,transparent_1px)] bg-[size:100%_28px] opacity-50 dark:opacity-10 pointer-events-none"></div>

    <!-- Decorative blobs -->
    <div class="absolute top-24 left-0 w-96 h-96 bg-emerald-100/50 dark:bg-emerald-900/20 rounded-full blur-3xl pointer-events-none -translate-x-1/2"></div>
    <div class="absolute bottom-0 right-0 w-80 h-80 bg-teal-100/40 dark:bg-teal-900/20 rounded-full blur-3xl pointer-events-none translate-x-1/4"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- grid-cols-2 dengan gap-8 (32px) sesuai ketentuan --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-8 items-center">
            
            <!-- === LEFT: Text Block === -->
            <div class="text-center lg:text-left">

                <!-- Pill Badge — visual entry point (mb-5 agar jarak ke headline rapi) -->
                <span class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full bg-white dark:bg-slate-800 border border-slate-200/90 dark:border-slate-700 shadow-sm text-slate-600 dark:text-slate-400 text-xs font-semibold mb-5">
                    <span class="w-2 h-2 rounded-full bg-[#059669] animate-pulse"></span>
                    Sistem Informasi BK Digital
                </span>

                <!-- Headline -->
                <h1 class="font-sora text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight text-slate-900 dark:text-white" style="margin-bottom: 24px;">
                    BK Lebih Modern.<br>
                    <span class="text-[#059669]">Siswa Makin Dekat.</span>
                </h1>

                <!-- Deskripsi: dengan margin-bottom 36px yang dijamin inline style -->
                <p class="text-base sm:text-lg text-slate-600 dark:text-slate-400 max-w-lg mx-auto lg:mx-0 font-normal" style="margin-bottom: 36px; line-height: 1.8;">
                    Sistem cerdas untuk mengelola data siswa, sesi konseling, instrumen asesmen, hingga pendampingan akademik & kesehatan mental secara privat dan terintegrasi di SMAN 4 Jember.
                </p>

                <!-- CTA Buttons: dengan margin-top 36px dan margin-bottom 36px yang dijamin inline style -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4" style="margin-top: 36px; margin-bottom: 36px;">

                    <!-- CTA UTAMA: py-4 + shadow kuat + icon → dominan, mudah ditemukan mata -->
                    @auth
                        <a href="{{ route('student.chat') }}"
                           class="inline-flex items-center justify-center gap-2
                                  bg-[#059669] hover:bg-emerald-700 text-white
                                  px-8 py-4 rounded-2xl font-bold text-base
                                  transition-all duration-200
                                  shadow-lg shadow-emerald-600/30 hover:shadow-emerald-600/40
                                  hover:-translate-y-0.5
                                  w-full sm:w-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            Mulai Gunakan Gratis
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center justify-center gap-2
                                  bg-[#059669] hover:bg-emerald-700 text-white
                                  px-8 py-4 rounded-2xl font-bold text-base
                                  transition-all duration-200
                                  shadow-lg shadow-emerald-600/30 hover:shadow-emerald-600/40
                                  hover:-translate-y-0.5
                                  w-full sm:w-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            Mulai Gunakan Gratis
                        </a>
                    @endauth

                    <!-- CTA SEKUNDER: py-3 + tanpa shadow + font-semibold (bukan bold) + text-slate-600
                         → terlihat jelas sebagai opsi pendukung, tidak bersaing dengan CTA utama -->
                    <a href="#tentang-sapa"
                       class="inline-flex items-center justify-center gap-2
                              bg-white dark:bg-slate-800/60
                              text-slate-600 dark:text-slate-300
                              border border-slate-200 dark:border-slate-700
                              hover:bg-slate-50 dark:hover:bg-slate-700/50
                              hover:border-slate-300 dark:hover:border-slate-600
                              px-8 py-3 rounded-2xl font-semibold text-sm
                              transition-all duration-200
                              w-full sm:w-auto">
                        Jelajahi Fitur
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </a>
                </div>

                <!-- Trust indicators — pill badges yang rapi, lega, & nyaman dipandang -->
                <div class="mt-8 flex flex-wrap items-center justify-center lg:justify-start gap-2.5 sm:gap-3">
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/80 text-slate-600 dark:text-slate-300 font-medium text-xs shadow-xs">
                        <svg class="w-3.5 h-3.5 text-[#059669] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Data Terenkripsi
                    </span>
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/80 text-slate-600 dark:text-slate-300 font-medium text-xs shadow-xs">
                        <svg class="w-3.5 h-3.5 text-[#059669] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Konseling 100% Privat
                    </span>
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/80 text-slate-600 dark:text-slate-300 font-medium text-xs shadow-xs">
                        <svg class="w-3.5 h-3.5 text-[#059669] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        Gratis SMAN 4 Jember
                    </span>
                </div>

            </div>
            
            <!-- RIGHT: Window Frame Card — items-center handles vertical centering -->
            <div class="flex justify-center lg:justify-end items-center">
                <div class="relative w-full max-w-sm sm:max-w-md">
                    <!-- Soft animated glow -->
                    <div class="absolute -inset-3 bg-gradient-to-r from-emerald-400/20 to-teal-400/20 rounded-[2.5rem] blur-2xl pointer-events-none" style="animation: glow-pulse 3s ease-in-out infinite;"></div>

                    <!-- Visual Card Container -->
                    <div class="relative bg-white dark:bg-slate-800
                                shadow-xl shadow-slate-300/40 dark:shadow-slate-950/40
                                border border-slate-200/70 dark:border-slate-700/70
                                p-4 sm:p-5 overflow-hidden" style="border-radius: 28px;">

                        <!-- Window chrome dots (merah / kuning / hijau) -->
                        <div class="flex items-center gap-2 mb-3 pb-2.5 border-b border-slate-100 dark:border-slate-700/60">
                            <span class="w-3 h-3 rounded-full bg-red-400 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-amber-400 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-emerald-400 inline-block"></span>
                            <span class="ml-auto text-[11px] font-bold text-slate-400 dark:text-slate-500 tracking-wide">Guru BK SMAN 4 Jember</span>
                        </div>

                        <!-- Image area -->
                        <div class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-slate-900/80 dark:to-slate-800/80 flex justify-center items-center p-2">
                            <img src="/GuruBk.png"
                                 alt="Guru BK SMAN 4 Jember"
                                 class="w-full h-auto max-h-[300px] sm:max-h-[340px] object-contain rounded-xl hover:scale-[1.02] transition-transform duration-500 drop-shadow-sm">

                            <!-- Floating Online badge -->
                            <div class="absolute top-3 right-3 inline-flex items-center gap-1.5 bg-white dark:bg-slate-800 border border-emerald-100 dark:border-emerald-900 rounded-full px-3 py-1.5 shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="text-[11px] font-bold text-emerald-700 dark:text-emerald-400">Online</span>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="mt-3 flex items-center justify-between px-1">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-[#059669] dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">Konsultasi Sekarang</span>
                            </div>
                            <span class="text-[11px] text-slate-400 dark:text-slate-500 font-medium">Respon cepat</span>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Features Bar Section (Clean Flow) -->
<section class="py-12 bg-white dark:bg-slate-800/90 border-y border-slate-100 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 divide-y sm:divide-y-0 sm:divide-x lg:divide-x-0 divide-slate-100 dark:divide-slate-700/60">
            <!-- Feature 1 -->
            <div class="flex items-start gap-4 pt-4 sm:pt-0 pl-0 sm:pl-4 lg:pl-0">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/40 flex items-center justify-center shrink-0 text-[#059669]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 dark:text-white text-sm mb-1">Aman & Terpercaya</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Keamanan data terjamin dengan standar enkripsi tinggi</p>
                </div>
            </div>
            <!-- Feature 2 -->
            <div class="flex items-start gap-4 pt-4 sm:pt-0 pl-0 sm:pl-4 lg:pl-0">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/40 flex items-center justify-center shrink-0 text-[#059669]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 dark:text-white text-sm mb-1">Data Real-time</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Pantau perkembangan peserta didik secara real-time dan akurat</p>
                </div>
            </div>
            <!-- Feature 3 -->
            <div class="flex items-start gap-4 pt-4 sm:pt-0 lg:pt-0 pl-0 sm:pl-0 lg:pl-0">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/40 flex items-center justify-center shrink-0 text-[#059669]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 dark:text-white text-sm mb-1">Mudah Digunakan</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Antarmuka intuitif yang dirancang khusus untuk guru BK</p>
                </div>
            </div>
            <!-- Feature 4 -->
            <div class="flex items-start gap-4 pt-4 sm:pt-0 pl-0 sm:pl-4 lg:pl-0">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/40 flex items-center justify-center shrink-0 text-[#059669]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 dark:text-white text-sm mb-1">Efisiensi Maksimal</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Hemat waktu administrasi, fokus pada layanan konseling</p>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ===== 2. TENTANG SAPA BK (Banner Card ala Bikonesia) ===== --}}
<section class="py-16 bg-white dark:bg-slate-900" id="tentang-sapa">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Bikonesia-style Banner Card -->
        <div class="relative bg-gradient-to-r from-[#047857] via-[#059669] to-[#10B981] rounded-3xl p-8 sm:p-12 lg:p-16 text-white shadow-2xl overflow-hidden" style="border-radius: 36px;">
            <!-- Decorative background pattern -->
            <div class="absolute -right-16 -bottom-16 w-80 h-80 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-16 -top-16 w-60 h-60 bg-emerald-300/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center relative z-10">
                
                <!-- Left: Logo BK Illustration -->
                <div class="lg:col-span-4 flex justify-center items-center">
                    <div class="relative group max-w-[240px] sm:max-w-xs w-full">
                        <div class="absolute inset-0 bg-white/20 rounded-full blur-2xl group-hover:bg-white/30 transition-all duration-300"></div>
                        <img src="/logoBk.png" alt="Logo BK SAPA BK" class="relative z-10 w-full h-auto object-contain drop-shadow-xl hover:scale-105 transition-transform duration-300">
                    </div>
                </div>

                <!-- Right: Content & Explanation -->
                <div class="lg:col-span-8 text-center lg:text-left">
                    <h2 class="font-sora text-3xl sm:text-4xl lg:text-5xl font-extrabold mb-6 tracking-tight text-white">
                        Apa itu SAPA BK ?
                    </h2>
                    
                    <p class="text-emerald-50 text-base sm:text-lg leading-relaxed mb-8 max-w-3xl font-medium">
                        SAPA BK (Sistem Asistensi Pintar Akademik) merupakan platform digital resmi layanan Bimbingan dan Konseling SMA Negeri 4 Jember. SAPA BK dikembangkan dengan tujuan memfasilitasi siswa SMAN 4 Jember untuk dapat mengakses beragam informasi berkaitan dengan bimbingan dan konseling, layanan konsultasi privat bersama Guru BK profesional, tes minat bakat, serta perpustakaan e-book edukatif hanya dalam satu platform.
                    </p>

                    <div>
                        @auth
                            <a href="{{ route('student.chat') }}" class="inline-flex items-center justify-center px-8 py-3.5 rounded-full bg-white text-[#047857] hover:bg-emerald-50 font-extrabold text-sm sm:text-base shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                                Mulai Konsultasi
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-3.5 rounded-full bg-white text-[#047857] hover:bg-emerald-50 font-extrabold text-sm sm:text-base shadow-lg transition-all duration-200 hover:-translate-y-0.5">
                                Masuk Sekarang
                            </a>
                        @endauth
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>


{{-- ===== 3. BERITA / ARTIKEL TERBARU (mirip "BERITA UTAMA" UAD) ===== --}}
@if($articles->isNotEmpty())
<section class="py-20 bg-white dark:bg-slate-900" id="berita-utama">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
            <div>
                <span class="section-label">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    Informasi & Edukasi BK
                </span>
                <h2 class="font-sora text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    Artikel & Berita Terbaru
                </h2>
                <div class="section-accent-bar"></div>
            </div>
            <a href="{{ route('artikel.list') }}" id="berita-semua-link" class="btn-secondary text-sm hidden sm:inline-flex shrink-0">
                Lihat Semua Artikel
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

        <!-- Articles Grid: 1 featured + 2 smaller (like UAD layout) -->
        @if($articles->count() >= 3)
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Featured Article (Left Large) -->
            <a href="{{ route('artikel.detail', $articles->first()->slug) }}" id="berita-featured" class="lg:col-span-7 news-card-featured group block">
                <!-- Cover -->
                <div class="relative h-64 sm:h-80 lg:h-96 bg-gradient-to-br from-[#042F2E] via-[#047857] to-[#10B981] overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center px-12">
                            <svg class="w-20 h-20 text-white/30 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                    </div>
                    <!-- Gradient overlay -->
                    <div class="absolute bottom-0 left-0 right-0 h-3/4 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <!-- Category badge -->
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center gap-1.5 bg-[#059669] text-white text-[10px] font-bold uppercase tracking-wider px-3 py-1.5 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                            Artikel Utama
                        </span>
                    </div>
                    <!-- Date overlay -->
                    <div class="absolute bottom-4 left-5 text-white text-xs font-medium">
                        <svg class="w-3.5 h-3.5 inline mr-1 mb-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $articles->first()->created_at->translatedFormat('d F Y') }}
                    </div>
                </div>
                <!-- Content -->
                <div class="p-6 sm:p-8">
                    <h3 class="font-sora font-bold text-xl sm:text-2xl mb-3 group-hover:text-[#059669] dark:group-hover:text-emerald-400 transition-colors line-clamp-2 leading-tight text-slate-900 dark:text-white">
                        {{ $articles->first()->title }}
                    </h3>
                    <p class="text-sm leading-relaxed line-clamp-3 mb-5 text-slate-600 dark:text-slate-300">
                        {{ Str::limit(strip_tags($articles->first()->content), 160) }}
                    </p>
                    <span class="inline-flex items-center gap-2 text-sm font-bold text-[#059669] dark:text-emerald-400 group-hover:gap-3 transition-all">
                        Baca Selengkapnya
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </span>
                </div>
            </a>

            <!-- Right Column: 2 smaller articles stacked -->
            <div class="lg:col-span-5 flex flex-col gap-6">
                @foreach($articles->skip(1)->take(2) as $i => $article)
                <a href="{{ route('artikel.detail', $article->slug) }}" id="berita-card-{{ $i + 2 }}" class="news-card group flex-1">
                    <div class="flex flex-col sm:flex-row lg:flex-col h-full">
                        <!-- Image -->
                        <div class="h-40 sm:w-48 sm:h-auto lg:w-auto lg:h-44 bg-gradient-to-br {{ $i === 0 ? 'from-[#047857] to-[#34d399]' : 'from-teal-700 to-teal-400' }} flex-shrink-0 relative overflow-hidden flex items-center justify-center">
                            <svg class="w-12 h-12 text-white/40" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            <div class="absolute top-3 left-3">
                                <span class="text-[9px] font-bold uppercase tracking-wider text-white bg-black/25 rounded-full px-2.5 py-1">Artikel BK</span>
                            </div>
                        </div>
                        <!-- Content -->
                        <div class="p-5 flex flex-col justify-between flex-1">
                            <div>
                                <p class="text-xs mb-2 text-slate-500 dark:text-slate-400">
                                    <svg class="w-3 h-3 inline mr-1 mb-0.5 text-[#059669] dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $article->created_at->translatedFormat('d M Y') }}
                                </p>
                                <h3 class="font-sora font-bold text-base mb-2 group-hover:text-[#059669] dark:group-hover:text-emerald-400 transition-colors line-clamp-2 text-slate-900 dark:text-white">
                                    {{ $article->title }}
                                </h3>
                                <p class="text-xs leading-relaxed line-clamp-2 text-slate-600 dark:text-slate-300">
                                    {{ Str::limit(strip_tags($article->content), 90) }}
                                </p>
                            </div>
                            <span class="text-xs font-bold text-[#059669] dark:text-emerald-400 inline-flex items-center gap-1 mt-3 group-hover:translate-x-1 transition-transform">
                                Baca →
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @else
        <!-- Fallback grid if < 3 articles -->
        <div class="grid grid-cols-1 md:grid-cols-{{ $articles->count() }} gap-6">
            @foreach($articles as $i => $article)
            <a href="{{ route('artikel.detail', $article->slug) }}" id="berita-single-{{ $i+1 }}" class="news-card group block">
                <div class="h-48 bg-gradient-to-br from-[#047857] to-[#10B981] relative flex items-center justify-center">
                    <svg class="w-14 h-14 text-white/40" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    <span class="absolute top-3 left-3 text-[10px] font-bold uppercase bg-[#059669] text-white px-2.5 py-1 rounded-full">Artikel BK</span>
                </div>
                <div class="p-5">
                    <p class="text-xs mb-2 text-slate-400">{{ $article->created_at->translatedFormat('d F Y') }}</p>
                    <h3 class="font-sora font-bold text-lg mb-2 group-hover:text-[#059669] dark:group-hover:text-emerald-400 transition-colors line-clamp-2 text-slate-900 dark:text-white">{{ $article->title }}</h3>
                    <p class="text-sm line-clamp-2 text-slate-600 dark:text-slate-300">{{ Str::limit(strip_tags($article->content), 100) }}</p>
                </div>
            </a>
            @endforeach
        </div>
        @endif

        <div class="text-center mt-8 sm:hidden">
            <a href="{{ route('artikel.list') }}" class="btn-secondary text-sm w-full justify-center">Lihat Semua Artikel →</a>
        </div>
    </div>
</section>
@endif


{{-- ===== 4. LAYANAN UNGGULAN (mirip "PRESTASI MAHASISWA" UAD → di-adaptasi ke fitur BK) ===== --}}
<section class="py-20 bg-[#F8FAFC] dark:bg-slate-950/80 border-y border-slate-200/70 dark:border-slate-800" id="layanan-unggulan">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="section-label">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                Keunggulan Platform
            </span>
            <h2 class="font-sora text-3xl sm:text-4xl font-extrabold tracking-tight mt-1 text-slate-900 dark:text-white">
                Layanan Digital BK Lengkap
            </h2>
            <div class="section-accent-bar mx-auto"></div>
            <p class="text-base leading-relaxed text-slate-600 dark:text-slate-300">
                Dirancang khusus untuk mendampingi siswa SMAN 4 Jember dalam setiap tahap perkembangan akademik dan personal.
            </p>
        </div>

        <!-- Service Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">

            <!-- Card 1: AI Chatbot -->
            <div id="layanan-chatbot" class="pillar-card group flex flex-col h-full">
                <div class="w-14 h-14 rounded-2xl bg-[#ECFDF5] dark:bg-emerald-950/80 text-[#059669] dark:text-emerald-400 flex items-center justify-center mb-5 group-hover:scale-110 group-hover:bg-[#059669] group-hover:text-white transition-all duration-300">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                </div>
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-[#059669] dark:text-emerald-300 bg-[#ECFDF5] dark:bg-emerald-950/80 dark:border dark:border-emerald-800/50 px-2.5 py-1 rounded-full mb-4 inline-block">AI Powered</span>
                    <h3 class="font-sora font-bold text-lg mb-3 group-hover:text-[#059669] dark:group-hover:text-emerald-400 transition-colors text-slate-900 dark:text-white">
                        Asisten Chatbot AI BK
                    </h3>
                    <p class="text-sm leading-relaxed mb-5 text-slate-600 dark:text-slate-300">
                        Konsultasikan keluh kesah, tips belajar, atau info jurusan 24/7 dan dapatkan jawaban instan dari AI yang terlatih khusus pedoman BK.
                    </p>
                </div>
                <a href="{{ auth()->check() ? route('student.chat') : route('login') }}" class="inline-flex items-center text-sm font-bold text-[#059669] dark:text-emerald-400 gap-1 group-hover:gap-2 transition-all mt-auto pt-2">
                    Mulai Chat <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            <!-- Card 2: E-Book -->
            <div id="layanan-ebook" class="pillar-card group flex flex-col h-full">
                <div class="w-14 h-14 rounded-2xl bg-teal-50 dark:bg-teal-950/80 text-teal-600 dark:text-teal-400 flex items-center justify-center mb-5 group-hover:scale-110 group-hover:bg-teal-600 group-hover:text-white transition-all duration-300">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-teal-600 dark:text-teal-300 bg-teal-50 dark:bg-teal-950/80 dark:border dark:border-teal-800/50 px-2.5 py-1 rounded-full mb-4 inline-block">Pustaka Digital</span>
                    <h3 class="font-sora font-bold text-lg mb-3 group-hover:text-[#059669] dark:group-hover:text-emerald-400 transition-colors text-slate-900 dark:text-white">
                        Perpustakaan E-Book
                    </h3>
                    <p class="text-sm leading-relaxed mb-5 text-slate-600 dark:text-slate-300">
                        Akses gratis modul bimbingan karir, buku kesehatan mental remaja, serta strategi sukses menembus PTN impian kapan saja.
                    </p>
                </div>
                <a href="{{ route('ebook.public') }}" class="inline-flex items-center text-sm font-bold text-teal-600 dark:text-teal-400 gap-1 group-hover:gap-2 transition-all mt-auto pt-2">
                    Buka Perpustakaan <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            <!-- Card 3: Artikel -->
            <div id="layanan-artikel" class="pillar-card group flex flex-col h-full">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/80 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mb-5 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-600 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/80 dark:border dark:border-emerald-800/50 px-2.5 py-1 rounded-full mb-4 inline-block">Edukasi</span>
                    <h3 class="font-sora font-bold text-lg mb-3 group-hover:text-[#059669] dark:group-hover:text-emerald-400 transition-colors text-slate-900 dark:text-white">
                        Artikel & Edukasi BK
                    </h3>
                    <p class="text-sm leading-relaxed mb-5 text-slate-600 dark:text-slate-300">
                        Kumpulan artikel inspiratif dari Guru BK profesional mengenai manajemen stres, efektivitas belajar, dan pengembangan karir.
                    </p>
                </div>
                <a href="{{ route('artikel.list') }}" class="inline-flex items-center text-sm font-bold text-emerald-600 dark:text-emerald-400 gap-1 group-hover:gap-2 transition-all mt-auto pt-2">
                    Baca Artikel <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            <!-- Card 4: Tes Minat Bakat -->
            <div id="layanan-tes" class="pillar-card group flex flex-col h-full">
                <div class="w-14 h-14 rounded-2xl bg-[#ECFDF5] dark:bg-emerald-950/80 text-[#059669] dark:text-emerald-400 flex items-center justify-center mb-5 group-hover:scale-110 group-hover:bg-[#059669] group-hover:text-white transition-all duration-300">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-[#059669] dark:text-emerald-300 bg-[#ECFDF5] dark:bg-emerald-950/80 dark:border dark:border-emerald-800/50 px-2.5 py-1 rounded-full mb-4 inline-block">Self-Assessment</span>
                    <h3 class="font-sora font-bold text-lg mb-3 group-hover:text-[#059669] dark:group-hover:text-emerald-400 transition-colors text-slate-900 dark:text-white">
                        Tes Minat & Bakat
                    </h3>
                    <p class="text-sm leading-relaxed mb-5 text-slate-600 dark:text-slate-300">
                        Evaluasi kepribadian dan rekomendasi jurusan yang disesuaikan dengan profil bakat & potensi unik setiap siswa SMAN 4 Jember.
                    </p>
                </div>
                <a href="{{ auth()->check() ? route('student.tes') : route('login') }}" class="inline-flex items-center text-sm font-bold text-[#059669] dark:text-emerald-400 gap-1 group-hover:gap-2 transition-all mt-auto pt-2">
                    Ikuti Tes <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

        </div>
    </div>
</section>


{{-- ===== 5. E-BOOK UNGGULAN ===== --}}
@if($ebooks->isNotEmpty())
<section class="py-20 bg-white dark:bg-slate-900" id="ebook-pilihan">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
            <div>
                <span class="section-label">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Pustaka Digital
                </span>
                <h2 class="font-sora text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    E-Book BK Pilihan
                </h2>
                <div class="section-accent-bar"></div>
            </div>
            <a href="{{ route('ebook.public') }}" id="ebook-semua-link" class="btn-secondary text-sm hidden sm:inline-flex shrink-0">
                Lihat Semua E-Book
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($ebooks as $i => $ebook)
            <div id="ebook-card-{{ $i+1 }}" class="news-card group flex flex-col">
                <!-- Cover -->
                @php
                    $gradients = ['from-[#042F2E] via-[#059669] to-[#10B981]','from-teal-800 to-teal-500','from-emerald-800 to-emerald-500','from-[#047857] to-[#34d399]'];
                    $gradient = $gradients[$i % count($gradients)];
                @endphp
                <div class="h-44 bg-gradient-to-br {{ $gradient }} relative overflow-hidden flex items-center justify-center">
                    <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/10 rounded-full blur-md"></div>
                    <svg class="w-16 h-16 text-white/40 relative z-10" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span class="absolute top-3 left-3 text-[9px] font-bold uppercase bg-black/30 text-white rounded-full px-2.5 py-1 backdrop-blur-sm">E-Book BK</span>
                    <span class="absolute bottom-3 right-3 text-[9px] font-bold text-white bg-[#059669]/80 rounded-full px-2.5 py-1">Gratis</span>
                </div>
                <!-- Content -->
                <div class="p-5 flex flex-col flex-1 justify-between">
                    <div>
                        <h3 class="font-sora font-bold text-sm mb-2 group-hover:text-[#059669] dark:group-hover:text-emerald-400 transition-colors line-clamp-2 text-slate-900 dark:text-white">
                            {{ $ebook->title }}
                        </h3>
                        <p class="text-xs leading-relaxed line-clamp-2 mb-4 text-slate-600 dark:text-slate-300">
                            {{ $ebook->description }}
                        </p>
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t border-slate-100 dark:border-slate-700">
                        <span class="text-[10px] font-bold text-[#059669] dark:text-emerald-300 bg-[#ECFDF5] dark:bg-emerald-950/80 dark:border dark:border-emerald-800/40 px-2.5 py-1 rounded-full">Akses Gratis</span>
                        @auth
                            <a href="{{ route('student.ebook') }}" class="btn-primary text-[10px] px-3.5 py-1.5">Baca</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-primary text-[10px] px-3.5 py-1.5">Login</a>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-8 sm:hidden">
            <a href="{{ route('ebook.public') }}" class="btn-secondary text-sm w-full justify-center">Lihat Semua E-Book →</a>
        </div>
    </div>
</section>

        <div class="text-center mt-8 sm:hidden">
            <a href="{{ route('ebook.public') }}" class="btn-secondary text-sm w-full justify-center">Lihat Semua E-Book →</a>
        </div>
    </div>
</section>
@endif


{{-- ===== 6. PENGUMUMAN & FAQ (mirip "PENGUMUMAN" UAD) ===== --}}
@if($faqs->isNotEmpty())
<section class="py-20 bg-[#F8FAFC] dark:bg-slate-950/80 border-t border-slate-200/70 dark:border-slate-800" id="pengumuman">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

            <!-- Left: FAQ -->
            <div class="lg:col-span-7">
                <span class="section-label">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Pertanyaan Umum
                </span>
                <h2 class="font-sora text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    Pengumuman & FAQ
                </h2>
                <div class="section-accent-bar"></div>
                <p class="text-sm leading-relaxed mb-8 text-slate-600 dark:text-slate-300">
                    Temukan jawaban atas pertanyaan umum seputar layanan SAPA BK SMAN 4 Jember.
                </p>

                <!-- FAQ Accordion -->
                <div class="space-y-3" id="faq-list">
                    @foreach($faqs as $i => $faq)
                    <div class="bg-white dark:bg-slate-800/90 rounded-2xl overflow-hidden border border-slate-200/80 dark:border-slate-700/60 transition-all"
                         x-data="{ open: {{ $i === 0 ? 'true' : 'false' }} }">
                        <button @click="open = !open" id="faq-btn-{{ $i+1 }}"
                                class="w-full flex items-center justify-between p-5 text-left hover:bg-slate-50 dark:hover:bg-slate-700/60 transition-colors gap-4">
                            <span class="font-sora font-bold text-sm text-slate-900 dark:text-white">{{ $faq->question }}</span>
                            <div class="w-8 h-8 rounded-full bg-[#ECFDF5] text-[#059669] flex items-center justify-center shrink-0 transition-transform duration-300 dark:bg-emerald-950/80 dark:text-emerald-400"
                                 :class="{ 'rotate-180 bg-[#059669] text-white dark:bg-[#059669]': open }">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="open" x-collapse
                             class="px-5 pb-5 text-sm leading-relaxed border-t border-slate-100 dark:border-slate-700/60 pt-4 text-slate-600 dark:text-slate-300">
                            {{ $faq->answer }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    <a href="{{ route('faq') }}" id="faq-semua-link" class="btn-secondary text-sm">
                        Lihat Semua FAQ →
                    </a>
                </div>
            </div>

            <!-- Right: How It Works (3 Steps) -->
            <div class="lg:col-span-5">
                <span class="section-label">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    Alur Konsultasi
                </span>
                <h2 class="font-sora text-2xl sm:text-3xl font-extrabold tracking-tight mb-2 text-slate-900 dark:text-white">
                    3 Langkah Mudah
                </h2>
                <div class="section-accent-bar"></div>

                <div class="space-y-4">
                    @foreach([
                        ['step' => '01', 'title' => 'Registrasi Akun Siswa', 'desc' => 'Daftar menggunakan email siswa SMAN 4 Jember untuk membuka akses konsultasi privat yang aman.', 'color' => '#059669'],
                        ['step' => '02', 'title' => 'Pilih Layanan BK', 'desc' => 'Chat dengan Asisten AI, baca e-book, ikuti tes minat bakat, atau ajukan pertanyaan langsung ke Guru BK.', 'color' => '#0891b2'],
                        ['step' => '03', 'title' => 'Dapatkan Solusi & Panduan', 'desc' => 'Terima rekomendasi solusi, akses materi relevan, dan pendampingan berkelanjutan dari Guru BK profesional.', 'color' => '#047857'],
                    ] as $step)
                    <div class="bg-white dark:bg-slate-800/90 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-700/60 flex gap-4 items-start">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 font-sora font-extrabold text-white text-lg shadow-md"
                             style="background: {{ $step['color'] }}; box-shadow: 0 6px 20px {{ $step['color'] }}30;">
                            {{ $step['step'] }}
                        </div>
                        <div>
                            <h4 class="font-sora font-bold text-base mb-1 text-slate-900 dark:text-white">{{ $step['title'] }}</h4>
                            <p class="text-xs leading-relaxed text-slate-600 dark:text-slate-300">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>


            </div>

        </div>
    </div>
</section>
@endif


{{-- ===== 7. KEPERCAYAAN / AKREDITASI (mirip "Sertifikat Akreditasi" UAD) ===== --}}
<section class="py-20 bg-white dark:bg-slate-900 border-t border-slate-200/70 dark:border-slate-800" id="kepercayaan">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="text-center max-w-xl mx-auto mb-12">
            <span class="section-label mx-auto">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                Kepercayaan
            </span>
            <h2 class="font-sora text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                Mengapa Percaya SAPA BK?
            </h2>
            <div class="section-accent-bar mx-auto"></div>
        </div>

        <!-- Trust Badges (like accreditation cards UAD) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-14">
            @foreach([
                ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'color' => '#059669', 'bg' => '#ECFDF5', 'title' => 'Platform Resmi BK SMAN 4 Jember', 'desc' => 'SAPA BK adalah sistem resmi yang dikembangkan dan dikelola langsung oleh tim Guru BK SMA Negeri 4 Jember yang berpengalaman.'],
                ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'color' => '#0891b2', 'bg' => '#e0f2fe', 'title' => 'Kerahasiaan Data Siswa Terjamin', 'desc' => 'Semua data konsultasi dan percakapan bersifat rahasia penuh. Sistem dilindungi enkripsi dan hanya dapat diakses oleh pihak yang berwenang.'],
                ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'color' => '#7c3aed', 'bg' => '#f3e8ff', 'title' => 'Teknologi AI Terkini', 'desc' => 'Didukung oleh AI besar yang telah dikustomisasi khusus dengan pengetahuan pedoman BK, kurikulum, dan kebutuhan siswa SMA.'],
                ['icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'color' => '#db2777', 'bg' => '#fce7f3', 'title' => 'Guru BK Profesional Responsif', 'desc' => 'Didukung oleh 4 Guru BK profesional bersertifikat yang siap menindaklanjuti konsultasi yang memerlukan perhatian khusus.'],
                ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => '#d97706', 'bg' => '#fffbeb', 'title' => 'Tersedia 24 Jam Sehari', 'desc' => 'Asisten AI siap menjawab pertanyaan kapan saja, termasuk di luar jam sekolah, malam hari, atau hari libur.'],
                ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'color' => '#059669', 'bg' => '#ECFDF5', 'title' => 'Konten Berdasarkan Kurikulum Resmi', 'desc' => 'Seluruh konten, artikel, e-book, dan panduan AI mengacu pada kurikulum BK resmi Kemdikbud dan kebutuhan nyata siswa SMAN 4 Jember.'],
            ] as $trust)
            <div class="accreditation-badge text-left gap-0">
                <div class="flex items-start gap-4 w-full">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 dark:bg-slate-700/80"
                         style="background: {{ $trust['bg'] }};">
                        <svg class="w-6 h-6" style="color: {{ $trust['color'] }};" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $trust['icon'] }}"/></svg>
                    </div>
                    <div>
                        <h4 class="font-sora font-bold text-sm mb-1 text-slate-900 dark:text-white">{{ $trust['title'] }}</h4>
                        <p class="text-xs leading-relaxed text-slate-600 dark:text-slate-300">{{ $trust['desc'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Full-width testimonial strip -->
        <div class="bg-gradient-to-r from-[#ECFDF5] to-[#d1fae5] dark:from-emerald-950/90 dark:to-teal-950/90 rounded-3xl p-8 sm:p-10 border border-emerald-200/60 dark:border-emerald-800/40">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
                <div>
                    <p class="font-sora text-4xl font-extrabold text-[#059669] dark:text-emerald-400 mb-1">100%</p>
                    <p class="font-bold text-sm text-slate-900 dark:text-white">Gratis untuk Seluruh Siswa</p>
                    <p class="text-xs mt-1 text-slate-600 dark:text-slate-300">Tidak ada biaya, tidak ada iklan</p>
                </div>
                <div class="border-x-0 sm:border-x border-emerald-300/50 dark:border-emerald-800/60 px-4">
                    <p class="font-sora text-4xl font-extrabold text-[#059669] dark:text-emerald-400 mb-1">4 BK</p>
                    <p class="font-bold text-sm text-slate-900 dark:text-white">Guru BK Berlisensi</p>
                    <p class="text-xs mt-1 text-slate-600 dark:text-slate-300">Pendampingan professional tersertifikasi</p>
                </div>
                <div>
                    <p class="font-sora text-4xl font-extrabold text-[#059669] dark:text-emerald-400 mb-1">AI</p>
                    <p class="font-bold text-sm text-slate-900 dark:text-white">Powered by Teknologi Terkini</p>
                    <p class="text-xs mt-1 text-slate-600 dark:text-slate-300">Asisten cerdas berbasis model bahasa besar</p>
                </div>
            </div>
        </div>

    </div>
</section>


{{-- ===== 8. TEMUKAN KAMI / KONTAK (mirip "TEMUKAN KAMI" UAD) ===== --}}
<section class="py-20 bg-[#F8FAFC] dark:bg-slate-950/80 border-t border-slate-200/70 dark:border-slate-800" id="temukan-kami">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="text-center max-w-xl mx-auto mb-12">
            <span class="section-label mx-auto">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Temukan Kami
            </span>
            <h2 class="font-sora text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                Lokasi & Informasi Kontak
            </h2>
            <div class="section-accent-bar mx-auto"></div>
            <p class="text-sm text-slate-600 dark:text-slate-300">Temukan kami di SMAN 4 Jember atau hubungi melalui platform digital berikut.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Left: Map embed placeholder -->
            <div class="lg:col-span-7 contact-card overflow-hidden shadow-lg">
                <div class="h-72 sm:h-96 bg-gradient-to-br from-slate-200 to-slate-300 dark:from-slate-700 dark:to-slate-600 relative flex items-center justify-center">
                    <!-- Embedded Google Maps for SMAN 4 Jember -->
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3948.427388065882!2d113.70253781477382!3d-8.169748994129316!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd695b48cba7885%3A0x2ba5c0d50dad5e24!2sSMA%20Negeri%204%20Jember!5e0!3m2!1sen!2sid!4v1627000000000!5m2!1sen!2sid"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="w-full h-full"
                        title="Lokasi SMAN 4 Jember">
                    </iframe>
                </div>
                <!-- Address Below Map -->
                <div class="p-5 sm:p-6 flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-[#ECFDF5] dark:bg-emerald-950/80 text-[#059669] dark:text-emerald-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="font-sora font-bold text-sm text-slate-900 dark:text-white">SMA Negeri 4 Jember</p>
                        <p class="text-xs leading-relaxed mt-1 text-slate-600 dark:text-slate-300">Jl. Hayam Wuruk No.9, Kepatihan, Kec. Kaliwates, Kabupaten Jember, Jawa Timur 68131</p>
                        <a href="https://maps.google.com/?q=SMAN+4+Jember" target="_blank" rel="noopener" class="text-xs font-bold text-[#059669] dark:text-emerald-400 mt-2 inline-flex items-center gap-1 hover:gap-2 transition-all">
                            Buka di Google Maps →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right: Contact Info Columns (OUR CHANNEL) -->
            <div class="lg:col-span-5 space-y-4">

                <!-- Hubungi Kami -->
                <div class="contact-card p-5 sm:p-6">
                    <h3 class="font-sora font-bold text-base mb-4 flex items-center gap-2 text-slate-900 dark:text-white">
                        <span class="w-7 h-7 rounded-full bg-[#ECFDF5] dark:bg-emerald-950/80 text-[#059669] dark:text-emerald-400 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </span>
                        Hubungi Kami
                    </h3>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[#059669] dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <a href="mailto:bk@sman4jember.sch.id" class="text-sm text-[#059669] dark:text-emerald-400 hover:underline">bk@sman4jember.sch.id</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[#059669] dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span class="text-sm text-slate-600 dark:text-slate-300">(0331) 487019</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-[#059669] dark:text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-sm text-slate-600 dark:text-slate-300">Senin–Jumat: 07.00–14.30 WIB<br><span class="text-xs text-[#059669] dark:text-emerald-400">*AI Chatbot tersedia 24/7</span></span>
                        </li>
                    </ul>
                </div>

                <!-- Informasi Tentang (Quick Links) -->
                <div class="contact-card p-5 sm:p-6">
                    <h3 class="font-sora font-bold text-base mb-4 flex items-center gap-2 text-slate-900 dark:text-white">
                        <span class="w-7 h-7 rounded-full bg-[#ECFDF5] dark:bg-emerald-950/80 text-[#059669] dark:text-emerald-400 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        Informasi Tentang
                    </h3>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach([
                            ['label' => 'Tentang BK', 'route' => 'tentang'],
                            ['label' => 'E-Book BK', 'route' => 'ebook.public'],
                            ['label' => 'Artikel', 'route' => 'artikel.list'],
                            ['label' => 'FAQ', 'route' => 'faq'],
                        ] as $link)
                        <a href="{{ route($link['route']) }}" class="flex items-center gap-2 text-sm px-3 py-2 rounded-xl hover:bg-[#ECFDF5] dark:hover:bg-emerald-900/20 transition-colors group" style="color: var(--text-body, #475569);">
                            <svg class="w-3 h-3 text-[#059669] group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            {{ $link['label'] }}
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Bergabung / Login CTA -->
                <div class="contact-card p-5 sm:p-6 bg-[#ECFDF5] dark:bg-emerald-900/20 border-[#a7f3d0] dark:border-emerald-700/30">
                    <h3 class="font-sora font-bold text-base mb-2 text-[#047857] dark:text-emerald-300">
                        Bergabung di SAPA BK
                    </h3>
                    <p class="text-xs leading-relaxed text-emerald-800 dark:text-emerald-200 mb-4">Akses layanan BK digital SMAN 4 Jember secara gratis. Daftar sebagai siswa dan mulai konsultasi sekarang.</p>
                    @auth
                        <a href="{{ route('student.dashboard') }}" id="cta-portal" class="btn-primary w-full justify-center text-sm">
                            Buka Portal Siswa →
                        </a>
                    @else
                        <a href="{{ route('register') }}" id="cta-daftar" class="btn-primary w-full justify-center text-sm">
                            Daftar Gratis Sekarang →
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </div>
</section>


{{-- ===== 9. BOTTOM CTA BANNER ===== --}}
<section class="py-16 sm:py-20 bg-gradient-to-b from-[#059669] via-[#047857] to-[#042F2E] relative overflow-hidden">
    <div class="absolute top-0 right-0 w-80 h-80 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/4 left-0 w-64 h-64 bg-emerald-400/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <span class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 text-xs font-bold text-emerald-200 uppercase tracking-widest mb-6">
            <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
            Platform Aktif & Siap Melayani
        </span>
        <h2 class="font-sora text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white mb-4 leading-tight">
            Siap Memulai Konsultasi<br class="hidden sm:block"> & Eksplorasi Potensi Diri?
        </h2>
        <p class="text-emerald-100 text-base sm:text-lg mb-10 max-w-xl mx-auto leading-relaxed">
            Bergabung dengan ribuan siswa SMAN 4 Jember yang telah merasakan manfaat SAPA BK — asisten digital BK terpercaya Anda.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            @auth
                <a href="{{ route('student.chat') }}" id="bottom-cta-chat" class="inline-flex items-center justify-center gap-2 bg-white text-[#047857] hover:bg-emerald-50 px-8 py-3.5 rounded-full font-extrabold text-sm sm:text-base shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all w-full sm:w-auto">
                    Mulai Chat Sekarang
                </a>
                <a href="{{ route('ebook.public') }}" class="inline-flex items-center justify-center gap-2 bg-white text-[#047857] hover:bg-emerald-50 px-8 py-3.5 rounded-full font-extrabold text-sm sm:text-base shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all w-full sm:w-auto">
                    Jelajahi E-Book BK
                </a>
            @else
                <a href="{{ route('register') }}" id="bottom-cta-register" class="inline-flex items-center justify-center gap-2 bg-white text-[#047857] hover:bg-emerald-50 px-8 py-3.5 rounded-full font-extrabold text-sm sm:text-base shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all w-full sm:w-auto">
                    Daftar Akun Gratis
                </a>
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 bg-white text-[#047857] hover:bg-emerald-50 px-8 py-3.5 rounded-full font-extrabold text-sm sm:text-base shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all w-full sm:w-auto">
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
                   flex items-center justify-center hover:bg-[#047857] hover:scale-105 active:scale-95 transition-all duration-200 relative"
            aria-label="Buka Asisten BK">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
        <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-red-500 text-white text-[9px] font-extrabold flex items-center justify-center animate-ping"></span>
        <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-red-500 text-white text-[9px] font-extrabold flex items-center justify-center">1</span>
    </button>

    <!-- Popup -->
    <div id="chat-popup" class="hidden absolute bottom-20 right-0 w-80 bg-white dark:bg-slate-800 rounded-3xl shadow-2xl overflow-hidden border border-slate-200 dark:border-slate-700">
        <div class="bg-gradient-to-r from-[#042F2E] to-[#059669] p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            </div>
            <div>
                <p class="font-sora font-bold text-white text-sm">Asisten Digital SAPA BK</p>
                <p class="text-emerald-100 text-xs flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span> Online & Siap Membantu
                </p>
            </div>
        </div>
        <div class="p-5 bg-[#F8FAFC] dark:bg-slate-700/50">
            <div class="bg-white dark:bg-slate-600 rounded-2xl rounded-tl-none p-3.5 shadow-sm border border-slate-100 dark:border-slate-500 mb-4">
                <p class="font-semibold mb-1 text-xs" style="color: var(--text-primary, #0F172A);">Halo Siswa SMAN 4 Jember! 👋</p>
                <p class="text-xs text-slate-500 dark:text-slate-300">Saya siap membantu pertanyaan seputar akademik, karir, atau kesehatan mental. Ada yang bisa dibantu?</p>
            </div>
            @auth
                <a href="{{ route('student.chat') }}" class="btn-primary w-full justify-center text-xs py-2.5">Mulai Konsultasi AI →</a>
            @else
                <a href="{{ route('login') }}" class="btn-primary w-full justify-center text-xs py-2.5">Login untuk Chat →</a>
            @endauth
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Chat widget toggle
    document.getElementById('chat-widget-btn')?.addEventListener('click', () => {
        document.getElementById('chat-popup').classList.toggle('hidden');
    });

    // Close chat popup on outside click
    document.addEventListener('click', (e) => {
        const widget = document.getElementById('chat-widget');
        if (!widget?.contains(e.target)) {
            document.getElementById('chat-popup')?.classList.add('hidden');
        }
    });

    // Scroll-triggered animation (Intersection Observer)
    const observerConfig = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, observerConfig);

    // Apply to section-level animate-on-scroll elements
    document.querySelectorAll('.news-card, .pillar-card, .stat-card, .accreditation-badge, .contact-card, .announcement-item').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(el);
    });
</script>
@endpush
