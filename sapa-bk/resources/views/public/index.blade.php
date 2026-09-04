@extends('layouts.public')

@section('title', 'Beranda')

@push('head')
<style>
/* ===== FULLSCREEN INTRO SCREEN (RAGGED EDGE CINEMATIC OPENING) ===== */
/* Header visibility control when on hero stage */
body:has(#ragged-hero-stage) #main-header {
    transform: translateY(-100%);
    opacity: 0;
    pointer-events: none;
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.4s ease, background 0.3s ease;
}

body:has(#ragged-hero-stage) #main-header.header-visible {
    transform: translateY(0) !important;
    opacity: 1 !important;
    pointer-events: auto !important;
    background: rgba(255, 255, 255, 0.85) !important;
    backdrop-filter: blur(20px) saturate(180%) !important;
    -webkit-backdrop-filter: blur(20px) saturate(180%) !important;
    border-bottom: 1px solid rgba(16, 185, 129, 0.18) !important;
    box-shadow: 0 10px 30px -10px rgba(5, 150, 105, 0.1), 0 1px 3px rgba(0, 0, 0, 0.05) !important;
}

.dark body:has(#ragged-hero-stage) #main-header.header-visible {
    background: rgba(15, 23, 42, 0.88) !important;
    border-bottom: 1px solid rgba(16, 185, 129, 0.25) !important;
    box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5) !important;
}

#ragged-hero-stage {
    position: relative;
    width: 100%;
    background: #020912;
    overflow: hidden;
}

/* Canvas background for animated light warp */
#ragged-light-canvas {
    width: 100%;
    height: 100%;
    pointer-events: none;
}

/* Atmospheric vignette & horizontal flare streaks */
.ragged-flare-streak {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 140px;
    transform: translateY(-50%);
    background: radial-gradient(ellipse 90% 45% at 50% 50%, rgba(56, 189, 248, 0.35) 0%, rgba(20, 184, 166, 0.2) 40%, transparent 75%);
    filter: blur(28px);
    pointer-events: none;
    z-index: 2;
    animation: flareBreath 6s ease-in-out infinite alternate;
}

.ragged-warm-flare {
    position: absolute;
    top: 10%;
    left: 8%;
    width: 45vw;
    height: 45vw;
    max-width: 550px;
    max-height: 550px;
    background: radial-gradient(circle at 40% 40%, rgba(217, 119, 6, 0.22) 0%, rgba(180, 83, 9, 0.1) 45%, transparent 70%);
    filter: blur(50px);
    pointer-events: none;
    z-index: 2;
    animation: warmFloat 8s ease-in-out infinite alternate;
}

.ragged-dark-vignette {
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at center, transparent 40%, rgba(2, 9, 18, 0.75) 85%, #020912 100%);
    pointer-events: none;
    z-index: 3;
}

@keyframes flareBreath {
    0% { opacity: 0.7; transform: translateY(-50%) scaleY(0.9); }
    100% { opacity: 1; transform: translateY(-50%) scaleY(1.15); }
}

@keyframes warmFloat {
    0% { transform: translate(0, 0) scale(1); }
    100% { transform: translate(25px, -15px) scale(1.08); }
}

/* Monolith Giant Stretched Typography (Ragged Edge Signature) */
.ragged-monolith-container {
    position: relative;
    z-index: 20;
    text-align: center;
    padding: 0 20px;
    will-change: transform, opacity, filter;
}

.ragged-monolith-title {
    font-family: 'Sora', system-ui, -apple-system, sans-serif;
    font-weight: 900;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: #ffffff !important;
    display: inline-block;
    transform: scaleX(1.28) scaleY(0.92);
    transform-origin: center center;
    filter: drop-shadow(0 0 35px rgba(56, 189, 248, 0.6)) drop-shadow(0 0 10px rgba(255, 255, 255, 0.95));
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), filter 0.4s ease;
    user-select: none;
    position: relative;
    z-index: 25;
}

.ragged-monolith-title:hover {
    transform: scaleX(1.32) scaleY(0.95);
    filter: drop-shadow(0 0 50px rgba(56, 189, 248, 0.85)) drop-shadow(0 0 16px rgba(255, 255, 255, 1));
}

.ragged-monolith-sub {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.35em;
    text-transform: uppercase;
    color: rgba(224, 242, 254, 0.85) !important;
    margin-top: 14px;
    text-shadow: 0 0 14px rgba(56, 189, 248, 0.6);
    position: relative;
    z-index: 25;
}

/* Floating Bottom Navigation Pills (Identical to reference image) */
.ragged-pill-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 9px 20px;
    border-radius: 9999px;
    background: rgba(255, 255, 255, 0.14) !important;
    border: 1px solid rgba(255, 255, 255, 0.28) !important;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    color: #ffffff !important;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.04em;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
    text-decoration: none !important;
}

.ragged-pill-btn:hover {
    background: rgba(255, 255, 255, 0.28) !important;
    border-color: rgba(255, 255, 255, 0.65) !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(56, 189, 248, 0.3);
    color: #ffffff !important;
}

/* Scroll indicator pill */
.ragged-scroll-indicator {
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    color: rgba(255, 255, 255, 0.8);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.3s ease;
}
.ragged-scroll-indicator:hover {
    color: #ffffff;
    transform: translateY(2px);
}

/* ===== BERANDA EXISTING CUSTOM ANIMATIONS & STYLES ===== */
:root {
    --ease-ragged: cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes gradientShift {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}
@keyframes floatUp {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-8px); }
}
@keyframes glowPulse {
    0%, 100% { opacity: 0.3; transform: scale(0.98); }
    50% { opacity: 0.65; transform: scale(1.04); }
}

