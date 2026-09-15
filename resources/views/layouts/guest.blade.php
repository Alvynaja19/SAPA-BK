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
      --shadow-card: 0 1px 3px rgba(15,29,19,0.05), 0 10px 24px -10px rgba(15,29,19,0.1);
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
      border: 1px solid rgba(217,119,6,0.3);
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
      box-shadow: 0 2px 6px rgba(21,128,61,0.25);
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
      background: rgba(21,128,61,0.06);
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
      color: #FFFFFF;
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
      background: rgba(248,250,248,0.96);
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
      padding: 64px 0 32px;
      margin-top: auto;
    }
    .foot-row {
      display: grid;
      grid-template-columns: 1.3fr 1fr 1fr 1.4fr;
      gap: 36px;
      align-items: start;
    }
    @media (max-width: 960px) {
      .foot-row {
        grid-template-columns: repeat(2, 1fr);
        gap: 32px;
      }
    }
    @media (max-width: 580px) {
      .foot-row {
        grid-template-columns: 1fr;
        gap: 28px;
      }
    }
    .foot-col h4 {
      color: #FFFFFF;
      font-size: 16px;
      margin-bottom: 16px;
      font-family: 'Work Sans', sans-serif;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .foot-col h4 .foot-bar {
      color: var(--accent);
      font-weight: 900;
    }
    .foot-col ul {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .foot-col ul li {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .foot-col ul li .foot-bullet {
      color: var(--accent);
      font-size: 10px;
      line-height: 1;
    }
    .foot-col a {
      color: #C9D8CD;
      font-size: 14px;
      transition: color .15s ease, transform .15s ease;
      display: inline-block;
    }
    .foot-col a:hover {
      color: #FFFFFF;
      transform: translateX(2px);
    }
    .foot-contact-item {
      display: flex;
      gap: 10px;
      font-size: 13.5px;
      color: #D2E4D6;
      line-height: 1.5;
      margin-bottom: 12px;
    }
    .foot-contact-item svg {
      width: 18px;
      height: 18px;
      flex-shrink: 0;
      margin-top: 2px;
      color: var(--accent);
    }
    .foot-map-wrap {
      margin-top: 14px;
      border-radius: 12px;
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      background: rgba(255, 255, 255, 0.05);
    }
    .foot-map-wrap iframe {
      width: 100%;
      height: 125px;
      border: 0;
      display: block;
    }
    .foot-map-link {
      display: block;
      padding: 5px 10px;
      background: rgba(0, 0, 0, 0.35);
      color: #FFFFFF;
      font-size: 11px;
      text-align: center;
      font-weight: 600;
      transition: background .15s ease;
    }
    .foot-map-link:hover {
      background: var(--accent);
      color: #0F1D13;
    }

    /* FOOTER MIDDLE BANNER */
    .foot-banner {
      margin: 48px auto 36px;
      text-align: center;
      padding: 24px 16px;
      border-top: 1px solid rgba(255, 255, 255, 0.12);
      border-bottom: 1px solid rgba(255, 255, 255, 0.12);
    }
    .foot-banner-tagline {
      font-family: 'Fraunces', Georgia, serif;
      font-size: clamp(22px, 3.2vw, 34px);
      font-weight: 800;
      letter-spacing: 0.08em;
      color: #FFFFFF;
      line-height: 1.2;
    }
    .foot-banner-tagline .accent-word {
      color: var(--accent);
    }
    .foot-banner-tagline .sep-dot {
      color: var(--accent);
      margin: 0 10px;
      opacity: 0.9;
    }
    .foot-banner-sub {
      margin-top: 8px;
      font-size: 11.5px;
      font-weight: 700;
      letter-spacing: 0.16em;
      text-transform: uppercase;
      color: #D2E4D6;
    }

    /* FOOTER BOTTOM BAR */
    .foot-bottom-bar {
      background: rgba(0, 0, 0, 0.22);
      border-radius: 14px;
      padding: 16px 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 16px;
      font-size: 13px;
      color: #C9D8CD;
    }
    .foot-socials {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .foot-social-label {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: #FFFFFF;
    }
    .social-btn {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: var(--accent);
      color: #15803D;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: transform .15s ease, background .15s ease;
    }
    .social-btn:hover {
      transform: translateY(-2px);
      background: #FBBF24;
      color: #0F1D13;
    }
    .social-btn svg {
      width: 16px;
      height: 16px;
      fill: currentColor;
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
      background: #15803D;
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
        <!-- Kolom 1: SAPA BK -->
        <div class="foot-col">
          <div class="brand-name" style="color: #FFFFFF; font-size: 22px; font-weight: 700; margin-bottom: 14px; letter-spacing: -0.01em;">SAPA BK</div>
          <p style="font-size: 14px; line-height: 1.65; color: #D2E4D6;">
            Portal Bimbingan dan Konseling digital SMA Negeri 4 Jember. Ruang aman bagi seluruh siswa untuk bertanya, bercerita, dan merencanakan masa depan.
          </p>
        </div>

        <!-- Kolom 2: Jelajahi Portal -->
        <div class="foot-col">
          <h4><span class="foot-bar">|</span> Jelajahi Portal</h4>
          <ul>
            <li><span class="foot-bullet">&#9642;</span><a href="{{ route('home') }}">Beranda</a></li>
            <li><span class="foot-bullet">&#9642;</span><a href="{{ route('home') }}#layanan">Layanan BK</a></li>
            <li><span class="foot-bullet">&#9642;</span><a href="{{ route('ebook.index') }}">Katalog E-Book</a></li>
            <li><span class="foot-bullet">&#9642;</span><a href="{{ route('article.index') }}">Artikel &amp; Tips</a></li>
            <li><span class="foot-bullet">&#9642;</span><a href="{{ route('faq') }}">Tanya Jawab (FAQ)</a></li>
          </ul>
        </div>

        <!-- Kolom 3: Akun Siswa -->
        <div class="foot-col">
          <h4><span class="foot-bar">|</span> Akun Siswa</h4>
          <ul>
            @auth
              @php
                $footDash = match(auth()->user()->role) {
                  'admin' => route('admin.dashboard'),
                  'guru_bk' => route('bk.dashboard'),
                  default => route('siswa.dashboard'),
                };
              @endphp
              <li><span class="foot-bullet">&#9642;</span><a href="{{ $footDash }}">Dashboard Saya</a></li>
              <li><span class="foot-bullet">&#9642;</span><a href="{{ route('profile') }}">Profil Saya</a></li>
            @else
              <li><span class="foot-bullet">&#9642;</span><a href="{{ route('login') }}">Masuk Akun</a></li>
              <li><span class="foot-bullet">&#9642;</span><a href="{{ route('register') }}">Pendaftaran Akun</a></li>
            @endauth
            <li><span class="foot-bullet">&#9642;</span><a href="{{ route('about') }}">Tentang SAPA BK</a></li>
          </ul>
        </div>

        <!-- Kolom 4: Kontak Sekolah & Maps -->
        <div class="foot-col">
          <h4><span class="foot-bar">|</span> Kontak Sekolah</h4>
          <div class="foot-contact-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
              <circle cx="12" cy="10" r="3"/>
            </svg>
            <div>
              <strong style="color: #FFFFFF; font-weight: 600; display: block;">Ruang BK, SMA Negeri 4 Jember</strong>
              <span>Jl. Hayam Wuruk No.145, Kaliwates, Jember</span>
            </div>
          </div>
          <div class="foot-contact-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <rect width="20" height="16" x="2" y="4" rx="2"/>
              <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
            </svg>
            <a href="mailto:bk@sman4jember.sch.id" style="color: #D2E4D6;">bk@sman4jember.sch.id</a>
          </div>

          <!-- Google Maps Embed SMAN 4 Jember -->
          <div class="foot-map-wrap">
            <iframe 
              src="https://maps.google.com/maps?q=SMA+Negeri+4+Jember,+Jl.+Hayam+Wuruk+No.145,+Kaliwates,+Jember&t=&z=15&ie=UTF8&iwloc=&output=embed" 
              loading="lazy" 
              allowfullscreen 
              referrerpolicy="no-referrer-when-downgrade"
              title="Peta Lokasi SMA Negeri 4 Jember"
            ></iframe>
            <a href="https://maps.google.com/?q=SMA+Negeri+4+Jember" target="_blank" rel="noopener noreferrer" class="foot-map-link">
              Buka di Google Maps &rarr;
            </a>
          </div>
        </div>
      </div>

      <!-- Banner Tagline Tengah -->
      <div class="foot-banner">
        <div class="foot-banner-tagline">
          <span>AMAN</span>
          <span class="sep-dot">&#183;</span>
          <span class="accent-word">RAHASIA</span>
          <span class="sep-dot">&#183;</span>
          <span>TERPERCAYA</span>
        </div>
        <div class="foot-banner-sub">
          LAYANAN BIMBINGAN &amp; KONSELING DIGITAL SMA NEGERI 4 JEMBER
        </div>
      </div>

      <!-- Bottom Bar -->
      <div class="foot-bottom-bar">
        <span>&copy; {{ date('Y') }} SAPA BK : SMA Negeri 4 Jember. Hak Cipta Dilindungi.</span>
        <div class="foot-socials">
          <span class="foot-social-label">IKUTI KAMI</span>
          <!-- Facebook -->
          <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="social-btn" title="Facebook SMAN 4 Jember" aria-label="Facebook">
            <svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
          </a>
          <!-- Instagram -->
          <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="social-btn" title="Instagram SMAN 4 Jember" aria-label="Instagram">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
              <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
              <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
            </svg>
          </a>
        </div>
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
