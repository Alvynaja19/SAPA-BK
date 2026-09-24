@extends('layouts.app')

@section('title', 'Perpustakaan E-Book & Modul : SAPA BK SMAN 4 Jember')
@section('page_title', 'Perpustakaan Modul Digital')

@push('styles')
<style>
  /* Container Utama */
  .ebook-container {
    display: flex;
    flex-direction: column;
    gap: 24px;
    max-width: 1200px;
    margin: 0 auto;
  }

  /* Header Section */
  .ebook-header {
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
  .ebook-header-text {
    max-width: 680px;
  }
  .ebook-badge-top {
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
  .ebook-header h2 {
    font-size: 24px;
    font-weight: 600;
    color: var(--ink);
    line-height: 1.25;
  }
  .ebook-header p {
    color: var(--ink-soft);
    font-size: 14.5px;
    margin-top: 6px;
    line-height: 1.55;
  }
  .ebook-header-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--primary-soft);
    color: var(--primary);
    padding: 10px 18px;
    border-radius: 99px;
    font-size: 13px;
    font-weight: 600;
    border: 1px solid rgba(21, 128, 61, 0.22);
    min-height: 44px;
  }

  /* Stat Summary Strip */
  .ebook-stats-strip {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
  }
  .ebook-stat-card {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-m);
    padding: 18px 20px;
    box-shadow: var(--shadow-card);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  .ebook-stat-label {
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: var(--ink-faint);
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .ebook-stat-val {
    font-family: 'Fraunces', Georgia, serif;
    font-size: 28px;
    font-weight: 600;
    color: var(--ink);
    line-height: 1;
    margin-top: 8px;
  }
  .ebook-stat-desc {
    font-size: 12px;
    color: var(--ink-soft);
    margin-top: 4px;
  }

  /* Filter & Search Bar */
  .ebook-toolbar {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-m);
    padding: 18px 20px;
    box-shadow: var(--shadow-card);
    display: flex;
    flex-direction: column;
    gap: 16px;
  }
  .ebook-search-box {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
  }
  .ebook-search-box svg.search-icon {
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
    transition: border-color .15s ease, box-shadow .15s ease;
  }
  .ebook-search-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.12);
  }
  .ebook-search-clear {
    position: absolute;
    right: 12px;
    background: transparent;
    border: none;
    color: var(--ink-faint);
    cursor: pointer;
    padding: 8px;
    min-width: 44px;
    min-height: 44px;
    display: none;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-s);
  }
  .ebook-search-clear:hover {
    color: var(--ink);
  }

  .ebook-tabs-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
  }
  .ebook-filter-pills {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
  }
  .ebook-pill-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    min-height: 44px;
    padding: 8px 16px;
    border-radius: 99px;
    border: 1.5px solid var(--line);
    background: var(--bg);
    color: var(--ink-soft);
    font-size: 13.5px;
    font-weight: 500;
    cursor: pointer;
    transition: all .15s ease;
  }
  .ebook-pill-btn:hover {
    border-color: var(--ink-faint);
    color: var(--ink);
  }
  .ebook-pill-btn.active {
    background: var(--primary);
    border-color: var(--primary);
    color: #FFFFFF;
    font-weight: 600;
  }
  .ebook-count-indicator {
    font-size: 13px;
    color: var(--ink-soft);
  }
  .ebook-count-indicator strong {
    color: var(--ink);
  }

  /* Grid Modul */
  .ebook-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 20px;
  }

  /* Kartu Modul */
  .ebook-card-item {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-m);
    box-shadow: var(--shadow-card);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
  }
  .ebook-card-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    border-color: rgba(21, 128, 61, 0.3);
  }

  /* Cover Modul */
  .ebook-card-cover {
    width: 100%;
    height: 170px;
    position: relative;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    overflow: hidden;
  }
  .ebook-cover-color-1 { background: linear-gradient(135deg, #14532D 0%, #166534 100%); }
  .ebook-cover-color-2 { background: linear-gradient(135deg, #065F46 0%, #047857 100%); }
  .ebook-cover-color-3 { background: linear-gradient(135deg, #1E3A8A 0%, #1D4ED8 100%); }
  .ebook-cover-color-4 { background: linear-gradient(135deg, #431407 0%, #7C2D12 100%); }

  .ebook-cover-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .ebook-badge-access {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .04em;
    padding: 4px 10px;
    border-radius: 99px;
    background: rgba(255, 255, 255, 0.2);
    color: #FFFFFF;
    backdrop-filter: blur(4px);
  }
  .ebook-cover-icon {
    color: rgba(255, 255, 255, 0.35);
  }
  .ebook-cover-title {
    font-family: 'Fraunces', Georgia, serif;
    font-size: 18px;
    font-weight: 600;
    color: #FFFFFF;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  /* Body Kartu */
  .ebook-card-body {
    padding: 18px 20px;
    display: flex;
    flex-direction: column;
    flex: 1;
    justify-content: space-between;
  }
  .ebook-meta-author {
    font-size: 12.5px;
    color: var(--ink-faint);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .ebook-card-title {
    font-size: 16px;
    font-weight: 600;
    color: var(--ink);
    line-height: 1.35;
    margin-bottom: 10px;
  }
  .ebook-card-desc {
    font-size: 13.5px;
    color: var(--ink-soft);
    line-height: 1.55;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 18px;
  }

  /* Aksi Kartu */
  .ebook-card-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    padding-top: 14px;
    border-top: 1px solid var(--line);
  }
  .ebook-btn-read {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 44px;
    padding: 8px 16px;
    background: var(--primary);
    color: #FFFFFF;
    border: none;
    border-radius: var(--radius-s);
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: background-color .15s ease;
  }
  .ebook-btn-read:hover {
    background: var(--primary-dark, #166534);
    color: #FFFFFF;
  }
  .ebook-btn-dl {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 44px;
    min-width: 44px;
    padding: 8px;
    background: var(--bg);
    color: var(--ink-soft);
    border: 1px solid var(--line);
    border-radius: var(--radius-s);
    cursor: pointer;
    text-decoration: none;
    transition: all .15s ease;
  }
  .ebook-btn-dl:hover {
    color: var(--primary);
    border-color: var(--primary);
    background: var(--surface);
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
    width: 56px;
    height: 56px;
    margin: 0 auto 16px;
    border-radius: 50%;
    background: var(--bg-alt);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .ebook-empty-state h3 {
    font-size: 18px;
    color: var(--ink);
    margin-bottom: 6px;
  }
  .ebook-empty-state p {
    font-size: 14px;
    color: var(--ink-soft);
    max-width: 420px;
    margin: 0 auto 16px;
    line-height: 1.5;
  }
  .ebook-reset-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 44px;
    padding: 8px 18px;
    background: var(--primary);
    color: #FFFFFF;
    border-radius: var(--radius-s);
    font-size: 13.5px;
    font-weight: 600;
    border: none;
    cursor: pointer;
  }

  /* Modal Pembaca PDF */
  .ebook-modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    background: rgba(15, 29, 19, 0.82);
    backdrop-filter: blur(4px);
    padding: 16px;
  }
  .ebook-modal-overlay.is-active {
    display: flex;
  }
  .ebook-modal-dialog {
    background: var(--surface);
    border-radius: var(--radius-l);
    width: 100%;
    max-width: 1050px;
    height: 90vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    box-shadow: 0 24px 64px rgba(0, 0, 0, 0.45);
    border: 1px solid var(--line);
  }
  .ebook-modal-header {
    background: #0F1D13;
    color: #FFFFFF;
    padding: 14px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.12);
  }
  .ebook-modal-title-box {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 0;
  }
  .ebook-modal-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #86EFAC;
    flex-shrink: 0;
  }
  .ebook-modal-title {
    font-family: 'Fraunces', Georgia, serif;
    font-size: 16px;
    font-weight: 600;
    color: #FFFFFF;
    line-height: 1.25;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .ebook-modal-sub {
    font-size: 12px;
    color: #94A3B8;
    margin-top: 2px;
  }
  .ebook-modal-actions {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
  }
  .ebook-modal-btn {
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
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.2);
    cursor: pointer;
    text-decoration: none;
    transition: background-color .15s ease;
  }
  .ebook-modal-btn:hover {
    background: rgba(255, 255, 255, 0.22);
  }
  .ebook-modal-btn.close {
    background: rgba(239, 68, 68, 0.25);
    border-color: rgba(239, 68, 68, 0.4);
    color: #FECACA;
    min-width: 44px;
    padding: 8px;
  }
  .ebook-modal-btn.close:hover {
    background: rgba(239, 68, 68, 0.45);
    color: #FFFFFF;
  }

  .ebook-modal-frame {
    flex: 1;
    width: 100%;
    height: 100%;
    border: none;
    background: #525659;
  }

  @media (max-width: 768px) {
    .ebook-header {
      padding: 18px 16px;
    }
    .ebook-grid {
      grid-template-columns: 1fr;
    }
    .ebook-modal-dialog {
      height: 98vh;
      border-radius: 0;
    }
    .ebook-modal-overlay {
      padding: 0;
    }
  }
</style>
@endpush

@section('content')
<div class="ebook-container">

  <!-- Header Section -->
  <header class="ebook-header">
    <div class="ebook-header-text">
      <div class="ebook-badge-top">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
        </svg>
        <span>Pustaka Modul Digital</span>
      </div>
      <h2>Perpustakaan E-Book &amp; Modul Siswa</h2>
      <p>
        Koleksi modul resmi Bimbingan dan Konseling SMA Negeri 4 Jember untuk mendukung persiapan studi lanjut, penentuan karir, regulasi emosional, dan komunikasi sehat di sekolah.
      </p>
    </div>
    <div>
      <div class="ebook-header-badge">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
          <path d="m9 12 2 2 4-4"/>
        </svg>
        <span>Modul Resmi Guru BK</span>
      </div>
    </div>
  </header>

  <!-- Summary Metric Strip -->
  <section class="ebook-stats-strip" aria-label="Statistik Koleksi Modul">
    <div class="ebook-stat-card">
      <div class="ebook-stat-label">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
          <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
        </svg>
        <span>Total Modul Tersedia</span>
      </div>
      <div class="ebook-stat-val">{{ $stats['total'] ?? $ebooks->count() }}</div>
      <div class="ebook-stat-desc">Dapat dibaca langsung secara online</div>
    </div>

    <div class="ebook-stat-card">
      <div class="ebook-stat-label">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="12" cy="12" r="10"/>
          <line x1="2" y1="12" x2="22" y2="12"/>
          <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
        </svg>
        <span>Akses Terbuka</span>
      </div>
      <div class="ebook-stat-val">{{ $stats['public'] ?? 0 }}</div>
      <div class="ebook-stat-desc">Terbuka untuk publik dan tamu</div>
    </div>

    <div class="ebook-stat-card">
      <div class="ebook-stat-label">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
          <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
        </svg>
        <span>Eksklusif Siswa SMAN 4</span>
      </div>
      <div class="ebook-stat-val">{{ $stats['internal'] ?? 0 }}</div>
      <div class="ebook-stat-desc">Materi khusus peserta didik terdaftar</div>
    </div>
  </section>

  <!-- Filter & Search Toolbar -->
  <section class="ebook-toolbar" aria-label="Alat Pencarian dan Filter Modul">
    <div class="ebook-search-box">
      <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <circle cx="11" cy="11" r="8"/>
        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
      </svg>
      <input 
        type="search" 
        id="modulSearchInput" 
        class="ebook-search-input" 
        placeholder="Cari judul modul, topik bimbingan, atau kata kunci..." 
        aria-label="Pencarian modul digital"
        autocomplete="off"
      />
      <button type="button" id="modulSearchClear" class="ebook-search-clear" aria-label="Bersihkan pencarian">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" y1="6" x2="6" y2="18"/>
          <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>

    <div class="ebook-tabs-row">
      <div class="ebook-filter-pills" role="tablist">
        <button type="button" class="ebook-pill-btn active" data-filter="all">
          Semua Modul
        </button>
        <button type="button" class="ebook-pill-btn" data-filter="public">
          Akses Terbuka
        </button>
        <button type="button" class="ebook-pill-btn" data-filter="internal">
          Eksklusif Siswa
        </button>
      </div>

      <div class="ebook-count-indicator">
        Menampilkan <strong id="visibleCountText">{{ $ebooks->count() }}</strong> dari {{ $ebooks->count() }} modul
      </div>
    </div>
  </section>

  <!-- Grid Modul Siswa -->
  <main class="ebook-grid" id="modulGrid">
    @forelse($ebooks as $index => $eb)
      @php
        $colorClass = 'ebook-cover-color-' . (($index % 4) + 1);
        $accessType = $eb->is_public ? 'public' : 'internal';
        $accessLabel = $eb->is_public ? 'Akses Terbuka' : 'Eksklusif Siswa';
        $authorName = $eb->uploader?->name ?? 'Tim Guru BK SMAN 4 Jember';
      @endphp
      <article 
        class="ebook-card-item" 
        data-title="{{ strtolower($eb->title) }}" 
        data-desc="{{ strtolower($eb->description ?? '') }}" 
        data-access="{{ $accessType }}"
      >
        <div class="ebook-card-cover {{ $colorClass }}">
          <div class="ebook-cover-top">
            <span class="ebook-badge-access">
              {{ $accessLabel }}
            </span>
            <div class="ebook-cover-icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
              </svg>
            </div>
          </div>
          <h3 class="ebook-cover-title">{{ $eb->title }}</h3>
        </div>

        <div class="ebook-card-body">
          <div>
            <div class="ebook-meta-author">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
              </svg>
              <span>{{ $authorName }}</span>
            </div>
            <h4 class="ebook-card-title">{{ $eb->title }}</h4>
            <p class="ebook-card-desc">
              {{ $eb->description ?? 'Modul pembelajaran bimbingan konseling untuk pengayaan akademik dan kesiapan karir siswa SMAN 4 Jember.' }}
            </p>
          </div>

          <div class="ebook-card-actions">
            <button 
              type="button" 
              class="ebook-btn-read open-reader-btn" 
              data-id="{{ $eb->id }}" 
              data-title="{{ $eb->title }}" 
              data-stream-url="{{ route('ebook.stream', $eb->id) }}" 
              data-download-url="{{ route('ebook.download', $eb->id) }}"
            >
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
              <span>Baca Modul</span>
            </button>
            <a 
              href="{{ route('ebook.download', $eb->id) }}" 
              class="ebook-btn-dl" 
              title="Unduh PDF Modul" 
              aria-label="Unduh berkas PDF untuk {{ $eb->title }}"
            >
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="7 10 12 15 17 10"/>
                <line x1="12" x2="12" y1="15" y2="3"/>
              </svg>
            </a>
          </div>
        </div>
      </article>
    @empty
      <div class="ebook-empty-state">
        <div class="ebook-empty-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
          </svg>
        </div>
        <h3>Belum Ada Modul Tersedia</h3>
        <p>Bahan ajar dan modul konseling akan segera diunggah oleh Guru BK SMAN 4 Jember.</p>
      </div>
    @endforelse

    <!-- Empty Filter Result Card -->
    <div id="filterEmptyCard" class="ebook-empty-state" style="display: none;">
      <div class="ebook-empty-icon">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"/>
          <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
      </div>
      <h3>Modul Tidak Ditemukan</h3>
      <p>Tidak ada modul yang cocok dengan kata kunci atau filter yang Anda pilih.</p>
      <button type="button" id="resetFilterAction" class="ebook-reset-link">
        Reset Pencarian
      </button>
    </div>
  </main>

</div>

<!-- Modal Pembaca Dokumen PDF -->
<div class="ebook-modal-overlay" id="pdfReaderModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
  <div class="ebook-modal-dialog">
    <div class="ebook-modal-header">
      <div class="ebook-modal-title-box">
        <div class="ebook-modal-icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
          </svg>
        </div>
        <div>
          <div class="ebook-modal-title" id="modalTitle">Judul Modul</div>
          <div class="ebook-modal-sub">Dokumen Resmi Bimbingan Konseling SMAN 4 Jember</div>
        </div>
      </div>
      <div class="ebook-modal-actions">
        <a href="#" id="modalDownloadBtn" class="ebook-modal-btn" title="Unduh Berkas PDF">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
            <polyline points="7 10 12 15 17 10"/>
            <line x1="12" x2="12" y1="15" y2="3"/>
          </svg>
          <span>Unduh PDF</span>
        </a>
        <button type="button" id="modalCloseBtn" class="ebook-modal-btn close" aria-label="Tutup Pembaca Modul">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
      </div>
    </div>
    <iframe id="pdfFrame" class="ebook-modal-frame" title="Penampil Dokumen PDF Modul"></iframe>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('modulSearchInput');
  const searchClear = document.getElementById('modulSearchClear');
  const filterPills = document.querySelectorAll('.ebook-pill-btn');
  const cards = document.querySelectorAll('.ebook-card-item');
  const countIndicator = document.getElementById('visibleCountText');
  const emptyCard = document.getElementById('filterEmptyCard');
  const resetBtn = document.getElementById('resetFilterAction');

  let currentFilter = 'all';
  let searchQuery = '';

  function applyFilter() {
    let visibleCount = 0;
    const q = searchQuery.toLowerCase().trim();

    cards.forEach(card => {
      const title = card.getAttribute('data-title') || '';
      const desc = card.getAttribute('data-desc') || '';
      const access = card.getAttribute('data-access') || '';

      const matchesFilter = (currentFilter === 'all') || (access === currentFilter);
      const matchesSearch = !q || title.includes(q) || desc.includes(q);

      if (matchesFilter && matchesSearch) {
        card.style.display = 'flex';
        visibleCount++;
      } else {
        card.style.display = 'none';
      }
    });

    if (countIndicator) {
      countIndicator.textContent = visibleCount;
    }

    if (emptyCard) {
      emptyCard.style.display = (visibleCount === 0 && cards.length > 0) ? 'block' : 'none';
    }
  }

  if (searchInput) {
    searchInput.addEventListener('input', function () {
      searchQuery = this.value;
      if (searchClear) {
        searchClear.style.display = searchQuery ? 'flex' : 'none';
      }
      applyFilter();
    });
  }

  if (searchClear) {
    searchClear.addEventListener('click', function () {
      if (searchInput) {
        searchInput.value = '';
        searchQuery = '';
        this.style.display = 'none';
        searchInput.focus();
        applyFilter();
      }
    });
  }

  filterPills.forEach(pill => {
    pill.addEventListener('click', function () {
      filterPills.forEach(p => p.classList.remove('active'));
      this.classList.add('active');
      currentFilter = this.getAttribute('data-filter') || 'all';
      applyFilter();
    });
  });

  if (resetBtn) {
    resetBtn.addEventListener('click', function () {
      if (searchInput) {
        searchInput.value = '';
        searchQuery = '';
      }
      if (searchClear) {
        searchClear.style.display = 'none';
      }
      currentFilter = 'all';
      filterPills.forEach(p => {
        if (p.getAttribute('data-filter') === 'all') {
          p.classList.add('active');
        } else {
          p.classList.remove('active');
        }
      });
      applyFilter();
    });
  }

  // Modal Pembaca Dokumen
  const modal = document.getElementById('pdfReaderModal');
  const modalTitle = document.getElementById('modalTitle');
  const modalDownload = document.getElementById('modalDownloadBtn');
  const pdfFrame = document.getElementById('pdfFrame');
  const modalClose = document.getElementById('modalCloseBtn');

  function openReader(streamUrl, downloadUrl, title) {
    if (!modal || !pdfFrame) return;
    if (modalTitle) modalTitle.textContent = title;
    if (modalDownload) modalDownload.href = downloadUrl;
    pdfFrame.src = streamUrl;
    modal.classList.add('is-active');
    document.body.style.overflow = 'hidden';
  }

  function closeReader() {
    if (!modal || !pdfFrame) return;
    modal.classList.remove('is-active');
    pdfFrame.src = 'about:blank';
    document.body.style.overflow = '';
  }

  document.querySelectorAll('.open-reader-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      const streamUrl = this.getAttribute('data-stream-url');
      const downloadUrl = this.getAttribute('data-download-url');
      const title = this.getAttribute('data-title');
      openReader(streamUrl, downloadUrl, title);
    });
  });

  if (modalClose) {
    modalClose.addEventListener('click', closeReader);
  }

  if (modal) {
    modal.addEventListener('click', function (e) {
      if (e.target === modal) {
        closeReader();
      }
    });
  }

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && modal && modal.classList.contains('is-active')) {
      closeReader();
    }
  });
});
</script>
@endpush
