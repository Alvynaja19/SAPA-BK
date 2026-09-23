@extends('layouts.app')

@section('title', 'Perpustakaan E-Book & Modul Siswa : SAPA BK SMAN 4 Jember')
@section('page_title', 'Perpustakaan Digital Siswa')

@push('styles')
<style>
  /* ===================================================
     SAPA BK - PERPUSTAKAAN DIGITAL & E-BOOK SISWA
     Antislop: No em dash, WCAG AA contrast, Vanilla CSS
     =================================================== */

  .ebook-portal-container {
    display: flex;
    flex-direction: column;
    gap: 24px;
    position: relative;
  }

  /* Editorial Header */
  .ebook-portal-header {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-l);
    padding: 24px 28px;
    box-shadow: var(--shadow-card);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
  }
  .ebook-portal-header-info {
    max-width: 680px;
  }
  .ebook-portal-breadcrumb {
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: var(--primary);
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .ebook-portal-header h2 {
    font-size: 24px;
    font-weight: 600;
    color: var(--ink);
    line-height: 1.25;
  }
  .ebook-portal-header p {
    color: var(--ink-soft);
    font-size: 14.5px;
    margin-top: 6px;
    line-height: 1.55;
  }
  .ebook-portal-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--primary-soft);
    color: var(--primary);
    padding: 10px 18px;
    border-radius: 99px;
    font-size: 13px;
    font-weight: 600;
    border: 1px solid rgba(21,128,61,0.22);
    min-height: 44px;
  }

  /* Summary Counter Strip */
  .ebook-summary-strip {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
  }
  .ebook-summary-card {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-m);
    padding: 18px 20px;
    box-shadow: var(--shadow-card);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 100px;
  }
  .ebook-summary-label {
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: var(--ink-faint);
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .ebook-summary-val {
    font-family: 'Fraunces', Georgia, serif;
    font-size: 28px;
    font-weight: 600;
    color: var(--ink);
    line-height: 1;
    margin-top: 8px;
  }
  .ebook-summary-desc {
    font-size: 12px;
    color: var(--ink-soft);
    margin-top: 4px;
  }

  /* Controls Panel: Search & Filters */
  .ebook-controls-panel {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-l);
    padding: 20px 24px;
    box-shadow: var(--shadow-card);
    display: flex;
    flex-direction: column;
    gap: 18px;
  }

  /* Search Input Wrapper */
  .ebook-search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
  }
  .ebook-search-icon {
    position: absolute;
    left: 16px;
    color: var(--ink-faint);
    pointer-events: none;
  }
  .ebook-search-input {
    width: 100%;
    min-height: 48px;
    padding: 12px 48px 12px 46px;
    font-size: 14.5px;
    border-radius: var(--radius-s);
    border: 1.5px solid var(--line);
    background: var(--bg);
    color: var(--ink);
    transition: border-color .15s ease, box-shadow .15s ease, background-color .15s ease;
  }
  .ebook-search-input:focus {
    outline: none;
    border-color: var(--primary);
    background: #FFFFFF;
    box-shadow: 0 0 0 3px rgba(21,128,61,0.15);
  }
  .ebook-search-clear {
    position: absolute;
    right: 12px;
    background: transparent;
    border: none;
    color: var(--ink-faint);
    cursor: pointer;
    padding: 8px;
    border-radius: 50%;
    display: none;
    align-items: center;
    justify-content: center;
    min-width: 32px;
    min-height: 32px;
  }
  .ebook-search-clear:hover {
    color: var(--ink);
    background: var(--line);
  }
  .ebook-search-clear.visible {
    display: flex;
  }

  /* Filter Navigation Tabs */
  .ebook-filter-scroll {
    display: flex;
    align-items: center;
    gap: 10px;
    overflow-x: auto;
    padding-bottom: 4px;
    scrollbar-width: thin;
    -webkit-overflow-scrolling: touch;
  }
  .ebook-filter-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    min-height: 44px;
    padding: 10px 18px;
    border-radius: 99px;
    font-size: 13.5px;
    font-weight: 500;
    color: var(--ink-soft);
    background: var(--bg-alt);
    border: 1px solid var(--line);
    cursor: pointer;
    white-space: nowrap;
    transition: all .15s ease;
  }
  .ebook-filter-pill:hover {
    background: #E4ECE3;
    color: var(--ink);
    border-color: #CAD5C8;
  }
  .ebook-filter-pill.active {
    background: var(--primary);
    color: #FFFFFF;
    border-color: var(--primary);
    box-shadow: 0 2px 6px rgba(21,128,61,0.25);
    font-weight: 600;
  }

  /* Sub-Filter Jenjang Kelas */
  .ebook-subfilter-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    padding-top: 14px;
    border-top: 1px dashed var(--line);
  }
  .ebook-subfilter-label {
    font-size: 12.5px;
    font-weight: 600;
    color: var(--ink-faint);
    text-transform: uppercase;
    letter-spacing: .05em;
  }
  .ebook-class-pill {
    display: inline-flex;
    align-items: center;
    min-height: 38px;
    padding: 6px 14px;
    border-radius: var(--radius-s);
    font-size: 13px;
    font-weight: 500;
    background: var(--surface);
    border: 1px solid var(--line);
    color: var(--ink-soft);
    cursor: pointer;
    transition: all .15s ease;
  }
  .ebook-class-pill:hover {
    border-color: var(--primary);
    color: var(--primary);
  }
  .ebook-class-pill.active {
    background: var(--primary-soft);
    border-color: var(--primary);
    color: var(--primary);
    font-weight: 600;
  }

  /* Status Bar */
  .ebook-status-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    font-size: 13.5px;
    color: var(--ink-faint);
  }
  .ebook-result-count strong {
    color: var(--ink);
  }
  .ebook-reset-btn {
    background: transparent;
    border: none;
    color: var(--primary);
    font-weight: 600;
    cursor: pointer;
    text-decoration: underline;
    font-size: 13px;
    padding: 6px 8px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
  .ebook-reset-btn:hover {
    color: var(--primary-hover);
  }

  /* Books Grid */
  .ebook-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
    gap: 22px;
  }

  /* Single Book Card */
  .ebook-card-item {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-m);
    box-shadow: var(--shadow-card);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    height: 100%;
  }
  .ebook-card-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 16px rgba(15,29,19,0.08), 0 14px 28px -6px rgba(15,29,19,0.14);
    border-color: #B4C4B8;
  }

  /* Book Cover Area */
  .ebook-cover-wrapper {
    height: 220px;
    position: relative;
    background: #1C2E25;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .ebook-cover-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .25s ease;
  }
  .ebook-card-item:hover .ebook-cover-img {
    transform: scale(1.04);
  }
  .ebook-cover-fallback {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 20px 22px;
    background: linear-gradient(135deg, #1B3832 0%, #24463F 65%, #0F211C 100%);
    color: #FFFFFF;
    position: relative;
  }
  .ebook-cover-fallback::before {
    content: '';
    position: absolute;
    top: 0;
    left: 12px;
    bottom: 0;
    width: 2px;
    background: rgba(255,255,255,0.18);
  }
  .ebook-fallback-title {
    font-family: 'Fraunces', Georgia, serif;
    font-size: 16px;
    font-weight: 600;
    line-height: 1.35;
    color: #FFFFFF;
  }

  /* Badge Overlay */
  .ebook-badge-overlay {
    position: absolute;
    top: 12px;
    left: 12px;
    right: 12px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 8px;
    z-index: 2;
  }
  .ebook-tag-badge {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .05em;
    padding: 5px 10px;
    border-radius: 6px;
    background: rgba(15, 29, 19, 0.78);
    backdrop-filter: blur(4px);
    border: 1px solid rgba(255,255,255,0.25);
    color: #FFFFFF;
    max-width: 160px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .ebook-tag-badge.badge-merdeka {
    background: rgba(21, 128, 61, 0.88);
    border-color: rgba(220, 252, 231, 0.4);
  }
  .ebook-tag-badge.badge-mental {
    background: rgba(180, 83, 9, 0.88);
    border-color: rgba(254, 243, 199, 0.4);
  }
  .ebook-tag-badge.badge-internal {
    background: rgba(30, 58, 138, 0.88);
    border-color: rgba(219, 234, 254, 0.4);
  }

  /* Card Body */
  .ebook-card-body {
    padding: 18px 20px;
    display: flex;
    flex-direction: column;
    flex: 1;
    justify-content: space-between;
    gap: 14px;
  }
  .ebook-card-category {
    font-size: 11.5px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: var(--primary);
  }
  .ebook-card-title {
    font-family: 'Fraunces', Georgia, serif;
    font-size: 17px;
    font-weight: 600;
    color: var(--ink);
    line-height: 1.35;
    margin-top: 4px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  .ebook-meta-authors {
    font-size: 12.5px;
    color: var(--ink-faint);
    margin-top: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .ebook-card-synopsis {
    font-size: 13px;
    color: var(--ink-soft);
    line-height: 1.55;
    margin-top: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  /* Card Footer Actions */
  .ebook-card-footer {
    padding-top: 14px;
    border-top: 1px solid var(--line);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
  }
  .ebook-card-meta-detail {
    font-size: 12px;
    color: var(--ink-faint);
    display: flex;
    align-items: center;
    gap: 5px;
  }
  .ebook-card-actions {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  /* Skeleton Loading */
  .ebook-skeleton-card {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-m);
    height: 420px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
  }
  .ebook-skeleton-cover {
    height: 220px;
    background: linear-gradient(90deg, #EDF2EC 25%, #E1E8DF 50%, #EDF2EC 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
  }
  .ebook-skeleton-body {
    padding: 18px 20px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    flex: 1;
  }
  .ebook-skeleton-line {
    height: 14px;
    border-radius: 4px;
    background: linear-gradient(90deg, #EDF2EC 25%, #E1E8DF 50%, #EDF2EC 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
  }
  @keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
  }

  /* Empty State */
  .ebook-empty-state {
    background: var(--surface);
    border: 1px dashed var(--line);
    border-radius: var(--radius-m);
    padding: 56px 24px;
    text-align: center;
    grid-column: 1 / -1;
  }
  .ebook-empty-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 16px;
    border-radius: 50%;
    background: var(--bg-alt);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .ebook-empty-state h3 {
    font-size: 20px;
    color: var(--ink);
    margin-bottom: 8px;
  }
  .ebook-empty-state p {
    font-size: 14px;
    color: var(--ink-soft);
    max-width: 480px;
    margin: 0 auto 20px;
    line-height: 1.6;
  }

  /* ===================================================
     MODAL PEMBACA ONLINE (IN-APP ONLINE READER)
     =================================================== */
  .ebook-modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 2000;
    display: none;
    align-items: center;
    justify-content: center;
    background: rgba(15, 29, 19, 0.82);
    backdrop-filter: blur(6px);
    padding: 16px;
    transition: opacity .2s ease;
  }
  .ebook-modal-overlay.is-active {
    display: flex;
  }
  .ebook-modal-dialog {
    background: var(--surface);
    border-radius: var(--radius-l);
    width: 100%;
    max-width: 1140px;
    height: 92vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    box-shadow: 0 24px 64px rgba(0, 0, 0, 0.45);
    border: 1px solid var(--line);
    animation: modalSlideUp .22s cubic-bezier(0.16, 1, 0.3, 1);
  }
  @keyframes modalSlideUp {
    from {
      opacity: 0;
      transform: translateY(24px) scale(0.98);
    }
    to {
      opacity: 1;
      transform: translateY(0) scale(1);
    }
  }

  /* Modal Header */
  .ebook-reader-header {
    background: #0F1D13;
    color: #FFFFFF;
    padding: 14px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    border-bottom: 1px solid rgba(255,255,255,0.12);
  }
  .ebook-reader-title-area {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 0;
  }
  .ebook-reader-icon {
    width: 38px;
    height: 38px;
    border-radius: 8px;
    background: rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #86EFAC;
  }
  .ebook-reader-meta {
    min-width: 0;
  }
  .ebook-reader-title {
    font-family: 'Fraunces', Georgia, serif;
    font-size: 16.5px;
    font-weight: 600;
    color: #FFFFFF;
    line-height: 1.25;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .ebook-reader-sub {
    font-size: 12px;
    color: #CBD5E1;
    margin-top: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .ebook-reader-actions {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
  }
  .ebook-reader-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    min-height: 44px;
    padding: 8px 14px;
    border-radius: var(--radius-s);
    font-size: 13px;
    font-weight: 600;
    color: #FFFFFF;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    cursor: pointer;
    transition: background-color .15s ease, border-color .15s ease;
  }
  .ebook-reader-btn:hover {
    background: rgba(255,255,255,0.22);
    border-color: rgba(255,255,255,0.35);
  }
  .ebook-reader-btn.close {
    background: rgba(239, 68, 68, 0.2);
    border-color: rgba(239, 68, 68, 0.4);
    color: #FECACA;
    min-width: 44px;
    padding: 8px;
  }
  .ebook-reader-btn.close:hover {
    background: rgba(239, 68, 68, 0.35);
    color: #FFFFFF;
  }

  /* Notice Bar inside Reader */
  .ebook-reader-notice {
    background: var(--bg-alt);
    border-bottom: 1px solid var(--line);
    padding: 8px 20px;
    font-size: 12.5px;
    color: var(--ink-soft);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
  }
  .ebook-reader-notice a {
    color: var(--primary);
    font-weight: 600;
    text-decoration: underline;
  }

  /* Frame Area */
  .ebook-reader-frame-box {
    flex: 1;
    position: relative;
    background: #F1F5F0;
    width: 100%;
    height: 100%;
  }
  .ebook-reader-iframe {
    width: 100%;
    height: 100%;
    border: none;
    display: block;
    background: #FFFFFF;
  }
  .ebook-reader-loading {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #F8FAF8;
    color: var(--ink);
    z-index: 5;
    gap: 14px;
    transition: opacity .2s ease;
  }
  .ebook-reader-spinner {
    width: 42px;
    height: 42px;
    border: 3.5px solid var(--line);
    border-top-color: var(--primary);
    border-radius: 50%;
    animation: readerSpin .8s linear infinite;
  }
  @keyframes readerSpin {
    to { transform: rotate(360deg); }
  }

  /* Modal Detail */
  .ebook-detail-dialog {
    max-width: 720px;
    height: auto;
    max-height: 90vh;
    padding: 28px;
    overflow-y: auto;
  }
  .ebook-detail-grid {
    display: grid;
    grid-template-columns: 220px 1fr;
    gap: 24px;
    align-items: start;
  }
  .ebook-detail-cover {
    width: 100%;
    aspect-ratio: 3/4;
    border-radius: var(--radius-s);
    object-fit: cover;
    box-shadow: 0 8px 24px rgba(15,29,19,0.18);
    border: 1px solid var(--line);
  }

  /* Responsive Design */
  @media (max-width: 992px) {
    .ebook-summary-strip {
      grid-template-columns: repeat(2, 1fr);
      gap: 12px;
    }
    .ebook-modal-dialog {
      height: 96vh;
    }
  }

  @media (max-width: 680px) {
    .ebook-summary-strip {
      grid-template-columns: 1fr;
    }
    .ebook-portal-header {
      padding: 18px 16px;
    }
    .ebook-controls-panel {
      padding: 16px;
    }
    .ebook-grid {
      grid-template-columns: 1fr;
      gap: 16px;
    }
    .ebook-modal-dialog {
      width: 100vw;
      height: 100vh;
      border-radius: 0;
    }
    .ebook-modal-overlay {
      padding: 0;
    }
    .ebook-detail-grid {
      grid-template-columns: 1fr;
      gap: 18px;
    }
    .ebook-reader-header {
      padding: 10px 14px;
    }
    .ebook-reader-title {
      font-size: 14.5px;
    }
  }
</style>
@endpush

@section('content')
<div class="ebook-portal-container">

  <!-- Editorial Header -->
  <header class="ebook-portal-header">
    <div class="ebook-portal-header-info">
      <div class="ebook-portal-breadcrumb">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
        </svg>
        <span>Pustaka Digital Bimbingan Konseling</span>
      </div>
      <h2>Perpustakaan E-Book &amp; Modul Siswa</h2>
      <p>
        Akses buku teks resmi Kurikulum Merdeka Kemendikbudristek, panduan kesehatan mental remaja, manajemen stres belajar, serta modul bimbingan resmi SMAN 4 Jember yang dapat dibaca langsung secara online.
      </p>
    </div>
    <div>
      <div class="ebook-portal-badge">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
          <path d="m9 12 2 2 4-4"/>
        </svg>
        <span>Koleksi Terverifikasi &amp; Daring</span>
      </div>
    </div>
  </header>

  <!-- Summary Metric Strip -->
  <section class="ebook-summary-strip" aria-label="Statistik Koleksi Pustaka">
    <div class="ebook-summary-card">
      <div class="ebook-summary-label">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
          <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
        </svg>
        <span>Total Koleksi Siap Baca</span>
      </div>
      <div class="ebook-summary-val" id="summaryTotalVal">{{ $stats['total_all'] ?? count($curatedBooks) }}</div>
      <div class="ebook-summary-desc">Modul kurasi dan buku pelajaran</div>
    </div>

    <div class="ebook-summary-card">
      <div class="ebook-summary-label">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
        </svg>
        <span>Kesehatan Jiwa &amp; Emosi</span>
      </div>
      <div class="ebook-summary-val">{{ $stats['total_mental_health'] ?? 4 }}</div>
      <div class="ebook-summary-desc">Regulasi cemas dan resiliensi diri</div>
    </div>

    <div class="ebook-summary-card">
      <div class="ebook-summary-label">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
          <path d="M6 12v5c3 3 9 3 12 0v-5"/>
        </svg>
        <span>Buku Pelajaran SMA</span>
      </div>
      <div class="ebook-summary-val">{{ $stats['total_materi_sma'] ?? 9 }}</div>
      <div class="ebook-summary-desc">Kemendikbud Kelas X, XI, XII</div>
    </div>

    <div class="ebook-summary-card">
      <div class="ebook-summary-label">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
          <polyline points="14 2 14 8 20 8"/>
        </svg>
        <span>Modul Guru BK SMAN 4</span>
      </div>
      <div class="ebook-summary-val">{{ $stats['total_internal'] ?? count($internalEbooks) }}</div>
      <div class="ebook-summary-desc">Panduan resmi konselor sekolah</div>
    </div>
  </section>

  <!-- Controls Panel: Live Search and Category Navigation -->
  <section class="ebook-controls-panel" aria-label="Pencarian dan Filter E-Book">
    <!-- Live Search Input -->
    <div class="ebook-search-wrapper">
      <svg class="ebook-search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <circle cx="11" cy="11" r="8"/>
        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
      </svg>
      <input 
        type="search" 
        id="ebookSearchInput" 
        class="ebook-search-input" 
        placeholder="Cari judul buku, topik emosi, mata pelajaran, atau penulis..." 
        aria-label="Pencarian koleksi e-book"
        autocomplete="off"
      />
      <button type="button" id="ebookSearchClear" class="ebook-search-clear" aria-label="Bersihkan pencarian">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" y1="6" x2="6" y2="18"/>
          <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>

    <!-- Category Filter Tabs -->
    <nav class="ebook-filter-scroll" aria-label="Kategori Koleksi">
      <button type="button" class="ebook-filter-pill active" data-category="semua">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="12" cy="12" r="10"/>
          <line x1="2" y1="12" x2="22" y2="12"/>
          <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
        </svg>
        <span>Semua Koleksi</span>
      </button>

      <button type="button" class="ebook-filter-pill" data-category="kesehatan_mental">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
        </svg>
        <span>Kesehatan Mental &amp; Remaja</span>
      </button>

      <button type="button" class="ebook-filter-pill" data-category="materi_sma">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
          <path d="M6 12v5c3 3 9 3 12 0v-5"/>
        </svg>
        <span>Materi Belajar SMA</span>
      </button>

      <button type="button" class="ebook-filter-pill" data-category="modul_internal">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
          <polyline points="14 2 14 8 20 8"/>
        </svg>
        <span>Modul Guru BK SMAN 4</span>
      </button>

      <button type="button" class="ebook-filter-pill" data-category="stres_belajar">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="12" cy="12" r="10"/>
          <polyline points="12 6 12 12 16 14"/>
        </svg>
        <span>Manajemen Stres &amp; Waktu</span>
      </button>

      <button type="button" class="ebook-filter-pill" data-category="karir_kuliah">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="12" cy="12" r="10"/>
          <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/>
        </svg>
        <span>Bimbingan Karir &amp; Kuliah</span>
      </button>
    </nav>

    <!-- Sub-Filter Jenjang Kelas (Muncul saat Materi Belajar SMA dipilih) -->
    <div class="ebook-subfilter-bar" id="classSubfilterBar" style="display: none;">
      <span class="ebook-subfilter-label">Pilih Jenjang Kelas:</span>
      <button type="button" class="ebook-class-pill active" data-class="semua">Semua Jenjang</button>
      <button type="button" class="ebook-class-pill" data-class="Kelas X">Kelas X</button>
      <button type="button" class="ebook-class-pill" data-class="Kelas XI">Kelas XI</button>
      <button type="button" class="ebook-class-pill" data-class="Kelas XII">Kelas XII</button>
    </div>

    <!-- Status Bar: Result Count and Reset Action -->
    <div class="ebook-status-bar">
      <div class="ebook-result-count" id="ebookResultCount">
        Menampilkan <strong id="visibleCountText">{{ count($curatedBooks) + count($internalEbooks) }}</strong> buku dan modul referensi
      </div>
      <button type="button" id="ebookResetFilterBtn" class="ebook-reset-btn" style="display: none;">
        <span>Reset Filter &amp; Pencarian</span>
      </button>
    </div>
  </section>

  <!-- Books Grid Container -->
  <main class="ebook-grid" id="ebookGridContainer" aria-label="Daftar Modul dan Buku Daring">
    {{-- Cards will be populated dynamically from JavaScript or initial SSR --}}
  </main>

  <!-- Error Notification State -->
  <div id="ebookErrorState" style="display: none; background: #FEF2F2; border: 1px solid #FECACA; border-radius: var(--radius-m); padding: 18px 24px; text-align: center; color: #991B1B;">
    <p style="font-size: 14.5px; font-weight: 500;">
      Terjadi kendala saat memuat data dari server. Menampilkan koleksi tersimpan lokal.
    </p>
    <button type="button" id="ebookRetryBtn" class="btn btn-ghost btn-sm" style="margin-top: 10px; color: #991B1B; border-color: #991B1B;">
      Muat Ulang Koleksi
    </button>
  </div>

</div>

<!-- ===================================================
     MODAL PEMBACA ONLINE (IN-APP READER)
     =================================================== -->
<div class="ebook-modal-overlay" id="ebookReaderModal" role="dialog" aria-modal="true" aria-labelledby="modalReaderTitle">
  <div class="ebook-modal-dialog">
    <!-- Header Pembaca -->
    <div class="ebook-reader-header">
      <div class="ebook-reader-title-area">
        <div class="ebook-reader-icon" aria-hidden="true">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
          </svg>
        </div>
        <div class="ebook-reader-meta">
          <h3 class="ebook-reader-title" id="modalReaderTitle">Judul Buku Sedang Dibaca</h3>
          <div class="ebook-reader-sub" id="modalReaderSub">Penerbit Resmi &bull; Pembaca Digital</div>
        </div>
      </div>

      <div class="ebook-reader-actions">
        <!-- Buka di Tab Baru -->
        <a href="#" id="readerNewTabLink" target="_blank" rel="noopener noreferrer" class="ebook-reader-btn" title="Buka buku di jendela peramban penuh">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
            <polyline points="15 3 21 3 21 9"/>
            <line x1="10" y1="14" x2="21" y2="3"/>
          </svg>
          <span class="btn-text">Buka Tab Baru</span>
        </a>

        <!-- Tombol Tutup -->
        <button type="button" id="readerCloseBtn" class="ebook-reader-btn close" aria-label="Tutup jendela pembaca">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- Notice Bar -->
    <div class="ebook-reader-notice">
      <span>Gunakan kontrol perbesaran (zoom) dan daftar isi di dalam tampilan pembaca di bawah.</span>
      <span id="readerNoticeAction">
        Jika dokumen belum tampil karena pengaturan keamanan browser, silakan gunakan tombol <strong>Buka Tab Baru</strong>.
      </span>
    </div>

    <!-- Frame Container -->
    <div class="ebook-reader-frame-box">
      <!-- Loading Spinner Indicator -->
      <div class="ebook-reader-loading" id="readerLoadingSpinner">
        <div class="ebook-reader-spinner" aria-hidden="true"></div>
        <div style="font-size: 14px; font-weight: 500; color: var(--ink);">
          Menghubungkan ke pembaca dokumen digital...
        </div>
        <div style="font-size: 12.5px; color: var(--ink-faint);">
          Mohon tunggu beberapa detik hingga halaman buku siap dibaca.
        </div>
      </div>

      <!-- Live Iframe -->
      <iframe 
        id="readerIframe" 
        class="ebook-reader-iframe" 
        src="about:blank" 
        title="Pembaca Digital E-Book"
        allow="fullscreen"
        loading="lazy"
      ></iframe>
    </div>
  </div>
</div>

<!-- ===================================================
     MODAL DETAIL BUKU (METADATA & SINOPSIS LENGKAP)
     =================================================== -->
<div class="ebook-modal-overlay" id="ebookDetailModal" role="dialog" aria-modal="true" aria-labelledby="modalDetailTitle">
  <div class="ebook-modal-dialog ebook-detail-dialog">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
      <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--primary);">
        Informasi Lengkap E-Book
      </div>
      <button type="button" id="detailCloseBtn" class="btn btn-ghost btn-sm" style="min-height: 38px; padding: 6px 12px;" aria-label="Tutup detail buku">
        Tutup
      </button>
    </div>

    <div class="ebook-detail-grid">
      <div>
        <img id="detailModalCover" src="" alt="Sampul Buku" class="ebook-detail-cover" />
        <div id="detailModalBadges" style="margin-top: 12px; display: flex; flex-wrap: wrap; gap: 6px;"></div>
      </div>

      <div>
        <h3 id="modalDetailTitle" style="font-family: 'Fraunces', Georgia, serif; font-size: 22px; color: var(--ink); line-height: 1.3; margin-bottom: 8px;">
          Judul Lengkap Buku
        </h3>
        <div id="detailModalAuthors" style="font-size: 14px; color: var(--ink-faint); margin-bottom: 16px;">
          Penulis
        </div>

        <div style="background: var(--bg-alt); border-radius: var(--radius-s); padding: 12px 16px; margin-bottom: 18px; font-size: 13px; color: var(--ink-soft); display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px;">
          <div><strong>Penerbit:</strong> <span id="detailModalPublisher">-</span></div>
          <div><strong>Tahun Rilis:</strong> <span id="detailModalYear">-</span></div>
          <div><strong>Jumlah Halaman:</strong> <span id="detailModalPages">-</span></div>
          <div><strong>Bahasa:</strong> <span id="detailModalLang">Indonesia</span></div>
        </div>

        <div style="margin-bottom: 20px;">
          <h4 style="font-size: 14px; font-weight: 600; color: var(--ink); margin-bottom: 6px;">Sinopsis &amp; Pokok Bahasan</h4>
          <p id="detailModalDesc" style="font-size: 13.5px; color: var(--ink-soft); line-height: 1.65; max-height: 180px; overflow-y: auto;">
            Deskripsi lengkap buku.
          </p>
        </div>

        <div style="display: flex; gap: 10px; flex-wrap: wrap; padding-top: 14px; border-top: 1px solid var(--line);">
          <button type="button" id="detailActionReadBtn" class="btn btn-primary" style="flex: 1;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
              <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
            </svg>
            <span>Mulai Baca Online Sekarang</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  (function() {
    'use strict';

    // Inisialisasi Data dari Server (Katalog Kurasi + Modul Internal SMAN 4)
    const initialCuratedBooks = @json($curatedBooks ?? []);
    const initialInternalEbooks = @json($internalEbooks ?? []);

    // Gabungkan seluruh koleksi dasar
    let allBooks = [...initialInternalEbooks, ...initialCuratedBooks];
    let currentCategory = 'semua';
    let currentClass = 'semua';
    let currentQuery = '';
    let debounceTimer = null;
    let activeModalBook = null;

    // DOM Elements
    const searchInput = document.getElementById('ebookSearchInput');
    const searchClear = document.getElementById('ebookSearchClear');
    const categoryPills = document.querySelectorAll('.ebook-filter-pill');
    const classSubfilterBar = document.getElementById('classSubfilterBar');
    const classPills = document.querySelectorAll('.ebook-class-pill');
    const gridContainer = document.getElementById('ebookGridContainer');
    const visibleCountText = document.getElementById('visibleCountText');
    const resetFilterBtn = document.getElementById('ebookResetFilterBtn');
    const errorState = document.getElementById('ebookErrorState');
    const retryBtn = document.getElementById('ebookRetryBtn');

    // Reader Modal Elements
    const readerModal = document.getElementById('ebookReaderModal');
    const modalReaderTitle = document.getElementById('modalReaderTitle');
    const modalReaderSub = document.getElementById('modalReaderSub');
    const readerNewTabLink = document.getElementById('readerNewTabLink');
    const readerCloseBtn = document.getElementById('readerCloseBtn');
    const readerIframe = document.getElementById('readerIframe');
    const readerLoadingSpinner = document.getElementById('readerLoadingSpinner');

    // Detail Modal Elements
    const detailModal = document.getElementById('ebookDetailModal');
    const detailCloseBtn = document.getElementById('detailCloseBtn');
    const detailModalCover = document.getElementById('detailModalCover');
    const modalDetailTitle = document.getElementById('modalDetailTitle');
    const detailModalAuthors = document.getElementById('detailModalAuthors');
    const detailModalPublisher = document.getElementById('detailModalPublisher');
    const detailModalYear = document.getElementById('detailModalYear');
    const detailModalPages = document.getElementById('detailModalPages');
    const detailModalLang = document.getElementById('detailModalLang');
    const detailModalDesc = document.getElementById('detailModalDesc');
    const detailModalBadges = document.getElementById('detailModalBadges');
    const detailActionReadBtn = document.getElementById('detailActionReadBtn');

    // Helper: Escape HTML
    function escapeHtml(str) {
      if (!str) return '';
      return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
    }

    // Helper: Truncate Text
    function truncateText(str, maxLength) {
      if (!str) return '';
      if (str.length <= maxLength) return str;
      return str.substr(0, maxLength) + '...';
    }

    // Render Kartu Buku ke dalam Grid
    function renderBooks(books) {
      gridContainer.innerHTML = '';
      visibleCountText.textContent = books.length;

      // Cek apakah tombol reset perlu ditampilkan
      const isFiltered = (currentCategory !== 'semua') || (currentClass !== 'semua') || (currentQuery.trim() !== '');
      if (resetFilterBtn) {
        resetFilterBtn.style.display = isFiltered ? 'inline-flex' : 'none';
      }

      if (books.length === 0) {
        gridContainer.innerHTML = `
          <div class="ebook-empty-state">
            <div class="ebook-empty-icon" aria-hidden="true">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
              </svg>
            </div>
            <h3>Tidak Ada E-Book yang Cocok</h3>
            <p>
              Tidak ditemukan buku yang sesuai dengan kata kunci atau filter yang Anda pilih. Silakan gunakan kata kunci lain seperti "Matematika", "Stres", "Cemas", atau reset filter.
            </p>
            <button type="button" class="btn btn-primary btn-sm" id="emptyStateResetBtn">
              Reset Pencarian &amp; Filter
            </button>
          </div>
        `;
        const emptyReset = document.getElementById('emptyStateResetBtn');
        if (emptyReset) {
          emptyReset.addEventListener('click', resetAllFilters);
        }
        return;
      }

      books.forEach((book, index) => {
        const card = document.createElement('article');
        card.className = 'ebook-card-item';

        // Badge Penanda
        let badgeClass = 'badge-merdeka';
        let badgeText = 'Kurikulum Merdeka';
        if (book.category === 'kesehatan_mental' || book.category === 'stres_belajar') {
          badgeClass = 'badge-mental';
          badgeText = 'Kesehatan Mental';
        } else if (book.is_internal || book.category === 'modul_internal') {
          badgeClass = 'badge-internal';
          badgeText = 'Modul Guru BK';
        } else if (book.badges && book.badges.length > 0) {
          badgeText = book.badges[0];
        }

        const classBadge = book.class_level ? `<span class="ebook-tag-badge">${escapeHtml(book.class_level)}</span>` : '';
        const authorText = Array.isArray(book.authors) ? book.authors.join(', ') : (book.authors || 'Tim Guru BK SMAN 4');
        const descText = book.description || 'Modul bimbingan dan referensi belajar komprehensif bagi peserta didik.';
        const pageText = book.page_count ? `${book.page_count} Hal` : (book.source || 'Daring');

        // Cover HTML: Image with fallback
        let coverHtml = '';
        if (book.cover_url) {
          coverHtml = `
            <img 
              src="${escapeHtml(book.cover_url)}" 
              alt="Sampul ${escapeHtml(book.title)}" 
              class="ebook-cover-img" 
              loading="lazy" 
              onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
            />
            <div class="ebook-cover-fallback" style="display: none;">
              <span class="ebook-fallback-title">${escapeHtml(book.title)}</span>
              <span style="font-size: 11px; opacity: 0.85;">${escapeHtml(authorText)}</span>
            </div>
          `;
        } else {
          coverHtml = `
            <div class="ebook-cover-fallback">
              <span class="ebook-fallback-title">${escapeHtml(book.title)}</span>
              <span style="font-size: 11px; opacity: 0.85;">${escapeHtml(authorText)}</span>
            </div>
          `;
        }

        card.innerHTML = `
          <div class="ebook-cover-wrapper">
            <div class="ebook-badge-overlay">
              <span class="ebook-tag-badge ${badgeClass}">${escapeHtml(badgeText)}</span>
              ${classBadge}
            </div>
            ${coverHtml}
          </div>

          <div class="ebook-card-body">
            <div>
              <div class="ebook-card-category">${escapeHtml(book.subject || book.category || 'Referensi')}</div>
              <h3 class="ebook-card-title" title="${escapeHtml(book.title)}">${escapeHtml(book.title)}</h3>
              <div class="ebook-meta-authors">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                  <circle cx="12" cy="7" r="4"/>
                </svg>
                <span>${escapeHtml(authorText)}</span>
              </div>
              <p class="ebook-card-synopsis">${escapeHtml(descText)}</p>
            </div>

            <div class="ebook-card-footer">
              <div class="ebook-card-meta-detail">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                  <polyline points="14 2 14 8 20 8"/>
                </svg>
                <span>${escapeHtml(pageText)}</span>
              </div>
              <div class="ebook-card-actions">
                <button type="button" class="btn btn-ghost btn-sm btn-detail-action" aria-label="Lihat detail buku ${escapeHtml(book.title)}">
                  Detail
                </button>
                <button type="button" class="btn btn-primary btn-sm btn-read-action" aria-label="Baca online buku ${escapeHtml(book.title)}">
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                  </svg>
                  <span>Baca Online</span>
                </button>
              </div>
            </div>
          </div>
        `;

        // Event listener Baca Online
        const readBtn = card.querySelector('.btn-read-action');
        readBtn.addEventListener('click', function() {
          openReaderModal(book);
        });

        // Event listener Detail
        const detailBtn = card.querySelector('.btn-detail-action');
        detailBtn.addEventListener('click', function() {
          openDetailModal(book);
        });

        gridContainer.appendChild(card);
      });
    }

    // Tampilkan Skeleton Sesaat ketika memuat dari API
    function showSkeleton() {
      gridContainer.innerHTML = '';
      for (let i = 0; i < 6; i++) {
        const skel = document.createElement('div');
        skel.className = 'ebook-skeleton-card';
        skel.innerHTML = `
          <div class="ebook-skeleton-cover"></div>
          <div class="ebook-skeleton-body">
            <div class="ebook-skeleton-line" style="width: 40%;"></div>
            <div class="ebook-skeleton-line" style="width: 85%; height: 18px;"></div>
            <div class="ebook-skeleton-line" style="width: 60%;"></div>
            <div class="ebook-skeleton-line" style="width: 100%; margin-top: 10px;"></div>
            <div class="ebook-skeleton-line" style="width: 90%;"></div>
            <div class="ebook-skeleton-line" style="width: 50%; margin-top: auto;"></div>
          </div>
        `;
        gridContainer.appendChild(skel);
      }
    }

    // Filter Lokal Berdasarkan Kategori dan Jenjang Kelas
    function filterLocalBooks() {
      let filtered = allBooks;

      // Filter Kategori
      if (currentCategory !== 'semua') {
        if (currentCategory === 'modul_internal') {
          filtered = filtered.filter(b => b.is_internal || b.category === 'modul_internal');
        } else if (currentCategory === 'materi_sma') {
          filtered = filtered.filter(b => b.category === 'materi_sma');
        } else if (currentCategory === 'kesehatan_mental') {
          filtered = filtered.filter(b => b.category === 'kesehatan_mental');
        } else if (currentCategory === 'stres_belajar') {
          filtered = filtered.filter(b => b.category === 'stres_belajar' || (b.category === 'kesehatan_mental' && b.id === 'curated-km-04'));
        } else if (currentCategory === 'karir_kuliah') {
          filtered = filtered.filter(b => b.category === 'karir_kuliah' || (b.category === 'kesehatan_mental' && b.id === 'curated-km-04'));
        }
      }

      // Filter Jenjang Kelas
      if (currentClass !== 'semua') {
        filtered = filtered.filter(b => b.class_level === currentClass);
      }

      // Filter Query Pencarian Lokal
      if (currentQuery.trim() !== '') {
        const q = currentQuery.toLowerCase().trim();
        filtered = filtered.filter(b => {
          const authors = Array.isArray(b.authors) ? b.authors.join(' ') : (b.authors || '');
          const searchStr = `${b.title || ''} ${authors} ${b.description || ''} ${b.subject || ''} ${b.publisher || ''}`.toLowerCase();
          return searchStr.includes(q);
        });
      }

      return filtered;
    }

    // Melakukan Pencarian Daring via API
    function performSearch() {
      const q = currentQuery.trim();

      // Jika query kosong, gunakan koleksi lokal terkurasi
      if (q === '') {
        renderBooks(filterLocalBooks());
        return;
      }

      showSkeleton();

      // Panggil endpoint /api/ebooks/search
      let url = `/api/ebooks/search?q=${encodeURIComponent(q)}`;
      if (currentCategory !== 'semua') {
        url += `&category=${encodeURIComponent(currentCategory)}`;
      }
      if (currentClass !== 'semua') {
        url += `&class_level=${encodeURIComponent(currentClass)}`;
      }

      fetch(url, {
        headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(res => {
        if (!res.ok) throw new Error('Network error');
        return res.json();
      })
      .then(data => {
        if (errorState) errorState.style.display = 'none';
        const apiBooks = data.books || [];

        // Gabungkan buku internal yang cocok secara lokal agar modul sekolah tetap muncul di hasil pencarian teratas
        const localMatches = filterLocalBooks();
        const mergedBooks = [...localMatches];

        apiBooks.forEach(apiB => {
          if (!mergedBooks.some(m => m.id === apiB.id)) {
            mergedBooks.push(apiB);
          }
        });

        renderBooks(mergedBooks);
      })
      .catch(err => {
        console.warn('API Search failed, using local fallback:', err);
        if (errorState) errorState.style.display = 'block';
        renderBooks(filterLocalBooks());
      });
    }

    // Reset Seluruh Filter dan Pencarian
    function resetAllFilters() {
      currentCategory = 'semua';
      currentClass = 'semua';
      currentQuery = '';
      if (searchInput) searchInput.value = '';
      if (searchClear) searchClear.classList.remove('visible');

      categoryPills.forEach(p => p.classList.remove('active'));
      const defaultPill = document.querySelector('.ebook-filter-pill[data-category="semua"]');
      if (defaultPill) defaultPill.classList.add('active');

      if (classSubfilterBar) classSubfilterBar.style.display = 'none';
      classPills.forEach(p => p.classList.remove('active'));
      const defaultClassPill = document.querySelector('.ebook-class-pill[data-class="semua"]');
      if (defaultClassPill) defaultClassPill.classList.add('active');

      renderBooks(filterLocalBooks());
    }

    // ===================================================
    // MODAL PEMBACA ONLINE (IN-APP READER)
    // ===================================================
    function openReaderModal(book) {
      activeModalBook = book;
      if (!readerModal) return;

      modalReaderTitle.textContent = book.title || 'Membaca E-Book';
      const authorText = Array.isArray(book.authors) ? book.authors.join(', ') : (book.authors || 'Tim Guru BK');
      modalReaderSub.textContent = `${authorText} • Sumber: ${book.source || 'Resmi'}`;

      const readerUrl = book.reader_url || book.preview_link || '#';
      readerNewTabLink.href = readerUrl;

      // Set Loading Spinner
      if (readerLoadingSpinner) {
        readerLoadingSpinner.style.opacity = '1';
        readerLoadingSpinner.style.display = 'flex';
      }

      // Tautkan reader iframe
      readerIframe.src = readerUrl;

      // Hilangkan spinner setelah iframe selesai memuat
      readerIframe.onload = function() {
        if (readerLoadingSpinner) {
          readerLoadingSpinner.style.opacity = '0';
          setTimeout(() => {
            readerLoadingSpinner.style.display = 'none';
          }, 200);
        }
      };

      // Tampilkan modal dan kunci scroll body
      readerModal.classList.add('is-active');
      document.body.style.overflow = 'hidden';
    }

    function closeReaderModal() {
      if (!readerModal) return;
      readerModal.classList.remove('is-active');
      readerIframe.src = 'about:blank';
      document.body.style.overflow = '';
      activeModalBook = null;
    }

    // ===================================================
    // MODAL DETAIL BUKU
    // ===================================================
    function openDetailModal(book) {
      activeModalBook = book;
      if (!detailModal) return;

      modalDetailTitle.textContent = book.title || 'Detail E-Book';
      const authorText = Array.isArray(book.authors) ? book.authors.join(', ') : (book.authors || 'Tim Guru BK');
      detailModalAuthors.textContent = `Penyusun: ${authorText}`;
      detailModalPublisher.textContent = book.publisher || 'SMAN 4 Jember';
      detailModalYear.textContent = book.published_year || '-';
      detailModalPages.textContent = book.page_count ? `${book.page_count} Halaman` : 'Dokumen Digital';
      detailModalLang.textContent = book.language === 'en' ? 'Bahasa Inggris' : 'Bahasa Indonesia';
      detailModalDesc.textContent = book.description || 'Tidak ada deskripsi rinci.';

      if (book.cover_url) {
        detailModalCover.src = book.cover_url;
        detailModalCover.style.display = 'block';
      } else {
        detailModalCover.style.display = 'none';
      }

      // Badges
      detailModalBadges.innerHTML = '';
      if (book.badges && Array.isArray(book.badges)) {
        book.badges.forEach(b => {
          const badgeSpan = document.createElement('span');
          badgeSpan.className = 'ebook-tag-badge badge-merdeka';
          badgeSpan.textContent = b;
          detailModalBadges.appendChild(badgeSpan);
        });
      }

      detailModal.classList.add('is-active');
      document.body.style.overflow = 'hidden';
    }

    function closeDetailModal() {
      if (!detailModal) return;
      detailModal.classList.remove('is-active');
      document.body.style.overflow = '';
    }

    // ===================================================
    // EVENT LISTENERS
    // ===================================================

    // Search Input Event
    if (searchInput) {
      searchInput.addEventListener('input', function() {
        currentQuery = this.value;
        if (searchClear) {
          if (currentQuery.length > 0) {
            searchClear.classList.add('visible');
          } else {
            searchClear.classList.remove('visible');
          }
        }

        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
          performSearch();
        }, 320);
      });
    }

    // Search Clear Button
    if (searchClear) {
      searchClear.addEventListener('click', function() {
        if (searchInput) searchInput.value = '';
        currentQuery = '';
        searchClear.classList.remove('visible');
        performSearch();
      });
    }

    // Category Tabs Event
    categoryPills.forEach(pill => {
      pill.addEventListener('click', function() {
        categoryPills.forEach(p => p.classList.remove('active'));
        this.classList.add('active');
        currentCategory = this.dataset.category;

        // Toggle subfilter bar jenjang kelas untuk Materi SMA
        if (currentCategory === 'materi_sma') {
          if (classSubfilterBar) classSubfilterBar.style.display = 'flex';
        } else {
          if (classSubfilterBar) classSubfilterBar.style.display = 'none';
          currentClass = 'semua';
          classPills.forEach(cp => cp.classList.remove('active'));
          const defaultCp = document.querySelector('.ebook-class-pill[data-class="semua"]');
          if (defaultCp) defaultCp.classList.add('active');
        }

        performSearch();
      });
    });

    // Class Subfilter Event
    classPills.forEach(pill => {
      pill.addEventListener('click', function() {
        classPills.forEach(p => p.classList.remove('active'));
        this.classList.add('active');
        currentClass = this.dataset.class;
        performSearch();
      });
    });

    // Reset Filter Button
    if (resetFilterBtn) {
      resetFilterBtn.addEventListener('click', resetAllFilters);
    }

    // Retry Button
    if (retryBtn) {
      retryBtn.addEventListener('click', performSearch);
    }

    // Reader Modal Close Events
    if (readerCloseBtn) {
      readerCloseBtn.addEventListener('click', closeReaderModal);
    }
    if (readerModal) {
      readerModal.addEventListener('click', function(e) {
        if (e.target === readerModal) {
          closeReaderModal();
        }
      });
    }

    // Detail Modal Close & Action Events
    if (detailCloseBtn) {
      detailCloseBtn.addEventListener('click', closeDetailModal);
    }
    if (detailModal) {
      detailModal.addEventListener('click', function(e) {
        if (e.target === detailModal) {
          closeDetailModal();
        }
      });
    }
    if (detailActionReadBtn) {
      detailActionReadBtn.addEventListener('click', function() {
        closeDetailModal();
        if (activeModalBook) {
          openReaderModal(activeModalBook);
        }
      });
    }

    // Keyboard ESC to close any open modal
    window.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        if (readerModal && readerModal.classList.contains('is-active')) {
          closeReaderModal();
        }
        if (detailModal && detailModal.classList.contains('is-active')) {
          closeDetailModal();
        }
      }
    });

    // First initial render
    renderBooks(allBooks);

  })();
</script>
@endpush
