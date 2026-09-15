@extends('layouts.app')

@section('title', 'Perpustakaan E-Book Siswa : SAPA BK SMAN 4 Jember')
@section('page_title', 'Perpustakaan E-Book Siswa')

@push('styles')
<style>
  /* ===================================================
     SAPA BK - PERPUSTAKAAN E-BOOK SISWA (WARM EDITORIAL)
     Antislop: No em dash, WCAG AA contrast, Vanilla CSS
     =================================================== */

  .ebook-portal-container {
    display: flex;
    flex-direction: column;
    gap: 24px;
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
    padding: 8px 16px;
    border-radius: 99px;
    font-size: 13px;
    font-weight: 600;
    border: 1px solid rgba(36,70,63,0.18);
  }

  /* Summary Counter Strip */
  .ebook-summary-strip {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
  }
  .ebook-summary-card {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-m);
    padding: 18px 22px;
    box-shadow: var(--shadow-card);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 96px;
  }
  .ebook-summary-label {
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: var(--ink-faint);
  }
  .ebook-summary-val {
    font-family: 'Fraunces', Georgia, serif;
    font-size: 28px;
    font-weight: 600;
    color: var(--ink);
    line-height: 1;
    margin-top: 6px;
  }
  .ebook-summary-desc {
    font-size: 12px;
    color: var(--ink-soft);
    margin-top: 4px;
  }

  /* Book Grid */
  .ebook-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
    gap: 20px;
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
  }
  .ebook-card-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 6px rgba(27,42,36,0.08), 0 12px 24px -8px rgba(27,42,36,0.18);
    border-color: #B4C4B8;
  }

  /* Book Cover Area */
  .ebook-cover-box {
    height: 190px;
    padding: 20px 24px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
    color: #FFFFFF;
    box-shadow: inset 5px 0 10px rgba(0,0,0,0.22);
  }
  .ebook-cover-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 14px;
    bottom: 0;
    width: 1px;
    background: rgba(255,255,255,0.15);
  }
  .ebook-cover-box.theme-1 {
    background: linear-gradient(140deg, #1b3832 0%, #24463F 65%, #132723 100%);
  }
  .ebook-cover-box.theme-2 {
    background: linear-gradient(140deg, #173252 0%, #20456e 65%, #0f2137 100%);
  }
  .ebook-cover-box.theme-3 {
    background: linear-gradient(140deg, #532d18 0%, #743e22 65%, #3c1e0e 100%);
  }
  .ebook-cover-box.theme-4 {
    background: linear-gradient(140deg, #372448 0%, #4d3365 65%, #23162e 100%);
  }

  .ebook-tag-badge {
    align-self: flex-start;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .05em;
    padding: 4px 10px;
    border-radius: 6px;
    background: rgba(0,0,0,0.3);
    backdrop-filter: blur(4px);
    border: 1px solid rgba(255,255,255,0.2);
    color: #FFFFFF;
  }
  .ebook-tag-badge.public {
    background: rgba(46, 125, 52, 0.45);
    border-color: rgba(165, 214, 167, 0.4);
  }
  .ebook-tag-badge.exclusive {
    background: rgba(201, 138, 59, 0.45);
    border-color: rgba(241, 223, 190, 0.4);
  }

  .ebook-cover-title {
    font-family: 'Fraunces', Georgia, serif;
    font-size: 17.5px;
    font-weight: 600;
    line-height: 1.35;
    color: #FFFFFF;
    text-shadow: 0 1px 3px rgba(0,0,0,0.4);
  }

  /* Card Content */
  .ebook-card-body {
    padding: 20px 22px;
    display: flex;
    flex-direction: column;
    flex: 1;
    justify-content: space-between;
    gap: 16px;
  }
  .ebook-meta-author {
    font-size: 12px;
    color: var(--ink-faint);
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .ebook-card-desc {
    font-size: 13.5px;
    color: var(--ink-soft);
    line-height: 1.6;
    margin-top: 6px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .ebook-card-footer {
    padding-top: 14px;
    border-top: 1px solid var(--line);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
  }
  .ebook-file-type {
    font-size: 12px;
    color: var(--ink-faint);
    display: flex;
    align-items: center;
    gap: 5px;
    font-weight: 500;
  }

  /* Empty state */
  .ebook-empty-state {
    background: var(--surface);
    border: 1px dashed var(--line);
    border-radius: var(--radius-m);
    padding: 60px 24px;
    text-align: center;
  }
  .ebook-empty-icon {
    width: 54px;
    height: 54px;
    margin: 0 auto 16px;
    border-radius: 50%;
    background: var(--bg-alt);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .ebook-empty-state h3 {
    font-size: 19px;
    color: var(--ink);
    margin-bottom: 6px;
  }
  .ebook-empty-state p {
    font-size: 14px;
    color: var(--ink-soft);
    max-width: 440px;
    margin: 0 auto 18px;
  }

  /* Responsive */
  @media (max-width: 860px) {
    .ebook-summary-strip {
      grid-template-columns: repeat(2, 1fr);
      gap: 12px;
    }
    .ebook-portal-header {
      padding: 20px 18px;
    }
  }

  @media (max-width: 580px) {
    .ebook-summary-strip {
      grid-template-columns: 1fr;
    }
    .ebook-grid {
      grid-template-columns: 1fr;
      gap: 16px;
    }
    .ebook-portal-header {
      padding: 16px;
    }
    .ebook-actions {
      flex-direction: column;
      gap: 10px;
    }
    .ebook-actions .btn {
      width: 100%;
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
        <span>Pustaka Bimbingan Konseling</span>
      </div>
      <h2>Perpustakaan E-Book &amp; Modul Siswa</h2>
      <p>
        Koleksi materi bimbingan karir, panduan seleksi masuk PTN, pengelolaan stres belajar, dan pengayaan diri yang disusun resmi oleh Tim Konselor SMA Negeri 4 Jember.
      </p>
    </div>
    <div>
      <div class="ebook-portal-badge">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
          <path d="m9 12 2 2 4-4"/>
        </svg>
        <span>Akses Terverifikasi Siswa</span>
      </div>
    </div>
  </header>

  <!-- Summary Strip -->
  <section class="ebook-summary-strip" aria-label="Ringkasan Modul">
    <div class="ebook-summary-card">
      <div class="ebook-summary-label">Total Koleksi Modul</div>
      <div class="ebook-summary-val">{{ $ebooks->total() }}</div>
      <div class="ebook-summary-desc">Tersedia untuk dibaca siswa</div>
    </div>
    <div class="ebook-summary-card">
      <div class="ebook-summary-label">Materi Khusus Siswa</div>
      <div class="ebook-summary-val">{{ $ebooks->where('is_public', false)->count() }}</div>
      <div class="ebook-summary-desc">Modul bimbingan internal SMAN 4</div>
    </div>
    <div class="ebook-summary-card">
      <div class="ebook-summary-label">Modul Akses Terbuka</div>
      <div class="ebook-summary-val">{{ $ebooks->where('is_public', true)->count() }}</div>
      <div class="ebook-summary-desc">Panduan pengayaan umum</div>
    </div>
  </section>

  <!-- Books Grid -->
  <main class="ebook-grid" aria-label="Daftar Modul E-Book">
    @forelse($ebooks as $index => $eb)
      @php
        $themeClass = 'theme-' . (($index % 4) + 1);
      @endphp
      <article class="ebook-card-item">
        <!-- 3D Book Spine Cover Presentation -->
        <div class="ebook-cover-box {{ $themeClass }}">
          <div class="ebook-tag-badge {{ $eb->is_public ? 'public' : 'exclusive' }}">
            {{ $eb->is_public ? 'Akses Terbuka' : 'Eksklusif Siswa SMAN 4' }}
          </div>
          <h3 class="ebook-cover-title">{{ $eb->title }}</h3>
        </div>

        <!-- Book Meta & Description -->
        <div class="ebook-card-body">
          <div>
            <div class="ebook-meta-author">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="7" r="4"/>
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
              </svg>
              <span>Disusun oleh Tim Guru BK SMAN 4</span>
            </div>
            <p class="ebook-card-desc">
              {{ $eb->description ?? 'Modul pembelajaran bimbingan konseling komprehensif untuk pengayaan akademik dan kesiapan karir siswa.' }}
            </p>
          </div>

          <div class="ebook-card-footer">
            <div class="ebook-file-type">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                <polyline points="14 2 14 8 20 8"/>
              </svg>
              <span>Dokumen PDF</span>
            </div>
            <a href="{{ route('ebook.detail', $eb->id) }}" class="btn btn-ghost btn-sm" aria-label="Buka modul {{ $eb->title }}">
              <span>Buka Modul</span>
              <span aria-hidden="true">&rarr;</span>
            </a>
          </div>
        </div>
      </article>
    @empty
      <div class="ebook-empty-state" style="grid-column: 1 / -1;">
        <div class="ebook-empty-icon" aria-hidden="true">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
          </svg>
        </div>
        <h3>Belum Ada Modul E-Book</h3>
        <p>
          Koleksi modul sedang dalam proses kurasi oleh Tim Guru BK. Silakan kembali lagi nanti atau hubungi konselor melalui Chat SAPA.
        </p>
        <a href="{{ route('siswa.chat') }}" class="btn btn-primary btn-sm">Buka Chat Konseling</a>
      </div>
    @endforelse
  </main>

  <!-- Pagination -->
  @if($ebooks->hasPages())
    <div style="display: flex; justify-content: center; margin-top: 10px;">
      {{ $ebooks->links() }}
    </div>
  @endif

</div>
@endsection
