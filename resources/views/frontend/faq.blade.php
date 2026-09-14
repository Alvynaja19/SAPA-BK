@extends('layouts.guest')

@section('title', 'Tanya Jawab & Bantuan : SAPA BK SMAN 4 Jember')

@section('content')
<section class="page-section">
  <div class="wrap">
    
    <!-- Page Header -->
    <div class="page-header">
      <div class="badge-pill">Pusat Informasi &amp; Bantuan</div>
      <h1 class="page-title">Pertanyaan yang Sering Diajukan</h1>
      <p class="page-lede">
        Temukan informasi lengkap terkait etika kerahasiaan konseling, panduan akses modul digital, peminatan studi lanjut, dan alur konsultasi di SMA Negeri 4 Jember.
      </p>
    </div>

    <!-- FAQ Accordion List -->
    <div class="faq-list">
      @forelse($faqs as $index => $f)
        <details {{ $index === 0 ? 'open' : '' }}>
          <summary>
            <span>{{ $f->question }}</span>
            <span class="plus" aria-hidden="true">+</span>
          </summary>
          <div class="faq-answer">
            {{ $f->answer }}
          </div>
        </details>
      @empty
        <div style="text-align: center; padding: 56px 20px; background: var(--surface); border: 1px dashed var(--line); border-radius: var(--radius-m); margin-top: 24px;">
          <div style="width: 56px; height: 56px; margin: 0 auto 16px; border-radius: 50%; background: var(--bg-alt); display: flex; align-items: center; justify-content: center; color: var(--primary);">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/>
              <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
              <path d="M12 17h.01"/>
            </svg>
          </div>
          <h3 style="font-size: 19px; margin-bottom: 8px;">Daftar Pertanyaan Sedang Diperbarui</h3>
          <p style="color: var(--ink-soft); font-size: 14.5px; max-width: 440px; margin: 0 auto 20px;">
            Pusat bantuan sedang dalam pembaruan konten. Jika ada hal mendesak yang ingin ditanyakan, hubungi langsung ruang BK SMAN 4 Jember.
          </p>
          <a href="{{ route('home') }}" class="btn btn-primary btn-sm">Kembali ke Beranda</a>
        </div>
      @endforelse
    </div>

    <!-- Help Banner -->
    <div class="help-banner">
      <h3>Punya Pertanyaan Lain yang Belum Terjawab?</h3>
      <p>
        Kamu bisa langsung bertanya kepada Asisten AI kami 24 jam sehari, atau berkunjung ke Ruang Bimbingan &amp; Konseling di Lantai 1 SMA Negeri 4 Jember.
      </p>
      <div style="display: flex; justify-content: center; gap: 14px; flex-wrap: wrap;">
        <a href="{{ auth()->check() ? route('siswa.chat') : route('login') }}" class="btn btn-primary">
          Tanya Asisten AI Sekarang
        </a>
        <a href="{{ route('about') }}" class="btn btn-ghost">
          Lihat Profil Guru BK
        </a>
      </div>
    </div>

  </div>
</section>
@endsection
