@extends('layouts.app')

@section('title', 'Lembar Asesmen : ' . $questionnaire->title . ' : SAPA BK SMAN 4 Jember')
@section('page_title', 'Lembar Asesmen Siswa')

@push('styles')
<style>
  /* ===================================================
     SAPA BK - LEMBAR ISIAN KUESIONER (WARM EDITORIAL)
     =================================================== */

  .isi-tes-container {
    max-width: 820px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 22px;
  }

  /* Back Action */
  .isi-tes-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13.5px;
    font-weight: 600;
    color: var(--ink-soft);
    transition: color .15s ease;
    align-self: flex-start;
  }
  .isi-tes-back:hover {
    color: var(--primary);
  }

  /* Header Card */
  .isi-tes-header-card {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-l);
    padding: 28px 32px;
    box-shadow: var(--shadow-card);
  }
  .isi-tes-tag {
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: var(--primary);
    margin-bottom: 8px;
  }
  .isi-tes-title {
    font-family: 'Fraunces', Georgia, serif;
    font-size: 24px;
    font-weight: 600;
    color: var(--ink);
    line-height: 1.3;
    margin-bottom: 10px;
  }
  .isi-tes-desc {
    font-size: 14.5px;
    color: var(--ink-soft);
    line-height: 1.65;
  }
  .isi-tes-notice {
    margin-top: 18px;
    padding: 12px 16px;
    background: var(--bg-alt);
    border-radius: var(--radius-s);
    font-size: 13px;
    color: var(--ink);
    display: flex;
    align-items: center;
    gap: 10px;
  }

  /* Questions List */
  .soal-card {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-m);
    padding: 24px 28px;
    box-shadow: var(--shadow-card);
    display: flex;
    flex-direction: column;
    gap: 16px;
  }
  .soal-header {
    display: flex;
    align-items: flex-start;
    gap: 14px;
  }
  .soal-number {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: var(--primary-soft);
    color: var(--primary);
    font-weight: 700;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .soal-text {
    font-size: 15px;
    font-weight: 600;
    color: var(--ink);
    line-height: 1.5;
  }

  /* Option items */
  .soal-options {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-left: 46px;
  }
  .option-label {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px 18px;
    border-radius: var(--radius-s);
    background: #FAFCF9;
    border: 1px solid var(--line);
    cursor: pointer;
    font-size: 14px;
    color: var(--ink);
    transition: all .15s ease;
  }
  .option-label:hover {
    background: #F3F7F2;
    border-color: var(--primary);
  }
  .option-label:has(input[type="radio"]:checked) {
    background: #EDF4EE;
    border-color: var(--primary);
    box-shadow: 0 0 0 1px var(--primary);
  }
  .option-label input[type="radio"] {
    width: 18px;
    height: 18px;
    accent-color: var(--primary);
    margin: 0;
    cursor: pointer;
  }

  /* Form Action Footer */
  .form-actions-card {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-m);
    padding: 20px 28px;
    box-shadow: var(--shadow-card);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
  }
  .form-action-note {
    font-size: 13px;
    color: var(--ink-faint);
  }

  @media (max-width: 640px) {
    .soal-options {
      margin-left: 0;
      gap: 8px;
    }
    .option-label {
      min-height: 48px;
      padding: 12px 14px;
      font-size: 13.5px;
    }
    .isi-tes-header-card {
      padding: 18px 16px;
      border-radius: var(--radius-m);
    }
    .isi-tes-title {
      font-size: 20px;
    }
    .soal-card {
      padding: 16px;
    }
    .form-actions-card {
      padding: 16px;
      flex-direction: column;
      align-items: stretch;
      gap: 12px;
    }
    .form-actions-card .btn {
      width: 100%;
    }
  }
</style>
@endpush

@section('content')
<div class="isi-tes-container">

  <!-- Back Link -->
  <a href="{{ route('siswa.tes') }}" class="isi-tes-back">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <path d="m15 18-6-6 6-6"/>
    </svg>
    <span>Kembali ke Daftar Asesmen</span>
  </a>

  <!-- Header Card -->
  <header class="isi-tes-header-card">
    <div class="isi-tes-tag">Lembar Kerja Asesmen Mandiri</div>
    <h1 class="isi-tes-title">{{ $questionnaire->title }}</h1>
    <p class="isi-tes-desc">{{ $questionnaire->description }}</p>
    <div class="isi-tes-notice">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="color: var(--primary); flex-shrink: 0;">
        <circle cx="12" cy="12" r="10"/>
        <line x1="12" y1="16" x2="12" y2="12"/>
        <line x1="12" y1="8" x2="12.01" y2="8"/>
      </svg>
      <span>Pilihlah salah satu opsi jawaban yang paling menggambarkan kebiasaan belajarmu sehari-hari. Tidak ada jawaban salah dalam asesmen ini.</span>
    </div>
  </header>

  <!-- Interactive Questionnaire Form -->
  <form method="POST" action="{{ route('siswa.tes.simpan', $questionnaire->id) }}" style="display: flex; flex-direction: column; gap: 18px;">
    @csrf

    @forelse($questionnaire->questions as $index => $qItem)
      <article class="soal-card">
        <div class="soal-header">
          <div class="soal-number">{{ $index + 1 }}</div>
          <div class="soal-text">{{ $qItem->question_text }}</div>
        </div>

        <div class="soal-options">
          @if(is_array($qItem->options))
            @foreach($qItem->options as $optIdx => $opt)
              @php
                $optVal = is_array($opt) ? ($opt['value'] ?? $optIdx) : $opt;
                $optLabel = is_array($opt) ? ($opt['label'] ?? $optVal) : $opt;
              @endphp
              <label class="option-label">
                <input
                  type="radio"
                  name="answers[{{ $qItem->id }}]"
                  value="{{ $optVal }}"
                  required
                />
                <span>{{ $optLabel }}</span>
              </label>
            @endforeach
          @endif
        </div>
      </article>
    @empty
      <div style="background: var(--surface); border: 1px dashed var(--line); border-radius: var(--radius-m); padding: 48px 20px; text-align: center;">
        <p style="color: var(--ink-soft); font-size: 14.5px;">Butir soal untuk instrumen ini sedang dalam proses penyusunan oleh Guru BK.</p>
        <div style="margin-top: 16px;">
          <a href="{{ route('siswa.tes') }}" class="btn btn-ghost btn-sm">Kembali ke Daftar Asesmen</a>
        </div>
      </div>
    @endforelse

    @if($questionnaire->questions->isNotEmpty())
      <!-- Form Actions -->
      <div class="form-actions-card">
        <div class="form-action-note">
          Periksa kembali pilihanmu sebelum mengirimkan lembar jawaban.
        </div>
        <button type="submit" class="btn btn-primary">
          <span>Kirim Lembar Jawaban &amp; Lihat Analisis</span>
          <span aria-hidden="true">&rarr;</span>
        </button>
      </div>
    @endif

  </form>

</div>
@endsection