.hero-animated-bg {
    background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 25%, #d1fae5 50%, #ecfdf5 75%, #f8fafc 100%);
    background-size: 400% 400%;
    animation: gradientShift 10s ease infinite;
}
.float-badge { animation: floatUp 3.5s ease-in-out infinite; }
.float-badge-2 { animation: floatUp 3.5s ease-in-out infinite 1.75s; }

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
    border: 1px solid rgba(5, 150, 105, 0.22);
    border-radius: 100px;
    padding: 6px 15px;
    margin-bottom: 16px;
    transition: all 0.3s var(--ease-ragged);
}
.section-label:hover {
    background: rgba(5, 150, 105, 0.14);
    border-color: rgba(5, 150, 105, 0.35);
}

.section-accent-bar {
    width: 48px;
    height: 4px;
    background: linear-gradient(90deg, #059669, #10b981);
    border-radius: 4px;
    margin: 12px 0 20px 0;
    transition: width 0.4s var(--ease-ragged);
}

.news-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid rgba(226, 232, 240, 0.85);
    transition: transform 0.4s var(--ease-ragged), box-shadow 0.4s var(--ease-ragged), border-color 0.4s var(--ease-ragged);
    display: flex;
    flex-direction: column;
    position: relative;
}
.news-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #059669, #10b981);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s var(--ease-ragged);
    z-index: 10;
}
.news-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px -10px rgba(5, 150, 105, 0.15);
    border-color: rgba(5, 150, 105, 0.3);
}
.news-card:hover::before {
    transform: scaleX(1);
}
.dark .news-card {
    background: rgba(30, 41, 59, 0.85);
    border-color: rgba(51, 65, 85, 0.7);
}
.dark .news-card:hover {
    border-color: rgba(52, 211, 153, 0.4);
    box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.5);
}

.news-card-featured {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    border: 1px solid rgba(226, 232, 240, 0.85);
    transition: transform 0.4s var(--ease-ragged), box-shadow 0.4s var(--ease-ragged), border-color 0.4s var(--ease-ragged);
}
.news-card-featured:hover {
    transform: translateY(-6px);
    box-shadow: 0 24px 48px -10px rgba(5, 150, 105, 0.18);
    border-color: rgba(5, 150, 105, 0.3);
}
.dark .news-card-featured {
    background: rgba(30, 41, 59, 0.85);
    border-color: rgba(51, 65, 85, 0.7);
}

.pillar-card {
    background: white;
    border-radius: 24px;
    padding: 30px 26px;
    border: 1px solid rgba(226, 232, 240, 0.85);
    transition: transform 0.4s var(--ease-ragged), box-shadow 0.4s var(--ease-ragged), border-color 0.4s var(--ease-ragged);
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
    transition: transform 0.4s var(--ease-ragged);
}
.pillar-card:hover { 
    transform: translateY(-6px); 
    box-shadow: 0 24px 44px -12px rgba(5, 150, 105, 0.15); 
    border-color: rgba(5, 150, 105, 0.3); 
}
.pillar-card:hover::before { transform: scaleX(1); }
.dark .pillar-card { background: rgba(30, 41, 59, 0.85); border-color: rgba(51, 65, 85, 0.7); }

.announcement-item {
    display: flex;
    gap: 16px;
    padding: 16px 0;
    border-bottom: 1px solid rgba(226, 232, 240, 0.7);
    align-items: flex-start;
    transition: transform 0.25s var(--ease-ragged), padding 0.25s var(--ease-ragged);
}
.announcement-item:last-child { border-bottom: none; }
.announcement-item:hover { padding-left: 6px; }
.dark .announcement-item { border-color: rgba(51, 65, 85, 0.5); }

.stat-card {
    background: white;
    border-radius: 20px;
    padding: 26px 22px;
    text-align: center;
    border: 1px solid rgba(226, 232, 240, 0.85);
    transition: transform 0.35s var(--ease-ragged), box-shadow 0.35s var(--ease-ragged), border-color 0.35s var(--ease-ragged);
}
.stat-card:hover { 
    box-shadow: 0 16px 36px -8px rgba(5, 150, 105, 0.14); 
    transform: translateY(-5px); 
    border-color: rgba(5, 150, 105, 0.25);
}
.dark .stat-card { background: rgba(30, 41, 59, 0.85); border-color: rgba(51, 65, 85, 0.7); }

.contact-card {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    border: 1px solid rgba(226, 232, 240, 0.85);
    transition: transform 0.35s var(--ease-ragged), box-shadow 0.35s var(--ease-ragged);
}
.contact-card:hover {
    box-shadow: 0 16px 36px -10px rgba(5, 150, 105, 0.12);
}
.dark .contact-card { background: rgba(30, 41, 59, 0.85); border-color: rgba(51, 65, 85, 0.7); }

.accreditation-badge {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 22px 18px;
    background: white;
    border-radius: 20px;
    border: 1px solid rgba(226, 232, 240, 0.85);
    text-align: center;
    transition: transform 0.35s var(--ease-ragged), box-shadow 0.35s var(--ease-ragged), border-color 0.35s var(--ease-ragged);
}
.accreditation-badge:hover { 
    transform: translateY(-5px); 
    box-shadow: 0 16px 32px -8px rgba(5, 150, 105, 0.14); 
    border-color: rgba(5, 150, 105, 0.3);
}
.dark .accreditation-badge { background: rgba(30, 41, 59, 0.85); border-color: rgba(51, 65, 85, 0.7); }

