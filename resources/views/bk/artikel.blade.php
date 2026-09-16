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
  <div class="rounded-3xl bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 shadow-xs overflow-hidden">
    
    <!-- Card Header: Judul & Keterangan -->
    <div class="p-5 sm:p-6 border-b border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gradient-to-b from-gray-50/60 to-white dark:from-gray-800/30 dark:to-gray-900">
      <div>
        <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white tracking-tight">
          Daftar Artikel &amp; Publikasi Edukasi
        </h2>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
          Kelola artikel bimbingan konseling, persiapan studi lanjut PTN, dan kesehatan mental siswa.
        </p>
      </div>

      <div class="flex items-center gap-2 self-start sm:self-auto shrink-0">
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-brand-50 text-brand-700 dark:bg-brand-950/60 dark:text-brand-300 border border-brand-200 dark:border-brand-800 shadow-2xs">
          <span class="h-1.5 w-1.5 rounded-full bg-brand-500"></span>
          <span>{{ $articles->total() }} Artikel Ditemukan</span>
        </span>
      </div>
    </div>

    <!-- Quick Category Tabs Navigation -->
    <div class="px-5 sm:px-6 pt-3.5 pb-3 border-b border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900">
      <div class="flex items-center gap-2 overflow-x-auto custom-scrollbar pb-1">
        <!-- Tab: Semua -->
        <a
          href="{{ route('bk.artikel', array_merge(request()->except('category', 'page'), ['category' => 'all'])) }}"
          class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 shadow-2xs"
          style="{{ (!request('category') || request('category') === 'all') ? 'background-color: #15803d !important; color: #ffffff !important;' : 'background-color: #f1f5f9; color: #334155;' }}"
        >
          <span>Semua Topik</span>
          <span class="px-1.5 py-0.5 rounded-md text-[10px] font-extrabold"
            style="{{ (!request('category') || request('category') === 'all') ? 'background-color: rgba(255,255,255,0.2) !important; color: #ffffff !important;' : 'background-color: #e2e8f0; color: #475569;' }}"
          >
            {{ $categoryCounts['all'] ?? 0 }}
          </span>
        </a>

        <!-- Tab: Tips PTN -->
        <a
          href="{{ route('bk.artikel', array_merge(request()->except('category', 'page'), ['category' => 'tips_ptn'])) }}"
          class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 shadow-2xs"
          style="{{ request('category') === 'tips_ptn' ? 'background-color: #2563eb !important; color: #ffffff !important;' : 'background-color: #f1f5f9; color: #334155;' }}"
        >
          <span class="h-2 w-2 rounded-full shrink-0" style="background-color: {{ request('category') === 'tips_ptn' ? '#ffffff' : '#2563eb' }};"></span>
          <span>Tips Masuk PTN</span>
          <span class="px-1.5 py-0.5 rounded-md text-[10px] font-extrabold"
            style="{{ request('category') === 'tips_ptn' ? 'background-color: rgba(255,255,255,0.2) !important; color: #ffffff !important;' : 'background-color: #dbeafe; color: #1e40af;' }}"
          >
            {{ $categoryCounts['tips_ptn'] ?? 0 }}
          </span>
        </a>

        <!-- Tab: Kesehatan Mental -->
        <a
          href="{{ route('bk.artikel', array_merge(request()->except('category', 'page'), ['category' => 'kesehatan_mental'])) }}"
          class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 shadow-2xs"
          style="{{ request('category') === 'kesehatan_mental' ? 'background-color: #059669 !important; color: #ffffff !important;' : 'background-color: #f1f5f9; color: #334155;' }}"
        >
          <span class="h-2 w-2 rounded-full shrink-0" style="background-color: {{ request('category') === 'kesehatan_mental' ? '#ffffff' : '#059669' }};"></span>
          <span>Kesehatan Mental</span>
          <span class="px-1.5 py-0.5 rounded-md text-[10px] font-extrabold"
            style="{{ request('category') === 'kesehatan_mental' ? 'background-color: rgba(255,255,255,0.2) !important; color: #ffffff !important;' : 'background-color: #d1fae5; color: #065f46;' }}"
          >
            {{ $categoryCounts['kesehatan_mental'] ?? 0 }}
          </span>
        </a>

        <!-- Tab: Edukasi Umum -->
        <a
          href="{{ route('bk.artikel', array_merge(request()->except('category', 'page'), ['category' => 'umum'])) }}"
          class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 shadow-2xs"
          style="{{ request('category') === 'umum' ? 'background-color: #d97706 !important; color: #ffffff !important;' : 'background-color: #f1f5f9; color: #334155;' }}"
        >
          <span class="h-2 w-2 rounded-full shrink-0" style="background-color: {{ request('category') === 'umum' ? '#ffffff' : '#d97706' }};"></span>
          <span>Edukasi Umum</span>
          <span class="px-1.5 py-0.5 rounded-md text-[10px] font-extrabold"
            style="{{ request('category') === 'umum' ? 'background-color: rgba(255,255,255,0.2) !important; color: #ffffff !important;' : 'background-color: #fef3c7; color: #92400e;' }}"
          >
            {{ $categoryCounts['umum'] ?? 0 }}
          </span>
        </a>
      </div>
    </div>

    <!-- Search & Date Filter Toolbar -->
    <div class="p-4 sm:px-6 sm:py-3.5 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30 flex flex-col md:flex-row md:items-center justify-between gap-3">
      <form method="GET" action="{{ route('bk.artikel') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 flex-1 max-w-3xl">
        @if(request('category') && request('category') !== 'all')
          <input type="hidden" name="category" value="{{ request('category') }}">
        @endif

        <!-- Search Input (Flex container prevents icon-text collision) -->
        <div class="flex items-center flex-1 rounded-xl border border-gray-200/90 dark:border-gray-700 bg-white dark:bg-gray-800 px-3.5 py-1.5 shadow-2xs focus-within:border-brand-500 focus-within:ring-2 focus-within:ring-brand-500/20 transition-all" style="min-height: 42px;">
          <svg class="h-4 w-4 text-gray-400 shrink-0 mr-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
          <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Cari kata kunci judul artikel..."
            class="w-full bg-transparent border-0 p-0 text-xs text-gray-900 dark:text-white placeholder-gray-400 focus:outline-hidden focus:ring-0"
            style="outline: none; border: none; background: transparent; font-size: 13px; box-shadow: none;"
          />
        </div>

        <!-- Date Picker Input (Native calendar without duplicate overlapping icon) -->
        <div class="sm:w-44 shrink-0">
          <input
            type="date"
            name="date"
            value="{{ request('date') }}"
            title="Filter tanggal terbit"
            class="w-full px-3.5 py-1.5 rounded-xl text-xs border border-gray-200/90 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 focus:outline-hidden focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 shadow-2xs cursor-pointer transition-colors"
            style="min-height: 42px; font-size: 13px;"
          />
        </div>

        <!-- Tombol Cari -->
        <button
          type="submit"
          class="inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl text-white font-bold text-xs shadow-xs shrink-0 cursor-pointer transition-all hover:opacity-90 active:scale-[0.98]"
          style="background-color: #15803d !important; color: #ffffff !important; min-height: 42px;"
        >
          <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
          <span>Cari</span>
        </button>
      </form>

      <!-- Active Filters Tag & Reset -->
      @if(request()->filled('q') || (request()->filled('category') && request('category') !== 'all') || request()->filled('date'))
        <div class="flex items-center gap-2 flex-wrap text-xs self-start md:self-auto shrink-0">
          <span class="text-gray-400 font-medium">Filter aktif:</span>
          @if(request()->filled('q'))
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-[11px] font-semibold text-gray-700 dark:text-gray-200 shadow-2xs">
              "{{ Str::limit(request('q'), 18) }}"
              <a href="{{ route('bk.artikel', array_merge(request()->except('q', 'page'))) }}" class="text-gray-400 hover:text-rose-500 ml-0.5">&times;</a>
            </span>
          @endif
          @if(request()->filled('date'))
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-[11px] font-semibold text-gray-700 dark:text-gray-200 shadow-2xs">
              {{ \Carbon\Carbon::parse(request('date'))->format('d M Y') }}
              <a href="{{ route('bk.artikel', array_merge(request()->except('date', 'page'))) }}" class="text-gray-400 hover:text-rose-500 ml-0.5">&times;</a>
            </span>
          @endif
          <a
            href="{{ route('bk.artikel') }}"
            class="text-xs font-bold text-rose-600 hover:text-rose-700 dark:text-rose-400 hover:underline px-1 py-1"
          >
            Reset Semua
          </a>
        </div>
      @endif
    </div>

    <!-- Table Responsive -->
    <div class="overflow-x-auto custom-scrollbar">
      <table class="w-full text-left border-collapse min-w-[920px]">
        <thead>
          <tr class="border-b border-gray-100 dark:border-gray-800 text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50/60 dark:bg-gray-800/40">
            <th class="py-3.5 px-6 min-w-[340px] sm:min-w-[400px]">Artikel &amp; Konten</th>
            <th class="py-3.5 px-6 w-36 whitespace-nowrap">Kategori</th>
            <th class="py-3.5 px-6 w-44 whitespace-nowrap">Sumber / Penulis</th>
            <th class="py-3.5 px-6 w-28 whitespace-nowrap">Status</th>
            <th class="py-3.5 px-6 w-32 whitespace-nowrap">Tanggal Terbit</th>
            <th class="py-3.5 px-6 w-28 text-right whitespace-nowrap">Opsi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-xs text-gray-600 dark:text-gray-300">
          @forelse($articles as $art)
            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors group">
              <!-- Thumbnail & Judul (Rapi, Sebaris, Lurus & Proporsional) -->
              <td class="py-3.5 px-6 min-w-[340px] sm:min-w-[400px]">
                <div class="flex items-center gap-3.5 min-w-0">
                  <!-- Thumbnail Gambar (Uniform 60x42 Rounded) -->
                  <div class="w-[60px] h-[42px] min-w-[60px] max-w-[60px] rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800 shrink-0 border border-gray-200/80 dark:border-gray-700 shadow-2xs relative flex items-center justify-center">
                    @if($art->thumbnail)
                      <img
                        src="{{ Str::startsWith($art->thumbnail, ['http://', 'https://']) ? $art->thumbnail : asset($art->thumbnail) }}"
                        alt="{{ $art->title }}"
                        loading="lazy"
                        class="w-full h-full object-cover object-center block"
                        onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.classList.remove('hidden');"
                      >
                      <div class="hidden w-full h-full items-center justify-center bg-gray-100 dark:bg-gray-800 text-gray-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                      </div>
                    @else
                      <div class="w-full h-full flex items-center justify-center bg-gray-100 dark:bg-gray-800 text-gray-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                      </div>
                    @endif
                  </div>

                  <!-- Judul & Cuplikan Konten (1 Baris Lurus & Rapi) -->
                  <div class="min-w-0 flex-1">
                    <a
                      href="{{ route('article.detail', $art->slug) }}"
                      target="_blank"
                      class="font-bold text-xs sm:text-sm text-gray-900 dark:text-white hover:text-brand-600 dark:hover:text-brand-400 transition-colors block"
                      style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; max-width: 100%;"
                      title="{{ $art->title }}"
                    >
                      {{ $art->title }}
                    </a>
                    <p
                      class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5"
                      style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; max-width: 100%;"
                      title="{{ strip_tags($art->content) }}"
                    >
                      {{ Str::limit(strip_tags($art->content), 80) }}
                    </p>
                  </div>
                </div>
              </td>

              <!-- Kategori -->
              <td class="py-3.5 px-6 whitespace-nowrap">
                @if($art->category === 'tips_ptn')
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 border border-blue-200/80 dark:border-blue-800">
                    <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                    <span>Tips Masuk PTN</span>
                  </span>
                @elseif($art->category === 'kesehatan_mental')
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    <span>Kesehatan Mental</span>
                  </span>
                @else
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-200/80 dark:border-amber-800">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                    <span>Edukasi Umum</span>
                  </span>
                @endif
              </td>

              <!-- Sumber / Penulis -->
              <td class="py-3.5 px-6 whitespace-nowrap">
                @if($art->source_name)
                  <div>
                    <span class="font-semibold text-xs text-gray-900 dark:text-gray-100 block truncate max-w-[170px]" title="{{ $art->source_name }}">
                      {{ $art->source_name }}
                    </span>
                    <span class="inline-flex items-center gap-1 text-[10px] text-amber-700 dark:text-amber-400 font-medium mt-0.5">
                      <svg class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 5c7.18 0 13 5.82 13 13M6 11a7 7 0 017 7m-6 0a1 1 0 11-2 0 1 1 0 012 0z" />
                      </svg>
                      <span>Sindikasi RSS</span>
                    </span>
                  </div>
                @else
                  <div>
                    <span class="font-semibold text-xs text-gray-900 dark:text-gray-100 block">
                      {{ $art->author?->name ?? 'Guru BK' }}
                    </span>
                    <span class="text-[10px] text-gray-500 dark:text-gray-400 font-medium block mt-0.5">
                      Tim Guru BK
                    </span>
                  </div>
                @endif
              </td>

              <!-- Status -->
              <td class="py-3.5 px-6 whitespace-nowrap">
                @if($art->is_published)
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    <span>Terbit</span>
                  </span>
                @else
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700">
                    <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                    <span>Draf</span>
                  </span>
                @endif
              </td>

              <!-- Tanggal Terbit -->
              <td class="py-3.5 px-6 whitespace-nowrap text-xs text-gray-600 dark:text-gray-300">
                {{ $art->created_at ? $art->created_at->format('d M Y') : '-' }}
              </td>

              <!-- Opsi -->
              <td class="py-3.5 px-6 text-right whitespace-nowrap">
                <div class="inline-flex items-center gap-2 justify-end">
                  <a
                    href="{{ route('article.detail', $art->slug) }}"
                    target="_blank"
                    class="px-3 py-1.5 rounded-xl bg-gray-100 hover:bg-brand-50 hover:text-brand-700 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-bold text-xs transition-colors inline-flex items-center gap-1.5 min-h-[36px] shadow-2xs border border-gray-200/60 dark:border-gray-700 focus-visible:outline-2 focus-visible:outline-brand-500"
                    title="Pratinjau artikel di tab baru"
                  >
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    <span>Lihat</span>
                  </a>
                  <form method="POST" action="{{ route('bk.artikel.destroy', $art->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                    @csrf
                    @method('DELETE')
                    <button
                      type="submit"
                      title="Hapus artikel"
                      class="p-2 rounded-xl text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/50 transition-colors cursor-pointer min-h-[36px] min-w-[36px] inline-flex items-center justify-center border border-transparent hover:border-rose-200 dark:hover:border-rose-800/60 focus-visible:outline-2 focus-visible:outline-rose-500"
                    >
                      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="p-12 text-center text-gray-500 dark:text-gray-400 text-xs">
                <div class="space-y-3 max-w-sm mx-auto">
                  <div class="h-12 w-12 rounded-2xl bg-gray-100 dark:bg-gray-800 text-gray-400 mx-auto flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                  </div>
                  @if(request()->filled('q') || (request()->filled('category') && request('category') !== 'all') || request()->filled('date'))
                    <div class="font-bold text-gray-800 dark:text-gray-200">Tidak ada artikel yang sesuai filter</div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                      Tidak ditemukan artikel dengan kriteria pencarian yang Anda tentukan. Coba ubah kata kunci judul, ganti kategori, atau bersihkan tanggal terbit.
                    </p>
                    <div class="pt-2">
                      <a
                        href="{{ route('bk.artikel') }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-bold text-xs transition-colors"
                      >
                        Reset Semua Filter
                      </a>
                    </div>
                  @else
                    <div class="font-bold text-gray-800 dark:text-gray-200">Belum ada artikel yang tersimpan</div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                      Klik tombol <strong>Tarik Artikel Terkini (RSS)</strong> di pojok kanan atas untuk menarik artikel edukasi otomatis atau klik <strong>Tulis Artikel Baru</strong>.
                    </p>
                  @endif
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
          <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Ambil artikel berkualitas dari portal publik resmi tanpa batasan kuota.</p>
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
              <span class="h-10 w-10 rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400 flex items-center justify-center shrink-0 shadow-xs">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /></svg>
              </span>
              <div class="text-left">
                <div class="font-bold text-gray-900 dark:text-white text-sm">Tips Lolos PTN &amp; SNBP</div>
                <div class="text-[11px] text-gray-500 dark:text-gray-400 font-medium">Strategi pemilihan jurusan, kiat belajar, dan persiapan UTBK</div>
              </div>
            </div>
            <span class="px-3 py-1.5 rounded-xl bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300 font-bold text-xs group-hover:bg-brand-500 group-hover:text-white transition-all shrink-0">
              Ambil Feed
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
              <span class="h-10 w-10 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-400 flex items-center justify-center shrink-0 shadow-xs">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
              </span>
              <div class="text-left">
                <div class="font-bold text-gray-900 dark:text-white text-sm">Kesehatan Mental Remaja</div>
                <div class="text-[11px] text-gray-500 dark:text-gray-400 font-medium">Kiat mengatasi stres ujian, burnout, dan regulasi emosi</div>
              </div>
            </div>
            <span class="px-3 py-1.5 rounded-xl bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 font-bold text-xs group-hover:bg-brand-500 group-hover:text-white transition-all shrink-0">
              Ambil Feed
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
