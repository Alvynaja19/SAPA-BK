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

/* About section split bg */
.about-gradient-bg {
    background: linear-gradient(135deg, #042F2E 0%, #064E3B 50%, #047857 100%);
}

/* dark/light text helpers */
.text-primary-color { color: var(--text-primary, #0F172A); }
.text-body-color { color: var(--text-body, #475569); }
</style>
@endpush

@section('content')

{{-- ===== 1. HERO SECTION ===== --}}
<section class="relative overflow-hidden hero-animated-bg dark:bg-gradient-to-b dark:from-slate-900 dark:to-slate-800 pt-14 pb-28 lg:pt-24 lg:pb-36">
    <!-- Decorative blobs -->
    <div class="absolute top-0 left-0 w-[600px] h-[600px] bg-[#059669]/8 rounded-full blur-[100px] pointer-events-none -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-[#10B981]/8 rounded-full blur-[80px] pointer-events-none translate-x-1/3 translate-y-1/3"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-6 items-center">

            <!-- Left: Text -->
            <div class="lg:col-span-6 text-center lg:text-left" style="animation: slideInLeft 0.7s ease forwards;">
                <span class="section-label">
                    <span class="w-2 h-2 rounded-full bg-[#059669] animate-pulse inline-block"></span>
                    Platform Resmi BK Digital SMAN 4 Jember
                </span>

                <h1 class="font-sora text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-[1.12] tracking-tight mb-6"
                    style="color: var(--text-primary, #0F172A);">
                    SAPA BK — <br class="hidden lg:block">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#059669] via-[#10B981] to-[#047857]">
                        Sahabat Konseling
                    </span><br>
                    Siswa SMAN 4 Jember
                </h1>

                <p class="text-base sm:text-lg leading-relaxed mb-8 max-w-xl mx-auto lg:mx-0" style="color: var(--text-body, #475569);">
                    <strong>Sistem Asistensi Pintar Akademik</strong> — Platform digital Bimbingan & Konseling yang mendampingi perjalanan akademik, karir, dan kesehatan mental siswa secara <em>aman, privat, dan 24 jam siap sedia</em>.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 mb-10">
                    @auth
                        <a href="{{ route('student.chat') }}" id="hero-cta-main" class="btn-primary text-base w-full sm:w-auto px-8 py-3.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            Mulai Konsultasi
                        </a>
                    @else
                        <a href="{{ route('register') }}" id="hero-cta-register" class="btn-primary text-base w-full sm:w-auto px-8 py-3.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            Daftar Akun Gratis
                        </a>
                    @endauth

                    <a href="{{ route('tentang') }}" id="hero-cta-tentang" class="btn-secondary text-base w-full sm:w-auto px-8 py-3.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Tentang SAPA BK
                    </a>
                </div>

                <!-- Trust Stats -->
                <div class="grid grid-cols-3 gap-4 pt-8 border-t border-slate-200/80 dark:border-slate-700/60 max-w-md mx-auto lg:mx-0">
                    <div>
                        <p class="font-sora text-2xl sm:text-3xl font-extrabold text-[#059669]">24/7</p>
                        <p class="text-xs font-medium mt-0.5" style="color: var(--text-body, #475569);">Asisten AI Siap</p>
                    </div>
                    <div>
                        <p class="font-sora text-2xl sm:text-3xl font-extrabold text-[#059669]">100%</p>
                        <p class="text-xs font-medium mt-0.5" style="color: var(--text-body, #475569);">Rahasia & Privat</p>
                    </div>
                    <div>
                        <p class="font-sora text-2xl sm:text-3xl font-extrabold text-[#059669]">4 BK</p>
                        <p class="text-xs font-medium mt-0.5" style="color: var(--text-body, #475569);">Guru BK Profesional</p>
                    </div>
                </div>
            </div>

            <!-- Right: Visual Card -->
            <div class="lg:col-span-6 flex justify-center lg:justify-end items-center relative mt-8 lg:mt-0">
                <div class="relative w-full max-w-lg">

                    <!-- Main Card -->
                    <div class="w-full bg-gradient-to-br from-[#042F2E] via-[#059669] to-[#10B981] p-7 rounded-3xl shadow-2xl shadow-[#059669]/30 text-white relative overflow-hidden border border-emerald-400/30">
                        <div class="absolute -right-12 -bottom-12 w-56 h-56 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                        <div class="absolute -left-8 -top-8 w-40 h-40 bg-emerald-300/10 rounded-full blur-xl pointer-events-none"></div>

                        <!-- Card Header -->
                        <div class="flex items-center justify-between mb-6 relative z-10">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30 shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-sora font-bold text-base">Asisten Digital SAPA BK</h3>
                                    <span class="text-xs text-emerald-100/90 flex items-center gap-1.5 mt-0.5">
                                        <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span> Online & Siap
                                    </span>
                                </div>
                            </div>
                            <span class="text-xs text-emerald-200 bg-white/10 rounded-full px-3 py-1 font-medium">AI Powered</span>
                        </div>

                        <!-- Chat Bubbles -->
                        <div class="space-y-3 mb-6 text-xs relative z-10">
                            <div class="bg-white/15 backdrop-blur-md rounded-2xl rounded-tl-sm p-3.5 border border-white/20 max-w-[85%]">
                                <p class="leading-relaxed font-medium">🤔 "Kak, saya bingung pilih jurusan IPA atau IPS. Gimana ya?"</p>
                            </div>
                            <div class="bg-white text-[#0F172A] rounded-2xl rounded-tr-sm p-3.5 shadow-md ml-auto max-w-[85%] font-medium">
                                <p class="leading-relaxed text-[#047857]">✨ Hei! Aku bisa bantu analisis minat & bakatmu. Yuk mulai tes minat bakat dulu!</p>
                            </div>
                            <div class="bg-white/15 backdrop-blur-md rounded-2xl rounded-tl-sm p-3.5 border border-white/20 max-w-[85%]">
                                <p class="leading-relaxed font-medium">💡 "Wah oke! Gimana cara mulainya?"</p>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-white/20 flex items-center justify-between text-xs text-emerald-100 relative z-10">
                            <span>Konsultasi Aman & Privat</span>
                            <span class="font-semibold bg-white/10 px-3 py-1 rounded-full">SMAN 4 JEMBER</span>
                        </div>
                    </div>

                    <!-- Floating Badge 1 -->
                    <div class="absolute -top-5 -right-4 bg-white/95 dark:bg-slate-800 backdrop-blur-md rounded-2xl shadow-xl border border-slate-200/80 dark:border-slate-700 px-4 py-3 flex items-center gap-3 float-badge">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 text-[#059669] flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold" style="color: var(--text-primary, #0F172A);">Privasi 100% Terjamin</p>
                            <p class="text-[10px]" style="color: var(--text-body, #475569);">Kerahasiaan Siswa Dijaga</p>
                        </div>
                    </div>

                    <!-- Floating Badge 2 -->
                    <div class="absolute -bottom-5 -left-4 bg-white/95 dark:bg-slate-800 backdrop-blur-md rounded-2xl shadow-xl border border-slate-200/80 dark:border-slate-700 px-4 py-3 flex items-center gap-3 float-badge-2">
                        <div class="w-9 h-9 rounded-xl bg-teal-50 dark:bg-teal-900/30 text-teal-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold" style="color: var(--text-primary, #0F172A);">Perpustakaan E-Book</p>
                            <p class="text-[10px]" style="color: var(--text-body, #475569);">Gratis Dibaca Kapan Saja</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>


{{-- ===== 2. TENTANG SAPA BK (mirip "Program Studi BK" UAD) ===== --}}
<section class="py-20 about-gradient-bg relative overflow-hidden" id="tentang-sapa">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4wMyI+PHBhdGggZD0iTTM2IDM0djZoNnYtNmgtNnptMCAwdi02aC02djZoNnptNiAwaDZ2LTZoLTZ2NnoiLz48L2c+PC9nPjwvc3ZnPg==')] opacity-40"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-300/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">

            <!-- Left: Text -->
            <div>
                <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-emerald-300 mb-5">
                    <span class="w-8 h-px bg-emerald-400 inline-block"></span>
                    Tentang Kami
                </span>
                <h2 class="font-sora text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight mb-6">
                    Sistem Asistensi Pintar Akademik Bimbingan & Konseling
                </h2>
                <div class="w-14 h-1 bg-gradient-to-r from-emerald-400 to-teal-300 rounded-full mb-6"></div>
                <p class="text-emerald-100 text-base leading-relaxed mb-5">
                    SAPA BK adalah platform digital resmi layanan Bimbingan dan Konseling SMA Negeri 4 Jember yang hadir untuk menjawab kebutuhan siswa di era modern. Dikembangkan sebagai jembatan komunikasi antara siswa dengan Guru BK profesional, SAPA BK mengintegrasikan kecerdasan buatan (AI) dengan pendekatan konseling yang humanis.
                </p>
                <p class="text-emerald-100/80 text-base leading-relaxed mb-8">
                    Sejak diluncurkan, SAPA BK telah melayani konsultasi akademik, pengembangan karir, dan pendampingan kesehatan mental siswa melalui platform yang aman, rahasia, dan mudah diakses kapan saja dan di mana saja.
                </p>

                <!-- Key features list -->
                <ul class="space-y-3 mb-8">
                    @foreach([
                        ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'text' => 'Tersertifikasi & Dikelola Guru BK Profesional SMAN 4 Jember'],
                        ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'text' => 'Sistem Kerahasiaan Data Siswa yang Ketat & Terpercaya'],
                        ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'text' => 'AI Chatbot BK Responsif & Berbasis Pedoman BK Resmi'],
                        ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'text' => 'Akses Gratis ke Perpustakaan E-Book & Modul BK Lengkap'],
                    ] as $feature)
                    <li class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-400/20 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5 text-emerald-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $feature['icon'] }}"/></svg>
                        </div>
                        <p class="text-emerald-100 text-sm leading-relaxed">{{ $feature['text'] }}</p>
                    </li>
                    @endforeach
                </ul>

                <a href="{{ route('tentang') }}" id="about-cta" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full bg-white text-[#047857] font-bold text-sm hover:bg-emerald-50 transition-all duration-200 shadow-lg shadow-black/20">
                    Selengkapnya Tentang SAPA BK
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            <!-- Right: Stats grid -->
            <div class="grid grid-cols-2 gap-4">
                @foreach([
                    ['value' => '24/7', 'label' => 'Asisten AI Online', 'sub' => 'Siap menjawab pertanyaan kapan saja', 'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
                    ['value' => '4+', 'label' => 'Guru BK Profesional', 'sub' => 'Siap mendampingi siswa', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                    ['value' => '100+', 'label' => 'E-Book & Modul BK', 'sub' => 'Koleksi lengkap untuk siswa', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                    ['value' => '100%', 'label' => 'Kerahasiaan Data', 'sub' => 'Konsultasi aman & terpercaya', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                ] as $stat)
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 text-center hover:bg-white/15 transition-all duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-white/15 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-emerald-300" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}"/></svg>
                    </div>
                    <p class="font-sora text-3xl font-extrabold text-white mb-1">{{ $stat['value'] }}</p>
                    <p class="font-bold text-emerald-200 text-sm mb-1">{{ $stat['label'] }}</p>
                    <p class="text-emerald-100/70 text-xs leading-tight">{{ $stat['sub'] }}</p>
                </div>
                @endforeach
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
                <h2 class="font-sora text-3xl sm:text-4xl font-extrabold tracking-tight" style="color: var(--text-primary, #0F172A);">
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
                    <h3 class="font-sora font-bold text-xl sm:text-2xl mb-3 group-hover:text-[#059669] transition-colors line-clamp-2 leading-tight" style="color: var(--text-primary, #0F172A);">
                        {{ $articles->first()->title }}
                    </h3>
                    <p class="text-sm leading-relaxed line-clamp-3 mb-5" style="color: var(--text-body, #475569);">
                        {{ Str::limit(strip_tags($articles->first()->content), 160) }}
                    </p>
                    <span class="inline-flex items-center gap-2 text-sm font-bold text-[#059669] group-hover:gap-3 transition-all">
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
                                <p class="text-xs mb-2" style="color: var(--text-body, #475569);">
                                    <svg class="w-3 h-3 inline mr-1 mb-0.5 text-[#059669]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $article->created_at->translatedFormat('d M Y') }}
                                </p>
                                <h3 class="font-sora font-bold text-base mb-2 group-hover:text-[#059669] transition-colors line-clamp-2" style="color: var(--text-primary, #0F172A);">
                                    {{ $article->title }}
                                </h3>
                                <p class="text-xs leading-relaxed line-clamp-2" style="color: var(--text-body, #475569);">
                                    {{ Str::limit(strip_tags($article->content), 90) }}
                                </p>
                            </div>
                            <span class="text-xs font-bold text-[#059669] inline-flex items-center gap-1 mt-3 group-hover:translate-x-1 transition-transform">
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
                    <h3 class="font-sora font-bold text-lg mb-2 group-hover:text-[#059669] transition-colors line-clamp-2" style="color: var(--text-primary, #0F172A);">{{ $article->title }}</h3>
                    <p class="text-sm line-clamp-2" style="color: var(--text-body, #475569);">{{ Str::limit(strip_tags($article->content), 100) }}</p>
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
<section class="py-20 bg-[#F8FAFC] dark:bg-slate-800 border-y border-slate-200/70 dark:border-slate-700/50" id="layanan-unggulan">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="section-label">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                Keunggulan Platform
            </span>
            <h2 class="font-sora text-3xl sm:text-4xl font-extrabold tracking-tight mt-1" style="color: var(--text-primary, #0F172A);">
                Layanan Digital BK Lengkap
            </h2>
            <div class="section-accent-bar mx-auto"></div>
            <p class="text-base leading-relaxed" style="color: var(--text-body, #475569);">
                Dirancang khusus untuk mendampingi siswa SMAN 4 Jember dalam setiap tahap perkembangan akademik dan personal.
            </p>
        </div>

        <!-- Service Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Card 1: AI Chatbot -->
            <div id="layanan-chatbot" class="pillar-card group">
                <div class="w-14 h-14 rounded-2xl bg-[#ECFDF5] text-[#059669] flex items-center justify-center mb-5 group-hover:scale-110 group-hover:bg-[#059669] group-hover:text-white transition-all duration-300">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                </div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-[#059669] bg-[#ECFDF5] px-2.5 py-1 rounded-full mb-4 inline-block">AI Powered</span>
                <h3 class="font-sora font-bold text-lg mb-3 group-hover:text-[#059669] transition-colors" style="color: var(--text-primary, #0F172A);">
                    Asisten Chatbot AI BK
                </h3>
                <p class="text-sm leading-relaxed mb-5" style="color: var(--text-body, #475569);">
                    Konsultasikan keluh kesah, tips belajar, atau info jurusan 24/7 dan dapatkan jawaban instan dari AI yang terlatih khusus pedoman BK.
                </p>
                <a href="{{ auth()->check() ? route('student.chat') : route('login') }}" class="inline-flex items-center text-sm font-bold text-[#059669] gap-1 group-hover:gap-2 transition-all">
                    Mulai Chat <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            <!-- Card 2: E-Book -->
            <div id="layanan-ebook" class="pillar-card group">
                <div class="w-14 h-14 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center mb-5 group-hover:scale-110 group-hover:bg-teal-600 group-hover:text-white transition-all duration-300">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-teal-600 bg-teal-50 px-2.5 py-1 rounded-full mb-4 inline-block">Pustaka Digital</span>
                <h3 class="font-sora font-bold text-lg mb-3 group-hover:text-[#059669] transition-colors" style="color: var(--text-primary, #0F172A);">
                    Perpustakaan E-Book
                </h3>
                <p class="text-sm leading-relaxed mb-5" style="color: var(--text-body, #475569);">
                    Akses gratis modul bimbingan karir, buku kesehatan mental remaja, serta strategi sukses menembus PTN impian kapan saja.
                </p>
                <a href="{{ route('ebook.public') }}" class="inline-flex items-center text-sm font-bold text-teal-600 gap-1 group-hover:gap-2 transition-all">
                    Buka Perpustakaan <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            <!-- Card 3: Artikel -->
            <div id="layanan-artikel" class="pillar-card group">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-5 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full mb-4 inline-block">Edukasi</span>
                <h3 class="font-sora font-bold text-lg mb-3 group-hover:text-[#059669] transition-colors" style="color: var(--text-primary, #0F172A);">
                    Artikel & Edukasi BK
                </h3>
                <p class="text-sm leading-relaxed mb-5" style="color: var(--text-body, #475569);">
                    Kumpulan artikel inspiratif dari Guru BK profesional mengenai manajemen stres, efektivitas belajar, dan pengembangan karir.
                </p>
                <a href="{{ route('artikel.list') }}" class="inline-flex items-center text-sm font-bold text-emerald-600 gap-1 group-hover:gap-2 transition-all">
                    Baca Artikel <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            <!-- Card 4: Tes Minat Bakat -->
            <div id="layanan-tes" class="pillar-card group">
                <div class="w-14 h-14 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center mb-5 group-hover:scale-110 group-hover:bg-sky-600 group-hover:text-white transition-all duration-300">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-sky-600 bg-sky-50 px-2.5 py-1 rounded-full mb-4 inline-block">Self-Assessment</span>
                <h3 class="font-sora font-bold text-lg mb-3 group-hover:text-[#059669] transition-colors" style="color: var(--text-primary, #0F172A);">
                    Tes Minat & Bakat
                </h3>
                <p class="text-sm leading-relaxed mb-5" style="color: var(--text-body, #475569);">
                    Evaluasi kepribadian dan rekomendasi jurusan yang disesuaikan dengan profil bakat & potensi unik setiap siswa SMAN 4 Jember.
                </p>
                <a href="{{ auth()->check() ? route('student.tes') : route('login') }}" class="inline-flex items-center text-sm font-bold text-sky-600 gap-1 group-hover:gap-2 transition-all">
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
                <h2 class="font-sora text-3xl sm:text-4xl font-extrabold tracking-tight" style="color: var(--text-primary, #0F172A);">
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
                        <h3 class="font-sora font-bold text-sm mb-2 group-hover:text-[#059669] transition-colors line-clamp-2" style="color: var(--text-primary, #0F172A);">
                            {{ $ebook->title }}
                        </h3>
                        <p class="text-xs leading-relaxed line-clamp-2 mb-4" style="color: var(--text-body, #475569);">
                            {{ $ebook->description }}
                        </p>
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t border-slate-100 dark:border-slate-700">
                        <span class="text-[10px] font-bold text-[#059669] bg-[#ECFDF5] dark:bg-emerald-900/30 px-2.5 py-1 rounded-full">Akses Gratis</span>
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
@endif


{{-- ===== 6. PENGUMUMAN & FAQ (mirip "PENGUMUMAN" UAD) ===== --}}
@if($faqs->isNotEmpty())
<section class="py-20 bg-[#F8FAFC] dark:bg-slate-800 border-t border-slate-200/70 dark:border-slate-700/50" id="pengumuman">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

            <!-- Left: FAQ -->
            <div class="lg:col-span-7">
                <span class="section-label">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Pertanyaan Umum
                </span>
                <h2 class="font-sora text-3xl sm:text-4xl font-extrabold tracking-tight" style="color: var(--text-primary, #0F172A);">
                    Pengumuman & FAQ
                </h2>
                <div class="section-accent-bar"></div>
                <p class="text-sm leading-relaxed mb-8" style="color: var(--text-body, #475569);">
                    Temukan jawaban atas pertanyaan umum seputar layanan SAPA BK SMAN 4 Jember.
                </p>

                <!-- FAQ Accordion -->
                <div class="space-y-3" id="faq-list">
                    @foreach($faqs as $i => $faq)
                    <div class="bg-white dark:bg-slate-700/50 rounded-2xl overflow-hidden border border-slate-200/80 dark:border-slate-600/50 transition-all"
                         x-data="{ open: {{ $i === 0 ? 'true' : 'false' }} }">
                        <button @click="open = !open" id="faq-btn-{{ $i+1 }}"
                                class="w-full flex items-center justify-between p-5 text-left hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors gap-4">
                            <span class="font-sora font-bold text-sm" style="color: var(--text-primary, #0F172A);">{{ $faq->question }}</span>
                            <div class="w-8 h-8 rounded-full bg-[#ECFDF5] text-[#059669] flex items-center justify-center shrink-0 transition-transform duration-300 dark:bg-emerald-900/30"
                                 :class="{ 'rotate-180 bg-[#059669] text-white dark:bg-[#059669]': open }">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="open" x-collapse
                             class="px-5 pb-5 text-sm leading-relaxed border-t border-slate-100 dark:border-slate-600/40 pt-4" style="color: var(--text-body, #475569);">
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
                <h2 class="font-sora text-2xl sm:text-3xl font-extrabold tracking-tight mb-2" style="color: var(--text-primary, #0F172A);">
                    3 Langkah Mudah
                </h2>
                <div class="section-accent-bar"></div>

                <div class="space-y-4">
                    @foreach([
                        ['step' => '01', 'title' => 'Registrasi Akun Siswa', 'desc' => 'Daftar menggunakan email siswa SMAN 4 Jember untuk membuka akses konsultasi privat yang aman.', 'color' => '#059669'],
                        ['step' => '02', 'title' => 'Pilih Layanan BK', 'desc' => 'Chat dengan Asisten AI, baca e-book, ikuti tes minat bakat, atau ajukan pertanyaan langsung ke Guru BK.', 'color' => '#0891b2'],
                        ['step' => '03', 'title' => 'Dapatkan Solusi & Panduan', 'desc' => 'Terima rekomendasi solusi, akses materi relevan, dan pendampingan berkelanjutan dari Guru BK profesional.', 'color' => '#047857'],
                    ] as $step)
                    <div class="bg-white dark:bg-slate-700/50 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-600/50 flex gap-4 items-start">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 font-sora font-extrabold text-white text-lg shadow-md"
                             style="background: {{ $step['color'] }}; box-shadow: 0 6px 20px {{ $step['color'] }}30;">
                            {{ $step['step'] }}
                        </div>
                        <div>
                            <h4 class="font-sora font-bold text-base mb-1" style="color: var(--text-primary, #0F172A);">{{ $step['title'] }}</h4>
                            <p class="text-xs leading-relaxed" style="color: var(--text-body, #475569);">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Quick CTA -->
                <div class="mt-6 bg-gradient-to-r from-[#042F2E] to-[#059669] rounded-2xl p-5 text-white">
                    <p class="font-sora font-bold text-base mb-2">Siap Memulai?</p>
                    <p class="text-emerald-100 text-xs mb-4">Daftar gratis dan mulai konsultasi bersama SAPA BK sekarang juga.</p>
                    @auth
                        <a href="{{ route('student.chat') }}" class="inline-flex items-center gap-2 bg-white text-[#047857] font-bold text-sm px-5 py-2.5 rounded-full hover:bg-emerald-50 transition-all">
                            Mulai Konsultasi →
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-white text-[#047857] font-bold text-sm px-5 py-2.5 rounded-full hover:bg-emerald-50 transition-all">
                            Daftar Sekarang →
                        </a>
                    @endauth
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
            <h2 class="font-sora text-3xl sm:text-4xl font-extrabold tracking-tight" style="color: var(--text-primary, #0F172A);">
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
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0"
                         style="background: {{ $trust['bg'] }};">
                        <svg class="w-6 h-6" style="color: {{ $trust['color'] }};" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $trust['icon'] }}"/></svg>
                    </div>
                    <div>
                        <h4 class="font-sora font-bold text-sm mb-1" style="color: var(--text-primary, #0F172A);">{{ $trust['title'] }}</h4>
                        <p class="text-xs leading-relaxed" style="color: var(--text-body, #475569);">{{ $trust['desc'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Full-width testimonial strip -->
        <div class="bg-gradient-to-r from-[#ECFDF5] to-[#d1fae5] dark:from-emerald-900/30 dark:to-teal-900/30 rounded-3xl p-8 sm:p-10 border border-emerald-200/60 dark:border-emerald-700/30">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
                <div>
                    <p class="font-sora text-4xl font-extrabold text-[#059669] mb-1">100%</p>
                    <p class="font-bold text-sm" style="color: var(--text-primary, #0F172A);">Gratis untuk Seluruh Siswa</p>
                    <p class="text-xs mt-1" style="color: var(--text-body, #475569);">Tidak ada biaya, tidak ada iklan</p>
                </div>
                <div class="border-x-0 sm:border-x border-emerald-300/50 dark:border-emerald-700/40 px-4">
                    <p class="font-sora text-4xl font-extrabold text-[#059669] mb-1">4 BK</p>
                    <p class="font-bold text-sm" style="color: var(--text-primary, #0F172A);">Guru BK Berlisensi</p>
                    <p class="text-xs mt-1" style="color: var(--text-body, #475569);">Pendampingan professional tersertifikasi</p>
                </div>
                <div>
                    <p class="font-sora text-4xl font-extrabold text-[#059669] mb-1">AI</p>
                    <p class="font-bold text-sm" style="color: var(--text-primary, #0F172A);">Powered by Teknologi Terkini</p>
                    <p class="text-xs mt-1" style="color: var(--text-body, #475569);">Asisten cerdas berbasis model bahasa besar</p>
                </div>
            </div>
        </div>

    </div>
</section>


{{-- ===== 8. TEMUKAN KAMI / KONTAK (mirip "TEMUKAN KAMI" UAD) ===== --}}
<section class="py-20 bg-[#F8FAFC] dark:bg-slate-800 border-t border-slate-200/70 dark:border-slate-700/50" id="temukan-kami">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="text-center max-w-xl mx-auto mb-12">
            <span class="section-label mx-auto">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Temukan Kami
            </span>
            <h2 class="font-sora text-3xl sm:text-4xl font-extrabold tracking-tight" style="color: var(--text-primary, #0F172A);">
                Lokasi & Informasi Kontak
            </h2>
            <div class="section-accent-bar mx-auto"></div>
            <p class="text-sm" style="color: var(--text-body, #475569);">Temukan kami di SMAN 4 Jember atau hubungi melalui platform digital berikut.</p>
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
                    <div class="w-10 h-10 rounded-xl bg-[#ECFDF5] text-[#059669] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="font-sora font-bold text-sm" style="color: var(--text-primary, #0F172A);">SMA Negeri 4 Jember</p>
                        <p class="text-xs leading-relaxed mt-1" style="color: var(--text-body, #475569);">Jl. Hayam Wuruk No.9, Kepatihan, Kec. Kaliwates, Kabupaten Jember, Jawa Timur 68131</p>
                        <a href="https://maps.google.com/?q=SMAN+4+Jember" target="_blank" rel="noopener" class="text-xs font-bold text-[#059669] mt-2 inline-flex items-center gap-1 hover:gap-2 transition-all">
                            Buka di Google Maps →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right: Contact Info Columns (OUR CHANNEL) -->
            <div class="lg:col-span-5 space-y-4">

                <!-- Hubungi Kami -->
                <div class="contact-card p-5 sm:p-6">
                    <h3 class="font-sora font-bold text-base mb-4 flex items-center gap-2" style="color: var(--text-primary, #0F172A);">
                        <span class="w-7 h-7 rounded-full bg-[#ECFDF5] text-[#059669] flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </span>
                        Hubungi Kami
                    </h3>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[#059669] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <a href="mailto:bk@sman4jember.sch.id" class="text-sm text-[#059669] hover:underline">bk@sman4jember.sch.id</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[#059669] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span class="text-sm" style="color: var(--text-body, #475569);">(0331) 487019</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-[#059669] shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-sm" style="color: var(--text-body, #475569);">Senin–Jumat: 07.00–14.30 WIB<br><span class="text-xs text-[#059669]">*AI Chatbot tersedia 24/7</span></span>
                        </li>
                    </ul>
                </div>

                <!-- Informasi Tentang (Quick Links) -->
                <div class="contact-card p-5 sm:p-6">
                    <h3 class="font-sora font-bold text-base mb-4 flex items-center gap-2" style="color: var(--text-primary, #0F172A);">
                        <span class="w-7 h-7 rounded-full bg-[#ECFDF5] text-[#059669] flex items-center justify-center">
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
<section class="py-16 bg-gradient-to-r from-[#042F2E] via-[#047857] to-[#059669] relative overflow-hidden">
    <div class="absolute top-0 right-0 w-80 h-80 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-emerald-300/10 rounded-full blur-2xl pointer-events-none"></div>

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
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @auth
                <a href="{{ route('student.chat') }}" id="bottom-cta-chat" class="btn-white text-base px-8 py-3.5">
                    💬 Mulai Chat Sekarang
                </a>
                <a href="{{ route('ebook.public') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full border-2 border-white text-white font-semibold text-sm hover:bg-white/10 transition-all">
                    📚 Jelajahi E-Book BK
                </a>
            @else
                <a href="{{ route('register') }}" id="bottom-cta-register" class="btn-white text-base px-8 py-3.5">
                    🚀 Daftar Akun Gratis
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
