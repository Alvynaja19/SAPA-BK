@extends('layouts.guest')

@section('title', $article->title . ' : SAPA BK SMAN 4 Jember')

@section('content')
<section class="page-section">
  <div class="wrap" style="max-width: 860px;">
    
    <!-- Back Button -->
    <div style="margin-bottom: 28px;">
      <a href="{{ route('article.index') }}" class="btn btn-ghost btn-sm" style="display: inline-flex; align-items: center; gap: 8px;">
        &larr; Kembali ke Daftar Artikel
      </a>
    </div>

    <!-- Article Reader Surface -->
    <article style="background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius-l); padding: clamp(24px, 5vw, 56px); box-shadow: var(--shadow-card);">
      
      <!-- Article Header -->
      <header style="border-bottom: 1px solid var(--line); padding-bottom: 28px; margin-bottom: 32px;">
        <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap; margin-bottom: 14px;">
          <div class="badge-pill" style="margin-bottom: 0;">
            @if($article->category === 'tips_ptn')
              Tips Masuk PTN &amp; SNBP
            @elseif($article->category === 'kesehatan_mental')
              Kesehatan Mental Remaja
            @else
              Artikel Edukasi
            @endif
          </div>
          <span style="font-size: 13px; color: var(--ink-faint);">
            Dipublikasikan: {{ $article->created_at ? $article->created_at->format('d F Y') : '-' }}
          </span>
          <span style="font-size: 13px; color: var(--ink-faint);">&bull;</span>
          <span style="font-size: 13px; color: var(--ink-faint);">
            {{ $article->source_name ? 'Sumber: ' . $article->source_name : 'Penulis: Tim Guru BK SMAN 4 Jember' }}
          </span>
        </div>

        <h1 style="font-size: clamp(26px, 4vw, 40px); line-height: 1.28; margin-top: 8px;">
          {{ $article->title }}
        </h1>
      </header>

      @if($article->thumbnail)
        <div style="margin-bottom: 32px; border-radius: var(--radius-m); overflow: hidden; max-height: 420px; box-shadow: var(--shadow-sm);">
          <img src="{{ Str::startsWith($article->thumbnail, ['http://', 'https://']) ? $article->thumbnail : asset($article->thumbnail) }}" alt="{{ $article->title }}" style="width: 100%; height: 100%; max-height: 420px; object-fit: cover;">
        </div>
      @endif

      <!-- Article Body -->
      <div class="article-content" style="font-size: 16.5px; line-height: 1.8; color: var(--ink-soft);">
        {!! $article->content !!}
      </div>

      @if($article->source_url)
        <div style="margin-top: 32px; padding: 20px; border-radius: var(--radius-m); background: var(--bg-alt); border: 1px solid var(--line); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
          <div>
            <div style="font-weight: 700; font-size: 14px; color: var(--ink);">Rujukan Publikasi Resmi</div>
            <div style="font-size: 13px; color: var(--ink-soft); margin-top: 4px;">
              Artikel ini disindikasikan dari <strong>{{ $article->source_name ?? 'Media Mitra' }}</strong>. Anda dapat membaca ulasan lengkap dari sumber aslinya.
            </div>
          </div>
          <a href="{{ $article->source_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm" style="white-space: nowrap; display: inline-flex; align-items: center; gap: 6px;">
            <span>Buka Sumber Asli</span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
          </a>
        </div>
      @endif

      <!-- Author Box & Call-to-Action -->
      <footer style="margin-top: 48px; padding-top: 28px; border-top: 1px solid var(--line); background: transparent; color: inherit; padding-left: 0; padding-right: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
          <div style="display: flex; align-items: center; gap: 14px;">
            <div style="width: 46px; height: 46px; border-radius: 12px; background: var(--primary); color: #FFFFFF; display: flex; align-items: center; justify-content: center; font-weight: 700; font-family: 'Fraunces', serif;">
              BK
            </div>
            <div>
              <div style="font-weight: 600; font-size: 15px; color: var(--ink);">Tim Bimbingan &amp; Konseling</div>
              <div style="font-size: 12.5px; color: var(--ink-faint);">SMA Negeri 4 Jember</div>
            </div>
          </div>

          <a href="{{ auth()->check() ? route('siswa.chat') : route('login') }}" class="btn btn-primary btn-sm">
            Konsultasikan Topik Ini &rarr;
          </a>
        </div>
      </footer>

    </article>

    <!-- Recent Articles -->
    @if(isset($recentArticles) && $recentArticles->isNotEmpty())
      <div style="margin-top: 56px;">
        <h3 style="font-size: 22px; margin-bottom: 24px;">Artikel Edukatif Lainnya</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
          @foreach($recentArticles as $rec)
            <div style="background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius-m); padding: 20px; display: flex; flex-direction: column; justify-content: space-between;">
              <div>
                <span style="font-size: 12px; color: var(--ink-faint); display: block; margin-bottom: 6px;">
                  {{ $rec->created_at ? $rec->created_at->format('d M Y') : '' }}
                </span>
                <h4 style="font-size: 16px; margin-bottom: 12px; line-height: 1.4;">
                  <a href="{{ route('article.detail', $rec->slug) }}" style="color: inherit;">
                    {{ $rec->title }}
                  </a>
                </h4>
              </div>
              <a href="{{ route('article.detail', $rec->slug) }}" style="font-size: 13px; font-weight: 600; color: var(--primary); display: inline-flex; align-items: center; gap: 4px;">
                Baca artikel &rarr;
              </a>
            </div>
          @endforeach
        </div>
      </div>
    @endif

  </div>
</section>

@push('styles')
<style>
  .article-content p {
    margin-bottom: 20px;
  }
  .article-content h2, .article-content h3 {
    margin-top: 32px;
    margin-bottom: 14px;
  }
  .article-content ul, .article-content ol {
    margin-bottom: 20px;
    padding-left: 24px;
  }
  .article-content li {
    margin-bottom: 8px;
  }
  .article-content blockquote {
    margin: 24px 0;
    padding: 16px 22px;
    background: var(--bg-alt);
    border-left: 4px solid var(--primary);
    border-radius: 0 var(--radius-s) var(--radius-s) 0;
    font-style: italic;
  }
</style>
@endpush
@endsection
