<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Autentikasi — SAPA BK SMAN 4 Jember')</title>
  <meta name="description" content="Portal Konseling & Bimbingan Belajar Siswa SMA Negeri 4 Jember" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
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
      --accent: #D97706;
      --accent-hover: #B45309;
      --accent-soft: #FEF3C7;
      --accent-ink: #78350F;
      --red: #E11D48;
      --red-soft: #FFE4E6;
      --blue: #2563EB;
      --blue-soft: #DBEAFE;
      --line: #E2E8DF;
      --radius-s: 8px;
      --radius-m: 14px;
      --radius-l: 22px;
      --shadow-card: 0 2px 4px rgba(15,29,19,0.04), 0 16px 36px -12px rgba(15,29,19,0.12);
      --shadow-input: 0 1px 2px rgba(15,29,19,0.05);
      --maxw-form: 520px;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }
    html { height: 100%; }
    body {
      min-height: 100%;
      background: var(--bg);
      color: var(--ink);
      font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      line-height: 1.55;
      -webkit-font-smoothing: antialiased;
      display: flex;
      flex-direction: column;
      position: relative;
      overflow-x: hidden;
    }

    /* Ambient background shapes matching the hero palette */
    .ambient-bg {
      position: fixed;
      inset: 0;
      pointer-events: none;
      z-index: 0;
      background:
        radial-gradient(circle at 88% 12%, rgba(217,119,6,0.08), transparent 50%),
        radial-gradient(circle at 10% 85%, rgba(21,128,61,0.08), transparent 50%),
        radial-gradient(circle at 50% 50%, rgba(238,244,237,0.4), transparent 70%);
    }

    /* Minimalist Auth Header */
    header.auth-nav {
      position: relative;
      z-index: 10;
      border-bottom: 1px solid var(--line);
      background: rgba(248,250,248,0.92);
      backdrop-filter: blur(8px);
    }
    .auth-nav-inner {
      max-width: 1180px;
      margin: 0 auto;
      padding: 14px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .brand {
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
      color: inherit;
    }
    .brand-mark {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      background: var(--primary);
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 12px rgba(21,128,61,0.25);
    }
    .brand-title {
      font-family: 'Fraunces', serif;
      font-weight: 600;
      font-size: 20px;
      line-height: 1.1;
      color: var(--ink);
    }
    .brand-sub {
      font-size: 11px;
      color: var(--ink-faint);
      font-weight: 500;
    }
    .nav-back {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 13.5px;
      font-weight: 600;
      color: var(--ink-soft);
      text-decoration: none;
      padding: 8px 14px;
      border-radius: var(--radius-s);
      border: 1px solid var(--line);
      background: var(--surface);
      transition: all .15s ease;
    }
    .nav-back:hover {
      color: var(--primary);
      border-color: var(--primary);
      background: #FFFFFF;
    }

    /* Main Auth Container */
    main.auth-main {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 48px 20px;
      position: relative;
      z-index: 1;
    }

    /* Auth Card */
    .auth-card {
      width: 100%;
      max-width: var(--maxw-form);
      background: var(--surface);
      border: 1px solid var(--line);
      border-radius: var(--radius-l);
      box-shadow: var(--shadow-card);
      padding: 40px;
      animation: cardAppear .5s ease both;
    }
    @media (max-width: 540px) {
      .auth-card {
        padding: 24px 18px;
        border-radius: var(--radius-m);
      }
      main.auth-main {
        padding: 24px 14px;
      }
      .form-input {
        font-size: 16px !important;
      }
    }

    @keyframes cardAppear {
      from {
        opacity: 0;
        transform: translateY(18px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Card Header Elements */
    .auth-header {
      text-align: center;
      margin-bottom: 28px;
    }
    .auth-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 12.5px;
      font-weight: 600;
      color: var(--accent-ink);
      background: var(--accent-soft);
      padding: 5px 12px;
      border-radius: 999px;
      margin-bottom: 14px;
    }
    .auth-title {
      font-family: 'Fraunces', serif;
      font-weight: 600;
      font-size: clamp(24px, 3.2vw, 30px);
      color: var(--ink);
      line-height: 1.2;
    }
    .auth-lede {
      margin-top: 8px;
      font-size: 14px;
      color: var(--ink-soft);
      line-height: 1.5;
    }

    /* Preset Switcher Box */
    .preset-box {
      margin-bottom: 24px;
      padding: 12px 14px;
      background: var(--bg);
      border: 1px solid var(--line);
      border-radius: var(--radius-m);
    }
    .preset-label {
      display: block;
      font-size: 11.5px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .04em;
      color: var(--ink-soft);
      margin-bottom: 8px;
    }
    .preset-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 8px;
    }
    .preset-btn {
      min-height: 40px;
      padding: 8px 10px;
      border-radius: var(--radius-s);
      border: 1px solid var(--line);
      background: var(--surface);
      font-family: inherit;
      font-size: 12.5px;
      font-weight: 600;
      color: var(--ink);
      cursor: pointer;
      text-align: center;
      transition: all .15s ease;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    @media (max-width: 420px) {
      .preset-grid {
        grid-template-columns: 1fr;
      }
      .preset-btn {
        min-height: 44px;
      }
    }
    .preset-btn:hover {
      border-color: var(--primary);
      color: var(--primary);
      background: #FFFFFF;
      transform: translateY(-1px);
    }

    /* Alerts */
    .alert-box {
      margin-bottom: 22px;
      padding: 12px 16px;
      border-radius: var(--radius-m);
      font-size: 13px;
      display: flex;
      gap: 12px;
      align-items: flex-start;
      line-height: 1.45;
    }
    .alert-danger {
      background: var(--red-soft);
      border: 1px solid #F1B0AB;
      color: #8C1C17;
    }
    .alert-success {
      background: #E6F4EA;
      border: 1px solid #B8E0C4;
      color: #1E6B24;
    }
    .alert-icon {
      flex-shrink: 0;
      margin-top: 1px;
    }
    .alert-list {
      margin-left: 16px;
      margin-top: 4px;
    }

    /* Form Fields */
    .form-group {
      margin-bottom: 18px;
    }
    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }
    @media (max-width: 500px) {
      .form-row {
        grid-template-columns: 1fr;
        gap: 0;
      }
    }
    .form-label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .03em;
      color: var(--ink-soft);
      margin-bottom: 6px;
    }
    .input-wrap {
      position: relative;
      display: flex;
      align-items: center;
    }
    .input-icon {
      position: absolute;
      left: 14px;
      color: var(--ink-faint);
      pointer-events: none;
      display: flex;
      align-items: center;
    }
    .form-input {
      width: 100%;
      padding: 11px 14px;
      padding-left: 40px;
      font-family: inherit;
      font-size: 14px;
      color: var(--ink);
      background: var(--surface);
      border: 1px solid var(--line);
      border-radius: var(--radius-s);
      transition: border-color .15s ease, box-shadow .15s ease;
      box-shadow: var(--shadow-input);
    }
    .form-input.no-icon {
      padding-left: 14px;
    }
    .form-input:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(46,125,52,0.15);
    }
    .form-input::placeholder {
      color: var(--ink-faint);
      opacity: 0.8;
    }

    /* Toggle Password Button */
    .toggle-password {
      position: absolute;
      right: 12px;
      background: none;
      border: none;
      color: var(--ink-faint);
      cursor: pointer;
      padding: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .toggle-password:hover {
      color: var(--primary);
    }

    /* Options Row (Remember me, etc) */
    .form-options {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin: 14px 0 22px;
      font-size: 13px;
    }
    .checkbox-label {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      color: var(--ink-soft);
      user-select: none;
    }
    .checkbox-label input[type="checkbox"] {
      width: 16px;
      height: 16px;
      accent-color: var(--primary);
      cursor: pointer;
    }

    /* Submit Button */
    .btn-submit {
      width: 100%;
      padding: 13px 20px;
      background: var(--primary);
      color: #F3F5EF;
      border: none;
      border-radius: var(--radius-s);
      font-family: inherit;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      box-shadow: 0 4px 14px rgba(46,125,52,0.25);
      transition: background-color .15s ease, transform .1s ease, box-shadow .15s ease;
    }
    .btn-submit:hover {
      background: var(--primary-hover);
      box-shadow: 0 6px 18px rgba(46,125,52,0.32);
      transform: translateY(-1px);
    }
    .btn-submit:active {
      transform: translateY(0);
    }

    /* Card Footer Switcher */
    .auth-switch {
      margin-top: 24px;
      padding-top: 20px;
      border-top: 1px solid var(--line);
      text-align: center;
      font-size: 13px;
      color: var(--ink-soft);
    }
    .auth-switch a {
      color: var(--primary);
      font-weight: 600;
      text-decoration: none;
      margin-left: 4px;
    }
    .auth-switch a:hover {
      text-decoration: underline;
    }

    /* Simple Footer */
    footer.auth-foot {
      position: relative;
      z-index: 1;
      text-align: center;
      padding: 20px;
      font-size: 12px;
      color: var(--ink-faint);
    }
  </style>
  @yield('styles')
</head>
<body>

  <div class="ambient-bg" aria-hidden="true"></div>

  <!-- Header -->
  <header class="auth-nav">
    <div class="auth-nav-inner">
      <a href="{{ route('home') }}" class="brand">
        <div class="brand-mark">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#EAF0EA" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 3v4M4.5 8.5 7 10M19.5 8.5 17 10M12 21v-7M6 14h12"/>
            <circle cx="12" cy="7" r="3.2"/>
          </svg>
        </div>
        <div>
          <div class="brand-title">SAPA BK</div>
          <div class="brand-sub">SMA Negeri 4 Jember</div>
        </div>
      </a>

      <a href="{{ route('home') }}" class="nav-back">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        <span>Ke Beranda</span>
      </a>
    </div>
  </header>

  <!-- Main Content -->
  <main class="auth-main">
    <div class="auth-card">
      @yield('content')
    </div>
  </main>

  <!-- Footer -->
  <footer class="auth-foot">
    <span>© 2026 SAPA BK — SMA Negeri 4 Jember · Sistem Layanan Bimbingan & Konseling Digital</span>
  </footer>

  <script>
    function togglePasswordVisibility(inputId, btn) {
      const input = document.getElementById(inputId);
      if (!input) return;
      if (input.type === 'password') {
        input.type = 'text';
        btn.innerHTML = `<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>`;
      } else {
        input.type = 'password';
        btn.innerHTML = `<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>`;
      }
    }
  </script>
  @yield('scripts')
</body>
</html>
