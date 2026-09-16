@if ($paginator->hasPages())
  <nav class="pagination-container" role="navigation" aria-label="Navigasi Halaman Artikel">
    <!-- Info Ringkasan Jumlah Artikel & Halaman Aktif -->
    <div class="pagination-summary">
      <span>Menampilkan</span>
      <span class="pagination-highlight">{{ $paginator->firstItem() }} &ndash; {{ $paginator->lastItem() }}</span>
      <span>dari</span>
      <span class="pagination-highlight">{{ $paginator->total() }}</span>
      <span>artikel (Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }})</span>
    </div>

    <!-- Tombol Navigasi Halaman -->
    <div class="pagination-controls">
      {{-- Tombol Halaman Sebelumnya --}}
      @if ($paginator->onFirstPage())
        <span class="page-btn page-nav page-disabled" aria-disabled="true">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6"/>
          </svg>
          <span>Sebelumnya</span>
        </span>
      @else
        <a href="{{ $paginator->previousPageUrl() }}" class="page-btn page-nav" rel="prev" aria-label="Halaman sebelumnya">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6"/>
          </svg>
          <span>Sebelumnya</span>
        </a>
      @endif

      {{-- Deretan Nomor Halaman --}}
      <div class="page-numbers-group">
        @foreach ($elements as $element)
          {{-- Pemisah Tiga Titik (...) --}}
          @if (is_string($element))
            <span class="page-ellipsis" aria-hidden="true">&hellip;</span>
          @endif

          {{-- Array Tautan Nomor Halaman --}}
          @if (is_array($element))
            @foreach ($element as $page => $url)
              @if ($page == $paginator->currentPage())
                <span class="page-btn page-num page-active" aria-current="page" title="Sedang di Halaman {{ $page }}">
                  {{ $page }}
                </span>
              @else
                <a href="{{ $url }}" class="page-btn page-num" title="Buka Halaman {{ $page }}">
                  {{ $page }}
                </a>
              @endif
            @endforeach
          @endif
        @endforeach
      </div>

      {{-- Tombol Halaman Selanjutnya --}}
      @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="page-btn page-nav" rel="next" aria-label="Halaman selanjutnya">
          <span>Selanjutnya</span>
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m9 18 6-6-6-6"/>
          </svg>
        </a>
      @else
        <span class="page-btn page-nav page-disabled" aria-disabled="true">
          <span>Selanjutnya</span>
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m9 18 6-6-6-6"/>
          </svg>
        </span>
      @endif
    </div>
  </nav>
@endif
