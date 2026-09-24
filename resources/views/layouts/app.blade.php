<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Portal Siswa : SAPA BK SMAN 4 Jember')</title>
  <meta name="description" content="Portal Konseling & Bimbingan Siswa SAPA BK SMA Negeri 4 Jember." />

  <!-- Favicon -->
  <link rel="icon" href="{{ asset('images/logo-sman4.png') }}" type="image/png" />

  <!-- Google Fonts: Fraunces & Work Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --bg: #F8FAF8;
      --bg-alt: #EEF4ED;
      --surface: #FFFFFF;
      --ink: #0F1D13;
      --ink-soft: #2D4033;
      --ink-faint: #526658;
      --primary: #15803D;
      --primary-hover: #166534;
      --primary-soft: #DCFCE7;
      --accent: #D97706;
      --accent-soft: #FEF3C7;
      --accent-ink: #78350F;
      --line: #E2E8DF;
      --good: #16A34A;
      --warn: #D97706;
      --radius-s: 8px;
      --radius-m: 14px;
      --radius-l: 16px;
      --shadow-card: 0 1px 3px rgba(15,29,19,0.05), 0 8px 20px -8px rgba(15,29,19,0.1);
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
      box-shadow: 0 2px 6px rgba(21,128,61,0.25);
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
      background: rgba(21,128,61,0.08);
    }
    .btn-sm {
      min-height: 38px;
      padding: 8px 16px;
      font-size: 13.5px;
    }
    .btn-block { width: 100%; }
    .btn[disabled] { opacity: .5; cursor: not-allowed; }

    /* Focus Visible Accessibility */
    a:focus-visible, button:focus-visible {
      outline: 3px solid var(--accent);
      outline-offset: 2px;
    }
    input:focus, textarea:focus, select:focus,
    input:focus-visible, textarea:focus-visible, select:focus-visible {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.18);
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
    .side-brand-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
      padding: 18px 16px 16px;
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .side-brand {
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
      flex: 1;
      min-width: 0;
    }
    .side-close-btn {
      display: none;
      width: 38px;
      height: 38px;
      border-radius: 8px;
      background: rgba(255,255,255,0.12);
      border: none;
      color: #FFFFFF;
      cursor: pointer;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      transition: background-color .15s ease;
    }
    .side-close-btn:hover {
      background: rgba(255,255,255,0.22);
    }
    .side-close-btn svg {
      width: 20px;
      height: 20px;
      stroke: #FFFFFF;
    }
    .side-brand-mark {
      width: 46px;
      height: 46px;
      border-radius: 10px;
      background: transparent;
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
      overflow: hidden;
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
      text-decoration: none;
      flex-shrink: 0;
      overflow: hidden;
      transition: transform .12s ease;
    }
    .topbar-user-avatar:hover {
      transform: scale(1.05);
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
    .confirm-btn-action.btn-action-primary {
      background: var(--primary);
      box-shadow: 0 2px 8px rgba(21, 128, 61, 0.3);
    }
    .confirm-btn-action.btn-action-primary:hover {
      background: var(--primary-hover);
    }
    .confirm-btn-action.btn-action-info {
      background: #2563EB;
      box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
    }
    .confirm-btn-action.btn-action-info:hover {
      background: #1D4ED8;
    }

    /* Toast Notification System */
    .app-toast-container {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 999999;
      display: flex;
      flex-direction: column;
      gap: 10px;
      max-width: 380px;
      width: calc(100% - 40px);
      pointer-events: none;
    }
    .app-toast-item {
      pointer-events: auto;
      display: flex;
      align-items: flex-start;
      gap: 12px;
      padding: 13px 16px;
      border-radius: 16px;
      background: #FFFFFF;
      border: 1.5px solid var(--line);
      box-shadow: 0 12px 30px -8px rgba(27, 42, 36, 0.22);
      transition: all .25s cubic-bezier(0.16, 1, 0.3, 1);
      transform: translateY(-8px);
      opacity: 0;
      font-size: 13.5px;
      line-height: 1.5;
      color: var(--ink);
    }
    .app-toast-item.is-visible {
      transform: translateY(0);
      opacity: 1;
    }
    .app-toast-item.toast-success {
      border-color: rgba(22, 101, 52, 0.3);
      background: #F0FDF4;
      color: #14532D;
    }
    .app-toast-item.toast-error,
    .app-toast-item.toast-danger {
      border-color: rgba(185, 28, 28, 0.3);
      background: #FEF2F2;
      color: #7F1D1D;
    }
    .app-toast-item.toast-warning {
      border-color: rgba(180, 83, 9, 0.3);
      background: #FFFBEB;
      color: #78350F;
    }
    .app-toast-item.toast-info {
      border-color: rgba(29, 78, 216, 0.3);
      background: #EFF6FF;
      color: #1E3A8A;
    }
    .app-toast-close {
      background: none;
      border: none;
      cursor: pointer;
      padding: 2px;
      color: inherit;
      opacity: 0.6;
      margin-left: auto;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: opacity .15s ease;
      min-width: 24px;
      min-height: 24px;
    }
    .app-toast-close:hover {
      opacity: 1;
    }

    .content {
      padding: 28px;
      flex: 1;
    }

    /* RESPONSIVE MOBILE & BOTTOM NAV */
    .mobile-bottom-nav {
      display: none;
    }

    @media (max-width: 980px) {
      .sidebar {
        position: fixed;
        left: -300px;
        top: 0;
        bottom: 0;
        width: 280px;
        max-width: 85vw;
        transition: left .25s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 20px 0 40px -20px rgba(0,0,0,0.45);
        z-index: 100;
      }
      .sidebar.open { left: 0; }
      .side-close-btn { display: inline-flex; }
      .sidebar-backdrop.open {
        display: block;
        position: fixed;
        inset: 0;
        background: rgba(27,42,36,0.55);
        backdrop-filter: blur(3px);
        -webkit-backdrop-filter: blur(3px);
        z-index: 99;
      }
      .menu-toggle { display: flex; }
      .content { padding: 20px; }
      .topbar { padding: 0 16px; }
    }

    @media (max-width: 768px) {
      /* Mobile Bottom Navigation Bar */
      .mobile-bottom-nav {
        display: flex;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 64px;
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-top: 1px solid var(--line);
        z-index: 40;
        justify-content: space-around;
        align-items: center;
        padding: 6px 8px calc(6px + env(safe-area-inset-bottom, 0px));
        box-shadow: 0 -4px 16px rgba(15, 29, 19, 0.05);
      }
      .mobile-nav-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 3px;
        color: var(--ink-faint);
        text-decoration: none;
        font-size: 11px;
        font-weight: 600;
        min-width: 54px;
        min-height: 48px;
        padding: 4px;
        border-radius: var(--radius-s);
        transition: color .15s ease, transform .12s ease;
      }
      .mobile-nav-link svg {
        width: 20px;
        height: 20px;
        stroke: currentColor;
        transition: stroke .15s ease;
      }
      .mobile-nav-link:active {
        transform: scale(0.95);
      }
      .mobile-nav-link.active {
        color: var(--primary);
      }
      .mobile-nav-link.active svg {
        stroke: var(--primary);
      }
      
      /* Reserve safe padding at content bottom so bottom nav never covers content */
      .content {
        padding: 16px 14px calc(84px + env(safe-area-inset-bottom, 0px)) !important;
      }
      .topbar {
        height: 58px;
        padding: 0 14px;
        gap: 12px;
      }
      .topbar-left {
        flex: 1;
        min-width: 0;
      }
      .page-title {
        font-size: 16px;
        min-width: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }
      .topbar-user-text {
        display: none !important;
      }
      .confirm-modal-box {
        max-width: 92vw;
        border-radius: 16px;
      }
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
    <div class="side-brand-header">
      <a href="{{ route('home') }}" class="side-brand">
        <div class="side-brand-mark" aria-hidden="true" style="background: transparent; overflow: hidden; width: 46px; height: 46px;">
          <img src="{{ asset('images/logo-sman4.png') }}" alt="Logo SMAN 4 Jember" style="width: 46px; height: 46px; object-fit: contain; filter: drop-shadow(0 1px 3px rgba(0,0,0,0.25));" />
        </div>
        <div>
          <div class="side-brand-name">SAPA BK</div>
          <div class="side-brand-sub">SMA Negeri 4 Jember</div>
        </div>
      </a>
      <button type="button" class="side-close-btn" id="sideCloseBtn" aria-label="Tutup menu navigasi">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
    </div>

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
          @if(auth()->user()->avatar)
            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" style="width: 100%; height: 100%; object-fit: cover;">
          @else
            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
          @endif
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
        <div class="topbar-user-text" style="text-align: right;">
          <div class="topbar-user-name">{{ auth()->user()->name }}</div>
          <div class="topbar-user-role">
            @if(auth()->user()->nis && auth()->user()->nisn)
              NIS: {{ auth()->user()->nis }} &bull; NISN: {{ auth()->user()->nisn }}
            @elseif(auth()->user()->nis)
              NIS: {{ auth()->user()->nis }}
            @else
              NISN: {{ auth()->user()->nisn ?? '-' }}
            @endif
          </div>
        </div>
        <a href="{{ route('profile') }}" class="topbar-user-avatar" title="Lihat Profil Saya" aria-label="Profil Siswa">
          @if(auth()->user()->avatar)
            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" style="width: 100%; height: 100%; object-fit: cover;">
          @else
            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
          @endif
        </a>
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

    <!-- MOBILE BOTTOM NAVIGATION (Siswa Quick Access) -->
    <nav class="mobile-bottom-nav" aria-label="Navigasi Cepat Siswa">
      <a href="{{ route('siswa.dashboard') }}" class="mobile-nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <rect x="3" y="3" width="7" height="9" rx="1"/>
          <rect x="14" y="3" width="7" height="5" rx="1"/>
          <rect x="14" y="12" width="7" height="9" rx="1"/>
          <rect x="3" y="16" width="7" height="5" rx="1"/>
        </svg>
        <span>Dashboard</span>
      </a>
      <a href="{{ route('siswa.chat') }}" class="mobile-nav-link {{ request()->routeIs('siswa.chat*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
        </svg>
        <span>Konseling</span>
      </a>
      <a href="{{ route('siswa.tes') }}" class="mobile-nav-link {{ request()->routeIs('siswa.tes*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M9 11l3 3L22 4"/>
          <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
        </svg>
        <span>Asesmen</span>
      </a>
      <a href="{{ route('siswa.riwayat') }}" class="mobile-nav-link {{ request()->routeIs('siswa.riwayat*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="12" cy="12" r="10"/>
          <polyline points="12 6 12 12 16 14"/>
        </svg>
        <span>Riwayat</span>
      </a>
      <a href="{{ route('profile') }}" class="mobile-nav-link {{ request()->routeIs('profile*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
          <circle cx="12" cy="7" r="4"/>
        </svg>
        <span>Profil</span>
      </a>
    </nav>
  </div>

</div>

<!-- SAPA BK CUSTOM CONFIRM & ALERT MODAL -->
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
      <h3 id="confirmModalTitle" class="confirm-modal-title">Konfirmasi Tindakan</h3>
      <p id="confirmModalDesc" class="confirm-modal-desc">Apakah Anda yakin ingin melanjutkan tindakan ini?</p>
    </div>
    <div class="confirm-modal-actions">
      <button type="button" id="confirmModalCancelBtn" class="confirm-btn-cancel">Batal</button>
      <button type="button" id="confirmModalActionBtn" class="confirm-btn-action">Lanjutkan</button>
    </div>
  </div>
</div>

<!-- SAPA BK Toast Notification Container -->
<div id="appToastContainer" class="app-toast-container" aria-live="polite"></div>

<!-- Drawer toggle & Global Modal scripts -->
<script>
  (function(){
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('backdrop');
    const menuToggle = document.getElementById('menuToggle');
    const sideCloseBtn = document.getElementById('sideCloseBtn');

    function closeSidebar() {
      if(sidebar) sidebar.classList.remove('open');
      if(backdrop) backdrop.classList.remove('open');
    }

    if(menuToggle && sidebar && backdrop){
      menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        backdrop.classList.toggle('open');
      });
      backdrop.addEventListener('click', closeSidebar);
    }

    if(sideCloseBtn) {
      sideCloseBtn.addEventListener('click', closeSidebar);
    }

    if(sidebar) {
      sidebar.querySelectorAll('.side-nav a').forEach(link => {
        link.addEventListener('click', () => {
          if(window.innerWidth <= 980) {
            closeSidebar();
          }
        });
      });
    }
  })();

  window.showConfirmModal = function(options) {
    options = options || {};
    const modal = document.getElementById('customConfirmModal');
    const titleEl = document.getElementById('confirmModalTitle');
    const descEl = document.getElementById('confirmModalDesc');
    const cancelBtn = document.getElementById('confirmModalCancelBtn');
    const actionBtn = document.getElementById('confirmModalActionBtn');
    const iconWrap = document.getElementById('confirmModalIcon');

    if (!modal) {
      if (typeof options.onConfirm === 'function') options.onConfirm();
      return;
    }

    titleEl.innerText = options.title || 'Konfirmasi Tindakan';
    descEl.innerText = options.message || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
    cancelBtn.innerText = options.cancelText || 'Batal';
    actionBtn.innerText = options.confirmText || (options.isAlert ? 'Mengerti' : 'Lanjutkan');

    if (options.isAlert) {
      cancelBtn.style.display = 'none';
      actionBtn.style.flex = '1 1 100%';
    } else {
      cancelBtn.style.display = '';
      actionBtn.style.flex = '1';
    }

    const type = options.type || (options.isAlert ? 'info' : 'warning');

    // Reset button style
    actionBtn.className = 'confirm-btn-action';
    if (type === 'success') {
      actionBtn.classList.add('btn-action-primary');
      iconWrap.style.background = 'rgba(21, 128, 61, 0.1)';
      iconWrap.style.borderColor = 'rgba(21, 128, 61, 0.25)';
      iconWrap.style.color = 'var(--primary)';
      iconWrap.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>';
    } else if (type === 'info') {
      actionBtn.classList.add('btn-action-info');
      iconWrap.style.background = 'rgba(37, 99, 235, 0.1)';
      iconWrap.style.borderColor = 'rgba(37, 99, 235, 0.25)';
      iconWrap.style.color = '#2563EB';
      iconWrap.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>';
    } else if (type === 'danger') {
      iconWrap.style.background = 'rgba(201, 96, 59, 0.1)';
      iconWrap.style.borderColor = 'rgba(201, 96, 59, 0.25)';
      iconWrap.style.color = 'var(--warn)';
      iconWrap.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>';
    } else {
      // Default: warning
      iconWrap.style.background = 'rgba(217, 119, 6, 0.1)';
      iconWrap.style.borderColor = 'rgba(217, 119, 6, 0.25)';
      iconWrap.style.color = '#D97706';
      iconWrap.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>';
    }

    modal.classList.add('is-open');
    (options.isAlert ? actionBtn : cancelBtn).focus();

    function closeModal() {
      modal.classList.remove('is-open');
      cleanup();
    }

    function handleAction() {
      closeModal();
      if (typeof options.onConfirm === 'function') {
        options.onConfirm();
      }
      if (typeof options.onOk === 'function') {
        options.onOk();
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

  window.showAlertModal = function(options) {
    if (typeof options === 'string') {
      options = { message: options };
    }
    options = options || {};
    window.showConfirmModal({
      title: options.title || 'Informasi',
      message: options.message || '',
      type: options.type || 'info',
      confirmText: options.confirmText || options.buttonText || 'Mengerti',
      isAlert: true,
      onConfirm: options.onOk || options.onConfirm
    });
  };

  window.showToast = function(message, type, duration) {
    type = type || 'info';
    duration = duration !== undefined ? duration : 3500;
    const container = document.getElementById('appToastContainer');
    if (!container) {
      console.log(`[Toast ${type}]: ${message}`);
      return;
    }

    const toast = document.createElement('div');
    toast.className = `app-toast-item toast-${type}`;

    let iconSvg = '';
    if (type === 'success') {
      iconSvg = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="shrink: 0;"><polyline points="20 6 9 17 4 12"></polyline></svg>';
    } else if (type === 'error' || type === 'danger') {
      iconSvg = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="shrink: 0;"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>';
    } else if (type === 'warning') {
      iconSvg = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="shrink: 0;"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>';
    } else {
      iconSvg = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="shrink: 0;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>';
    }

    toast.innerHTML = `
      <div style="flex-shrink: 0; margin-top: 1px;">${iconSvg}</div>
      <div style="flex: 1; font-weight: 500;">${message}</div>
      <button type="button" class="app-toast-close" aria-label="Tutup notifikasi">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
      </button>
    `;

    container.appendChild(toast);

    requestAnimationFrame(() => {
      toast.classList.add('is-visible');
    });

    const closeBtn = toast.querySelector('.app-toast-close');
    let timer = null;

    function dismiss() {
      if (timer) clearTimeout(timer);
      toast.classList.remove('is-visible');
      setTimeout(() => {
        if (toast.parentNode) toast.parentNode.removeChild(toast);
      }, 260);
    }

    if (closeBtn) closeBtn.addEventListener('click', dismiss);
    if (duration > 0) {
      timer = setTimeout(dismiss, duration);
    }
  };

  // Intercept data-confirm on forms
  document.addEventListener('submit', function(e) {
    const form = e.target;
    if (!form || !form.dataset) return;
    const confirmMsg = form.dataset.confirm;
    if (confirmMsg && !form._isConfirmed) {
      e.preventDefault();
      window.showConfirmModal({
        title: form.dataset.confirmTitle || 'Konfirmasi Tindakan',
        message: confirmMsg,
        type: form.dataset.confirmType || 'danger',
        confirmText: form.dataset.confirmBtn || 'Ya, Lanjutkan',
        cancelText: 'Batal',
        onConfirm: function() {
          form._isConfirmed = true;
          form.submit();
        }
      });
    }
  });

  // Override window.alert
  window.alert = function(msg) {
    window.showAlertModal({
      title: 'Perhatian',
      message: String(msg),
      type: 'warning',
      buttonText: 'Mengerti'
    });
  };

  // Real-time Session Guard: otomatis logout tanpa refresh halaman jika akun aktif di perangkat lain
  (function() {
    let isTerminated = false;
    function verifySessionStatus() {
      if (isTerminated) return;
      fetch("{{ route('auth.session-status') }}", {
        headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        },
        cache: 'no-store'
      })
      .then(function(res) {
        if (res.status === 401 || !res.ok) {
          isTerminated = true;
          window.location.href = "{{ route('login') }}?reason=session_terminated";
        }
      })
      .catch(function() {
        // Abaikan kegagalan jaringan sementara
      });
    }

    // Polling setiap 4 detik untuk responsivitas instan
    setInterval(verifySessionStatus, 4000);

    // Cek seketika saat pengguna kembali ke tab ini
    window.addEventListener('focus', verifySessionStatus);
    document.addEventListener('visibilitychange', function() {
      if (document.visibilityState === 'visible') {
        verifySessionStatus();
      }
    });
  })();
</script>
<!-- Pusher & Laravel Echo untuk WebSocket Real-time Reverb -->
<script src="https://js.pusher.com/8.4.0-rc2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
@stack('scripts')
</body>
</html>
