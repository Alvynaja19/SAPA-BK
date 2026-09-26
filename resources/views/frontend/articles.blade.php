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

    <!-- Filter Kategori & Pencarian Artikel (Live Search) -->
    <div class="article-filter-bar">
      <!-- Category Tabs -->
      <div id="frontendCatChips" class="article-cat-group">
        <a
          href="{{ route('article.index', array_merge(request()->except('category', 'page'), ['category' => 'all'])) }}"
          class="cat-chip {{ (!request('category') || request('category') === 'all') ? 'active' : '' }}"
        >
          <span>Semua Topik</span>
          <span class="chip-count">{{ $categoryCounts['all'] ?? 0 }}</span>
        </a>

        <a
          href="{{ route('article.index', array_merge(request()->except('category', 'page'), ['category' => 'tips_ptn'])) }}"
          class="cat-chip {{ request('category') === 'tips_ptn' ? 'active' : '' }}"
        >
          <span>Tips Masuk PTN</span>
          <span class="chip-count">{{ $categoryCounts['tips_ptn'] ?? 0 }}</span>
        </a>

        <a
          href="{{ route('article.index', array_merge(request()->except('category', 'page'), ['category' => 'kesehatan_mental'])) }}"
          class="cat-chip {{ request('category') === 'kesehatan_mental' ? 'active' : '' }}"
        >
          <span>Kesehatan Mental</span>
          <span class="chip-count">{{ $categoryCounts['kesehatan_mental'] ?? 0 }}</span>
        </a>

        <a
          href="{{ route('article.index', array_merge(request()->except('category', 'page'), ['category' => 'umum'])) }}"
          class="cat-chip {{ request('category') === 'umum' ? 'active' : '' }}"
        >
          <span>Edukasi Umum</span>
          <span class="chip-count">{{ $categoryCounts['umum'] ?? 0 }}</span>
        </a>
      </div>

      <!-- Search Box (Live Instant Search) -->
      <form id="frontendArticleSearchForm" method="GET" action="{{ route('article.index') }}" class="article-search-box">
        @if(request('category') && request('category') !== 'all')
          <input type="hidden" name="category" value="{{ request('category') }}">
        @endif
        <div class="article-search-input-wrap" style="position: relative;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--ink-faint); flex-shrink: 0;">
            <circle cx="11" cy="11" r="8"/>
            <path d="m21 21-4.3-4.3"/>
          </svg>
          <input
            type="text"
            id="frontendArticleSearchInput"
            name="q"
            value="{{ request('q') }}"
            placeholder="Cari artikel..."
            autocomplete="off"
            class="article-search-input"
            style="padding-right: 48px;"
          />
          <div style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); display: flex; align-items: center; gap: 6px;">
            <!-- Spinner Indikator Loading Live Search -->
            <div id="frontendArticleSearchSpinner" style="display: none;">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="animation: spin 1s linear infinite; color: var(--primary);">
                <circle cx="12" cy="12" r="10" stroke-opacity="0.25"/>
                <path d="M12 2a10 10 0 0 1 10 10"/>
              </svg>
            </div>
            <!-- Tombol Hapus Kata Kunci -->
            <button
              type="button"
              id="frontendArticleSearchClearBtn"
              style="{{ request('q') ? 'display: flex;' : 'display: none;' }} align-items: center; justify-content: center; background: none; border: none; cursor: pointer; color: var(--ink-faint); padding: 4px;"
              title="Hapus kata kunci"
              aria-label="Hapus kata kunci pencarian"
            >
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
              </svg>
            </button>
          </div>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Cari</button>
      </form>
    </div>

    <!-- Container Hasil Pencarian & Artikel -->
    <div id="frontendArticlesContainer" style="transition: opacity 0.15s ease;">
      @if(request()->filled('q'))
        <div class="active-filter-badge">
          <span>Menampilkan hasil pencarian untuk: <strong>"{{ request('q') }}"</strong></span>
          <a href="{{ route('article.index', array_merge(request()->except('q', 'page'))) }}" style="color: var(--red); font-weight: 700; margin-left: 6px;" title="Hapus pencarian">&times;</a>
        </div>
      @endif

      <!-- Articles Grid -->
      <div class="article-row">
        @forelse($articles as $art)
          <article class="article-card">
            <div class="article-thumb" aria-hidden="true">
              @if($art->thumbnail)
                <img src="{{ Str::startsWith($art->thumbnail, ['http://', 'https://']) ? $art->thumbnail : asset($art->thumbnail) }}" alt="{{ $art->title }}" style="width: 100%; height: 100%; object-fit: cover;">
              @else
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
                  <path d="M6 6h10M6 10h10"/>
                </svg>
              @endif
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
            <h3 style="font-size: 19px; margin-bottom: 8px;">Belum Ada Artikel yang Sesuai</h3>
            <p style="color: var(--ink-soft); font-size: 14.5px; max-width: 440px; margin: 0 auto 20px;">
              Tidak ditemukan artikel pada kategori atau kata kunci ini. Silakan coba cari dengan kata kunci lain.
            </p>
            <a href="{{ route('article.index') }}" class="btn btn-primary btn-sm">Lihat Semua Artikel</a>
          </div>
        @endforelse
      </div>

      <!-- Pagination -->
      @if($articles->hasPages())
        <div class="pagination-wrap">
          {{ $articles->links('pagination.landing') }}
        </div>
      @endif
    </div>

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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('frontendArticleSearchForm');
  const searchInput = document.getElementById('frontendArticleSearchInput');
  const clearBtn = document.getElementById('frontendArticleSearchClearBtn');
  const spinner = document.getElementById('frontendArticleSearchSpinner');
  const container = document.getElementById('frontendArticlesContainer');
  const catChips = document.getElementById('frontendCatChips');

  let debounceTimer = null;
  let abortController = null;

  function doFetch(url) {
    if (abortController) {
      abortController.abort();
    }
    abortController = new AbortController();

    if (spinner) spinner.style.display = 'block';
    if (container) {
      container.style.opacity = '0.5';
      container.style.pointerEvents = 'none';
      container.setAttribute('aria-busy', 'true');
    }

    fetch(url, {
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
      signal: abortController.signal
    })
      .then(res => {
        if (!res.ok) throw new Error('Network error');
        return res.text();
      })
      .then(html => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');

        const newContainer = doc.getElementById('frontendArticlesContainer');
        if (newContainer && container) {
          container.innerHTML = newContainer.innerHTML;
        }

        const newCatChips = doc.getElementById('frontendCatChips');
        if (newCatChips && catChips) {
          catChips.innerHTML = newCatChips.innerHTML;
        }

        window.history.replaceState(null, '', url);
      })
      .catch(err => {
        if (err.name !== 'AbortError') {
          console.error('Frontend articles search error:', err);
        }
      })
      .finally(() => {
        if (spinner) spinner.style.display = 'none';
        if (container) {
          container.style.opacity = '1';
          container.style.pointerEvents = 'auto';
          container.removeAttribute('aria-busy');
        }
      });
  }

  function triggerSearch(immediate = false) {
    clearTimeout(debounceTimer);
    const delay = immediate ? 0 : 280;

    debounceTimer = setTimeout(() => {
      const formData = new FormData(form);
      const params = new URLSearchParams();

      for (const [key, value] of formData.entries()) {
        if (value && value.trim() !== '') {
          params.set(key, value.trim());
        }
      }

      const action = form.getAttribute('action') || window.location.pathname;
      const queryString = params.toString();
      const targetUrl = queryString ? `${action}?${queryString}` : action;

      doFetch(targetUrl);
    }, delay);
  }

  if (searchInput) {
    searchInput.addEventListener('input', function () {
      if (clearBtn) {
        if (this.value.trim().length > 0) {
          clearBtn.style.display = 'flex';
        } else {
          clearBtn.style.display = 'none';
        }
      }
      triggerSearch(false);
    });

    searchInput.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        triggerSearch(true);
      }
    });
  }

  if (clearBtn) {
    clearBtn.addEventListener('click', function () {
      if (searchInput) {
        searchInput.value = '';
        this.style.display = 'none';
        searchInput.focus();
        triggerSearch(true);
      }
    });
  }

  if (form) {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      triggerSearch(true);
    });
  }

  // Intercept category chip clicks
  if (catChips) {
    catChips.addEventListener('click', (e) => {
      const chip = e.target.closest('a.cat-chip');
      if (chip && chip.href) {
        e.preventDefault();
        const url = new URL(chip.href, window.location.origin);
        const catVal = url.searchParams.get('category') || '';
        let hiddenCat = form.querySelector('input[name="category"]');
        if (catVal && catVal !== 'all') {
          if (!hiddenCat) {
            hiddenCat = document.createElement('input');
            hiddenCat.type = 'hidden';
            hiddenCat.name = 'category';
            form.appendChild(hiddenCat);
          }
          hiddenCat.value = catVal;
        } else if (hiddenCat) {
          hiddenCat.remove();
        }
        doFetch(chip.href);
      }
    });
  }

  // Intercept pagination clicks
  if (container) {
    container.addEventListener('click', (e) => {
      const pageLink = e.target.closest('a.page-link, .pagination-wrap a');
      if (pageLink && pageLink.href) {
        e.preventDefault();
        doFetch(pageLink.href);
        window.scrollTo({ top: container.offsetTop - 80, behavior: 'smooth' });
      }
    });
  }
});
</script>
@endpush
