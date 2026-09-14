@extends('layouts.app')

@section('title', 'Kuesioner & Asesmen Minat Siswa : SAPA BK SMAN 4 Jember')
@section('page_title', 'Kuesioner & Asesmen Minat')

@push('styles')
<style>
  /* ===================================================
     SAPA BK - KUESIONER & ASESMEN SISWA (WARM EDITORIAL)
     Antislop: No em dash, WCAG AA contrast, Vanilla CSS
     =================================================== */

  .tes-container {
    display: flex;
    flex-direction: column;
    gap: 24px;
  }

  /* Editorial Header */
  .tes-header {
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
  .tes-header-info {
    max-width: 680px;
  }
  .tes-breadcrumb {
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
  .tes-header h2 {
    font-size: 24px;
    font-weight: 600;
    color: var(--ink);
    line-height: 1.25;
  }
  .tes-header p {
    color: var(--ink-soft);
    font-size: 14.5px;
    margin-top: 6px;
    line-height: 1.55;
  }
  .tes-badge-verified {
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

  /* Summary Metrics Strip */
  .tes-summary-strip {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
  }
  .tes-metric-card {
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
  .tes-metric-label {
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: var(--ink-faint);
  }
  .tes-metric-val {
    font-family: 'Fraunces', Georgia, serif;
    font-size: 28px;
    font-weight: 600;
    color: var(--ink);
    line-height: 1;
    margin-top: 6px;
  }
  .tes-metric-desc {
    font-size: 12px;
    color: var(--ink-soft);
    margin-top: 4px;
  }

  /* Questionnaire Grid */
  .tes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
    gap: 24px;
  }

  /* Single Questionnaire Card */
  .tes-card {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-m);
    box-shadow: var(--shadow-card);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 24px;
    transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
  }
  .tes-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 6px rgba(27,42,36,0.08), 0 12px 24px -8px rgba(27,42,36,0.18);
    border-color: #B4C4B8;
  }

  .tes-card-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 16px;
  }
  .tes-icon-box {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: var(--bg-alt);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .tes-status-pill {
    font-size: 11.5px;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 99px;
    letter-spacing: .02em;
  }
  .tes-status-pill.done {
    background: #E8F5E9;
    color: #1B5E20;
    border: 1px solid #A5D6A7;
  }
  .tes-status-pill.pending {
    background: #FFF8E1;
    color: #8D6E00;
    border: 1px solid #FFE082;
  }

  .tes-card-title {
    font-family: 'Fraunces', Georgia, serif;
    font-size: 18px;
    font-weight: 600;
    color: var(--ink);
    line-height: 1.35;
    margin-bottom: 8px;
  }
  .tes-card-desc {
    font-size: 13.5px;
    color: var(--ink-soft);
    line-height: 1.6;
    margin-bottom: 18px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .tes-card-footer {
    padding-top: 16px;
    border-top: 1px solid var(--line);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
  }
  .tes-meta-creator {
    font-size: 12px;
    color: var(--ink-faint);
    display: flex;
    align-items: center;
    gap: 6px;
  }

  /* Empty State */
  .tes-empty-box {
    background: var(--surface);
    border: 1px dashed var(--line);
    border-radius: var(--radius-m);
    padding: 64px 20px;
    text-align: center;
    grid-column: 1 / -1;
  }
  .tes-empty-icon {
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

  @media (max-width: 860px) {
    .tes-summary-strip {
      grid-template-columns: 1fr;
      gap: 12px;
    }
    .tes-header {
      padding: 20px;
    }
  }
</style>
@endpush

@section('content')
<div class="tes-container">

  <!-- Editorial Header -->
  <header class="tes-header">
    <div class="tes-header-info">
      <div class="tes-breadcrumb">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <rect x="5.5" y="4" width="13" height="17" rx="2"/>
          <path d="M9 3.5h6v2H9zM8.5 12.5l2 2 4.5-4.5"/>
        </svg>
        <span>Asesmen Diagnostik &amp; Peminatan</span>
      </div>
      <h2>Kuesioner &amp; Asesmen Minat Bakat</h2>
      <p>
        Instrumen asesmen mandiri untuk membantumu mengenali gaya belajar dominan, tipe kepribadian, serta peta potensi karir masa depan yang disupervisi oleh Guru BK SMAN 4 Jember.
      </p>
    </div>
    <div>
      <div class="tes-badge-verified">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
          <path d="m9 12 2 2 4-4"/>
        </svg>
        <span>Instrumen Terverifikasi BK</span>
      </div>
    </div>
  </header>

  @php
    $totalInstrumen = $questionnaires->count();
    $sudahDikerjakan = $questionnaires->filter(fn($q) => $q->results->isNotEmpty())->count();
    $belumDikerjakan = $questionnaires->filter(fn($q) => $q->results->isEmpty())->count();
  @endphp

  <!-- Summary Strip -->
  <section class="tes-summary-strip" aria-label="Ringkasan Asesmen">
    <div class="tes-metric-card">
      <div class="tes-metric-label">Total Instrumen Aktif</div>
      <div class="tes-metric-val">{{ $totalInstrumen }}</div>
      <div class="tes-metric-desc">Kuesioner asesmen diagnostik</div>
    </div>
    <div class="tes-metric-card">
      <div class="tes-metric-label">Telah Diselesaikan</div>
      <div class="tes-metric-val">{{ $sudahDikerjakan }}</div>
      <div class="tes-metric-desc">Hasil analisis siap dipelajari</div>
    </div>
    <div class="tes-metric-card">
      <div class="tes-metric-label">Menunggu Dikerjakan</div>
      <div class="tes-metric-val">{{ $belumDikerjakan }}</div>
      <div class="tes-metric-desc">Instrumen belum diselesaikan</div>
    </div>
  </section>

  <!-- Questionnaire Grid -->
  <main class="tes-grid" aria-label="Daftar Kuesioner">
    @forelse($questionnaires as $q)
      @php
        $latestResult = $q->results->first();
      @endphp
      <article class="tes-card">
        <div>
          <div class="tes-card-top">
            <div class="tes-icon-box" aria-hidden="true">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                <rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>
                <path d="M9 14l2 2 4-4"/>
              </svg>
            </div>
            @if($latestResult)
              <span class="tes-status-pill done">
                Sudah Dikerjakan (Skor: {{ $latestResult->score }})
              </span>
            @else
              <span class="tes-status-pill pending">
                Belum Dikerjakan
              </span>
            @endif
          </div>

          <h3 class="tes-card-title">{{ $q->title }}</h3>
          <p class="tes-card-desc">{{ $q->description }}</p>
        </div>

        <div class="tes-card-footer">
          <div class="tes-meta-creator">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <circle cx="12" cy="7" r="4"/>
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            </svg>
            <span>Penyusun: Guru BK SMAN 4</span>
          </div>

          @if($latestResult)
            <a href="{{ route('siswa.tes.hasil', $latestResult->id) }}" class="btn btn-ghost btn-sm" aria-label="Lihat hasil kuesioner {{ $q->title }}">
              <span>Lihat Hasil &amp; Rekomendasi</span>
              <span aria-hidden="true">&rarr;</span>
            </a>
          @else
            <a href="{{ route('siswa.tes.isi', $q->id) }}" class="btn btn-primary btn-sm" aria-label="Mulai kerjakan kuesioner {{ $q->title }}">
              <span>Mulai Kerjakan</span>
              <span aria-hidden="true">&rarr;</span>
            </a>
          @endif
        </div>
      </article>
    @empty
      <div class="tes-empty-box">
        <div class="tes-empty-icon" aria-hidden="true">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="5.5" y="4" width="13" height="17" rx="2"/>
            <path d="M9 3.5h6v2H9z"/>
          </svg>
        </div>
        <h3 style="font-size: 19px; margin-bottom: 8px;">Belum Ada Kuesioner Aktif</h3>
        <p style="color: var(--ink-soft); font-size: 14px; max-width: 440px; margin: 0 auto 20px;">
          Instrumen asesmen minat dan bakat sedang disiapkan oleh Tim Konselor. Silakan kembali lagi nanti atau berkonsultasi via Chat SAPA.
        </p>
        <a href="{{ route('siswa.chat') }}" class="btn btn-primary btn-sm">Buka Chat Konseling</a>
      </div>
    @endforelse
  </main>

</div>
@endsection
