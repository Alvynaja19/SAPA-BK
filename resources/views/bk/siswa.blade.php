@extends('layouts.tailadmin')

@section('title', 'Direktori Siswa : SAPA BK')

@section('content')
<div class="space-y-6">

  <!-- Page Header & Live Search Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
        Direktori Siswa Bimbingan
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
        Daftar peserta didik SMA Negeri 4 Jember yang terdaftar pada sistem konseling digital SAPA BK.
      </p>
    </div>

    <!-- Live Search Box (Instant Search-as-you-type) -->
    <form id="siswaSearchForm" method="GET" action="{{ route('bk.siswa') }}" class="w-full sm:w-80">
      <div class="relative flex items-center rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3.5 py-2 shadow-2xs focus-within:border-brand-500 focus-within:ring-2 focus-within:ring-brand-500/20 transition-all min-h-[44px]">
        <svg class="h-4 w-4 text-gray-400 shrink-0 mr-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input
          type="text"
          id="siswaSearchInput"
          name="q"
          value="{{ request('q') }}"
          placeholder="Cari nama, NISN, atau kelas..."
          autocomplete="off"
          class="w-full bg-transparent border-0 p-0 text-xs sm:text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:outline-hidden focus:ring-0 pr-7"
          style="outline: none; border: none; background: transparent;"
        />
        <div class="absolute inset-y-0 right-0 pr-3 flex items-center gap-1">
          <!-- Spinner Loading -->
          <div id="siswaSearchSpinner" class="hidden text-brand-600 animate-spin" title="Mencari siswa...">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
          </div>
          <!-- Clear Button -->
          <button
            type="button"
            id="siswaSearchClearBtn"
            class="{{ request('q') ? '' : 'hidden' }} text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 cursor-pointer p-1"
            title="Hapus kata kunci"
            aria-label="Hapus kata kunci pencarian"
          >
            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </form>
  </div>

  <!-- Siswa Table Card (TailAdmin Layout) -->
  <div id="siswaTableCard" class="rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs overflow-hidden transition-opacity duration-150">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="border-b border-gray-100 dark:border-gray-800 text-[11px] font-bold text-gray-400 dark:text-gray-400 uppercase tracking-wider bg-gray-50/50 dark:bg-gray-800/30">
            <th class="py-4 px-6">Nama & Email Siswa</th>
            <th class="py-4 px-6">NISN</th>
            <th class="py-4 px-6">Rombongan Belajar (Kelas)</th>
            <th class="py-4 px-6">Kontak WhatsApp</th>
            <th class="py-4 px-6">Status</th>
            <th class="py-4 px-6 text-right">Opsi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-xs text-gray-600 dark:text-gray-300">
          @forelse($siswa as $s)
            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
              <td class="py-4 px-6 font-medium text-gray-900 dark:text-white">
                <div class="flex items-center gap-3">
                  <div class="h-9 w-9 rounded-xl bg-gradient-to-tr from-[#205A26] to-[#2E7D34] text-white font-bold flex items-center justify-center text-xs shrink-0 shadow-xs">
                    {{ strtoupper(substr($s->name, 0, 2)) }}
                  </div>
                  <div>
                    <span class="font-bold block">{{ $s->name }}</span>
                    <span class="text-[11px] text-gray-400 block">{{ $s->email }}</span>
                  </div>
                </div>
              </td>
              <td class="py-4 px-6 font-semibold text-gray-700 dark:text-gray-300">
                {{ $s->nisn ?? '-' }}
              </td>
              <td class="py-4 px-6">
                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-bold bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200">
                  {{ $s->kelas ?? '-' }}
                </span>
              </td>
              <td class="py-4 px-6">
                {{ $s->no_hp ?? '-' }}
              </td>
              <td class="py-4 px-6">
                @if($s->is_active)
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Aktif
                  </span>
                @else
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300 border border-rose-200 dark:border-rose-800">
                    <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Nonaktif
                  </span>
                @endif
              </td>
              <td class="py-4 px-6 text-right">
                <a
                  href="{{ route('bk.live-chat') }}"
                  class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-brand-50 hover:bg-brand-100 text-brand-700 dark:bg-brand-950/60 dark:text-brand-300 dark:hover:bg-brand-900/60 text-xs font-bold transition-colors"
                >
                  <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                  <span>Konseling Live</span>
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="py-12 text-center text-gray-400 text-xs">
                @if(request('q'))
                  Tidak ditemukan siswa dengan kata kunci "{{ request('q') }}".
                @else
                  Belum ada siswa terdaftar.
                @endif
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($siswa->hasPages())
      <div id="siswaPagination" class="p-6 border-t border-gray-100 dark:border-gray-800">
        {{ $siswa->links() }}
      </div>
    @endif
  </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('siswaSearchForm');
  const searchInput = document.getElementById('siswaSearchInput');
  const clearBtn = document.getElementById('siswaSearchClearBtn');
  const spinner = document.getElementById('siswaSearchSpinner');
  const card = document.getElementById('siswaTableCard');

  let debounceTimer = null;
  let abortController = null;

  function doFetch(url) {
    if (abortController) {
      abortController.abort();
    }
    abortController = new AbortController();

    if (spinner) spinner.classList.remove('hidden');
    if (card) {
      card.classList.add('opacity-50', 'pointer-events-none');
      card.setAttribute('aria-busy', 'true');
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

        const newCard = doc.getElementById('siswaTableCard');
        if (newCard && card) {
          card.innerHTML = newCard.innerHTML;
        }

        window.history.replaceState(null, '', url);
      })
      .catch(err => {
        if (err.name !== 'AbortError') {
          console.error('Siswa search error:', err);
        }
      })
      .finally(() => {
        if (spinner) spinner.classList.add('hidden');
        if (card) {
          card.classList.remove('opacity-50', 'pointer-events-none');
          card.removeAttribute('aria-busy');
        }
      });
  }

  function triggerSearch(immediate = false) {
    clearTimeout(debounceTimer);
    const delay = immediate ? 0 : 280;

    debounceTimer = setTimeout(() => {
      const q = searchInput ? searchInput.value.trim() : '';
      const action = form.getAttribute('action') || window.location.pathname;
      const targetUrl = q ? `${action}?q=${encodeURIComponent(q)}` : action;

      doFetch(targetUrl);
    }, delay);
  }

  if (searchInput) {
    searchInput.addEventListener('input', function () {
      if (clearBtn) {
        if (this.value.trim().length > 0) {
          clearBtn.classList.remove('hidden');
        } else {
          clearBtn.classList.add('hidden');
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
        this.classList.add('hidden');
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

  if (card) {
    card.addEventListener('click', (e) => {
      const pageLink = e.target.closest('a.page-link, .pagination a');
      if (pageLink && pageLink.href) {
        e.preventDefault();
        doFetch(pageLink.href);
        window.scrollTo({ top: card.offsetTop - 80, behavior: 'smooth' });
      }
    });
  }
});
</script>
@endpush
