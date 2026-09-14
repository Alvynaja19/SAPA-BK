<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'SAPA BK : Portal Bimbingan & Konseling SMA Negeri 4 Jember')</title>
  <meta name="description" content="@yield('meta_description', 'Portal Bimbingan & Konseling Digital SMA Negeri 4 Jember. Ruang aman dan terpercaya bagi siswa untuk berkonsultasi, mengakses materi bimbingan, dan terhubung dengan Guru BK.')" />

  <!-- Fonts & Typography -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --bg: #FBF8EA;
      --bg-alt: #F7EDC2;
      --surface: #FFFFFF;
      --ink: #1C2B18;
      --ink-soft: #3B4D36;
      --ink-faint: #5A6B54;
      --primary: #2E7D34;
      --primary-hover: #205A26;
      --accent: #F4B400;
      --accent-hover: #D89E00;
      --accent-soft: #FBE9AE;
      --accent-ink: #614000;
      --red: #D6362E;
      --red-soft: #FADBD8;
      --blue: #1C6EB4;
      --blue-soft: #D9E9F6;
      --line: #DFD396;
      --radius-s: 8px;
      --radius-m: 14px;
      --radius-l: 22px;
      --shadow-card: 0 1px 2px rgba(28,43,24,0.06), 0 10px 24px -12px rgba(28,43,24,0.22);
      --maxw: 1180px;
    }

    * { box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body {
      margin: 0;
      background: var(--bg);
      color: var(--ink);
      font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    h1, h2, h3, h4, h5, h6 {
      font-family: 'Fraunces', Georgia, serif;
      font-weight: 600;
      line-height: 1.25;
      margin: 0;
      color: var(--ink);
    }
    p { margin: 0; }
    a { color: inherit; text-decoration: none; }
    img, svg { display: block; max-width: 100%; }
    ul { margin: 0; padding: 0; list-style: none; }
    button { font-family: inherit; cursor: pointer; }

    .wrap {
      max-width: var(--maxw);
      margin: 0 auto;
      padding: 0 28px;
      width: 100%;
    }
    main {
      flex: 1;
    }
    section.page-section {
      padding: 64px 0 88px;
    }
    @media (max-width: 768px) {
      section.page-section { padding: 40px 0 64px; }
      .wrap { padding: 0 20px; }
    }

    /* Page Header */
    .page-header {
      text-align: center;
      max-width: 720px;
      margin: 0 auto 52px;
    }
    .badge-pill {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 14px;
      border-radius: 999px;
      background: var(--accent-soft);
      color: var(--accent-ink);
      font-size: 12.5px;
      font-weight: 600;
      letter-spacing: 0.04em;
      text-transform: uppercase;
      margin-bottom: 16px;
      border: 1px solid rgba(244,180,0,0.35);
    }
    .page-title {
      font-size: clamp(30px, 4.2vw, 46px);
      letter-spacing: -0.015em;
      color: var(--ink);
      margin-bottom: 14px;
    }
    .page-lede {
      font-size: 16px;
      color: var(--ink-soft);
      line-height: 1.6;
    }

    /* Standard Buttons (Min 44px tap targets) */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      min-height: 44px;
      padding: 12px 24px;
      border-radius: var(--radius-s);
      font-weight: 600;
      font-size: 15px;
      border: 1px solid transparent;
      transition: background-color .18s ease, color .18s ease, border-color .18s ease, box-shadow .18s ease, transform .15s ease;
      text-align: center;
      cursor: pointer;
    }
    .btn:active { transform: translateY(1px); }
    .btn-primary {
      background: var(--primary);
      color: #FFFFFF;
      box-shadow: 0 2px 6px rgba(46,125,52,0.25);
    }
    .btn-primary:hover {
      background: var(--primary-hover);
      color: #FFFFFF;
    }
    .btn-primary:focus-visible {
      outline: 3px solid var(--accent);
      outline-offset: 2px;
    }
    .btn-ghost {
      background: transparent;
      color: var(--primary);
      border-color: var(--primary);
    }
    .btn-ghost:hover {
      background: rgba(46,125,52,0.06);
      border-color: var(--primary-hover);
    }
    .btn-ghost:focus-visible {
      outline: 3px solid var(--accent);
      outline-offset: 2px;
    }
    .btn-sm {
      min-height: 38px;
      padding: 8px 16px;
      font-size: 13.5px;
    }
    .btn-accent {
      background: var(--accent);
      color: #2A1C08;
    }
    .btn-accent:hover {
      background: var(--accent-hover);
    }

    /* Focus Visible Standard */
    a:focus-visible, button:focus-visible, input:focus-visible, summary:focus-visible {
      outline: 3px solid var(--accent);
      outline-offset: 2px;
    }

    /* NAVBAR */
    header.nav {
      position: sticky;
      top: 0;
      z-index: 40;
      background: rgba(251,248,234,0.96);
      backdrop-filter: blur(8px);
      border-bottom: 1px solid var(--line);
    }
    .nav-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      min-height: 68px;
    }
    .brand {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .brand-mark {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      background: var(--primary);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    .brand-name {
      font-family: 'Fraunces', Georgia, serif;
      font-weight: 700;
      font-size: 20px;
      letter-spacing: -0.01em;
      color: var(--ink);
    }
    .brand-sub {
      font-size: 11.5px;
      color: var(--ink-faint);
      font-weight: 500;
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 26px;
    }
    .nav-links a {
      font-size: 14.5px;
      font-weight: 500;
      color: var(--ink-soft);
      padding: 8px 4px;
      position: relative;
      transition: color .15s ease;
    }
    .nav-links a:hover {
      color: var(--primary);
    }
    .nav-links a.active {
      color: var(--primary);
      font-weight: 700;
    }
    .nav-links a.active::after {
      content: "";
      position: absolute;
      bottom: 0;
      left: 4px;
      right: 4px;
      height: 2px;
      background: var(--primary);
      border-radius: 2px;
    }

    .nav-actions {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .nav-actions a.login {
      font-size: 14.5px;
      font-weight: 600;
      color: var(--primary);
      padding: 10px 14px;
      min-height: 44px;
      display: inline-flex;
      align-items: center;
    }
    .nav-actions a.login:hover {
      color: var(--primary-hover);
    }

    .nav-toggle {
      display: none;
      background: none;
      border: 1px solid var(--line);
      border-radius: var(--radius-s);
      min-width: 44px;
      min-height: 44px;
      padding: 10px;
      align-items: center;
      justify-content: center;
    }
    .nav-toggle span {
      display: block;
      width: 22px;
      height: 2px;
      background: var(--ink);
      margin: 4px 0;
      transition: transform .2s ease;
    }

    @media (max-width: 920px) {
      .nav-links {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        flex-direction: column;
        align-items: stretch;
        gap: 0;
        background: var(--surface);
        border-bottom: 1px solid var(--line);
        max-height: 0;
        overflow: hidden;
        transition: max-height .28s ease;
        box-shadow: 0 12px 24px -10px rgba(0,0,0,0.15);
      }
      .nav-links.open { max-height: 400px; }
      .nav-links a {
        min-height: 48px;
        display: flex;
        align-items: center;
        padding: 12px 24px;
        border-top: 1px solid var(--line);
        font-size: 15.5px;
      }
      .nav-links a.active::after { display: none; }
      .nav-toggle { display: flex; }
      .nav-actions .login { display: none; }
    }

    /* CARD COMPONENTS */
    /* E-Book Cards */
    .ebook-row {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 28px;
    }
    @media (max-width: 990px) { .ebook-row { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px) { .ebook-row { grid-template-columns: 1fr; } }
    .ebook-card {
      display: flex;
      flex-direction: column;
      gap: 14px;
      background: var(--surface);
      border: 1px solid var(--line);
      border-radius: var(--radius-m);
      padding: 18px;
      transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }
    .ebook-card:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow-card);
      border-color: var(--primary);
    }
    .ebook-cover {
      aspect-ratio: 3/4;
      border-radius: 8px;
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      padding: 20px;
      position: relative;
      overflow: hidden;
      background: linear-gradient(145deg, var(--primary), #1B5E20);
      color: #FFFFFF;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .ebook-cover.alt-color-1 { background: linear-gradient(145deg, #2E7D34, #1B5E20); }
    .ebook-cover.alt-color-2 { background: linear-gradient(145deg, #0277BD, #01579B); }
    .ebook-cover.alt-color-3 { background: linear-gradient(145deg, #D65A15, #BF360C); }
    .ebook-cover.alt-color-4 { background: linear-gradient(145deg, #4527A0, #311B92); }
    .ebook-cover::after {
      content: "";
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 8px;
      background: rgba(0,0,0,0.22);
    }
    .ebook-cover span {
      font-family: 'Fraunces', Georgia, serif;
      font-weight: 600;
      font-size: 17px;
      line-height: 1.3;
      z-index: 1;
    }
    .ebook-cover .ebook-badge {
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      opacity: 0.9;
      margin-bottom: 8px;
      z-index: 1;
    }
    .ebook-meta {
      font-size: 13.5px;
      color: var(--ink-faint);
    }
    .ebook-meta strong {
      color: var(--ink);
      display: block;
      font-size: 16px;
      font-weight: 600;
      margin-bottom: 4px;
      line-height: 1.35;
    }
    .ebook-meta p {
      font-size: 13px;
      color: var(--ink-soft);
      line-height: 1.5;
      margin-top: 6px;
    }

    /* Article Cards */
    .article-row {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 26px;
    }
    @media (max-width: 900px) { .article-row { grid-template-columns: 1fr; } }
    .article-card {
      background: var(--surface);
      border-radius: var(--radius-m);
      overflow: hidden;
      border: 1px solid var(--line);
      display: flex;
      flex-direction: column;
      transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }
    .article-card:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow-card);
      border-color: var(--primary);
    }
    .article-thumb {
      height: 150px;
      background: linear-gradient(135deg, rgba(46,125,52,0.9), rgba(28,110,180,0.85)),
                  radial-gradient(circle at top left, var(--accent), transparent);
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #FFFFFF;
    }
    .article-thumb svg {
      width: 48px;
      height: 48px;
      opacity: 0.45;
    }
    .article-card .abody {
      padding: 22px;
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .article-card h3 {
      font-size: 18px;
      margin-bottom: 8px;
      line-height: 1.35;
    }
    .article-card h3 a:hover {
      color: var(--primary);
    }
    .article-card p {
      font-size: 14px;
      color: var(--ink-soft);
      line-height: 1.55;
    }
    .article-card .ameta {
      margin-top: 20px;
      padding-top: 14px;
      border-top: 1px solid var(--line);
      font-size: 12.5px;
      color: var(--ink-faint);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    /* FAQ Component */
    .faq-list {
      max-width: 820px;
      margin: 0 auto;
      border-top: 1px solid var(--line);
    }
    details {
      border-bottom: 1px solid var(--line);
      padding: 22px 0;
    }
    summary {
      cursor: pointer;
      list-style: none;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: 600;
      font-size: 17px;
      gap: 16px;
      min-height: 44px;
      color: var(--ink);
    }
    summary::-webkit-details-marker { display: none; }
    summary .plus {
      font-size: 24px;
      color: var(--primary);
      flex-shrink: 0;
      transition: transform .2s ease;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 32px;
      height: 32px;
    }
    details[open] summary .plus { transform: rotate(45deg); }
    details .faq-answer {
      margin-top: 14px;
      color: var(--ink-soft);
      font-size: 15px;
      line-height: 1.65;
    }

    /* Help Banner */
    .help-banner {
      background: var(--surface);
      border: 1px solid var(--line);
      border-radius: var(--radius-m);
      padding: 36px 28px;
      text-align: center;
      margin-top: 48px;
      box-shadow: var(--shadow-card);
    }
    .help-banner h3 {
      font-size: 22px;
      margin-bottom: 10px;
    }
    .help-banner p {
      color: var(--ink-soft);
      font-size: 15px;
      max-width: 560px;
      margin: 0 auto 20px;
    }

    /* Pagination Styling */
    .pagination-wrap {
      margin-top: 48px;
      display: flex;
      justify-content: center;
    }
    .pagination-wrap nav svg {
      width: 20px;
      height: 20px;
      display: inline;
    }

    /* FOOTER */
    footer {
      background: var(--primary);
      color: #E2ECE4;
      padding: 56px 0 28px;
      margin-top: auto;
    }
    .foot-row {
      display: flex;
      justify-content: space-between;
      gap: 40px;
      flex-wrap: wrap;
    }
    footer h4 {
      color: #FFFFFF;
      font-size: 16px;
      margin-bottom: 14px;
      font-family: 'Work Sans', sans-serif;
      font-weight: 600;
    }
    footer .brand-name { color: #FFFFFF; }
    .foot-col { flex: 1; min-width: 200px; }
    .foot-col.brand-col { flex: 1.5; min-width: 280px; }
    .foot-col a {
      display: inline-flex;
      align-items: center;
      color: #C9D8CD;
      font-size: 14.5px;
      padding: 6px 0;
      min-height: 38px;
      transition: color .15s ease;
    }
    .foot-col a:hover { color: #FFFFFF; }
    .foot-bottom {
      margin-top: 44px;
      padding-top: 22px;
      border-top: 1px solid rgba(255,255,255,0.18);
      font-size: 13px;
      color: #B2C6B7;
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 10px;
    }

    /* FLOATING CHATBOT WIDGET */
    .fab {
      position: fixed;
      right: 24px;
      bottom: 24px;
      z-index: 60;
      width: 56px;
      height: 56px;
      border-radius: 50%;
      background: var(--accent);
      border: 1px solid rgba(0,0,0,0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 10px 24px -8px rgba(0,0,0,0.35);
      cursor: pointer;
      transition: transform .18s ease;
    }
    .fab:hover { transform: scale(1.06); }
    .fab svg {
      width: 26px;
      height: 26px;
      stroke: #2A1C08;
    }
    .fab .fabdot {
      position: absolute;
      top: 4px;
      right: 4px;
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: #2E7D34;
      border: 2px solid var(--surface);
    }

    .widget-panel {
      position: fixed;
      right: 24px;
      bottom: 92px;
      z-index: 60;
      width: 350px;
      max-width: calc(100vw - 32px);
      background: var(--surface);
      border-radius: var(--radius-m);
      border: 1px solid var(--line);
      box-shadow: 0 20px 45px -16px rgba(0,0,0,0.35);
      overflow: hidden;
      transform: translateY(12px) scale(0.98);
      opacity: 0;
      pointer-events: none;
      transition: opacity .18s ease, transform .18s ease;
    }
    .widget-panel.open {
      opacity: 1;
      transform: translateY(0) scale(1);
      pointer-events: auto;
    }
    .widget-head {
      background: var(--primary);
      color: #FFFFFF;
      padding: 16px 18px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .widget-head .who {
      font-weight: 600;
      font-size: 15px;
    }
    .widget-head .hours {
      font-size: 12px;
      color: #D2E4D6;
      margin-top: 2px;
    }
    .widget-close {
      background: none;
      border: none;
      color: #FFFFFF;
      font-size: 20px;
      line-height: 1;
      cursor: pointer;
      padding: 6px;
      min-width: 36px;
      min-height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 4px;
    }
    .widget-close:hover {
      background: rgba(255,255,255,0.15);
    }
    .widget-body {
      padding: 16px;
      background: #F8FAF6;
      display: flex;
      flex-direction: column;
      gap: 12px;
      max-height: 280px;
      overflow-y: auto;
    }
    .widget-notice {
      font-size: 12.5px;
      background: var(--accent-soft);
      color: var(--accent-ink);
      padding: 10px 12px;
      border-radius: 8px;
      line-height: 1.45;
      border: 1px solid rgba(244,180,0,0.3);
    }
    .widget-body .bubble.bot {
      background: var(--surface);
      color: var(--ink);
      border: 1px solid var(--line);
      border-radius: var(--radius-s);
      padding: 12px 14px;
      font-size: 13.5px;
      line-height: 1.5;
    }
    .widget-foot {
      padding: 12px 14px;
      border-top: 1px solid var(--line);
      display: flex;
      gap: 8px;
      background: var(--surface);
    }
    .widget-foot input {
      flex: 1;
      min-height: 44px;
      border: 1px solid var(--line);
      border-radius: 999px;
      padding: 9px 16px;
      font-size: 14px;
      font-family: inherit;
      background: var(--bg);
      color: var(--ink);
    }
    .widget-foot input:focus {
      outline: 2px solid var(--accent);
      outline-offset: 1px;
    }
    .widget-foot button {
      min-width: 44px;
      min-height: 44px;
      border-radius: 50%;
      background: var(--accent);
      border: none;
      flex-shrink: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #2A1C08;
    }
    .widget-foot button:hover {
      background: var(--accent-hover);
    }

    @media (prefers-reduced-motion: reduce) {
      html { scroll-behavior: auto; }
      .widget-panel, .nav-links, summary .plus, .ebook-card, .article-card {
        transition: none !important;
      }
    }
  </style>

  @stack('styles')
</head>
<body>

  <!-- NAVBAR -->
  <header class="nav">
    <div class="wrap nav-row">
      <div class="brand">
        <div class="brand-mark" aria-hidden="true">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 3v4M4.5 8.5 7 10M19.5 8.5 17 10M12 21v-7M6 14h12"/>
            <circle cx="12" cy="7" r="3.2"/>
          </svg>
        </div>
        <div>
          <a href="{{ route('home') }}" class="brand-name">SAPA BK</a>
          <div class="brand-sub">SMA Negeri 4 Jember</div>
        </div>
      </div>

      <nav class="nav-links" id="navLinks" aria-label="Navigasi Utama">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">Tentang Layanan</a>
        <a href="{{ route('ebook.index') }}" class="{{ request()->routeIs('ebook.*') ? 'active' : '' }}">Katalog E-Book</a>
        <a href="{{ route('article.index') }}" class="{{ request()->routeIs('article.*') ? 'active' : '' }}">Artikel &amp; Tips</a>
        <a href="{{ route('faq') }}" class="{{ request()->routeIs('faq') ? 'active' : '' }}">Pusat Bantuan</a>
      </nav>

      <div class="nav-actions">
        @auth
          @php
            $dashUrl = match(auth()->user()->role) {
              'admin' => route('admin.dashboard'),
              'guru_bk' => route('bk.dashboard'),
              default => route('siswa.dashboard'),
            };
          @endphp
          <a class="login" href="{{ $dashUrl }}">Dashboard Saya</a>
          <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-ghost btn-sm">Keluar</button>
          </form>
        @else
          <a class="login" href="{{ route('login') }}">Masuk</a>
          <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Daftar Akun</a>
        @endauth

        <button class="nav-toggle" id="navToggle" aria-label="Buka menu navigasi" aria-expanded="false">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
    </div>
  </header>

  <!-- MAIN CONTENT -->
  <main id="mainContent">
    @yield('content')
  </main>

  <!-- FOOTER -->
  <footer>
    <div class="wrap">
      <div class="foot-row">
        <div class="foot-col brand-col">
          <div class="brand" style="margin-bottom: 14px;">
            <div class="brand-mark" style="background: rgba(255,255,255,0.15);" aria-hidden="true">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 3v4M4.5 8.5 7 10M19.5 8.5 17 10M12 21v-7M6 14h12"/>
                <circle cx="12" cy="7" r="3.2"/>
              </svg>
            </div>
            <div>
              <div class="brand-name">SAPA BK</div>
              <div class="brand-sub" style="color: #C9D8CD;">SMA Negeri 4 Jember</div>
            </div>
          </div>
          <p style="font-size: 14px; line-height: 1.6; color: #D2E4D6; max-width: 360px;">
            Sistem Asisten Pendamping Akademik &amp; Konseling Terpadu SMA Negeri 4 Jember. Ruang aman bagi siswa untuk berkonsultasi, berliterasi, dan merencanakan masa depan.
          </p>
        </div>
        <div class="foot-col">
          <h4>Jelajahi Portal</h4>
          <a href="{{ route('home') }}">Beranda</a>
          <a href="{{ route('about') }}">Tentang Layanan BK</a>
          <a href="{{ route('ebook.index') }}">Katalog E-Book</a>
          <a href="{{ route('article.index') }}">Artikel &amp; Tips</a>
          <a href="{{ route('faq') }}">Tanya Jawab (FAQ)</a>
        </div>
        <div class="foot-col">
          <h4>Akun Siswa</h4>
          @auth
            @php
              $footDash = match(auth()->user()->role) {
                'admin' => route('admin.dashboard'),
                'guru_bk' => route('bk.dashboard'),
                default => route('siswa.dashboard'),
              };
            @endphp
            <a href="{{ $footDash }}">Dashboard Saya</a>
            <a href="{{ route('profile') }}">Profil Siswa</a>
          @else
            <a href="{{ route('login') }}">Masuk Akun</a>
            <a href="{{ route('register') }}">Pendaftaran Akun</a>
          @endauth
        </div>
        <div class="foot-col">
          <h4>Kontak Sekolah</h4>
          <a href="https://maps.google.com/?q=SMA+Negeri+4+Jember" target="_blank" rel="noopener noreferrer">Ruang BK, SMAN 4 Jember</a>
          <a href="mailto:bk@sman4jember.sch.id">bk@sman4jember.sch.id</a>
          <a href="{{ route('about') }}">Profil Konselor BK</a>
        </div>
      </div>
      <div class="foot-bottom">
        <span>&copy; {{ date('Y') }} SAPA BK : SMA Negeri 4 Jember. Hak Cipta Dilindungi.</span>
        <span>Layanan Bimbingan &amp; Konseling Digital</span>
      </div>
    </div>
  </footer>

  <!-- FLOATING CHATBOT WIDGET -->
  <button class="fab" id="fabBtn" aria-label="Buka Asisten Konseling SAPA" aria-expanded="false">
    <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <path d="M4 5.5h16v10H8l-4 3.2V5.5Z"/>
    </svg>
    <span class="fabdot" aria-hidden="true"></span>
  </button>

  <div class="widget-panel" id="widgetPanel" role="dialog" aria-label="Jendela Konseling SAPA" aria-modal="false">
    <div class="widget-head">
      <div>
        <div class="who">SAPA : Asisten BK</div>
        <div class="hours">Live chat Guru BK: 08.00 - 15.00 WIB</div>
      </div>
      <button class="widget-close" id="closeWidgetBtn" aria-label="Tutup jendela chat">&times;</button>
    </div>
    <div class="widget-body">
      @guest
        <div class="widget-notice">
          Kamu sedang dalam mode tamu. Silakan masuk dengan akun siswa untuk menyimpan riwayat sesi konseling dan terhubung langsung ke Guru BK.
        </div>
      @endguest
      <div class="bubble bot">
        Halo! Ada hal yang sedang kamu pikirkan seputar belajar atau masa depan? Ceritakan saja, kami siap mendengarkan.
      </div>
    </div>
    <form action="{{ auth()->check() ? route('siswa.chat') : route('login') }}" method="GET" class="widget-foot">
      <input 
        type="text" 
        name="{{ auth()->check() ? 'q' : 'initial_query' }}" 
        placeholder="Ketik pertanyaanmu di sini..." 
        aria-label="Tulis pertanyaan untuk asisten BK" 
        required
      />
      <button type="submit" aria-label="Kirim pertanyaan">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M4 12h15M13 6l6 6-6 6"/>
        </svg>
      </button>
    </form>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('js/landing.js') }}" defer></script>
  @stack('scripts')
</body>
</html>
