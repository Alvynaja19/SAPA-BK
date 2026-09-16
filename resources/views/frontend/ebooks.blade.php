@extends('layouts.guest')

@section('title', 'Katalog E-Book & Modul BK : SAPA BK SMAN 4 Jember')

@section('content')
<section class="page-section">
  <div class="wrap">
    
    <!-- Page Header -->
    <div class="page-header">
      <div class="badge-pill">Perpustakaan Digital</div>
      <h1 class="page-title">Katalog E-Book &amp; Modul BK</h1>
      <p class="page-lede">
        Koleksi modul bimbingan komprehensif, panduan studi lanjut, serta materi pengembangan diri yang disusun oleh Tim Konselor SMA Negeri 4 Jember.
      </p>
    </div>

    <!-- E-Book Grid -->
    <div class="ebook-row">
      @forelse($ebooks as $index => $eb)
        @php
          $colorIndex = ($index % 4) + 1;
        @endphp
        <div class="ebook-card">
          <a href="{{ route('ebook.detail', $eb->id) }}" class="ebook-cover alt-color-{{ $colorIndex }}">
            <div class="ebook-badge">{{ $eb->is_public ? 'Akses Terbuka' : 'Khusus Siswa' }}</div>
            <span>{{ $eb->title }}</span>
          </a>
          <div class="ebook-meta">
            <strong>
              <a href="{{ route('ebook.detail', $eb->id) }}" style="color: inherit;">
                {{ $eb->title }}
              </a>
            </strong>
            <span style="display: block; font-size: 12.5px; color: var(--ink-faint);">Disusun oleh Tim Guru BK</span>
            <p>
              {{ \Illuminate\Support\Str::limit($eb->description ?? 'Modul bimbingan konseling untuk mendampingi masa depan akademik dan kesiapan karir siswa.', 110) }}
            </p>
            <div style="margin-top: 14px; padding-top: 10px; border-top: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center;">
              <span style="font-size: 11.5px; font-weight: 600; color: var(--primary);">SMAN 4 Jember</span>
              <a href="{{ route('ebook.detail', $eb->id) }}" class="btn btn-ghost btn-sm" style="padding: 6px 12px; font-size: 12.5px; min-height: 34px;">
                Buka Detail &rarr;
              </a>
            </div>
          </div>
        </div>
      @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 64px 20px; background: var(--surface); border: 1px dashed var(--line); border-radius: var(--radius-m);">
          <div style="width: 56px; height: 56px; margin: 0 auto 16px; border-radius: 50%; background: var(--bg-alt); display: flex; align-items: center; justify-content: center; color: var(--primary);">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
            </svg>
          </div>
          <h3 style="font-size: 19px; margin-bottom: 8px;">Belum Ada Koleksi E-Book Publik</h3>
          <p style="color: var(--ink-soft); font-size: 14.5px; max-width: 440px; margin: 0 auto 20px;">
            Materi modul sedang dalam proses kurasi oleh Tim Guru BK. Silakan kembali lagi nanti atau tanyakan langsung melalui asisten cerdas.
          </p>
          <a href="{{ route('home') }}" class="btn btn-primary btn-sm">Kembali ke Beranda</a>
        </div>
      @endforelse
    </div>

    <!-- Pagination -->
    @if($ebooks->hasPages())
      <div class="pagination-wrap">
        {{ $ebooks->links('pagination.landing') }}
      </div>
    @endif

    <!-- Help Banner -->
    <div class="help-banner">
      <h3>Butuh Rekomendasi Modul atau Bahan Bimbingan?</h3>
      <p>
        Konsultasikan kebutuhan belajar, persiapan ujian, atau pemilihan jurusanmu dengan Asisten AI atau Guru BK di Ruang Konseling SMAN 4 Jember.
      </p>
      <a href="{{ auth()->check() ? route('siswa.chat') : route('login') }}" class="btn btn-primary">
        Mulai Konsultasi Gratis
      </a>
    </div>

  </div>
</section>
@endsection