.ragged-reveal {
    opacity: 0;
    transform: translateY(28px);
    transition: opacity 0.7s var(--ease-ragged), transform 0.7s var(--ease-ragged);
    will-change: opacity, transform;
}
.ragged-reveal.revealed {
    opacity: 1;
    transform: translateY(0);
}

.text-primary-color { color: var(--text-primary, #0F172A); }
.text-body-color { color: var(--text-body, #475569); }

/* ===== RAGGED EDGE LUXURIOUS GRADIENT TRANSITION BRIDGE ===== */
.ragged-gradient-bridge {
    position: relative;
    width: 100%;
    height: 360px;
    z-index: 10;
    pointer-events: none;
    background: linear-gradient(
        to bottom,
        rgba(2, 9, 18, 0) 0%,
        rgba(2, 9, 18, 0.4) 15%,
        rgba(4, 47, 46, 0.65) 35%,
        rgba(5, 150, 105, 0.38) 55%,
        rgba(16, 185, 129, 0.28) 72%,
        rgba(209, 250, 229, 0.75) 88%,
        #ecfdf5 100%
    );
}

.dark .ragged-gradient-bridge {
    background: linear-gradient(
        to bottom,
        rgba(2, 9, 18, 0) 0%,
        rgba(2, 9, 18, 0.5) 15%,
        rgba(4, 47, 46, 0.7) 35%,
        rgba(6, 78, 59, 0.6) 55%,
        rgba(15, 23, 42, 0.8) 75%,
        rgba(2, 44, 34, 0.95) 90%,
        #022c22 100%
    );
}

/* Living Radiant Gradient for Beranda */
@keyframes gradientShift {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.hero-animated-bg {
    background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 25%, #d1fae5 50%, #ecfdf5 75%, #f8fafc 100%);
    background-size: 300% 300%;
    animation: gradientShift 14s ease infinite;
}

.dark .hero-animated-bg {
    background: linear-gradient(135deg, #022c22 0%, #064e3b 25%, #0f172a 60%, #020912 100%);
    background-size: 300% 300%;
    animation: gradientShift 14s ease infinite;
}
</style>
@endpush

@section('content')

{{-- =========================================================================
     0. RAGGED EDGE UNIFIED HERO STAGE (KONTINU DENGAN GRADASI HALUS KE BERANDA)
     - Kanvas pendaran cahaya aktif melingkupi pembuka (100vh)
     - Transisi gradasi feathery 320px menghubungkan pendaran gelap ke warna asli Beranda
     - Bebas garis batas (border) tajam, menyatu secara lembut dan seamless
========================================================================= --}}
<section id="ragged-hero-stage" class="relative w-full overflow-hidden bg-[#020912]">
    <!-- Pinned Canvas Background (Fixed behind the hero stage) -->
    <div id="ragged-hero-canvas-wrap" style="position: fixed; inset: 0; width: 100vw; height: 100vh; pointer-events: none; z-index: 0; overflow: hidden;">
        <canvas id="ragged-light-canvas" style="width: 100%; height: 100%; display: block;"></canvas>
        <div class="ragged-warm-flare"></div>
        <div class="ragged-flare-streak"></div>
        <div class="ragged-dark-vignette"></div>
    </div>

    <!-- 1. INTRO VIEWPORT (100vh) -->
    <div id="ragged-intro-view" class="relative w-full h-screen min-h-[580px] flex flex-col justify-between items-center select-none" style="position: relative; z-index: 10;">
        <!-- Top school identity -->
        <div class="w-full pt-8 px-6 sm:px-12 flex justify-between items-center z-10">
            <span class="text-[11px] font-bold tracking-[0.25em] text-white/80 uppercase">
                SMA NEGERI 4 JEMBER
            </span>
            <span class="text-[11px] font-bold tracking-[0.25em] text-emerald-300 uppercase">
                EST. BK DIGITAL
            </span>
        </div>

        <!-- Centerpiece Monolith Extended Title: SAPA BK -->
        <div class="ragged-monolith-container my-auto">
            <h1 class="ragged-monolith-title text-white text-5xl sm:text-7xl md:text-8xl lg:text-[7.5rem]">
                SAPA&nbsp;BK
            </h1>
            <p class="ragged-monolith-sub">
                SISTEM ASISTENSI PINTAR AKADEMIK &bull; SMAN 4 JEMBER
            </p>
        </div>

        <!-- Bottom Navigation Bar & Scroll Prompt -->
        <div id="ragged-bottom-bar" class="w-full pb-8 px-4 sm:pl-10 sm:pr-20 flex flex-col sm:flex-row items-center justify-between gap-5 z-20">
            <!-- Left Group Pills -->
            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2.5">
                <a href="#main-beranda" class="ragged-pill-btn">Beranda</a>
                <a href="{{ route('tentang') }}" class="ragged-pill-btn">Tentang BK</a>
                <a href="#layanan-unggulan" class="ragged-pill-btn">Layanan</a>
                <a href="{{ route('artikel.list') }}" class="ragged-pill-btn">Artikel</a>
            </div>

            <!-- Center: Scroll to Beranda Indicator -->
            <a href="#main-beranda"
                 class="ragged-scroll-indicator order-first sm:order-none" title="Geser ke bawah untuk ke Beranda">
                <span>Geser Ke Bawah</span>
                <svg class="w-4 h-4 animate-bounce text-emerald-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </a>

            <!-- Right Group Pills -->
            <div class="flex items-center justify-center sm:justify-end gap-2.5">
                @auth
                    <a href="{{ route('student.dashboard') }}" class="ragged-pill-btn">Portal Siswa</a>
                    <a href="{{ route('student.chat') }}" class="ragged-pill-btn bg-emerald-600/40 border-emerald-400/50 hover:bg-emerald-600/70">Konsultasi</a>
                @else
                    <a href="{{ route('login') }}" class="ragged-pill-btn">Masuk</a>
                    <a href="{{ route('register') }}" class="ragged-pill-btn bg-emerald-600/40 border-emerald-400/50 hover:bg-emerald-600/70">Mulai Gratis</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- 1.5 SMOOTH GRADIENT TRANSITION BRIDGE (RAGGED EDGE GRADIENT BLEND) -->
    <div class="ragged-gradient-bridge"></div>
</section>

<!-- 2. BERANDA HERO SECTION (WARNA & DESAIN ASLI LANDING PAGE SAPA BK DENGAN GRADASI HIDUP) -->
<section id="main-beranda" class="relative z-20 hero-animated-bg pt-12 sm:pt-16 lg:pt-20 pb-16 sm:pb-20 overflow-hidden scroll-mt-20">
    <!-- Background grid pattern -->
    <div class="absolute inset-0 bg-[linear-gradient(to_bottom,#f1f5f9_1px,transparent_1px)] bg-[size:100%_28px] opacity-40 dark:opacity-10 pointer-events-none"></div>

    <!-- Glowing decorative ambient gradient blobs in Beranda -->
    <div class="absolute top-12 left-0 w-[30rem] h-[30rem] bg-gradient-to-br from-emerald-200/50 to-teal-200/40 dark:from-emerald-800/30 dark:to-teal-900/20 rounded-full blur-3xl pointer-events-none -translate-x-1/2"></div>
    <div class="absolute bottom-0 right-0 w-[28rem] h-[28rem] bg-gradient-to-tl from-teal-200/40 to-emerald-200/40 dark:from-teal-800/25 dark:to-emerald-900/20 rounded-full blur-3xl pointer-events-none translate-x-1/4"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-8 items-center">
            
            <!-- === LEFT: Text Block === -->
            <div class="text-center lg:text-left">

                <!-- Pill Badge -->
                <span class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full bg-white dark:bg-slate-800 border border-slate-200/90 dark:border-slate-700 shadow-sm text-slate-600 dark:text-slate-400 text-xs font-semibold mb-5">
                    <span class="w-2 h-2 rounded-full bg-[#059669] animate-pulse"></span>
                    Sistem Informasi BK Digital
                </span>

                <!-- Headline -->
                <h1 class="font-sora text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight text-slate-900 dark:text-white" style="margin-bottom: 24px;">
                    BK Lebih Modern.<br>
                    <span class="text-[#059669]">Siswa Makin Dekat.</span>
                </h1>

                <!-- Deskripsi -->
                <p class="text-base sm:text-lg text-slate-600 dark:text-slate-400 max-w-lg mx-auto lg:mx-0 font-normal" style="margin-bottom: 36px; line-height: 1.8;">
                    Sistem cerdas untuk mengelola data siswa, sesi konseling, instrumen asesmen, hingga pendampingan akademik & kesehatan mental secara privat dan terintegrasi di SMAN 4 Jember.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4" style="margin-top: 36px; margin-bottom: 36px;">
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

                    <!-- CTA SEKUNDER -->
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

                <!-- Trust indicators -->
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
            
            <!-- RIGHT: Window Frame Card (Original White Card) -->
            <div class="flex justify-center lg:justify-end items-center">
                <div class="relative w-full max-w-sm sm:max-w-md">
                    <!-- Soft animated glow -->
                    <div class="absolute -inset-3 bg-gradient-to-r from-emerald-400/20 to-teal-400/20 rounded-[2.5rem] blur-2xl pointer-events-none float-badge"></div>

                    <!-- Visual Card Container -->
                    <div class="relative bg-white dark:bg-slate-800
                                shadow-xl shadow-slate-300/40 dark:shadow-slate-950/40
                                border border-slate-200/70 dark:border-slate-700/70
                                p-4 sm:p-5 overflow-hidden rounded-[28px] transition-transform duration-300 hover:-translate-y-1">

                        <!-- Window chrome dots -->
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
                                <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400">Online</span>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="mt-3 flex items-center justify-between px-1">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-[#059669]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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

<!-- Sub-hero content container with solid background covering canvas -->
<div class="relative z-10 bg-white dark:bg-slate-900" style="position: relative; z-index: 10;">

<!-- Features Bar Section (Clean Flow) -->
<section class="py-12 bg-white dark:bg-slate-900 border-y border-slate-100 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 divide-y sm:divide-y-0 sm:divide-x lg:divide-x-0 divide-slate-100 dark:divide-slate-700/60">
            <!-- Feature 1 -->
            <div class="flex items-start gap-4 pt-4 sm:pt-0 pl-0 sm:pl-4 lg:pl-0 ragged-reveal">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/40 flex items-center justify-center shrink-0 text-[#059669] transition-transform duration-300 hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 dark:text-white text-sm mb-1">Aman & Terpercaya</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Keamanan data terjamin dengan standar enkripsi tinggi</p>
                </div>
            </div>
            <!-- Feature 2 -->
            <div class="flex items-start gap-4 pt-4 sm:pt-0 pl-0 sm:pl-4 lg:pl-0 ragged-reveal">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/40 flex items-center justify-center shrink-0 text-[#059669] transition-transform duration-300 hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 dark:text-white text-sm mb-1">Data Real-time</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Pantau perkembangan peserta didik secara real-time dan akurat</p>
                </div>
            </div>
            <!-- Feature 3 -->
            <div class="flex items-start gap-4 pt-4 sm:pt-0 lg:pt-0 pl-0 sm:pl-0 lg:pl-0 ragged-reveal">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/40 flex items-center justify-center shrink-0 text-[#059669] transition-transform duration-300 hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 dark:text-white text-sm mb-1">Mudah Digunakan</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Antarmuka intuitif yang dirancang khusus untuk guru BK</p>
                </div>
            </div>
            <!-- Feature 4 -->
            <div class="flex items-start gap-4 pt-4 sm:pt-0 pl-0 sm:pl-4 lg:pl-0 ragged-reveal">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/40 flex items-center justify-center shrink-0 text-[#059669] transition-transform duration-300 hover:scale-110">
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
<section class="relative z-10 py-16 bg-white dark:bg-slate-900" id="tentang-sapa" style="position: relative; z-index: 10; background-color: #ffffff;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Bikonesia-style Banner Card -->
        <div class="relative bg-gradient-to-r from-[#047857] via-[#059669] to-[#10B981] rounded-3xl p-8 sm:p-12 lg:p-16 text-white shadow-2xl overflow-hidden ragged-reveal" style="border-radius: 36px;">
            <!-- Decorative background pattern with gentle floating animation -->
            <div class="absolute -right-16 -bottom-16 w-80 h-80 bg-white/10 rounded-full blur-3xl pointer-events-none float-badge"></div>
            <div class="absolute -left-16 -top-16 w-60 h-60 bg-emerald-300/10 rounded-full blur-2xl pointer-events-none float-badge-2"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center relative z-10">
                
                <!-- Left: Logo BK Illustration -->
                <div class="lg:col-span-4 flex justify-center items-center">
                    <div class="relative group max-w-[240px] sm:max-w-xs w-full">
                        <div class="absolute inset-0 bg-white/20 rounded-full blur-2xl group-hover:bg-white/30 transition-all duration-500"></div>
                        <img src="/logoBk.png" alt="Logo BK SAPA BK" class="relative z-10 w-full h-auto object-contain drop-shadow-xl hover:scale-105 transition-transform duration-500">
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
                            <a href="{{ route('student.chat') }}" class="inline-flex items-center justify-center px-8 py-3.5 rounded-full bg-white text-[#047857] hover:bg-emerald-50 font-extrabold text-sm sm:text-base shadow-lg transition-all duration-300 hover:-translate-y-1">
                                Mulai Konsultasi
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-3.5 rounded-full bg-white text-[#047857] hover:bg-emerald-50 font-extrabold text-sm sm:text-base shadow-lg transition-all duration-300 hover:-translate-y-1">
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
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12 ragged-reveal">
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
            <a href="{{ route('artikel.list') }}" id="berita-semua-link" class="btn-secondary text-sm hidden sm:inline-flex shrink-0 group">
                Lihat Semua Artikel
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

        <!-- Articles Grid: 1 featured + 2 smaller (like UAD layout) -->
        @if($articles->count() >= 3)
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Featured Article (Left Large) -->
            <a href="{{ route('artikel.detail', $articles->first()->slug) }}" id="berita-featured" class="lg:col-span-7 news-card-featured group block ragged-reveal">
                <!-- Cover -->
                <div class="relative h-64 sm:h-80 lg:h-96 bg-gradient-to-br from-[#042F2E] via-[#047857] to-[#10B981] overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center group-hover:scale-105 transition-transform duration-700">
                        <div class="text-center px-12">
                            <svg class="w-20 h-20 text-white/30 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                    </div>
                    <!-- Gradient overlay -->
                    <div class="absolute bottom-0 left-0 right-0 h-3/4 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <!-- Category badge -->
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center gap-1.5 bg-[#059669] text-white text-[10px] font-bold uppercase tracking-wider px-3.5 py-1.5 rounded-full shadow-sm">
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
                <a href="{{ route('artikel.detail', $article->slug) }}" id="berita-card-{{ $i + 2 }}" class="news-card group flex-1 ragged-reveal">
                    <div class="flex flex-col sm:flex-row lg:flex-col h-full">
                        <!-- Image -->
                        <div class="h-40 sm:w-48 sm:h-auto lg:w-auto lg:h-44 bg-gradient-to-br {{ $i === 0 ? 'from-[#047857] to-[#34d399]' : 'from-teal-700 to-teal-400' }} flex-shrink-0 relative overflow-hidden flex items-center justify-center">
                            <svg class="w-12 h-12 text-white/40 group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
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
                            <span class="text-xs font-bold text-[#059669] dark:text-emerald-400 inline-flex items-center gap-1 mt-3 group-hover:translate-x-1.5 transition-transform">
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
            <a href="{{ route('artikel.detail', $article->slug) }}" id="berita-single-{{ $i+1 }}" class="news-card group block ragged-reveal">
                <div class="h-48 bg-gradient-to-br from-[#047857] to-[#10B981] relative flex items-center justify-center overflow-hidden">
                    <svg class="w-14 h-14 text-white/40 group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
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

        <div class="text-center mt-8 sm:hidden ragged-reveal">
            <a href="{{ route('artikel.list') }}" class="btn-secondary text-sm w-full justify-center">Lihat Semua Artikel →</a>
        </div>
    </div>
</section>
@endif


{{-- ===== 4. LAYANAN UNGGULAN (mirip "PRESTASI MAHASISWA" UAD → di-adaptasi ke fitur BK) ===== --}}
<section class="py-20 bg-[#F8FAFC] dark:bg-slate-950/80 border-y border-slate-200/70 dark:border-slate-800" id="layanan-unggulan">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto mb-14 ragged-reveal">
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
            <div id="layanan-chatbot" class="pillar-card group flex flex-col h-full ragged-reveal">
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
            <div id="layanan-ebook" class="pillar-card group flex flex-col h-full ragged-reveal">
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
            <div id="layanan-artikel" class="pillar-card group flex flex-col h-full ragged-reveal">
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
            <div id="layanan-tes" class="pillar-card group flex flex-col h-full ragged-reveal">
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
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12 ragged-reveal">
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
            <a href="{{ route('ebook.public') }}" id="ebook-semua-link" class="btn-secondary text-sm hidden sm:inline-flex shrink-0 group">
                Lihat Semua E-Book
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($ebooks as $i => $ebook)
            <div id="ebook-card-{{ $i+1 }}" class="news-card group flex flex-col ragged-reveal">
                <!-- Cover -->
                @php
                    $gradients = ['from-[#042F2E] via-[#059669] to-[#10B981]','from-teal-800 to-teal-500','from-emerald-800 to-emerald-500','from-[#047857] to-[#34d399]'];
                    $gradient = $gradients[$i % count($gradients)];
                @endphp
                <div class="h-44 bg-gradient-to-br {{ $gradient }} relative overflow-hidden flex items-center justify-center">
                    <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/10 rounded-full blur-md"></div>
                    <svg class="w-16 h-16 text-white/40 relative z-10 group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
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
                            <a href="{{ route('student.ebook') }}" class="btn-primary text-[10px] px-3.5 py-1.5 hover:shadow-md transition-shadow">Baca</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-primary text-[10px] px-3.5 py-1.5 hover:shadow-md transition-shadow">Login</a>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-8 sm:hidden ragged-reveal">
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
            <div class="lg:col-span-7 ragged-reveal">
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
                    <div class="bg-white dark:bg-slate-800/90 rounded-2xl overflow-hidden border border-slate-200/80 dark:border-slate-700/60 transition-all hover:border-emerald-300/60"
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
            <div class="lg:col-span-5 ragged-reveal">
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
                    <div class="bg-white dark:bg-slate-800/90 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-700/60 flex gap-4 items-start transition-all duration-300 hover:-translate-y-1 hover:border-emerald-300/70 shadow-xs">
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
        <div class="text-center max-w-xl mx-auto mb-12 ragged-reveal">
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
            <div class="accreditation-badge text-left gap-0 ragged-reveal">
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
        <div class="bg-gradient-to-r from-[#ECFDF5] to-[#d1fae5] dark:from-emerald-950/90 dark:to-teal-950/90 rounded-3xl p-8 sm:p-10 border border-emerald-200/60 dark:border-emerald-800/40 ragged-reveal">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
                <div class="group cursor-default">
                    <p class="font-sora text-4xl font-extrabold text-[#059669] dark:text-emerald-400 mb-1 group-hover:scale-105 transition-transform duration-300">100%</p>
                    <p class="font-bold text-sm text-slate-900 dark:text-white">Gratis untuk Seluruh Siswa</p>
                    <p class="text-xs mt-1 text-slate-600 dark:text-slate-300">Tidak ada biaya, tidak ada iklan</p>
                </div>
                <div class="border-x-0 sm:border-x border-emerald-300/50 dark:border-emerald-800/60 px-4 group cursor-default">
                    <p class="font-sora text-4xl font-extrabold text-[#059669] dark:text-emerald-400 mb-1 group-hover:scale-105 transition-transform duration-300">4 BK</p>
                    <p class="font-bold text-sm text-slate-900 dark:text-white">Guru BK Berlisensi</p>
                    <p class="text-xs mt-1 text-slate-600 dark:text-slate-300">Pendampingan professional tersertifikasi</p>
                </div>
                <div class="group cursor-default">
                    <p class="font-sora text-4xl font-extrabold text-[#059669] dark:text-emerald-400 mb-1 group-hover:scale-105 transition-transform duration-300">AI</p>
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
        <div class="text-center max-w-xl mx-auto mb-12 ragged-reveal">
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
            <div class="lg:col-span-7 contact-card overflow-hidden shadow-lg ragged-reveal">
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
            <div class="lg:col-span-5 space-y-4 ragged-reveal">

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
                            <svg class="w-3 h-3 text-[#059669] group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
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
    <div class="absolute top-0 right-0 w-80 h-80 bg-white/5 rounded-full blur-3xl pointer-events-none float-badge"></div>
    <div class="absolute top-1/4 left-0 w-64 h-64 bg-emerald-400/10 rounded-full blur-3xl pointer-events-none float-badge-2"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 ragged-reveal">
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
                <a href="{{ route('student.chat') }}" id="bottom-cta-chat" class="inline-flex items-center justify-center gap-2 bg-white text-[#047857] hover:bg-emerald-50 px-8 py-3.5 rounded-full font-extrabold text-sm sm:text-base shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full sm:w-auto">
                    Mulai Chat Sekarang
                </a>
                <a href="{{ route('ebook.public') }}" class="inline-flex items-center justify-center gap-2 bg-white text-[#047857] hover:bg-emerald-50 px-8 py-3.5 rounded-full font-extrabold text-sm sm:text-base shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full sm:w-auto">
                    Jelajahi E-Book BK
                </a>
            @else
                <a href="{{ route('register') }}" id="bottom-cta-register" class="inline-flex items-center justify-center gap-2 bg-white text-[#047857] hover:bg-emerald-50 px-8 py-3.5 rounded-full font-extrabold text-sm sm:text-base shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full sm:w-auto">
                    Daftar Akun Gratis
                </a>
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 bg-white text-[#047857] hover:bg-emerald-50 px-8 py-3.5 rounded-full font-extrabold text-sm sm:text-base shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full sm:w-auto">
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
    <div id="chat-popup" class="hidden absolute bottom-20 right-0 w-80 bg-white dark:bg-slate-800 rounded-3xl shadow-2xl overflow-hidden border border-slate-200 dark:border-slate-700 transition-all duration-300">
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

    // Ragged Edge-style Smooth Scroll-Triggered Staggered Animation
    function initPublicPage() {
        const observerConfig = { threshold: 0.12, rootMargin: '0px 0px -40px 0px' };
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, observerConfig);

        // Stagger cards in grids automatically
        document.querySelectorAll('.grid').forEach(grid => {
            const items = grid.querySelectorAll('.news-card, .pillar-card, .stat-card, .accreditation-badge, .contact-card, .announcement-item, .ragged-reveal');
            items.forEach((item, index) => {
                item.style.transitionDelay = `${(index % 4) * 80}ms`;
            });
        });

        // Observe all interactive & reveal elements
        document.querySelectorAll('.ragged-reveal, .news-card, .pillar-card, .stat-card, .accreditation-badge, .contact-card, .announcement-item').forEach(el => {
            el.classList.add('ragged-reveal');
            revealObserver.observe(el);
        });

        // ===== NAVBAR SMART VISIBILITY & RAGGED EDGE SCROLL INTERPOLATION =====
        const mainHeader = document.getElementById('main-header');
        const heroStage = document.getElementById('ragged-hero-stage');
        const introView = document.getElementById('ragged-intro-view');
        const mainBeranda = document.getElementById('main-beranda');
        const monolithContainer = document.querySelector('.ragged-monolith-container');
        const bottomPillBar = document.getElementById('ragged-bottom-bar');
        const lightCanvas = document.getElementById('ragged-light-canvas');
        const canvasWrap = document.getElementById('ragged-hero-canvas-wrap');

        if (heroStage) {
            function updateScrollEffects() {
                const scrollY = window.scrollY;
                const viewH = window.innerHeight;
                const introH = introView ? introView.offsetHeight : viewH;

                // 1. Header visibility: reveals navbar when scrolling into Beranda
                if (mainHeader) {
                    if (scrollY > introH * 0.45) {
                        mainHeader.classList.add('header-visible');
                    } else {
                        mainHeader.classList.remove('header-visible');
                    }
                }

                // 2. Ragged Edge Title Parallax & Scaling:
                // Smooth interpolation as user scrolls down from top
                const progress = Math.min(1, Math.max(0, scrollY / (introH * 0.7)));
                
                if (monolithContainer) {
                    const translateY = -progress * 130;
                    const scale = 1 - progress * 0.32;
                    const opacity = Math.max(0, 1 - progress * 1.5);
                    monolithContainer.style.transform = `translateY(${translateY}px) scale(${scale})`;
                    monolithContainer.style.opacity = opacity;
                }

                // 3. Bottom Pill Bar fades out smoothly on scroll
                if (bottomPillBar) {
                    const pillOpacity = Math.max(0, 1 - progress * 2.5);
                    bottomPillBar.style.opacity = pillOpacity;
                    bottomPillBar.style.pointerEvents = pillOpacity < 0.1 ? 'none' : 'auto';
                }

                // 4. Smooth Canvas Opacity Fade across the gradient bridge
                if (canvasWrap) {
                    const bridgeEl = document.querySelector('.ragged-gradient-bridge');
                    const bridgeH = bridgeEl ? bridgeEl.offsetHeight : 320;
                    const fadeStart = introH * 0.2;
                    const fadeEnd = introH + bridgeH * 0.7;
                    let canvasOpacity = 1;
                    if (scrollY >= fadeStart) {
                        canvasOpacity = Math.max(0, 1 - (scrollY - fadeStart) / (fadeEnd - fadeStart));
                    }
                    canvasWrap.style.opacity = canvasOpacity;
                    canvasWrap.style.display = canvasOpacity <= 0 ? 'none' : 'block';
                }
            }

            window.addEventListener('scroll', updateScrollEffects, { passive: true });
            window.addEventListener('resize', updateScrollEffects, { passive: true });
            updateScrollEffects();
        }

        // ===== RAGGED EDGE FLUID LIGHT RAY CANVAS ANIMATION =====
        const canvas = lightCanvas;
        if (canvas) {
            const ctx = canvas.getContext('2d');
            let w = canvas.width = window.innerWidth;
            let h = canvas.height = window.innerHeight;
            let mouseX = w / 2;
            let mouseY = h / 2;
            let targetMouseX = w / 2;
            let targetMouseY = h / 2;
            let time = 0;

            function resizeCanvas() {
                if (!canvas) return;
                w = canvas.width = window.innerWidth;
                h = canvas.height = window.innerHeight;
            }
            window.addEventListener('resize', resizeCanvas);

            // Subtle mouse parallax
            window.addEventListener('mousemove', (e) => {
                targetMouseX = e.clientX;
                targetMouseY = e.clientY;
            });

            // Ray definition (streaks of light exploding outward like the reference image)
            const numRays = 32;
            const rays = [];
            for (let i = 0; i < numRays; i++) {
                rays.push({
                    angle: (i / numRays) * Math.PI * 2,
                    length: Math.random() * 0.5 + 0.75,
                    width: Math.random() * 0.18 + 0.08,
                    speed: (Math.random() - 0.5) * 0.003,
                    colorAlpha: Math.random() * 0.45 + 0.25,
                    hue: (i % 2 === 0) ? 190 : 175 // Cyan to teal tones
                });
            }

            function drawLightWarp() {
                if (canvasWrap && canvasWrap.style.display === 'none') {
                    requestAnimationFrame(drawLightWarp);
                    return;
                }
                time += 0.015;
                // Lerp mouse
                mouseX += (targetMouseX - mouseX) * 0.05;
                mouseY += (targetMouseY - mouseY) * 0.05;

                ctx.clearRect(0, 0, w, h);

                const cx = w / 2 + (mouseX - w / 2) * 0.12;
                const cy = h / 2 + (mouseY - h / 2) * 0.08;

                // Dynamic scroll-driven chromatic morph (Ragged Edge Color Shift)
                const scrollProg = Math.min(1, Math.max(0, window.scrollY / (window.innerHeight || 800)));
                const morphHue1 = Math.round(190 - scrollProg * 35); // 190 (Cyan) -> 155 (Emerald)
                const morphHue2 = Math.round(175 - scrollProg * 30); // 175 (Teal) -> 145 (Mint)

                // 1. Draw central deep blue backdrop with dynamic scroll color shift
                const bgGrad = ctx.createRadialGradient(cx, cy, 10, cx, cy, Math.max(w, h) * 0.85);
                bgGrad.addColorStop(0, `hsla(${morphHue1}, 85%, 50%, ${0.45 + scrollProg * 0.15})`);
                bgGrad.addColorStop(0.25, `hsla(${morphHue2}, 80%, 42%, ${0.35 + scrollProg * 0.15})`);
                bgGrad.addColorStop(0.55, 'rgba(3, 30, 50, 0.85)');
                bgGrad.addColorStop(1, 'rgba(2, 9, 18, 1)');
                ctx.fillStyle = bgGrad;
                ctx.fillRect(0, 0, w, h);

                // 2. Draw rotating volumetric light rays with dynamic hue morph
                ctx.save();
                ctx.translate(cx, cy);

                rays.forEach((ray) => {
                    ray.angle += ray.speed;
                    const rayLength = Math.max(w, h) * ray.length;
                    const pulse = Math.sin(time * 1.5 + ray.angle * 3) * 0.2 + 0.8;
                    const rayHue = Math.round(ray.hue - scrollProg * 35);

                    ctx.beginPath();
                    ctx.moveTo(0, 0);
                    ctx.arc(0, 0, rayLength, ray.angle - ray.width / 2, ray.angle + ray.width / 2);
                    ctx.closePath();

                    const rayGrad = ctx.createRadialGradient(0, 0, 0, 0, 0, rayLength);
                    rayGrad.addColorStop(0, `hsla(${rayHue}, 90%, 80%, ${ray.colorAlpha * pulse * 0.8})`);
                    rayGrad.addColorStop(0.3, `hsla(${rayHue}, 85%, 55%, ${ray.colorAlpha * pulse * 0.6})`);
                    rayGrad.addColorStop(0.7, `hsla(${rayHue + 15}, 80%, 35%, ${ray.colorAlpha * pulse * 0.25})`);
                    rayGrad.addColorStop(1, 'rgba(2, 9, 18, 0)');

                    ctx.fillStyle = rayGrad;
                    ctx.fill();
                });
                ctx.restore();

                // 3. Draw horizontal energy beam flare with dynamic hue
                ctx.save();
                const beamH = 160 + Math.sin(time * 2) * 25;
                const beamGrad = ctx.createLinearGradient(0, cy - beamH / 2, 0, cy + beamH / 2);
                const beamHue = Math.round(195 - scrollProg * 35);
                beamGrad.addColorStop(0, `hsla(${beamHue}, 90%, 65%, 0)`);
                beamGrad.addColorStop(0.5, `hsla(${beamHue}, 95%, 85%, ${0.45 + scrollProg * 0.1})`);
                beamGrad.addColorStop(1, `hsla(${beamHue}, 90%, 65%, 0)`);

                ctx.fillStyle = beamGrad;
                ctx.fillRect(0, cy - beamH / 2, w, beamH);
                ctx.restore();

                // 4. Center intense bright core with dynamic glow
                const coreGrad = ctx.createRadialGradient(cx, cy, 0, cx, cy, 180);
                const coreHue = Math.round(195 - scrollProg * 35);
                coreGrad.addColorStop(0, 'rgba(255, 255, 255, 0.95)');
                coreGrad.addColorStop(0.25, `hsla(${coreHue}, 85%, 80%, 0.7)`);
                coreGrad.addColorStop(0.6, `hsla(${coreHue}, 90%, 60%, 0.35)`);
                coreGrad.addColorStop(1, 'rgba(2, 9, 18, 0)');

                ctx.fillStyle = coreGrad;
                ctx.beginPath();
                ctx.arc(cx, cy, 180, 0, Math.PI * 2);
                ctx.fill();

                requestAnimationFrame(drawLightWarp);
            }

            drawLightWarp();
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPublicPage);
    } else {
        initPublicPage();
    }
</script>
@endpush
