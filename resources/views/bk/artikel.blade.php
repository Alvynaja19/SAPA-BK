@extends('layouts.tailadmin')

@section('title', 'Manajemen Artikel BK : SAPA BK')

@section('content')
<div class="space-y-6" x-data="{ modalTambah: false, modalSync: false }" @keydown.escape.window="modalTambah = false; modalSync = false">

  <!-- Page Header & Action Buttons -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
        Artikel &amp; Edukasi Bimbingan
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
        Kelola artikel panduan belajar, kesehatan mental remaja, tips lolos PTN, dan info studi lanjut SMAN 4 Jember.
      </p>
    </div>

    <!-- Action Buttons -->
    <div class="flex items-center gap-2.5 flex-wrap self-start sm:self-auto">
      <!-- Tombol Buka Modal Tarik RSS -->
      <button
        type="button"
        @click="modalSync = true"
        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-brand-300 dark:border-brand-700/80 bg-brand-50/80 hover:bg-brand-100 text-brand-800 dark:bg-brand-950/60 dark:text-brand-300 dark:hover:bg-brand-900/60 font-bold text-xs transition-all shadow-xs cursor-pointer min-h-[44px]"
      >
        <svg class="h-4 w-4 text-brand-600 dark:text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 5c7.18 0 13 5.82 13 13M6 11a7 7 0 017 7m-6 0a1 1 0 11-2 0 1 1 0 012 0z" />
        </svg>
        <span>Tarik Artikel Terkini (RSS)</span>
      </button>

      <!-- Tombol Buka Modal Tulis Artikel -->
      <button
        type="button"
        @click="modalTambah = true"
        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-md shadow-brand-500/20 transition-all cursor-pointer min-h-[44px]"
      >
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        <span>Tulis Artikel Baru</span>
      </button>
    </div>
  </div>

  <!-- Flash Notifications -->
  @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800/60 shadow-xs flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="h-8 w-8 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
        </div>
        <p class="text-xs sm:text-sm font-semibold">{{ session('success') }}</p>
      </div>
    </div>
  @endif

  @if(session('info'))
    <div class="p-4 rounded-2xl bg-blue-50 text-blue-800 border border-blue-200 dark:bg-blue-950/40 dark:text-blue-300 dark:border-blue-800/60 shadow-xs flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="h-8 w-8 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <p class="text-xs sm:text-sm font-semibold">{{ session('info') }}</p>
      </div>
    </div>
  @endif

  <!-- Main Table Card: Daftar Artikel BK -->
  <div class="rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs overflow-hidden">
    <div class="p-5 sm:p-6 border-b border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-gray-50/40 dark:bg-gray-800/20">
      <div>
        <h2 class="text-base font-bold text-gray-900 dark:text-white">Daftar Artikel &amp; Publikasi Edukasi</h2>
        <p class="text-xs text-gray-400 mt-0.5">Seluruh artikel yang tampil di katalog publik dan beranda siswa.</p>
      </div>
      <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-brand-50 text-brand-700 dark:bg-brand-950/60 dark:text-brand-300 border border-brand-200 dark:border-brand-800 self-start sm:self-auto">
        Total: {{ $articles->total() }} Artikel Tersimpan
      </span>
    </div>

    <!-- Table Responsive -->
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="border-b border-gray-100 dark:border-gray-800 text-[11px] font-bold text-gray-400 dark:text-gray-400 uppercase tracking-wider bg-gray-50/50 dark:bg-gray-800/30">
            <th class="py-4 px-6">Artikel &amp; Konten</th>
            <th class="py-4 px-6">Kategori</th>
            <th class="py-4 px-6">Sumber / Penulis</th>
            <th class="py-4 px-6">Status</th>
            <th class="py-4 px-6">Tanggal Terbit</th>
            <th class="py-4 px-6 text-right">Opsi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-xs text-gray-600 dark:text-gray-300">
          @forelse($articles as $art)
            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
              <!-- Thumbnail & Judul -->
              <td class="py-4 px-6 min-w-[280px]">
                <div class="flex items-center gap-3.5">
                  <div class="h-14 w-20 rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800 shrink-0 border border-gray-200/60 dark:border-gray-700 shadow-2xs">
                    @if($art->thumbnail)
                      <img src="{{ Str::startsWith($art->thumbnail, ['http://', 'https://']) ? $art->thumbnail : asset($art->thumbnail) }}" alt="{{ $art->title }}" class="h-full w-full object-cover">
                    @else
                      <div class="h-full w-full flex items-center justify-center bg-gray-200 dark:bg-gray-700 text-gray-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                      </div>
                    @endif
                  </div>
                  <div class="space-y-1 min-w-0 flex-1">
                    <h3 class="font-bold text-gray-900 dark:text-white line-clamp-2 leading-snug">
                      {{ $art->title }}
                    </h3>
                    <p class="text-[11px] text-gray-400 line-clamp-1 leading-normal">
                      {{ Str::limit(strip_tags($art->content), 80) }}
                    </p>
                  </div>
                </div>
              </td>

              <!-- Kategori -->
              <td class="py-4 px-6 whitespace-nowrap">
                @if($art->category === 'tips_ptn')
                  <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                    Tips Masuk PTN
                  </span>
                @elseif($art->category === 'kesehatan_mental')
                  <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                    Kesehatan Mental
                  </span>
                @else
                  <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300 border border-gray-200/60 dark:border-gray-700">
                    Edukasi Umum
                  </span>
                @endif
              </td>

              <!-- Sumber / Penulis -->
              <td class="py-4 px-6 whitespace-nowrap">
                @if($art->source_name)
                  <div>
                    <span class="font-semibold text-gray-800 dark:text-gray-200 block">{{ $art->source_name }}</span>
                    <span class="text-[10px] text-brand-600 dark:text-brand-400 font-medium">Sindikasi RSS Feed</span>
                  </div>
                @else
                  <div>
                    <span class="font-semibold text-gray-800 dark:text-gray-200 block">{{ $art->author?->name ?? 'Guru BK' }}</span>
                    <span class="text-[10px] text-gray-400 font-medium">Tim Guru BK</span>
                  </div>
                @endif
              </td>

              <!-- Status -->
              <td class="py-4 px-6 whitespace-nowrap">
                @if($art->is_published)
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    <span>Terbit</span>
                  </span>
                @else
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700">
                    <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                    <span>Draf</span>
                  </span>
                @endif
              </td>

              <!-- Tanggal Terbit -->
              <td class="py-4 px-6 whitespace-nowrap text-gray-500 dark:text-gray-400 text-[11px]">
                {{ $art->created_at ? $art->created_at->format('d M Y') : '-' }}
              </td>

              <!-- Opsi -->
              <td class="py-4 px-6 text-right whitespace-nowrap">
                <div class="inline-flex items-center gap-1.5 justify-end">
                  <a
                    href="{{ route('article.detail', $art->slug) }}"
                    target="_blank"
                    class="px-3 py-1.5 rounded-xl bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold transition-colors inline-flex items-center gap-1 min-h-[36px]"
                  >
                    <span>Lihat</span>
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                  </a>
                  <form method="POST" action="{{ route('bk.artikel.destroy', $art->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                    @csrf
                    @method('DELETE')
                    <button
                      type="submit"
                      title="Hapus artikel"
                      class="p-2 rounded-xl text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/50 transition-colors cursor-pointer min-h-[36px] min-w-[36px] inline-flex items-center justify-center"
                    >
                      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="p-12 text-center text-gray-400 text-xs">
                <div class="space-y-3 max-w-sm mx-auto">
                  <div class="h-12 w-12 rounded-2xl bg-gray-100 dark:bg-gray-800 text-gray-400 mx-auto flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                  </div>
                  <div class="font-bold text-gray-700 dark:text-gray-300">Belum ada artikel yang tersimpan</div>
                  <p class="text-[11px] text-gray-400 leading-relaxed">
                    Klik tombol <strong>Tarik Artikel Terkini (RSS)</strong> di pojok kanan atas untuk menarik artikel edukasi otomatis atau klik <strong>Tulis Artikel Baru</strong>.
                  </p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($articles->hasPages())
      <div class="p-6 border-t border-gray-100 dark:border-gray-800">
        {{ $articles->links() }}
      </div>
    @endif
  </div>

  <!-- MODAL 1: Tarik Artikel Terkini (RSS Feed) -->
  <div
    x-show="modalSync"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-xs flex items-center justify-center p-4"
    style="display: none;"
  >
    <div
      @click.outside="modalSync = false"
      class="w-full max-w-lg rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-2xl p-6 sm:p-8 space-y-5"
    >
      <!-- Modal Header -->
      <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
        <div>
          <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-brand-100 text-brand-800 dark:bg-brand-950 dark:text-brand-300 border border-brand-300 dark:border-brand-800 mb-1.5">
            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 5c7.18 0 13 5.82 13 13M6 11a7 7 0 017 7m-6 0a1 1 0 11-2 0 1 1 0 012 0z" /></svg>
            <span>Sindikasi Feed Otomatis</span>
          </div>
          <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tarik Artikel Terkini (RSS)</h3>
          <p class="text-xs text-gray-400 mt-0.5">Ambil artikel berkualitas dari portal publik resmi tanpa batasan kuota.</p>
        </div>
        <button
          type="button"
          @click="modalSync = false"
          class="h-8 w-8 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-500 hover:text-gray-800 dark:text-gray-300 flex items-center justify-center cursor-pointer transition-colors"
        >
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
      </div>

      <!-- Modal Options -->
      <div class="space-y-3">
        <!-- Opsi 1: Tips Lolos PTN -->
        <form method="POST" action="{{ route('bk.artikel.sync-rss') }}">
          @csrf
          <input type="hidden" name="category" value="tips_ptn">
          <button
            type="submit"
            class="w-full flex items-center justify-between p-4 rounded-2xl bg-gray-50 hover:bg-brand-50/60 dark:bg-gray-800/60 dark:hover:bg-gray-800 border border-gray-200/80 dark:border-gray-700 text-gray-800 dark:text-gray-100 text-xs transition-all shadow-xs group cursor-pointer"
          >
            <div class="flex items-center gap-3.5">
              <span class="h-10 w-10 rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400 flex items-center justify-center shrink-0 shadow-2xs">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /></svg>
              </span>
              <div class="text-left">
                <div class="font-bold text-gray-900 dark:text-white text-sm">Tips Lolos PTN &amp; SNBP</div>
                <div class="text-[11px] text-gray-400 font-medium">Strategi pemilihan jurusan, kiat belajar, dan persiapan UTBK</div>
              </div>
            </div>
            <span class="px-3 py-1.5 rounded-xl bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300 font-bold text-xs group-hover:bg-brand-500 group-hover:text-white transition-all shrink-0">
              Tarik &rarr;
            </span>
          </button>
        </form>

        <!-- Opsi 2: Kesehatan Mental Remaja -->
        <form method="POST" action="{{ route('bk.artikel.sync-rss') }}">
          @csrf
          <input type="hidden" name="category" value="kesehatan_mental">
          <button
            type="submit"
            class="w-full flex items-center justify-between p-4 rounded-2xl bg-gray-50 hover:bg-brand-50/60 dark:bg-gray-800/60 dark:hover:bg-gray-800 border border-gray-200/80 dark:border-gray-700 text-gray-800 dark:text-gray-100 text-xs transition-all shadow-xs group cursor-pointer"
          >
            <div class="flex items-center gap-3.5">
              <span class="h-10 w-10 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-400 flex items-center justify-center shrink-0 shadow-2xs">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
              </span>
              <div class="text-left">
                <div class="font-bold text-gray-900 dark:text-white text-sm">Kesehatan Mental Remaja</div>
                <div class="text-[11px] text-gray-400 font-medium">Kiat mengatasi stres ujian, burnout, dan regulasi emosi</div>
              </div>
            </div>
            <span class="px-3 py-1.5 rounded-xl bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 font-bold text-xs group-hover:bg-brand-500 group-hover:text-white transition-all shrink-0">
              Tarik &rarr;
            </span>
          </button>
        </form>

        <!-- Opsi 3: Tarik Semua Sekaligus -->
        <form method="POST" action="{{ route('bk.artikel.sync-rss') }}">
          @csrf
          <input type="hidden" name="category" value="all">
          <button
            type="submit"
            class="w-full py-3 px-4 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-md shadow-brand-500/20 transition-all flex items-center justify-center gap-2 cursor-pointer"
          >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
            <span>Tarik Semua Kategori Sekaligus (PTN &amp; Kesehatan Mental)</span>
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- MODAL 2: Tulis Artikel Mandiri -->
  <div
    x-show="modalTambah"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-xs flex items-center justify-center p-4"
    style="display: none;"
  >
    <div
      @click.outside="modalTambah = false"
      class="w-full max-w-xl rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-2xl p-6 sm:p-8 space-y-5"
    >
      <!-- Modal Header -->
      <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
        <div>
          <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tulis Artikel Baru</h3>
          <p class="text-xs text-gray-400 mt-0.5">Tulis panduan atau materi edukasi bimbingan resmi konseling SMAN 4 Jember.</p>
        </div>
        <button
          type="button"
          @click="modalTambah = false"
          class="h-8 w-8 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-500 hover:text-gray-800 dark:text-gray-300 flex items-center justify-center cursor-pointer transition-colors"
        >
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
      </div>

      <!-- Form Tulis Artikel -->
      <form method="POST" action="{{ route('bk.artikel.store') }}" class="space-y-4">
        @csrf

        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Judul Artikel *</label>
          <input
            type="text"
            name="title"
            required
            placeholder="Contoh: 5 Kiat Mengatasi Burnout Belajar Menjelang Ujian"
            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
          />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Kategori Artikel</label>
          <select
            name="category"
            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
          >
            <option value="tips_ptn">Tips Masuk PTN &amp; SNBP</option>
            <option value="kesehatan_mental">Kesehatan Mental &amp; Psikologi</option>
            <option value="umum" selected>Edukasi &amp; Konseling Umum</option>
          </select>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Isi / Konten Artikel *</label>
          <textarea
            name="content"
            rows="6"
            required
            placeholder="Tulis uraian materi bimbingan konseling di sini..."
            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500 leading-relaxed"
          ></textarea>
        </div>

        <div class="pt-1">
          <label class="flex items-center gap-2 cursor-pointer">
            <input
              type="checkbox"
              name="is_published"
              value="1"
              checked
              class="rounded text-brand-600 focus:ring-brand-500"
            />
            <span class="text-xs text-gray-600 dark:text-gray-300 font-medium">Langsung Terbitkan ke Publik</span>
          </label>
        </div>

        <div class="pt-2 flex items-center justify-end gap-2.5">
          <button
            type="button"
            @click="modalTambah = false"
            class="px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold text-xs transition-colors cursor-pointer"
          >
            Batal
          </button>
          <button
            type="submit"
            class="px-5 py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-md shadow-brand-500/20 transition-all cursor-pointer"
          >
            Terbitkan Artikel Sekarang
          </button>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection
