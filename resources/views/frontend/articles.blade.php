@extends('layouts.guest')

@section('title', 'Artikel & Tips Bimbingan Edukatif : SAPA BK SMAN 4 Jember')

@section('content')
<section class="page-section">
  <div class="wrap">
    
    <!-- Page Header -->
    <div class="page-header">
      <div class="badge-pill">Pojok Literasi &amp; Edukasi</div>
      <h1 class="page-title">Artikel &amp; Tips Bimbingan</h1>
      <p class="page-lede">
        Wawasan inspiratif seputar metode belajar cerdas, persiapan studi lanjut perguruan tinggi, serta kiat memelihara kesehatan mental remaja dari Tim Guru BK SMAN 4 Jember.
      </p>
    </div>

    <!-- Articles Grid -->
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
              <div style="font-size: 12px; font-weight: 600; color: var(--primary); margin-bottom: 8px;">
                @if($art->category === 'tips_ptn')
                  Tips Masuk PTN &amp; SNBP
                @elseif($art->category === 'kesehatan_mental')
                  Kesehatan Mental Remaja
                @else
                  Edukasi &amp; Konseling
                @endif
              </div>
              <h3>
                <a href="{{ route('article.detail', $art->slug) }}">
                  {{ $art->title }}
                </a>
              </h3>
              <p>
                {{ \Illuminate\Support\Str::limit(strip_tags($art->content), 125) }}
              </p>
            </div>
            <div>
              <div class="ameta">
                <span>{{ $art->source_name ? 'Sumber: ' . $art->source_name : 'Oleh Tim Guru BK' }}</span>
                <span>{{ $art->created_at ? $art->created_at->format('d M Y') : 'Terbaru' }}</span>
              </div>
              <div style="margin-top: 14px; padding-top: 10px; border-top: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 11.5px; color: var(--ink-faint);">SMAN 4 Jember</span>
                <a href="{{ route('article.detail', $art->slug) }}" class="btn btn-ghost btn-sm" style="padding: 6px 12px; font-size: 12.5px; min-height: 34px;">
                  Baca Selengkapnya &rarr;
                </a>
              </div>
            </div>
          </div>
        </article>
      @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 64px 20px; background: var(--surface); border: 1px dashed var(--line); border-radius: var(--radius-m);">
          <div style="width: 56px; height: 56px; margin: 0 auto 16px; border-radius: 50%; background: var(--bg-alt); display: flex; align-items: center; justify-content: center; color: var(--primary);">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
          </div>
          <h3 style="font-size: 19px; margin-bottom: 8px;">Belum Ada Artikel yang Dipublikasikan</h3>
          <p style="color: var(--ink-soft); font-size: 14.5px; max-width: 440px; margin: 0 auto 20px;">
            Artikel edukasi baru sedang dipersiapkan oleh tim konselor kami. Silakan cek kembali dalam waktu dekat.
          </p>
          <a href="{{ route('home') }}" class="btn btn-primary btn-sm">Kembali ke Beranda</a>
        </div>
      @endforelse
    </div>

    <!-- Pagination -->
    @if($articles->hasPages())
      <div class="pagination-wrap">
        {{ $articles->links() }}
      </div>
    @endif

    <!-- Help Banner -->
    <div class="help-banner">
      <h3>Ingin Berbagi Cerita atau Mendiskusikan Topik di Atas?</h3>
      <p>
        Guru BK selalu siap mendengarkan cerita dan keluh kesahmu tanpa menghakimi. Semua percakapan terjamin kerahasiaannya.
      </p>
      <a href="{{ auth()->check() ? route('siswa.chat') : route('login') }}" class="btn btn-primary">
        Buka Obrolan Konseling
      </a>
    </div>

  </div>
</section>
@endsection
