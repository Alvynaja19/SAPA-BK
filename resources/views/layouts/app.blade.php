<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Portal Siswa : SAPA BK SMAN 4 Jember')</title>
  <meta name="description" content="Portal Konseling & Bimbingan Siswa SAPA BK SMA Negeri 4 Jember." />

  <!-- Favicon -->
  <link rel="icon" href="{{ asset('saasable/images/favicon.ico') }}" type="image/x-icon" />

  <!-- Google Fonts: Fraunces & Work Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --bg: #EDF1EC;
      --bg-alt: #E3EADD;
      --surface: #FFFFFF;
      --ink: #1B2A24;
      --ink-soft: #3B4D36;
      --ink-faint: #5A6B54;
      --primary: #24463F;
      --primary-hover: #16302B;
      --primary-soft: #DCE6DE;
      --accent: #C98A3B;
      --accent-soft: #F1DFBE;
      --accent-ink: #6B4A1B;
      --line: #D3DCCC;
      --good: #2E7D34;
      --warn: #C9603B;
      --radius-s: 8px;
      --radius-m: 14px;
      --radius-l: 16px;
      --shadow-card: 0 1px 2px rgba(27,42,36,0.06), 0 8px 18px -10px rgba(27,42,36,0.22);
    }

    * { box-sizing: border-box; }
    body {
      margin: 0;
      background: var(--bg);
      color: var(--ink);
      font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      line-height: 1.55;
      -webkit-font-smoothing: antialiased;
    }
    h1, h2, h3, h4 {
      font-family: 'Fraunces', Georgia, serif;
      font-weight: 600;
      margin: 0;
      line-height: 1.25;
      color: var(--ink);
    }
    p { margin: 0; }
    a { color: inherit; text-decoration: none; }
    ul { margin: 0; padding: 0; list-style: none; }
    button, input, textarea, select { font-family: inherit; }
    img, svg { display: block; max-width: 100%; }

    /* Buttons with standard 44px tap target */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      min-height: 44px;
      padding: 11px 22px;
      border-radius: var(--radius-s);
      font-weight: 600;
      font-size: 14.5px;
      border: 1px solid transparent;
      cursor: pointer;
      transition: background-color .15s ease, border-color .15s ease, color .15s ease, transform .12s ease;
      white-space: nowrap;
      text-align: center;
    }
    .btn-primary {
      background: var(--primary);
      color: #FFFFFF;
      box-shadow: 0 2px 6px rgba(36,70,63,0.25);
    }
    .btn-primary:hover {
      background: var(--primary-hover);
      color: #FFFFFF;
    }
    .btn-ghost {
      background: transparent;
      border-color: var(--primary);
      color: var(--primary);
    }
    .btn-ghost:hover {
      background: rgba(36,70,63,0.08);
    }
    .btn-sm {
      min-height: 38px;
      padding: 8px 16px;
      font-size: 13.5px;
    }
    .btn-block { width: 100%; }
    .btn[disabled] { opacity: .5; cursor: not-allowed; }

    /* Focus Visible Accessibility */
    a:focus-visible, button:focus-visible, input:focus-visible, textarea:focus-visible {
      outline: 3px solid var(--accent);
      outline-offset: 2px;
    }

    .card {
      background: var(--surface);
      border: 1px solid var(--line);
      border-radius: var(--radius-m);
      box-shadow: var(--shadow-card);
    }

    /* APP SHELL */
    .app-shell {
      display: flex;
      min-height: 100vh;
    }

    /* SIDEBAR */
    .sidebar {
      width: 256px;
      flex-shrink: 0;
      background: var(--primary);
      color: #E2ECE4;
      display: flex;
      flex-direction: column;
      position: sticky;
      top: 0;
      height: 100vh;
      z-index: 30;
      border-right: 1px solid rgba(255,255,255,0.08);
    }
    .side-brand {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 22px 20px 18px;
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .side-brand-mark {
      width: 36px;
      height: 36px;
      border-radius: 9px;
      background: rgba(255,255,255,0.15);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    .side-brand-mark svg {
      width: 20px;
      height: 20px;
      stroke: #FFFFFF;
    }
    .side-brand-name {
      font-family: 'Fraunces', Georgia, serif;
      font-weight: 600;
      font-size: 18px;
      color: #FFFFFF;
      letter-spacing: -0.01em;
    }
    .side-brand-sub {
      font-size: 11px;
      color: #B2C6B7;
    }

    .side-nav {
      padding: 10px 12px;
      display: flex;
      flex-direction: column;
      gap: 3px;
      flex: 1;
      overflow-y: auto;
    }
    .side-nav a {
      display: flex;
      align-items: center;
      gap: 12px;
      min-height: 44px;
      padding: 10px 14px;
      border-radius: 9px;
      font-size: 14.5px;
      font-weight: 500;
      color: #D2E4D6;
      border-left: 3px solid transparent;
      transition: background-color .15s ease, color .15s ease, border-color .15s ease;
    }
    .side-nav a svg {
      width: 19px;
      height: 19px;
      stroke: currentColor;
      flex-shrink: 0;
    }
    .side-nav a:hover {
      background: rgba(255,255,255,0.08);
      color: #FFFFFF;
    }
    .side-nav a.active {
      background: rgba(255,255,255,0.14);
      color: #FFFFFF;
      font-weight: 600;
      border-left-color: var(--accent);
    }
    .side-nav a.active svg { stroke: var(--accent); }
    .side-nav .nav-label {
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: .06em;
      color: #8CA894;
      font-weight: 700;
      padding: 16px 14px 4px;
    }

    .side-foot {
      padding: 14px 16px 18px;
      border-top: 1px solid rgba(255,255,255,0.12);
    }
    .side-user {
      display: flex;
      align-items: center;
      gap: 11px;
      padding: 6px 4px;
    }
    .side-user-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: var(--accent);
      color: #2A1C08;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 13.5px;
      flex-shrink: 0;
    }
    .side-user-name {
      font-size: 13.5px;
      color: #FFFFFF;
      font-weight: 600;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 170px;
    }
    .side-user-role {
      font-size: 11.5px;
      color: #B2C6B7;
    }
    .side-logout-btn {
      display: flex;
      align-items: center;
      gap: 10px;
      width: 100%;
      background: none;
      border: none;
      cursor: pointer;
      margin-top: 8px;
      padding: 10px 8px;
      font-size: 13.5px;
      font-weight: 500;
      color: #D2E4D6;
      border-radius: 8px;
      transition: background-color .15s ease, color .15s ease;
      text-align: left;
    }
    .side-logout-btn:hover {
      background: rgba(214,54,46,0.2);
      color: #FFFFFF;
    }
    .side-logout-btn svg {
      width: 18px;
      height: 18px;
      stroke: currentColor;
    }

    .sidebar-backdrop { display: none; }

    /* MAIN COLUMN */
    .main-col {
      flex: 1;
      display: flex;
      flex-direction: column;
      min-width: 0;
    }
    .topbar {
      height: 68px;
      flex-shrink: 0;
      background: var(--surface);
      border-bottom: 1px solid var(--line);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 28px;
      position: sticky;
      top: 0;
      z-index: 20;
    }
    .topbar-left {
      display: flex;
      align-items: center;
      gap: 14px;
    }
    .page-title {
      font-family: 'Fraunces', Georgia, serif;
      font-size: 19px;
      font-weight: 600;
      margin: 0;
      color: var(--ink);
    }
    .menu-toggle {
      display: none;
      background: none;
      border: 1px solid var(--line);
      border-radius: var(--radius-s);
      min-width: 44px;
      min-height: 44px;
      padding: 10px;
      cursor: pointer;
      align-items: center;
      justify-content: center;
    }
    .menu-toggle span {
      display: block;
      width: 20px;
      height: 2px;
      background: var(--ink);
      margin: 3px 0;
    }
    .topbar-user {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .topbar-user-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: var(--primary);
      color: #FFFFFF;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 13.5px;
    }
    .topbar-user-name {
      font-size: 14px;
      font-weight: 600;
      color: var(--ink);
    }
    .topbar-user-role {
      font-size: 12px;
      color: var(--ink-faint);
    }

    /* SAPA BK - EDITORIAL CONFIRM MODAL */
    .confirm-modal-backdrop {
      position: fixed;
      inset: 0;
      background: rgba(20, 35, 30, 0.55);
      backdrop-filter: blur(5px);
      -webkit-backdrop-filter: blur(5px);
      z-index: 99999;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      opacity: 0;
      pointer-events: none;
      transition: opacity .2s ease;
    }
    .confirm-modal-backdrop.is-open {
      opacity: 1;
      pointer-events: auto;
    }
    .confirm-modal-box {
      background: #FFFFFF;
      border: 1.5px solid var(--line);
      border-radius: 20px;
      width: 100%;
      max-width: 440px;
      box-shadow: 0 20px 40px -12px rgba(27, 42, 36, 0.35);
      overflow: hidden;
      transform: scale(0.95) translateY(8px);
      transition: transform .2s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .confirm-modal-backdrop.is-open .confirm-modal-box {
      transform: scale(1) translateY(0);
    }
    .confirm-modal-icon-wrap {
      width: 54px;
      height: 54px;
      border-radius: 50%;
      background: rgba(201, 96, 59, 0.1);
      border: 1px solid rgba(201, 96, 59, 0.25);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--warn);
      margin: 28px auto 14px;
    }
    .confirm-modal-icon-wrap svg {
      width: 24px;
      height: 24px;
      stroke: currentColor;
    }
    .confirm-modal-content {
      text-align: center;
      padding: 0 26px 22px;
    }
    .confirm-modal-title {
      font-family: 'Fraunces', serif;
      font-size: 19px;
      font-weight: 600;
      color: var(--ink);
      margin: 0 0 8px;
      line-height: 1.3;
    }
    .confirm-modal-desc {
      font-size: 13.5px;
      line-height: 1.6;
      color: var(--ink-soft);
      margin: 0;
    }
    .confirm-modal-actions {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 16px 24px;
      background: var(--bg);
      border-top: 1px solid var(--line);
    }
    .confirm-btn-cancel,
    .confirm-btn-action {
      flex: 1;
      min-height: 44px;
      padding: 10px 18px;
      border-radius: var(--radius-s);
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all .15s ease;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      border: 1px solid transparent;
      text-decoration: none;
    }
    .confirm-btn-cancel {
      background: #FFFFFF;
      border-color: var(--line);
      color: var(--ink-soft);
    }
    .confirm-btn-cancel:hover {
      background: #F3F6F1;
      color: var(--ink);
      border-color: var(--primary);
    }
    .confirm-btn-cancel:focus-visible {
      outline: 2px solid var(--primary);
      outline-offset: 2px;
    }
    .confirm-btn-action {
      background: var(--warn);
      color: #FFFFFF;
      box-shadow: 0 2px 8px rgba(201, 96, 59, 0.3);
    }
    .confirm-btn-action:hover {
      background: #B34F2C;
    }
    .confirm-btn-action:focus-visible {
      outline: 2px solid var(--warn);
      outline-offset: 2px;
    }

    .content {
      padding: 28px;
      flex: 1;
    }

    /* RESPONSIVE MOBILE */
    @media (max-width: 980px) {
      .sidebar {
        position: fixed;
        left: -270px;
        top: 0;
        bottom: 0;
        transition: left .25s ease;
        box-shadow: 20px 0 40px -20px rgba(0,0,0,0.35);
      }
      .sidebar.open { left: 0; }
      .sidebar-backdrop.open {
        display: block;
        position: fixed;
        inset: 0;
        background: rgba(27,42,36,0.4);
        backdrop-filter: blur(2px);
        z-index: 25;
      }
      .menu-toggle { display: flex; }
      .content { padding: 20px; }
      .topbar { padding: 0 18px; }
    }

    /* Alerts */
    .alert {
      padding: 14px 18px;
      border-radius: var(--radius-m);
      margin-bottom: 22px;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .alert-success {
      background: #E8F5E9;
      color: #1B5E20;
      border: 1px solid #A5D6A7;
    }
    .alert-danger {
      background: #FFEBEE;
      color: #B71C1C;
      border: 1px solid #FFCDD2;
    }
  </style>
  @stack('styles')
</head>
<body>

<div class="app-shell">

  <!-- Mobile backdrop -->
  <div class="sidebar-backdrop" id="backdrop"></div>

  <!-- SIDEBAR (sapa-bk-dashboard-siswa style) -->
  <aside class="sidebar" id="sidebar">
    <a href="{{ route('home') }}" class="side-brand">
      <div class="side-brand-mark" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 3v4M4.5 8.5 7 10M19.5 8.5 17 10M12 21v-7M6 14h12"/>
          <circle cx="12" cy="7" r="3.2"/>
        </svg>
      </div>
      <div>
        <div class="side-brand-name">SAPA BK</div>
        <div class="side-brand-sub">SMA Negeri 4 Jember</div>
      </div>
    </a>

    <nav class="side-nav">
      <!-- Dashboard -->
      <a href="{{ route('siswa.dashboard') }}" class="{{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3.5" y="3.5" width="7.5" height="7.5" rx="1.5"/>
          <rect x="13" y="3.5" width="7.5" height="7.5" rx="1.5"/>
          <rect x="3.5" y="13" width="7.5" height="7.5" rx="1.5"/>
          <rect x="13" y="13" width="7.5" height="7.5" rx="1.5"/>
        </svg>
        <span>Dashboard</span>
      </a>

      <!-- Chat SAPA -->
      <a href="{{ route('siswa.chat') }}" class="{{ request()->routeIs('siswa.chat*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M4 5.5h16v10H8l-4 3.2V5.5Z"/>
        </svg>
        <span>Chat SAPA</span>
      </a>

      <!-- Riwayat Konsultasi -->
      <a href="{{ route('siswa.riwayat') }}" class="{{ request()->routeIs('siswa.riwayat') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12.5" r="8.3"/>
          <path d="M12 7.5v5.3l3.4 2"/>
        </svg>
        <span>Riwayat Konsultasi</span>
      </a>

      <!-- E-Book -->
      <a href="{{ route('siswa.ebook') }}" class="{{ request()->routeIs('siswa.ebook') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 6.5c-2-1.3-4.6-1.7-7-1V17c2.4-.7 5-.3 7 1 2-1.3 4.6-1.7 7-1V5.5c-2.4-.7-5-.3-7 1Z"/>
          <path d="M12 6.5V18"/>
        </svg>
        <span>E-Book Bimbingan</span>
      </a>

      <!-- Kuesioner / Tes -->
      <a href="{{ route('siswa.tes') }}" class="{{ request()->routeIs('siswa.tes*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <rect x="5.5" y="4" width="13" height="17" rx="2"/>
          <path d="M9 3.5h6v2H9zM8.5 12.5l2 2 4.5-4.5"/>
        </svg>
        <span>Kuesioner &amp; Tes</span>
      </a>

      <!-- Akun Section -->
      <span class="nav-label">Akun Siswa</span>

      <!-- Profil Saya -->
      <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="8.5" r="3.3"/>
          <path d="M5 20c1-3.6 3.6-5.5 7-5.5s6 1.9 7 5.5"/>
        </svg>
        <span>Profil Saya</span>
      </a>

      <!-- Portal Publik Link -->
      <a href="{{ route('home') }}" target="_blank">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14L21 3"/>
        </svg>
        <span>Halaman Depan</span>
      </a>
    </nav>

    <!-- Sidebar Footer (User Info & Logout) -->
    <div class="side-foot">
      <div class="side-user">
        <div class="side-user-avatar">
          {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
        </div>
        <div>
          <div class="side-user-name">{{ auth()->user()->name }}</div>
          <div class="side-user-role">{{ auth()->user()->kelas ?? 'Siswa' }} &bull; SMAN 4</div>
        </div>
      </div>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="side-logout-btn">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/>
          </svg>
          <span>Keluar</span>
        </button>
      </form>
    </div>
  </aside>

  <!-- MAIN COLUMN -->
  <div class="main-col">
    <header class="topbar">
      <div class="topbar-left">
        <button class="menu-toggle" id="menuToggle" aria-label="Buka menu navigasi">
          <span></span><span></span><span></span>
        </button>
        <h1 class="page-title">@yield('page_title', 'Dashboard')</h1>
      </div>
      <div class="topbar-user">
        <div style="text-align: right;">
          <div class="topbar-user-name">{{ auth()->user()->name }}</div>
          <div class="topbar-user-role">NISN: {{ auth()->user()->nisn ?? '-' }}</div>
        </div>
        <div class="topbar-user-avatar">
          {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
        </div>
      </div>
    </header>

    <main class="content">
      <!-- Session Alerts -->
      @if(session('success'))
        <div class="alert alert-success">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
          <div>{{ session('success') }}</div>
        </div>
      @endif

      @if(isset($errors) && $errors->any())
        <div class="alert alert-danger">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
          <div>
            @foreach($errors->all() as $err)
              <div>{{ $err }}</div>
            @endforeach
          </div>
        </div>
      @endif

      @yield('content')
    </main>
  </div>

</div>

<!-- SAPA BK CUSTOM CONFIRM MODAL -->
<div id="customConfirmModal" class="confirm-modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="confirmModalTitle" aria-describedby="confirmModalDesc">
  <div class="confirm-modal-box">
    <div class="confirm-modal-icon-wrap" id="confirmModalIcon">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="3 6 5 6 21 6"></polyline>
        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
        <line x1="10" y1="11" x2="10" y2="17"></line>
        <line x1="14" y1="11" x2="14" y2="17"></line>
      </svg>
    </div>
    <div class="confirm-modal-content">
      <h3 id="confirmModalTitle" class="confirm-modal-title">Hapus Arsip Percakapan AI?</h3>
      <p id="confirmModalDesc" class="confirm-modal-desc">Seluruh riwayat obrolan dan respons asisten pada sesi ini akan dihapus secara permanen dari akun Anda.</p>
    </div>
    <div class="confirm-modal-actions">
      <button type="button" id="confirmModalCancelBtn" class="confirm-btn-cancel">Batal</button>
      <button type="button" id="confirmModalActionBtn" class="confirm-btn-action">Hapus Percakapan</button>
    </div>
  </div>
</div>

<!-- Drawer toggle & Global Modal scripts -->
<script>
  (function(){
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('backdrop');
    const menuToggle = document.getElementById('menuToggle');
    if(menuToggle && sidebar && backdrop){
      menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        backdrop.classList.toggle('open');
      });
      backdrop.addEventListener('click', () => {
        sidebar.classList.remove('open');
        backdrop.classList.remove('open');
      });
    }
  })();

  window.showConfirmModal = function(options) {
    const modal = document.getElementById('customConfirmModal');
    const titleEl = document.getElementById('confirmModalTitle');
    const descEl = document.getElementById('confirmModalDesc');
    const cancelBtn = document.getElementById('confirmModalCancelBtn');
    const actionBtn = document.getElementById('confirmModalActionBtn');

    if (!modal) {
      if (options.onConfirm) options.onConfirm();
      return;
    }

    titleEl.innerText = options.title || 'Konfirmasi Tindakan';
    descEl.innerText = options.message || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
    cancelBtn.innerText = options.cancelText || 'Batal';
    actionBtn.innerText = options.confirmText || 'Lanjutkan';

    modal.classList.add('is-open');
    cancelBtn.focus();

    function closeModal() {
      modal.classList.remove('is-open');
      cleanup();
    }

    function handleAction() {
      closeModal();
      if (typeof options.onConfirm === 'function') {
        options.onConfirm();
      }
    }

    function handleKeydown(e) {
      if (e.key === 'Escape') {
        closeModal();
      }
    }

    function handleBackdropClick(e) {
      if (e.target === modal) {
        closeModal();
      }
    }

    function cleanup() {
      cancelBtn.removeEventListener('click', closeModal);
      actionBtn.removeEventListener('click', handleAction);
      document.removeEventListener('keydown', handleKeydown);
      modal.removeEventListener('click', handleBackdropClick);
    }

    cancelBtn.addEventListener('click', closeModal);
    actionBtn.addEventListener('click', handleAction);
    document.addEventListener('keydown', handleKeydown);
    modal.addEventListener('click', handleBackdropClick);
  };
</script>
@stack('scripts')
</body>
</html>
