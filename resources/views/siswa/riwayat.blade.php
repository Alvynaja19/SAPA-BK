@extends('layouts.app')

@section('title', 'Riwayat Konsultasi : SAPA BK SMAN 4 Jember')
@section('page_title', 'Buku Riwayat Konsultasi')

@push('styles')
<style>
  /* ===================================================
     SAPA BK - BUKU RIWAYAT KONSULTASI SISWA (ANTISLOP)
     Warm Editorial System: Fraunces & Work Sans
     Palette: Forest Green (#24463F), Slate Blue (#1C6EB4), Krem (#EDF1EC, #FBF8EA)
     =================================================== */

  .riwayat-container {
    display: flex;
    flex-direction: column;
    gap: 24px;
  }

  /* Page Editorial Header */
  .riwayat-header {
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
  .riwayat-header-info {
    max-width: 650px;
  }
  .riwayat-breadcrumb {
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
  .riwayat-header h2 {
    font-size: 24px;
    font-weight: 600;
    color: var(--ink);
    line-height: 1.25;
  }
  .riwayat-header p {
    color: var(--ink-soft);
    font-size: 14.5px;
    margin-top: 6px;
    line-height: 1.55;
  }
  .riwayat-header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
  }

  /* Counseling Ledger Summary Strip (3 Columns) */
  .riwayat-ledger-strip {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
  }
  .ledger-tile {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-m);
    padding: 20px 22px;
    box-shadow: var(--shadow-card);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 112px;
    position: relative;
    overflow: hidden;
  }
  .ledger-tile-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
  }
  .ledger-tile-label {
    font-size: 12px;
    font-weight: 600;
    color: var(--ink-faint);
    text-transform: uppercase;
    letter-spacing: .05em;
  }
  .ledger-tile-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .icon-ai {
    background: var(--primary-soft);
    color: var(--primary);
  }
  .icon-guru {
    background: rgba(28, 110, 180, 0.12);
    color: #1C6EB4;
  }
  .icon-shield {
    background: var(--bg);
    border: 1px solid var(--line);
    color: var(--primary);
  }

  .ledger-tile-value {
    font-family: 'Fraunces', Georgia, serif;
    font-size: 22px;
    font-weight: 700;
    color: var(--ink);
    margin: 6px 0 2px;
  }
  .ledger-tile-hint {
    font-size: 12px;
    color: var(--ink-soft);
    line-height: 1.4;
  }

  /* Mode Filter Tabs */
  .mode-filter-container {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-m);
    padding: 14px 18px;
    box-shadow: var(--shadow-card);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
  }

  .mode-tabs {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
  }
  .mode-tab {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    min-height: 40px;
    padding: 8px 16px;
    border-radius: 999px;
    font-size: 13.5px;
    font-weight: 600;
    color: var(--ink-soft);
    background: var(--bg);
    border: 1px solid var(--line);
    text-decoration: none;
    transition: all .15s ease;
  }
  .mode-tab:hover {
    color: var(--primary);
    border-color: var(--primary);
    background: #FFFFFF;
  }
  .mode-tab.active {
    background: var(--primary);
    color: #FFFFFF;
    border-color: var(--primary);
    box-shadow: 0 2px 6px rgba(36, 70, 63, 0.2);
  }
  .mode-tab.active-guru {
    background: #1C6EB4 !important;
    color: #FFFFFF !important;
    border-color: #1C6EB4 !important;
    box-shadow: 0 2px 6px rgba(28, 110, 180, 0.25) !important;
  }
  .tab-badge-count {
    display: inline-block;
    padding: 1px 7px;
    border-radius: 10px;
    font-size: 11px;
    font-weight: 700;
    background: rgba(0, 0, 0, 0.08);
    color: inherit;
  }
  .mode-tab.active .tab-badge-count,
  .mode-tab.active-guru .tab-badge-count {
    background: rgba(255, 255, 255, 0.25);
    color: #FFFFFF;
  }

  /* Search Box */
  .filter-form {
    display: flex;
    align-items: center;
    gap: 8px;
    min-width: 280px;
  }
  .search-input-wrap {
    position: relative;
    flex: 1;
    display: flex;
    align-items: center;
  }
  .search-input-wrap svg {
    position: absolute;
    left: 14px;
    width: 17px;
    height: 17px;
    stroke: var(--ink-faint);
    pointer-events: none;
  }
  .search-input {
    width: 100%;
    min-height: 40px;
    padding: 8px 14px 8px 40px;
    background: var(--bg);
    border: 1px solid var(--line);
    border-radius: var(--radius-s);
    font-size: 13.5px;
    color: var(--ink);
    outline: none;
    transition: border-color .15s ease, background-color .15s ease;
  }
  .search-input:focus {
    background: #FFFFFF;
    border-color: var(--primary);
  }

  /* Search Tag & Reset */
  .search-feedback-bar {
    padding: 8px 16px;
    background: var(--bg);
    border: 1px solid var(--line);
    border-radius: var(--radius-s);
    font-size: 13px;
    color: var(--ink-soft);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
  }
  .reset-link {
    color: var(--warn);
    font-weight: 600;
    font-size: 12.5px;
    text-decoration: underline;
  }

  /* Ledger Session Card */
  .ledger-card {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-l);
    box-shadow: var(--shadow-card);
    overflow: hidden;
  }
  .ledger-card-header {
    padding: 16px 24px;
    border-bottom: 1px solid var(--line);
    background: rgba(237, 241, 236, 0.45);
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .ledger-card-title {
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: var(--ink-soft);
  }
  .ledger-card-count {
    font-size: 12px;
    font-weight: 600;
    color: var(--primary);
    background: var(--primary-soft);
    padding: 3px 10px;
    border-radius: 20px;
  }

  /* Ledger List Items */
  .ledger-list {
    display: flex;
    flex-direction: column;
  }
  .ledger-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 20px 24px;
    border-bottom: 1px solid var(--line);
    transition: background-color .15s ease;
  }
  .ledger-row:last-child {
    border-bottom: none;
  }
  .ledger-row:hover {
    background-color: var(--bg);
  }
  .ledger-row.row-guru {
    border-left: 4px solid #1C6EB4;
  }
  .ledger-row.row-ai {
    border-left: 4px solid var(--primary);
  }

  /* Date Calendar Badge */
  .date-calendar-badge {
    width: 62px;
    flex-shrink: 0;
    text-align: center;
    background: var(--bg);
    border: 1px solid var(--line);
    border-radius: var(--radius-s);
    padding: 8px 4px 6px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }
  .badge-border-guru {
    border-color: rgba(28, 110, 180, 0.4) !important;
    background: rgba(28, 110, 180, 0.05) !important;
  }
  .badge-border-ai {
    border-color: rgba(36, 70, 63, 0.3) !important;
    background: var(--bg) !important;
  }
  .date-badge-day {
    font-family: 'Fraunces', Georgia, serif;
    font-size: 20px;
    font-weight: 700;
    color: var(--ink);
    line-height: 1;
  }
  .date-badge-month {
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: var(--primary);
    margin-top: 3px;
  }
  .date-badge-year {
    font-size: 9.5px;
    color: var(--ink-faint);
    line-height: 1;
    margin-top: 1px;
  }

  /* Middle Text Area */
  .ledger-main-area {
    display: flex;
    align-items: flex-start;
    gap: 18px;
    flex: 1;
    min-width: 0;
  }
  .ledger-content-wrap {
    flex: 1;
    min-width: 0;
  }
  .ledger-topic-title {
    font-size: 16px;
    font-weight: 600;
    color: var(--ink);
    margin-bottom: 5px;
    line-height: 1.35;
  }
  .ledger-topic-title a {
    color: inherit;
    text-decoration: none;
    transition: color .15s ease;
  }
  .ledger-topic-title a:hover {
    color: var(--primary);
  }

  /* Distinct Channel Tag (AI vs Guru BK) */
  .tag-channel {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 9px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .04em;
    margin-bottom: 6px;
  }
  .tag-channel svg {
    width: 13px;
    height: 13px;
    stroke: currentColor;
  }
  .tag-channel-guru {
    background: rgba(28, 110, 180, 0.12);
    color: #1C6EB4;
    border: 1px solid rgba(28, 110, 180, 0.25);
  }
  .tag-channel-ai {
    background: var(--primary-soft);
    color: var(--primary);
    border: 1px solid rgba(36, 70, 63, 0.2);
  }

  .ledger-snippet {
    font-size: 13.5px;
    color: var(--ink-soft);
    line-height: 1.5;
    margin-bottom: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .ledger-meta-bar {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    font-size: 12px;
    color: var(--ink-faint);
  }
  .ledger-meta-item {
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }
  .ledger-meta-item svg {
    width: 13px;
    height: 13px;
    stroke: currentColor;
    flex-shrink: 0;
  }
  .tag-pill {
    padding: 2px 7px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 600;
  }
  .tag-pill-active {
    background: var(--bg);
    color: var(--primary);
    border: 1px solid var(--line);
  }
  .tag-pill-draft {
    background: var(--bg);
    color: var(--ink-faint);
    border: 1px solid var(--line);
  }

  /* Actions Area */
  .ledger-actions {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
  }
  .btn-delete-session {
    min-height: 38px;
    width: 38px;
    padding: 0;
    background: transparent;
    border: 1px solid var(--line);
    border-radius: var(--radius-s);
    color: var(--ink-faint);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color .15s ease, border-color .15s ease, color .15s ease;
  }
  .btn-delete-session:hover {
    background: rgba(201, 96, 59, 0.1);
    border-color: var(--warn);
    color: var(--warn);
  }
  .btn-delete-session svg {
    width: 16px;
    height: 16px;
    stroke: currentColor;
  }
  .badge-locked-guru {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 11px;
    border-radius: var(--radius-s);
    background: rgba(28, 110, 180, 0.08);
    border: 1px solid rgba(28, 110, 180, 0.2);
    color: #1C6EB4;
    font-size: 11.5px;
    font-weight: 600;
  }

  /* Empty State */
  .empty-ledger {
    text-align: center;
    padding: 56px 24px;
  }
  .empty-icon-shield {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: var(--bg);
    border: 1px solid var(--line);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
  }
  .empty-icon-shield svg {
    width: 26px;
    height: 26px;
    stroke: var(--primary);
  }
  .empty-title {
    font-size: 19px;
    font-weight: 600;
    margin-bottom: 8px;
    color: var(--ink);
  }
  .empty-desc {
    color: var(--ink-soft);
    font-size: 14.5px;
    max-width: 480px;
    margin: 0 auto 22px;
    line-height: 1.6;
  }

  /* Ethics & Privacy Box */
  .ethics-notice-box {
    padding: 20px 24px;
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-m);
    box-shadow: var(--shadow-card);
    display: flex;
    align-items: flex-start;
    gap: 16px;
    font-size: 13.5px;
    color: var(--ink-soft);
    line-height: 1.6;
  }
  .ethics-icon-wrap {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: var(--bg);
    border: 1px solid var(--line);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .ethics-icon-wrap svg {
    width: 20px;
    height: 20px;
    stroke: var(--primary);
  }
  .ethics-text h4 {
    font-size: 14.5px;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 4px;
  }

  /* Pagination Bar */
  .pagination-container {
    padding: 16px 24px;
    border-top: 1px solid var(--line);
    display: flex;
    justify-content: center;
  }

  @media (max-width: 900px) {
    .riwayat-ledger-strip {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 768px) {
    .riwayat-header {
      padding: 18px 20px;
    }
    .riwayat-header h2 {
      font-size: 21px;
    }
    .ledger-row {
      flex-direction: column;
      align-items: flex-start;
      gap: 16px;
      padding: 16px 18px;
    }
    .ledger-main-area {
      width: 100%;
    }
    .ledger-actions {
      width: 100%;
      justify-content: space-between;
      padding-top: 10px;
      border-top: 1px dashed var(--line);
    }
    .ledger-actions .btn {
      flex: 1;
    }
    .mode-filter-container {
      flex-direction: column;
      align-items: stretch;
    }
    .filter-form {
      min-width: 100%;
    }
  }

  @media (max-width: 480px) {
    .riwayat-header {
      padding: 16px;
    }
    .riwayat-header-actions {
      width: 100%;
    }
    .riwayat-header-actions .btn {
      width: 100%;
    }
    .mode-tabs {
      width: 100%;
      overflow-x: auto;
      flex-wrap: nowrap;
      padding-bottom: 4px;
      -webkit-overflow-scrolling: touch;
    }
    .mode-tab {
      flex-shrink: 0;
    }
  }
</style>
@endpush

@section('content')
<div class="riwayat-container">

  <!-- Editorial Page Header -->
  <div class="riwayat-header">
    <div class="riwayat-header-info">
      <div class="riwayat-breadcrumb">
        <span>Bimbingan Konseling</span>
        <span>/</span>
        <span>Catatan Percakapan Siswa</span>
      </div>
      <h2>Buku Riwayat Konsultasi Siswa</h2>
      <p>
        Arsip rekaman resmi dialog bimbingan konseling di SAPA BK SMA Negeri 4 Jember, terbagi antara percakapan mandiri bersama Chatbot AI dan sesi interaktif langsung bersama Guru BK piket.
      </p>
    </div>
    <div class="riwayat-header-actions">
      <a href="{{ route('siswa.chat') }}" class="btn btn-primary" title="Konsultasi cepat 24 jam dengan asisten cerdas">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
        </svg>
        <span>Tanya Chatbot AI</span>
      </a>
      <a href="{{ route('siswa.chat', ['mode' => 'live']) }}" class="btn btn-ghost" title="Konsultasi langsung dengan Guru BK piket">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
          <circle cx="9" cy="7" r="4"></circle>
          <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
          <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
        </svg>
        <span>Live Chat Guru BK</span>
      </a>
    </div>
  </div>



  <!-- Counseling Ledger Summary Strip (3 Columns: AI vs Live Chat vs Privacy) -->
  <div class="riwayat-ledger-strip">
    <!-- Tile 1: Chatbot AI -->
    <div class="ledger-tile">
      <div class="ledger-tile-top">
        <span class="ledger-tile-label">Chatbot AI (Mandiri)</span>
        <div class="ledger-tile-icon icon-ai">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
          </svg>
        </div>
      </div>
      <div class="ledger-tile-value">{{ $totalAiSessions ?? 0 }} Sesi</div>
      <span class="ledger-tile-hint">Konseling mandiri 24/7 dengan basis materi RAG</span>
    </div>

    <!-- Tile 2: Live Chat Guru BK -->
    <div class="ledger-tile">
      <div class="ledger-tile-top">
        <span class="ledger-tile-label">Live Chat Guru BK</span>
        <div class="ledger-tile-icon icon-guru">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
          </svg>
        </div>
      </div>
      <div class="ledger-tile-value" style="color: #1C6EB4;">{{ $totalGuruSessions ?? 0 }} Sesi</div>
      <span class="ledger-tile-hint">Dialog privat bersama Tim Konselor SMAN 4 Jember</span>
    </div>

    <!-- Tile 3: Kode Etik ABKIN -->
    <div class="ledger-tile">
      <div class="ledger-tile-top">
        <span class="ledger-tile-label">Standar Perlindungan</span>
        <div class="ledger-tile-icon icon-shield">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
          </svg>
        </div>
      </div>
      <div class="ledger-tile-value" style="font-size: 18px; color: var(--primary);">Kode Etik ABKIN</div>
      <span class="ledger-tile-hint">Kerahasiaan bimbingan terlindungi secara profesional</span>
    </div>
  </div>

  <!-- Mode Filter Tabs & Search Controls -->
  <div class="mode-filter-container">
    <!-- Category Tabs -->
    <div class="mode-tabs" role="tablist" aria-label="Filter Mode Konsultasi">
      <a href="{{ route('siswa.riwayat', array_merge(request()->except('page', 'mode'), ['mode' => 'all'])) }}" 
         class="mode-tab {{ (!request('mode') || request('mode') === 'all') ? 'active' : '' }}">
        <span>Semua Riwayat</span>
        <span class="tab-badge-count">{{ $totalSessions ?? 0 }}</span>
      </a>

      <a href="{{ route('siswa.riwayat', array_merge(request()->except('page', 'mode'), ['mode' => 'ai'])) }}" 
         class="mode-tab {{ request('mode') === 'ai' ? 'active' : '' }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
        </svg>
        <span>Chatbot AI (24/7)</span>
        <span class="tab-badge-count">{{ $totalAiSessions ?? 0 }}</span>
      </a>

      <a href="{{ route('siswa.riwayat', array_merge(request()->except('page', 'mode'), ['mode' => 'guru_bk'])) }}" 
         class="mode-tab {{ request('mode') === 'guru_bk' ? 'active-guru' : '' }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
          <circle cx="9" cy="7" r="4"></circle>
          <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
          <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
        </svg>
        <span>Live Chat Guru BK</span>
        <span class="tab-badge-count">{{ $totalGuruSessions ?? 0 }}</span>
      </a>
    </div>

    <!-- Search Form (Preserves Mode) -->
    <form action="{{ route('siswa.riwayat') }}" method="GET" class="filter-form">
      @if(request('mode'))
        <input type="hidden" name="mode" value="{{ request('mode') }}" />
      @endif
      <div class="search-input-wrap">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"/>
          <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input 
          type="text" 
          name="q" 
          value="{{ $search ?? '' }}" 
          placeholder="Cari topik bimbingan atau kata kunci..." 
          class="search-input"
          aria-label="Cari riwayat bimbingan"
        />
      </div>
      <button type="submit" class="btn btn-ghost btn-sm">
        <span>Cari</span>
      </button>
    </form>
  </div>

  @if(!empty($search))
    <div class="search-feedback-bar">
      <span>Menampilkan hasil pencarian: <strong>"{{ $search }}"</strong> pada kategori <strong>{{ request('mode') === 'guru_bk' ? 'Live Chat Guru BK' : (request('mode') === 'ai' ? 'Chatbot AI' : 'Semua Sesi') }}</strong></span>
      <a href="{{ route('siswa.riwayat', request()->except('q', 'page')) }}" class="reset-link">Reset Pencarian</a>
    </div>
  @endif

  <!-- Ledger Session Card -->
  <div class="ledger-card">
    <div class="ledger-card-header">
      <span class="ledger-card-title">
        @if(request('mode') === 'guru_bk')
          Daftar Rekaman Sesi Live Chat Guru BK
        @elseif(request('mode') === 'ai')
          Daftar Rekaman Percakapan Chatbot AI
        @else
          Seluruh Rekaman Sesi Konsultasi
        @endif
      </span>
      <span class="ledger-card-count">{{ $sessions->total() }} Sesi Ditampilkan</span>
    </div>

    <div class="ledger-list">
      @forelse($sessions as $s)
        @php
          $isGuru = ($s->mode === 'guru_bk');
          $latestMsg = $s->messages->first();
          $createdDate = $s->created_at ?? now();
        @endphp
        <div class="ledger-row {{ $isGuru ? 'row-guru' : 'row-ai' }}">
          <div class="ledger-main-area">
            <!-- Calendar Date Badge -->
            <div class="date-calendar-badge {{ $isGuru ? 'badge-border-guru' : 'badge-border-ai' }}">
              <span class="date-badge-day">{{ $createdDate->format('d') }}</span>
              <span class="date-badge-month" style="{{ $isGuru ? 'color: #1C6EB4;' : '' }}">{{ $createdDate->translatedFormat('M') }}</span>
              <span class="date-badge-year">{{ $createdDate->format('Y') }}</span>
            </div>

            <!-- Content Group -->
            <div class="ledger-content-wrap">
              <!-- Channel / Mode Tag -->
              @if($isGuru)
                <span class="tag-channel tag-channel-guru">
                  <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                  </svg>
                  <span>Live Chat Guru BK</span>
                </span>
              @else
                <span class="tag-channel tag-channel-ai">
                  <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                  </svg>
                  <span>Chatbot AI (24/7)</span>
                </span>
              @endif

              <h3 class="ledger-topic-title">
                <a href="{{ route('siswa.chat.session', $s->id) }}">
                  {{ $s->title }}
                </a>
              </h3>

              @if($latestMsg && !empty($latestMsg->content))
                <p class="ledger-snippet">
                  "{{ Str::limit(strip_tags($latestMsg->content), 120, '...') }}"
                </p>
              @else
                <p class="ledger-snippet" style="color: var(--ink-faint); font-style: italic;">
                  Belum ada pesan terkirim dalam sesi ini. Buka percakapan untuk memulai dialog bimbingan.
                </p>
              @endif

              <div class="ledger-meta-bar">
                <span class="ledger-meta-item">
                  <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                  </svg>
                  <span>Pukul {{ $createdDate->format('H:i') }} WIB</span>
                </span>
                <span>&bull;</span>
                <span class="ledger-meta-item">
                  <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                  </svg>
                  <span>{{ $s->messages_count }} Pesan Dialog</span>
                </span>
                <span>&bull;</span>
                @if($isGuru)
                  <span class="tag-pill tag-pill-active" style="color: #1C6EB4; border-color: rgba(28, 110, 180, 0.25);">Konseling Langsung Guru BK</span>
                @else
                  <span class="tag-pill tag-pill-active">Asisten Mandiri RAG</span>
                @endif
              </div>
            </div>
          </div>

          <!-- Actions -->
          <div class="ledger-actions">
            <a href="{{ route('siswa.chat.session', $s->id) }}" class="btn btn-ghost btn-sm" style="{{ $isGuru ? 'border-color: #1C6EB4; color: #1C6EB4;' : '' }}">
              <span>Buka Percakapan</span>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14M12 5l7 7-7 7"/>
              </svg>
            </a>

            @if(!$isGuru)
              <form id="delete-form-{{ $s->id }}" action="{{ route('siswa.riwayat.delete', $s->id) }}" method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="button" 
                        class="btn-delete-session" 
                        onclick="confirmDeleteRiwayat({{ $s->id }}, '{{ addslashes($s->title) }}')"
                        title="Hapus arsip percakapan Chatbot AI" 
                        aria-label="Hapus arsip percakapan {{ $s->title }}">
                  <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                  </svg>
                </button>
              </form>
            @else
              <span class="badge-locked-guru" title="Rekaman resmi bimbingan konseling bersama Guru BK terlindungi sesuai kode etik ABKIN dan tidak dapat dihapus siswa.">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#1C6EB4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                  <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                <span>Arsip Resmi</span>
              </span>
            @endif
          </div>
        </div>
      @empty
        <div class="empty-ledger">
          <div class="empty-icon-shield">
            @if(request('mode') === 'guru_bk')
              <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="stroke: #1C6EB4;">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
              </svg>
            @else
              <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
              </svg>
            @endif
          </div>

          @if(!empty($search))
            <h3 class="empty-title">Topik Konsultasi Tidak Ditemukan</h3>
            <p class="empty-desc">
              Tidak ditemukan catatan bimbingan yang cocok dengan kata kunci <strong>"{{ $search }}"</strong> pada kategori ini.
            </p>
            <a href="{{ route('siswa.riwayat') }}" class="btn btn-primary">
              Tampilkan Semua Riwayat
            </a>
          @elseif(request('mode') === 'guru_bk')
            <h3 class="empty-title">Belum Ada Riwayat Live Chat Guru BK</h3>
            <p class="empty-desc">
              Anda belum memiliki arsip percakapan langsung bersama Guru BK piket. Sampaikan pertanyaan seputar penjurusan atau permasalahan belajar secara privat kapan saja.
            </p>
            <a href="{{ route('siswa.chat', ['mode' => 'live']) }}" class="btn btn-primary" style="background: #1C6EB4;">
              Mulai Live Chat Guru BK
            </a>
          @elseif(request('mode') === 'ai')
            <h3 class="empty-title">Belum Ada Riwayat Chatbot AI</h3>
            <p class="empty-desc">
              Anda belum memiliki arsip percakapan dengan asisten mandiri. Tanyakan informasi seputar materi bimbingan dan pilihan studi secara instan 24 jam.
            </p>
            <a href="{{ route('siswa.chat') }}" class="btn btn-primary">
              Mulai Konsultasi Chatbot AI
            </a>
          @else
            <h3 class="empty-title">Belum Ada Riwayat Konsultasi</h3>
            <p class="empty-desc">
              Anda belum memiliki catatan percakapan bimbingan tersimpan. Mulai percakapan pertama Anda sekarang.
            </p>
            <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
              <a href="{{ route('siswa.chat') }}" class="btn btn-primary">
                Tanya Chatbot AI
              </a>
              <a href="{{ route('siswa.chat', ['mode' => 'live']) }}" class="btn btn-ghost" style="border-color: #1C6EB4; color: #1C6EB4;">
                Live Chat Guru BK
              </a>
            </div>
          @endif
        </div>
      @endforelse
    </div>

    @if($sessions->hasPages())
      <div class="pagination-container">
        {{ $sessions->links() }}
      </div>
    @endif
  </div>

  <!-- Professional Counseling Ethics Notice (ABKIN) -->
  <div class="ethics-notice-box">
    <div class="ethics-icon-wrap">
      <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
      </svg>
    </div>
    <div class="ethics-text">
      <h4>Asas Kerahasiaan Konseling (Kode Etik ABKIN)</h4>
      <p>
        Seluruh catatan bimbingan konseling dan dialog interaktif bersifat rahasia dan terlindungi secara etis. Data percakapan ini hanya digunakan demi kepentingan pendampingan perkembangan akademik serta psikososial Anda di SMA Negeri 4 Jember.
      </p>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
  function confirmDeleteRiwayat(sessionId, title) {
    showConfirmModal({
      title: 'Hapus Arsip Percakapan AI?',
      message: 'Sesi "' + title + '" dan seluruh catatan dialog di dalamnya akan dihapus secara permanen dari buku riwayat Anda.',
      confirmText: 'Ya, Hapus Percakapan',
      cancelText: 'Batal',
      onConfirm: function() {
        var form = document.getElementById('delete-form-' + sessionId);
        if (form) {
          form.submit();
        }
      }
    });
  }
</script>
@endpush

