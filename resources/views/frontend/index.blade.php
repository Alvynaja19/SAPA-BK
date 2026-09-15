<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SAPA BK : Portal Bimbingan & Konseling SMA Negeri 4 Jember</title>
  <meta name="description" content="SAPA BK SMA Negeri 4 Jember. Ruang aman dan terpercaya bagi siswa untuk berkonsultasi, mengakses materi bimbingan, dan terhubung dengan Guru BK." />
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
    }
    h1, h2, h3, h4 {
      font-family: 'Fraunces', Georgia, serif;
      font-weight: 600;
      line-height: 1.2;
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
    }
    section { padding: 88px 0; }
    @media (max-width: 768px) {
      section { padding: 56px 0; }
      .wrap { padding: 0 20px; }
    }

    .heading-section { font-size: clamp(26px, 3.8vw, 42px); max-width: 640px; }
    .section-lede {
      color: var(--ink-soft);
      font-size: 16.5px;
      max-width: 520px;
      margin-top: 14px;
      line-height: 1.55;
    }

    /* Buttons with standard 44px min tap targets */
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
      transition: background-color .18s ease, color .18s ease, border-color .18s ease, box-shadow .18s ease;
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
      gap: 28px;
    }
    .nav-links a {
      font-size: 15px;
      font-weight: 500;
      color: var(--ink-soft);
      padding: 8px 4px;
      transition: color .15s ease;
    }
    .nav-links a:hover {
      color: var(--primary);
    }
    .nav-actions {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .nav-actions a.login {
      font-size: 15px;
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
      .nav-links.open { max-height: 360px; }
      .nav-links a {
        min-height: 48px;
        display: flex;
        align-items: center;
        padding: 12px 24px;
        border-top: 1px solid var(--line);
        font-size: 15.5px;
      }
      .nav-toggle { display: flex; }
      .nav-actions .login { display: none; }
    }

    /* HERO */
    .hero {
      position: relative;
      overflow: hidden;
    }
    .hero-canvas {
      position: absolute;
      top: -5%;
      right: -2%;
      width: 58%;
      height: 110%;
      z-index: 0;
      pointer-events: none;
    }
    .hero-canvas canvas { display: block; }
    .hero-canvas.static-fallback {
      background:
        radial-gradient(circle at 72% 35%, rgba(244,180,0,0.22), transparent 55%),
        radial-gradient(circle at 45% 65%, rgba(46,125,52,0.18), transparent 52%);
      filter: blur(10px);
    }
    @media (max-width: 900px) {
      .hero-canvas { display: none; }
    }

    .hero .wrap {
      position: relative;
      z-index: 1;
      display: grid;
      grid-template-columns: 1.1fr 0.9fr;
      gap: 52px;
      align-items: center;
      padding-top: 60px;
      padding-bottom: 48px;
    }
    @media (max-width: 900px) {
      .hero .wrap {
        grid-template-columns: 1fr;
        padding-top: 32px;
        gap: 40px;
      }
    }

    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 13.5px;
      font-weight: 600;
      color: var(--accent-ink);
      background: var(--accent-soft);
      border: 1px solid rgba(217,119,6,0.3);
      padding: 6px 14px;
      border-radius: 999px;
      margin-bottom: 20px;
    }
    .badge-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: var(--primary);
    }

    .hero h1 {
      font-size: clamp(32px, 4.4vw, 50px);
      max-width: 580px;
      letter-spacing: -0.015em;
    }
    .hero h1 em {
      font-style: normal;
      color: var(--primary);
      text-decoration: underline;
      text-decoration-color: var(--accent);
      text-decoration-thickness: 3px;
      text-underline-offset: 4px;
    }
    .hero-lede {
      margin-top: 18px;
      font-size: 17.5px;
      color: var(--ink-soft);
      max-width: 500px;
      line-height: 1.6;
    }
    .hero-ctas {
      display: flex;
      gap: 14px;
      margin-top: 32px;
      flex-wrap: wrap;
    }
    .hero-trust {
      margin-top: 38px;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      border-top: 1px solid var(--line);
      padding-top: 22px;
      color: var(--ink-faint);
      font-size: 13px;
    }
    @media (max-width: 600px) {
      .hero-trust { grid-template-columns: 1fr; gap: 14px; }
    }
    .hero-trust strong {
      color: var(--ink);
      display: block;
      font-family: 'Fraunces', Georgia, serif;
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 2px;
    }

    /* Hero interactive card */
    .chat-mock-wrap {
      position: relative;
      perspective: 1200px;
    }
    .chat-mock-wrap::before {
      content: "";
      position: absolute;
      top: -24px;
      right: -16px;
      width: 70%;
      height: 65%;
      background: radial-gradient(circle, rgba(244,180,0,0.28), transparent 70%);
      filter: blur(30px);
      z-index: -1;
    }
    .chat-mock {
      background: var(--surface);
      border: 1px solid var(--line);
      border-radius: var(--radius-m);
      box-shadow: var(--shadow-card);
      overflow: hidden;
      transform-style: preserve-3d;
      transition: transform .18s ease-out, box-shadow .18s ease-out;
    }
    .chat-mock-head {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 16px 20px;
      background: var(--primary);
      color: #FFFFFF;
    }
    .status-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: #7FD79A;
      box-shadow: 0 0 0 3px rgba(127,215,154,0.3);
      flex-shrink: 0;
    }
    .chat-mock-head .who {
      font-weight: 600;
      font-size: 15px;
    }
    .chat-mock-head .status-text {
      font-size: 12px;
      color: #E2ECE4;
      margin-left: auto;
      text-align: right;
    }
    .chat-mock-body {
      padding: 22px 20px;
      display: flex;
      flex-direction: column;
      gap: 14px;
      background: #F8FAF6;
    }
    .bubble {
      max-width: 86%;
      padding: 12px 16px;
      border-radius: 14px;
      font-size: 14.5px;
      line-height: 1.5;
    }
    .bubble.user {
      align-self: flex-end;
      background: var(--primary);
      color: #FFFFFF;
      border-bottom-right-radius: 4px;
    }
    .bubble.bot {
      align-self: flex-start;
      background: var(--surface);
      border: 1px solid var(--line);
      color: var(--ink);
      border-bottom-left-radius: 4px;
    }
    .bubble.bot .src {
      display: block;
      margin-top: 8px;
      font-size: 12px;
      color: var(--ink-faint);
    }

    /* Real Interactive Form in Hero Card */
    .chat-mock-foot {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px 16px;
      border-top: 1px solid var(--line);
      background: var(--surface);
    }
    .chat-mock-foot input {
      flex: 1;
      min-height: 44px;
      background: var(--bg);
      border: 1px solid var(--line);
      border-radius: 999px;
      padding: 10px 18px;
      font-size: 14px;
      font-family: inherit;
      color: var(--ink);
      transition: border-color .15s ease, background-color .15s ease;
    }
    .chat-mock-foot input:focus {
      border-color: var(--primary);
      background: var(--surface);
      outline: 2px solid var(--accent);
      outline-offset: 1px;
    }
    .chat-mock-foot button {
      min-width: 44px;
      min-height: 44px;
      border-radius: 50%;
      background: var(--accent);
      border: none;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      color: #2A1C08;
      transition: background-color .15s ease, transform .15s ease;
    }
    .chat-mock-foot button:hover {
      background: var(--accent-hover);
      transform: scale(1.05);
    }

    /* SERVICES */
    .services { background: var(--surface); }
    .services-head {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      gap: 24px;
      flex-wrap: wrap;
    }
    .service-grid {
      margin-top: 44px;
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 22px;
    }
    @media (max-width: 768px) {
      .service-grid { grid-template-columns: 1fr; }
    }
    .service-item {
      background: var(--bg);
      border: 1px solid var(--line);
      border-radius: var(--radius-m);
      padding: 28px;
      display: flex;
      gap: 20px;
      transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }
    .service-item:hover {
      transform: translateY(-3px);
      box-shadow: var(--shadow-card);
      border-color: var(--primary);
    }
    .service-icon {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      background: var(--surface);
      border: 1px solid var(--line);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    .service-icon svg {
      width: 24px;
      height: 24px;
      stroke: var(--primary);
    }
    .service-item h3 {
      font-size: 19px;
      margin-bottom: 8px;
    }
    .service-item p {
      color: var(--ink-soft);
      font-size: 14.5px;
      line-height: 1.55;
    }
    .service-item .tag {
      display: inline-block;
      margin-top: 12px;
      font-size: 12.5px;
      font-weight: 600;
      color: var(--accent-ink);
      background: var(--accent-soft);
      padding: 4px 10px;
      border-radius: 6px;
    }

    /* HOW IT WORKS */
    .how { background: var(--bg); }
    .how-steps {
      margin-top: 52px;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 36px;
      position: relative;
    }
    .how-steps::before {
      content: "";
      position: absolute;
      top: 24px;
      left: calc(100%/6);
      right: calc(100%/6);
      height: 2px;
      background: repeating-linear-gradient(90deg, var(--line) 0 8px, transparent 8px 14px);
    }
    @media (max-width: 768px) {
      .how-steps { grid-template-columns: 1fr; gap: 28px; }
      .how-steps::before {
        top: 0;
        bottom: 0;
        left: 23px;
        right: auto;
        width: 2px;
        height: auto;
        background: repeating-linear-gradient(180deg, var(--line) 0 8px, transparent 8px 14px);
      }
    }
    .how-step { position: relative; }
    .how-num {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background: var(--primary);
      color: #FFFFFF;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Fraunces', Georgia, serif;
      font-weight: 700;
      font-size: 18px;
      position: relative;
      z-index: 2;
      box-shadow: 0 2px 8px rgba(21,128,61,0.3);
    }
    .how-step h3 {
      font-size: 18px;
      margin-top: 18px;
      margin-bottom: 8px;
    }
    .how-step p {
      color: var(--ink-soft);
      font-size: 14.5px;
      line-height: 1.55;
    }

    /* E-BOOKS */
    .ebooks { background: var(--surface); }
    .ebook-row {
      margin-top: 40px;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 22px;
    }
    @media (max-width: 990px) { .ebook-row { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 520px) { .ebook-row { grid-template-columns: 1fr; } }
    .ebook-card {
      display: flex;
      flex-direction: column;
      gap: 12px;
      background: var(--bg);
      border: 1px solid var(--line);
      border-radius: var(--radius-m);
      padding: 16px;
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
      padding: 16px;
      position: relative;
      overflow: hidden;
      background: linear-gradient(145deg, var(--primary), #1C4A20);
      color: #FFFFFF;
    }
    .ebook-cover.alt-color-1 { background: linear-gradient(145deg, #2E7D34, #1B5E20); }
    .ebook-cover.alt-color-2 { background: linear-gradient(145deg, #0277BD, #01579B); }
    .ebook-cover.alt-color-3 { background: linear-gradient(145deg, #E65100, #BF360C); }
    .ebook-cover.alt-color-4 { background: linear-gradient(145deg, #4527A0, #311B92); }
    .ebook-cover::after {
      content: "";
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 7px;
      background: rgba(0,0,0,0.18);
    }
    .ebook-cover span {
      font-family: 'Fraunces', Georgia, serif;
      font-weight: 600;
      font-size: 15.5px;
      line-height: 1.3;
      z-index: 1;
    }
    .ebook-cover .ebook-badge {
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      opacity: 0.85;
      margin-bottom: 6px;
      z-index: 1;
    }
    .ebook-meta {
      font-size: 13px;
      color: var(--ink-faint);
    }
    .ebook-meta strong {
      color: var(--ink);
      display: block;
      font-size: 15px;
      font-weight: 600;
      margin-bottom: 4px;
      line-height: 1.35;
    }

    /* ARTIKEL */
    .articles { background: var(--bg-alt); }
    .article-row {
      margin-top: 44px;
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
      transition: transform .2s ease, box-shadow .2s ease;
    }
    .article-card:hover {
      transform: translateY(-3px);
      box-shadow: var(--shadow-card);
    }
    .article-thumb {
      height: 140px;
      background: linear-gradient(135deg, rgba(46,125,52,0.85), rgba(28,110,180,0.85)),
                  radial-gradient(circle at top left, var(--accent), transparent);
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #FFFFFF;
    }
    .article-thumb svg {
      width: 44px;
      height: 44px;
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
      font-size: 17px;
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
      margin-top: 18px;
      padding-top: 12px;
      border-top: 1px solid var(--line);
      font-size: 12.5px;
      color: var(--ink-faint);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    /* FAQ */
    .faq { background: var(--bg); }
    .faq .wrap { max-width: 820px; }
    .faq-list {
      margin-top: 36px;
      border-top: 1px solid var(--line);
    }
    details {
      border-bottom: 1px solid var(--line);
      padding: 20px 0;
    }
    summary {
      cursor: pointer;
      list-style: none;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: 600;
      font-size: 16.5px;
      gap: 16px;
      min-height: 44px;
      color: var(--ink);
    }
    summary::-webkit-details-marker { display: none; }
    summary .plus {
      font-size: 22px;
      color: var(--primary);
      flex-shrink: 0;
      transition: transform .2s ease;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 28px;
      height: 28px;
    }
    details[open] summary .plus { transform: rotate(45deg); }
    details p {
      margin-top: 14px;
      color: var(--ink-soft);
      font-size: 15px;
      line-height: 1.6;
    }

    /* FOOTER */
    footer {
      background: #1B4D2E;
      color: #FFFFFF;
      padding: 64px 0 32px;
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
      font-size: 16.5px;
      margin-bottom: 18px;
      font-family: 'Work Sans', sans-serif;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 8px;
      letter-spacing: -0.01em;
    }
    .foot-col h4 .foot-bar {
      color: #FBBF24;
      font-weight: 800;
      font-size: 18px;
    }
    .foot-col ul {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }
    .foot-col ul li {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .foot-col ul li .foot-bullet {
      color: #FBBF24;
      font-size: 11px;
      line-height: 1;
    }
    .foot-col a {
      color: #F0F7F2;
      font-size: 14px;
      font-weight: 500;
      transition: color .15s ease, transform .15s ease;
      display: inline-block;
    }
    .foot-col a:hover {
      color: #FDE047;
      transform: translateX(3px);
    }
    .foot-contact-item {
      display: flex;
      gap: 12px;
      font-size: 13.5px;
      color: #E8F3EA;
      line-height: 1.55;
      margin-bottom: 12px;
    }
    .foot-contact-item svg {
      width: 18px;
      height: 18px;
      flex-shrink: 0;
      margin-top: 3px;
      color: #FBBF24;
    }
    .foot-contact-item a {
      color: #FFFFFF;
      font-weight: 600;
      text-decoration: underline;
      text-decoration-color: rgba(255, 255, 255, 0.4);
      transition: color .15s ease;
    }
    .foot-contact-item a:hover {
      color: #FDE047;
      text-decoration-color: #FDE047;
    }
    .foot-map-wrap {
      margin-top: 14px;
      border-radius: 10px;
      overflow: hidden;
      border: 1.5px solid rgba(255, 255, 255, 0.25);
      box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2);
      background: #E5EBE6;
    }
    .foot-map-wrap iframe {
      width: 100%;
      height: 125px;
      border: 0;
      display: block;
    }
    .foot-map-link {
      display: block;
      padding: 6px 12px;
      background: #143D24;
      color: #FFFFFF;
      font-size: 11.5px;
      text-align: center;
      font-weight: 600;
      letter-spacing: 0.02em;
      transition: background .15s ease;
    }
    .foot-map-link:hover {
      background: #D97706;
      color: #FFFFFF;
    }

    /* FOOTER MIDDLE BANNER */
    .foot-banner {
      margin: 48px auto 32px;
      text-align: center;
      padding: 16px 0;
    }
    .foot-banner-tagline {
      font-family: 'Fraunces', Georgia, serif;
      font-size: clamp(24px, 3.5vw, 38px);
      font-weight: 800;
      letter-spacing: 0.08em;
      color: #FFFFFF;
      line-height: 1.2;
    }
    .foot-banner-tagline .accent-word {
      color: #FBBF24;
    }
    .foot-banner-tagline .sep-dot {
      color: #FFFFFF;
      margin: 0 12px;
      opacity: 0.8;
    }
    .foot-banner-sub {
      margin-top: 8px;
      font-size: 11.5px;
      font-weight: 700;
      letter-spacing: 0.16em;
      text-transform: uppercase;
      color: #E8F3EA;
    }

    /* FOOTER BOTTOM BAR */
    .foot-bottom-bar {
      background: #143D24;
      border-radius: 8px;
      padding: 16px 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 16px;
      font-size: 13.5px;
      color: #E8F3EA;
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
      background: #D97706;
      color: #FFFFFF;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: transform .15s ease, background .15s ease;
    }
    .social-btn:hover {
      transform: translateY(-2px);
      background: #F59E0B;
    }
    .social-btn svg {
      width: 16px;
      height: 16px;
      fill: currentColor;
    }

    /* CHATBOT WIDGET */
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
      background: #F8FAF8;
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
      border: 1px solid rgba(217,119,6,0.3);
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
      .widget-panel, .nav-links, summary .plus, .chat-mock, .ebook-card, .service-item, .article-card {
        transition: none !important;
      }
    }
  </style>
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
        <a href="{{ route('home') }}">Beranda</a>
        <a href="{{ route('about') }}">Tentang Layanan</a>
        <a href="{{ route('ebook.index') }}">Katalog E-Book</a>
        <a href="{{ route('article.index') }}">Artikel &amp; Tips</a>
        <a href="{{ route('faq') }}">Pusat Bantuan</a>
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
            <button type="submit" class="btn btn-ghost" style="padding: 10px 18px; font-size:14px;">Keluar</button>
          </form>
        @else
          <a class="login" href="{{ route('login') }}">Masuk</a>
          <a class="btn btn-primary" href="{{ route('register') }}">Daftar Akun</a>
        @endauth
        <button class="nav-toggle" id="navToggle" aria-label="Buka navigasi menu" aria-expanded="false">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>
  </header>

  <!-- HERO SECTION -->
  <section class="hero" id="hero">
    <div class="hero-canvas static-fallback" id="heroCanvas" aria-hidden="true"></div>
    <div class="wrap">
      <div>
        <div class="hero-badge">
          <span class="badge-dot"></span> Bimbingan &amp; Konseling SMA Negeri 4 Jember
        </div>
        <h1>Ruang aman untuk bercerita, bertanya, dan menemukan <em>arah</em>.</h1>
        <p class="hero-lede">
          SAPA hadir mendampingi siswa SMA Negeri 4 Jember dalam menghadapi persoalan belajar, pemilihan jurusan kuliah, maupun pengembangan diri. Tanyakan pertanyaanmu di sini, atau terhubung langsung dengan Guru BK.
        </p>
        <div class="hero-ctas">
          <a href="{{ auth()->check() ? route('siswa.chat') : route('login') }}" class="btn btn-primary" id="openWidgetFromHero">Mulai Konsultasi Online</a>
          <a href="#layanan" class="btn btn-ghost">Jelajahi Layanan BK</a>
        </div>
        <div class="hero-trust">
          <div>
            <strong>08.00 - 15.00 WIB</strong>
            Layanan live chat Guru BK
          </div>
          <div>
            <strong>Ruang Rahasia</strong>
            Terjaga kode etik konseling
          </div>
          <div>
            <strong>Terbuka untuk Siswa</strong>
            Kelas X, XI, dan XII SMAN 4
          </div>
        </div>
      </div>

      <!-- HERO INTERACTIVE CONSULTATION CARD -->
      <div class="chat-mock-wrap">
        <div class="chat-mock">
          <div class="chat-mock-head">
            <div class="status-dot"></div>
            <div class="who">SAPA : Pendamping Digital BK</div>
            <div class="status-text">Siap Mendengarkan<br/>08.00 - 15.00 WIB</div>
          </div>
          <div class="chat-mock-body">
            <div class="bubble user">Saya sering merasa cemas dan bingung memilih fokus jurusan kuliah...</div>
            <div class="bubble bot">
              Wajar sekali merasa bimbang saat merencanakan masa depan. Mari mulai dengan memetakan minat belajarmu dan mendiskusikan peluang jalur SNBP/SNBT bersama Guru BK.
              <span class="src">Sumber: Panduan Eksplorasi Minat &amp; Bakat SMAN 4 Jember</span>
            </div>
          </div>
          
          <!-- REAL INTERACTIVE INPUT FORM -->
          <form id="heroChatForm" action="{{ auth()->check() ? route('siswa.chat') : route('login') }}" method="GET" class="chat-mock-foot">
            <input 
              type="text" 
              name="{{ auth()->check() ? 'q' : 'initial_query' }}" 
              placeholder="Ceritakan apa yang sedang kamu rasakan..." 
              aria-label="Tuliskan pertanyaan atau cerita konseling"
              required 
              autocomplete="off"
            />
            <button type="submit" aria-label="Kirim dan mulai sesi konsultasi">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 12h15M13 6l6 6-6 6"/>
              </svg>
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- LAYANAN BK -->
  <section class="services" id="layanan">
    <div class="wrap">
      <div class="services-head">
        <div>
          <h2 class="heading-section">Layanan yang Dapat Kamu Akses</h2>
          <p class="section-lede">
            Setiap siswa memiliki tantangan yang berbeda. Kami menyediakan empat bidang pendampingan agar kamu dapat belajar dan berkembang dengan nyaman.
          </p>
        </div>
      </div>

      <div class="service-grid">
        <div class="service-item">
          <div class="service-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 6.5c-2-1.3-4.6-1.7-7-1V17c2.4-.7 5-.3 7 1 2-1.3 4.6-1.7 7-1V5.5c-2.4-.7-5-.3-7 1Z"/>
              <path d="M12 6.5V18"/>
            </svg>
          </div>
          <div>
            <h3>Bimbingan Belajar &amp; Akademik</h3>
            <p>Bantuan menyusun manajemen waktu belajar, mengatasi kesulitan pemahaman mata pelajaran, serta persiapan ujian sekolah.</p>
            <span class="tag">Chat Asisten &amp; Guru BK</span>
          </div>
        </div>

        <div class="service-item">
          <div class="service-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="9" cy="9" r="3.3"/>
              <circle cx="16" cy="10" r="2.6"/>
              <path d="M3.5 19c.6-3 2.7-4.6 5.5-4.6s4.9 1.6 5.5 4.6"/>
              <path d="M14.5 19c.4-2.2 1.9-3.4 4-3.4"/>
            </svg>
          </div>
          <div>
            <h3>Konseling Pribadi &amp; Sosial</h3>
            <p>Ruang aman untuk bercerita tentang pertemanan, hubungan keluarga, atau tekanan perasaan yang berat dihadapi sendirian.</p>
            <span class="tag">Kerahasiaan Dijamin Penuh</span>
          </div>
        </div>

        <div class="service-item">
          <div class="service-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="8.3"/>
              <path d="m15 9-1.8 4.2L9 15l1.8-4.2Z"/>
            </svg>
          </div>
          <div>
            <h3>Konseling Karier &amp; Studi Lanjut</h3>
            <p>Eksplorasi minat bakat, konsultasi pemilihan jurusan perguruan tinggi, persiapan seleksi SNBP/SNBT, hingga sekolah kedinasan.</p>
            <span class="tag">Kuesioner &amp; Konsultasi</span>
          </div>
        </div>

        <div class="service-item">
          <div class="service-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 7v5.5l3.5 2"/>
              <circle cx="12" cy="12.5" r="8.3"/>
            </svg>
          </div>
          <div>
            <h3>Konsultasi Langsung Guru BK</h3>
            <p>Bicara langsung dengan Guru BK pada jam sekolah melalui fitur percakapan terintegrasi atau janji temu di ruang BK sekolah.</p>
            <span class="tag">Senin - Jumat, 08.00 - 15.00 WIB</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CARA KERJA -->
  <section class="how">
    <div class="wrap">
      <h2 class="heading-section">Cara Mudah Memulai Konseling</h2>
      <p class="section-lede">Tiga langkah sederhana, mulai dari menuliskan hal yang kamu rasakan hingga berbicara langsung dengan Guru BK.</p>

      <div class="how-steps">
        <div class="how-step">
          <div class="how-num">1</div>
          <h3>Ceritakan Hal yang Mengganjal</h3>
          <p>Tulis pertanyaan, keluhan belajar, atau situasi yang sedang kamu alami. Tidak ada pertanyaan yang dianggap terlalu kecil.</p>
        </div>
        <div class="how-step">
          <div class="how-num">2</div>
          <h3>Dapatkan Arahan Terpercaya</h3>
          <p>SAPA menyusun jawaban berdasarkan dokumen resmi dan pedoman BK sekolah, lengkap dengan rujukan materi yang jelas.</p>
        </div>
        <div class="how-step">
          <div class="how-num">3</div>
          <h3>Lanjutkan ke Guru BK Bila Butuh</h3>
          <p>Jika kamu memerlukan bimbingan lebih dalam, kamu bisa langsung terhubung ke Guru BK saat jam sekolah berlangsung.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- E-BOOK BK -->
  <section class="ebooks" id="ebook">
    <div class="wrap">
      <div class="services-head">
        <div>
          <h2 class="heading-section">Koleksi E-Book &amp; Modul Bimbingan</h2>
          <p class="section-lede">Kumpulan panduan praktis belajar, kesehatan mental remaja, dan persiapan karier yang dapat dibaca oleh seluruh siswa.</p>
        </div>
        <a href="{{ route('ebook.index') }}" class="btn btn-ghost">Buka Katalog E-Book</a>
      </div>

      <div class="ebook-row">
        @forelse($ebooks as $index => $eb)
          @php
            $colorClasses = ['alt-color-1', 'alt-color-2', 'alt-color-3', 'alt-color-4'];
            $colorClass = $colorClasses[$index % count($colorClasses)];
          @endphp
          <div class="ebook-card">
            <a href="{{ route('ebook.detail', $eb->id) }}" class="ebook-cover {{ $colorClass }}" aria-label="Buka detail e-book {{ $eb->title }}">
              <div class="ebook-badge">E-Book BK</div>
              <span>{{ $eb->title }}</span>
            </a>
            <div class="ebook-meta">
              <strong><a href="{{ route('ebook.detail', $eb->id) }}">{{ $eb->title }}</a></strong>
              <span>Tim Guru BK SMAN 4 Jember</span>
            </div>
          </div>
        @empty
          <!-- Fallback items if database is empty -->
          <div class="ebook-card">
            <a href="{{ route('ebook.index') }}" class="ebook-cover alt-color-1">
              <div class="ebook-badge">Modul Belajar</div>
              <span>Strategi Belajar Efektif di SMA</span>
            </a>
            <div class="ebook-meta">
              <strong>Strategi Belajar Efektif di SMA</strong>
              <span>Tim Guru BK SMAN 4 Jember</span>
            </div>
          </div>
          <div class="ebook-card">
            <a href="{{ route('ebook.index') }}" class="ebook-cover alt-color-2">
              <div class="ebook-badge">Kesehatan Mental</div>
              <span>Mengelola Stres &amp; Beban Ujian</span>
            </a>
            <div class="ebook-meta">
              <strong>Mengelola Stres &amp; Beban Ujian</strong>
              <span>Tim Guru BK SMAN 4 Jember</span>
            </div>
          </div>
          <div class="ebook-card">
            <a href="{{ route('ebook.index') }}" class="ebook-cover alt-color-3">
              <div class="ebook-badge">Perencanaan Karier</div>
              <span>Panduan Memilih Jurusan Kuliah</span>
            </a>
            <div class="ebook-meta">
              <strong>Panduan Memilih Jurusan Kuliah</strong>
              <span>Tim Guru BK SMAN 4 Jember</span>
            </div>
          </div>
          <div class="ebook-card">
            <a href="{{ route('ebook.index') }}" class="ebook-cover alt-color-4">
              <div class="ebook-badge">Pengembangan Diri</div>
              <span>Mengenal Potensi Diri Remaja</span>
            </a>
            <div class="ebook-meta">
              <strong>Mengenal Potensi Diri Remaja</strong>
              <span>Tim Guru BK SMAN 4 Jember</span>
            </div>
          </div>
        @endforelse
      </div>
    </div>
  </section>

  <!-- ARTIKEL BK -->
  <section class="articles" id="artikel">
    <div class="wrap">
      <div class="services-head">
        <div>
          <h2 class="heading-section">Artikel &amp; Tips Bimbingan Terbaru</h2>
          <p class="section-lede">Wawasan praktis seputar motivasi belajar, tips ujian, dan kesehatan emosi dari Guru BK SMA Negeri 4 Jember.</p>
        </div>
        <a href="{{ route('article.index') }}" class="btn btn-ghost">Lihat Semua Artikel</a>
      </div>

      <div class="article-row">
        @forelse($articles as $art)
          <article class="article-card">
            <div class="article-thumb" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
                <path d="M6 6h10M6 10h10"/>
              </svg>
            </div>
            <div class="abody">
              <div>
                <h3><a href="{{ route('article.detail', $art->slug) }}">{{ $art->title }}</a></h3>
                <p>{{ \Illuminate\Support\Str::limit(strip_tags($art->content), 100) }}</p>
              </div>
              <div class="ameta">
                <span>Tim Guru BK</span>
                <span>{{ $art->created_at ? $art->created_at->format('d M Y') : 'Terbaru' }}</span>
              </div>
            </div>
          </article>
        @empty
          <!-- Fallback items if database is empty -->
          <article class="article-card">
            <div class="article-thumb" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
                <path d="M6 6h10M6 10h10"/>
              </svg>
            </div>
            <div class="abody">
              <div>
                <h3><a href="{{ route('article.index') }}">5 Cara Meredakan Rasa Cemas Menjelang Ujian Sekolah</a></h3>
                <p>Langkah sederhana yang bisa dicoba sehari sebelum ujian agar pikiran tetap tenang dan fokus.</p>
              </div>
              <div class="ameta">
                <span>Tim Guru BK</span>
                <span>4 menit baca</span>
              </div>
            </div>
          </article>
          <article class="article-card">
            <div class="article-thumb" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
                <path d="M6 6h10M6 10h10"/>
              </svg>
            </div>
            <div class="abody">
              <div>
                <h3><a href="{{ route('article.index') }}">Bingung Memilih Jurusan Kuliah? Mulai dari 3 Pertanyaan Ini</a></h3>
                <p>Panduan refleksi diri untuk memetakan bakat alami dan kesesuaian dengan prospek karier.</p>
              </div>
              <div class="ameta">
                <span>Tim Guru BK</span>
                <span>5 menit baca</span>
              </div>
            </div>
          </article>
          <article class="article-card">
            <div class="article-thumb" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
                <path d="M6 6h10M6 10h10"/>
              </svg>
            </div>
            <div class="abody">
              <div>
                <h3><a href="{{ route('article.index') }}">Bercerita ke Guru BK Bukan Hal yang Perlu Ditakuti</a></h3>
                <p>Mengenal peran Guru BK sebagai pendamping yang mendengar tanpa menghakimi.</p>
              </div>
              <div class="ameta">
                <span>Tim Guru BK</span>
                <span>3 menit baca</span>
              </div>
            </div>
          </article>
        @endforelse
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section class="faq" id="faq">
    <div class="wrap">
      <h2 class="heading-section">Pertanyaan yang Sering Diajukan</h2>

      <div class="faq-list">
        @forelse($faqs as $index => $f)
          <details {{ $index === 0 ? 'open' : '' }}>
            <summary>
              <span>{{ $f->question }}</span>
              <span class="plus" aria-hidden="true">+</span>
            </summary>
            <p>{{ $f->answer }}</p>
          </details>
        @empty
          <details open>
            <summary>
              <span>Siapa saja yang dapat menggunakan layanan SAPA BK?</span>
              <span class="plus" aria-hidden="true">+</span>
            </summary>
            <p>Seluruh siswa SMA Negeri 4 Jember dapat mengakses materi edukasi, e-book, dan berkonsultasi dengan SAPA. Untuk menyimpan riwayat sesi konseling dan terhubung langsung ke Guru BK, siswa dapat masuk menggunakan akun terdaftar.</p>
          </details>
          <details>
            <summary>
              <span>Apakah cerita dan permasalahan saya dijamin kerahasiaannya?</span>
              <span class="plus" aria-hidden="true">+</span>
            </summary>
            <p>Ya. Kerahasiaan percakapanmu dijaga sepenuhnya sesuai dengan kode etik Bimbingan dan Konseling. Hanya Guru BK berwenang yang dapat mengakses data konseling demi memberikan pendampingan yang tepat.</p>
          </details>
          <details>
            <summary>
              <span>Kapan saya bisa mengobrol langsung dengan Guru BK?</span>
              <span class="plus" aria-hidden="true">+</span>
            </summary>
            <p>Fitur live chat dengan Guru BK tersedia setiap hari sekolah, Senin sampai Jumat pukul 08.00 sampai 15.00 WIB. Di luar jam tersebut, kamu tetap dapat menyampaikan pertanyaan melalui asisten SAPA.</p>
          </details>
          <details>
            <summary>
              <span>Apakah SAPA menggantikan peran Guru BK di sekolah?</span>
              <span class="plus" aria-hidden="true">+</span>
            </summary>
            <p>Tidak. SAPA adalah asisten pendamping digital yang membantu memberikan jawaban awal dan referensi materi. Untuk pendampingan yang mendalam, tatap muka dan konseling personal dengan Guru BK tetap menjadi sarana utama.</p>
          </details>
        @endforelse
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <div class="wrap">
      <div class="foot-row">
        <!-- Kolom 1: SAPA BK -->
        <div class="foot-col">
          <div class="brand-name" style="color: #FFFFFF; font-size: 22px; font-weight: 700; margin-bottom: 14px; letter-spacing: -0.01em;">SAPA BK</div>
          <p style="font-size: 14.5px; line-height: 1.65; color: #E2EFE5;">
            Portal Bimbingan dan Konseling digital SMA Negeri 4 Jember. Ruang aman bagi seluruh siswa untuk bertanya, bercerita, dan merencanakan masa depan.
          </p>
        </div>

        <!-- Kolom 2: Jelajahi Portal -->
        <div class="foot-col">
          <h4><span class="foot-bar">|</span> Jelajahi Portal</h4>
          <ul>
            <li><span class="foot-bullet">&#9642;</span><a href="#hero">Beranda</a></li>
            <li><span class="foot-bullet">&#9642;</span><a href="#layanan">Layanan BK</a></li>
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
            <a href="mailto:bk@sman4jember.sch.id" style="color: #FFFFFF;">bk@sman4jember.sch.id</a>
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

  <!-- Modular Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js" defer></script>
  <script src="{{ asset('js/hero-scene.js') }}" defer></script>
  <script src="{{ asset('js/landing.js') }}" defer></script>
</body>
</html>
