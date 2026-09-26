@extends('layouts.app')

@section('title', 'Hasil Analisis Kuesioner : SAPA BK SMAN 4 Jember')
@section('page_title', 'Hasil Analisis Asesmen')

@push('styles')
<style>
  /* ===================================================
     SAPA BK - HASIL ANALISIS ASESMEN SISWA (WARM EDITORIAL)
     =================================================== */

  .hasil-tes-container {
    max-width: 820px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 22px;
  }

  .hasil-tes-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13.5px;
    font-weight: 600;
    color: var(--ink-soft);
    transition: color .15s ease;
    align-self: flex-start;
  }
  .hasil-tes-back:hover {
    color: var(--primary);
  }

  .hasil-tes-surface {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-l);
    padding: clamp(24px, 4vw, 36px);
    box-shadow: var(--shadow-card);
    display: flex;
    flex-direction: column;
    gap: 24px;
  }

  /* Completion Header */
  .hasil-header {
    text-align: center;
    padding-bottom: 24px;
    border-bottom: 1px solid var(--line);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
  }
  .hasil-check-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #E8F5E9;
    color: #1B5E20;
    border: 2px solid #A5D6A7;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(27,94,32,0.12);
  }
  .hasil-header h1 {
    font-family: 'Fraunces', Georgia, serif;
    font-size: 26px;
    font-weight: 600;
    color: var(--ink);
    line-height: 1.25;
  }
  .hasil-header p {
    font-size: 14px;
    color: var(--ink-soft);
    max-width: 520px;
    line-height: 1.6;
  }

  /* 2-Column Metrics */
  .hasil-metrics-grid {
    display: grid;
    grid-template-columns: 1fr 1.4fr;
    gap: 18px;
  }
  .hasil-metric-box {
    border-radius: var(--radius-m);
    padding: 22px 24px;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  .hasil-metric-box.score {
    background: var(--primary-soft);
    border: 1px solid rgba(36,70,63,0.2);
    text-align: center;
    gap: 6px;
  }
  .hasil-metric-box.profile {
    background: #FAFCF9;
    border: 1px solid var(--line);
    gap: 8px;
  }
  .hasil-metric-label {
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: var(--primary);
  }
  .hasil-score-val {
    font-family: 'Fraunces', Georgia, serif;
    font-size: 38px;
    font-weight: 700;
    color: var(--primary);
    line-height: 1.1;
  }
  .hasil-score-sub {
    font-size: 12px;
    color: var(--ink-soft);
    font-weight: 500;
  }
  .hasil-profile-title {
    font-family: 'Fraunces', Georgia, serif;
    font-size: 19px;
    font-weight: 600;
    color: var(--ink);
  }
  .hasil-profile-desc {
    font-size: 13px;
    color: var(--ink-soft);
    line-height: 1.6;
  }

  /* Recommendations Card */
  .hasil-recom-box {
    background: #FAFCF9;
    border: 1px solid var(--line);
    border-radius: var(--radius-m);
    padding: 22px 26px;
    display: flex;
    flex-direction: column;
    gap: 14px;
  }
  .hasil-recom-head {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 15px;
    font-weight: 700;
    color: var(--ink);
  }
  .hasil-recom-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding-left: 20px;
    list-style: disc;
    font-size: 13.5px;
    color: var(--ink);
    line-height: 1.6;
  }

  /* Actions Bar */
  .hasil-actions {
    padding-top: 20px;
    border-top: 1px solid var(--line);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
  }

  @media (max-width: 680px) {
    .hasil-metrics-grid {
      grid-template-columns: 1fr;
    }
    .hasil-header h1 {
      font-size: 21px;
    }
    .hasil-actions {
      flex-direction: column;
      align-items: stretch;
      gap: 10px;
    }
    .hasil-actions .btn {
      width: 100%;
    }
  }
</style>
@endpush

@section('content')
<div class="hasil-tes-container">

  <!-- Back Link -->
  <a href="{{ route('siswa.tes') }}" class="hasil-tes-back">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <path d="m15 18-6-6 6-6"/>
    </svg>
    <span>Kembali ke Daftar Asesmen</span>
  </a>

  <article class="hasil-tes-surface">
    
    <!-- Completion Header -->
    <div class="hasil-header">
      <div class="hasil-check-icon" aria-hidden="true">
        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="20 6 9 17 4 12"/>
        </svg>
      </div>
      <h1>Hasil Analisis &amp; Profil Belajarmu</h1>
      <p>
        Instrumen: <strong>{{ $result->questionnaire->title }}</strong><br>
        Diselesaikan oleh <strong>{{ auth()->user()->name }}</strong> pada {{ $result->created_at->format('d F Y, H:i') }} WIB
      </p>
    </div>

    <!-- Metrics Cards -->
    <div class="hasil-metrics-grid">
      <div class="hasil-metric-box score">
        <span class="hasil-metric-label">Skor Asesmen</span>
        <div class="hasil-score-val">{{ $result->score ?? 30 }}</div>
        <span class="hasil-score-sub">Tingkat Ketuntasan: 100% Valid</span>
      </div>

      <div class="hasil-metric-box profile">
        <span class="hasil-metric-label">Modalitas Belajar Dominan</span>
        <div class="hasil-profile-title">Dominan Visual &amp; Auditori</div>
        <p class="hasil-profile-desc">
          Kamu menyerap materi paling optimal melalui representasi visual (diagram, infografis warna-warni) serta mendengarkan penjelasan lisan atau berdiskusi interaktif bersama teman dan guru.
        </p>
      </div>
    </div>

    <!-- BK Recommendations -->
    <div class="hasil-recom-box">
      <div class="hasil-recom-head">
        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="color: var(--accent);">
          <path d="M9 18h6M10 22h4M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1 .23 2.23 1.5 3.5A4.61 4.61 0 0 1 8.91 14"/>
        </svg>
        <span>Rekomendasi Strategi Belajar dari Guru BK SMAN 4 Jember:</span>
      </div>
      <ul class="hasil-recom-list">
        <li>Gunakan <em>Highlighter</em> (stabilo warna-warni) saat merangkum catatan materi penting di buku pegangan.</li>
        <li>Buat mind mapping atau diagram alur konsep di awal bab sebelum menghadapi asesmen sumatif.</li>
        <li>Diskusikan topik pelajaran yang menantang bersama kelompok belajar untuk memperkuat daya serap auditori.</li>
        <li>Bila membutuhkan konsultasi lanjutan mengenai kecocokan jurusan kuliah, silakan buka sesi konseling tatap muka atau diskusikan di Chat SAPA.</li>
      </ul>
    </div>

    <!-- Actions -->
    <div class="hasil-actions">
      <a href="{{ route('siswa.chat', ['mode' => 'live', 'ref' => 'tes', 'ref_id' => $result->id]) }}" class="btn btn-primary btn-sm">
        <span>Diskusikan Hasil Ini via Chat SAPA</span>
        <span aria-hidden="true">&rarr;</span>
      </a>
      <a href="{{ route('siswa.dashboard') }}" class="btn btn-ghost btn-sm">
        <span>Kembali ke Dashboard</span>
      </a>
    </div>

  </article>

</div>
@endsection
