@extends('layouts.tailadmin')

@section('title', 'Manajemen Artikel BK — SAPA BK')

@section('content')
<div class="space-y-6">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
        Artikel & Edukasi Bimbingan
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
        Kelola artikel panduan belajar, kesehatan mental remaja, tips lolos PTN, dan info studi lanjut SMAN 4 Jember.
      </p>
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

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    
    <!-- Left Column (5 cols): Sync RSS & Manual Write Form -->
    <div class="lg:col-span-5 space-y-6 self-start">

      <!-- Sync RSS Feed Card -->
      <div class="rounded-3xl bg-gradient-to-br from-brand-50/60 via-white to-emerald-50/40 dark:from-gray-900 dark:via-gray-900 dark:to-brand-950/20 p-6 sm:p-7 border border-brand-200/70 dark:border-brand-900/60 shadow-xs space-y-4">
        <div class="flex items-start justify-between gap-3">
          <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-brand-100 text-brand-800 dark:bg-brand-950 dark:text-brand-300 border border-brand-300 dark:border-brand-800 mb-2">
              <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 5c7.18 0 13 5.82 13 13M6 11a7 7 0 017 7m-6 0a1 1 0 11-2 0 1 1 0 012 0z" /></svg>
              <span>Sindikasi RSS Feed Otomatis</span>
            </div>
            <h2 class="text-base font-bold text-gray-900 dark:text-white">Tarik Artikel Terkini</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
              Ambil artikel dan tips terpercaya dari portal publik (Detik Edu, Kompas, Kemenkes) secara gratis tanpa batas kuota.
            </p>
          </div>
        </div>

        <div class="space-y-2.5 pt-1">
          <!-- Tombol Tarik Tips PTN -->
          <form method="POST" action="{{ route('bk.artikel.sync-rss') }}">
            @csrf
            <input type="hidden" name="category" value="tips_ptn">
            <button
              type="submit"
              class="w-full flex items-center justify-between px-4 py-3 rounded-2xl bg-white dark:bg-gray-800 hover:bg-brand-50 dark:hover:bg-gray-700/80 border border-gray-200/80 dark:border-gray-700 text-gray-800 dark:text-gray-100 text-xs font-bold transition-all shadow-xs group"
            >
              <div class="flex items-center gap-3">
                <span class="h-8 w-8 rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400 flex items-center justify-center shrink-0">
                  <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /></svg>
                </span>
                <div class="text-left">
                  <div class="font-bold text-gray-900 dark:text-white">Tips Lolos PTN & SNBP</div>
                  <div class="text-[10px] text-gray-400 font-normal">Kiat jurusan, strategi nilai & UTBK</div>
                </div>
              </div>
              <span class="text-brand-600 dark:text-brand-400 font-bold group-hover:translate-x-0.5 transition-transform">&plus; Tarik</span>
            </button>
          </form>

          <!-- Tombol Tarik Kesehatan Mental -->
          <form method="POST" action="{{ route('bk.artikel.sync-rss') }}">
            @csrf
            <input type="hidden" name="category" value="kesehatan_mental">
            <button
              type="submit"
              class="w-full flex items-center justify-between px-4 py-3 rounded-2xl bg-white dark:bg-gray-800 hover:bg-brand-50 dark:hover:bg-gray-700/80 border border-gray-200/80 dark:border-gray-700 text-gray-800 dark:text-gray-100 text-xs font-bold transition-all shadow-xs group"
            >
              <div class="flex items-center gap-3">
                <span class="h-8 w-8 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-400 flex items-center justify-center shrink-0">
                  <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                </span>
                <div class="text-left">
                  <div class="font-bold text-gray-900 dark:text-white">Kesehatan Mental Remaja</div>
                  <div class="text-[10px] text-gray-400 font-normal">Manajemen stres, motivasi & emosi</div>
                </div>
              </div>
              <span class="text-brand-600 dark:text-brand-400 font-bold group-hover:translate-x-0.5 transition-transform">&plus; Tarik</span>
            </button>
          </form>

          <!-- Tombol Tarik Keduanya -->
          <form method="POST" action="{{ route('bk.artikel.sync-rss') }}">
            @csrf
            <input type="hidden" name="category" value="all">
            <button
              type="submit"
              class="w-full py-2.5 px-4 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-sm transition-all flex items-center justify-center gap-2"
            >
              <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
              <span>Tarik Semua Kategori Sekaligus</span>
            </button>
          </form>
        </div>
      </div>

      <!-- Write Article Form (Manual) -->
      <div class="rounded-3xl bg-white dark:bg-gray-900 p-6 sm:p-7 border border-gray-100 dark:border-gray-800 shadow-xs space-y-4">
        <div>
          <h2 class="text-base font-bold text-gray-900 dark:text-white">Tulis Artikel Mandiri</h2>
          <p class="text-xs text-gray-400">Tulis panduan atau pengumuman resmi konseling SMAN 4 Jember.</p>
        </div>

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
              <option value="tips_ptn">Tips Masuk PTN & SNBP</option>
              <option value="kesehatan_mental">Kesehatan Mental & Psikologi</option>
              <option value="umum" selected>Edukasi & Konseling Umum</option>
            </select>
          </div>

          <div>
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Isi / Konten Artikel *</label>
            <textarea
              name="content"
              rows="5"
              required
              placeholder="Tulis uraian materi edukasi bimbingan konseling di sini..."
              class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
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

          <button
            type="submit"
            class="w-full py-3 px-4 rounded-xl bg-gray-900 hover:bg-black dark:bg-brand-500 dark:hover:bg-brand-600 text-white font-bold text-xs shadow-md transition-all"
          >
            Terbitkan Artikel Sekarang
          </button>
        </form>
      </div>

    </div>

    <!-- Article Table List (7 cols) -->
    <div class="lg:col-span-7 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs overflow-hidden self-start">
      <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
        <div>
          <h2 class="text-base font-bold text-gray-900 dark:text-white">Daftar Artikel BK</h2>
          <p class="text-xs text-gray-400">Total: {{ $articles->total() }} Artikel Tersimpan</p>
        </div>
      </div>

      <div class="divide-y divide-gray-100 dark:divide-gray-800">
        @forelse($articles as $art)
          <div class="p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
            <div class="flex items-start gap-3.5 min-w-0 flex-1">
              @if($art->thumbnail)
                <div class="h-16 w-20 sm:h-20 sm:w-28 rounded-2xl overflow-hidden bg-gray-100 dark:bg-gray-800 shrink-0 border border-gray-200/60 dark:border-gray-700 shadow-xs">
                  <img src="{{ Str::startsWith($art->thumbnail, ['http://', 'https://']) ? $art->thumbnail : asset($art->thumbnail) }}" alt="{{ $art->title }}" class="h-full w-full object-cover">
                </div>
              @endif
              <div class="space-y-1.5 min-w-0 flex-1">
                <div class="flex items-center gap-2 flex-wrap">
                  <!-- Category Badge -->
                  @if($art->category === 'tips_ptn')
                    <span class="text-[10px] px-2 py-0.5 rounded-full font-bold bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                      Tips PTN
                    </span>
                  @elseif($art->category === 'kesehatan_mental')
                    <span class="text-[10px] px-2 py-0.5 rounded-full font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                      Kesehatan Mental
                    </span>
                  @else
                    <span class="text-[10px] px-2 py-0.5 rounded-full font-bold bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                      Edukasi BK
                    </span>
                  @endif

                  <span class="text-[10px] px-2 py-0.5 rounded-full font-bold {{ $art->is_published ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300' : 'bg-gray-100 text-gray-600' }}">
                    {{ $art->is_published ? 'Terbit' : 'Draf' }}
                  </span>

                  @if($art->source_name)
                    <span class="text-[10px] px-2 py-0.5 rounded-full font-medium bg-amber-50 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-200/80 dark:border-amber-800/60">
                      RSS: {{ $art->source_name }}
                    </span>
                  @endif
                </div>

                <h3 class="text-sm font-bold text-gray-900 dark:text-white line-clamp-2 leading-snug">
                  {{ $art->title }}
                </h3>

                <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">
                  {{ Str::limit(strip_tags($art->content), 120) }}
                </p>

                <span class="text-[11px] text-gray-400 block pt-0.5">
                  {{ $art->source_name ? 'Sumber: ' . $art->source_name : 'Oleh ' . ($art->author?->name ?? 'Guru BK') }} • {{ $art->created_at ? $art->created_at->format('d M Y') : '-' }}
                </span>
              </div>
            </div>

            <div class="flex items-center gap-2 shrink-0 self-end sm:self-center">
              <a
                href="{{ route('article.detail', $art->slug) }}"
                target="_blank"
                class="px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-semibold transition-colors inline-flex items-center gap-1"
              >
                <span>Lihat</span>
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
              </a>
              <form method="POST" action="{{ route('bk.artikel.destroy', $art->id) }}" onsubmit="return confirm('Hapus artikel ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" title="Hapus artikel" class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/50 transition-colors">
                  <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </button>
              </form>
            </div>
          </div>
        @empty
          <div class="p-12 text-center text-gray-400 text-xs space-y-2">
            <svg class="h-8 w-8 mx-auto text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
            <div>Belum ada artikel yang tersimpan.</div>
            <div class="text-[11px] text-gray-400">Gunakan tombol <strong>Tarik Artikel Terkini</strong> di sebelah kiri untuk mengisi konten otomatis dari RSS.</div>
          </div>
        @endforelse
      </div>

      @if($articles->hasPages())
        <div class="p-6 border-t border-gray-100 dark:border-gray-800">
          {{ $articles->links() }}
        </div>
      @endif
    </div>

  </div>

</div>
@endsection
