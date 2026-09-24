@extends('layouts.tailadmin')

@section('title', 'Riwayat Chatbot AI - SAPA BK')

@section('content')
<div class="space-y-6">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
        Riwayat Chatbot AI
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
        Pantau interaksi bimbingan konseling digital siswa dengan Asisten Cerdas AI (Gemini) dan tinjau evaluasi respons.
      </p>
    </div>

    <!-- Quick Link ke Riwayat Live Chat -->
    <a
      href="{{ route('bk.live-chat.riwayat') }}"
      class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-bold transition-all shadow-2xs shrink-0"
    >
      <svg class="h-4 w-4 text-brand-600 dark:text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
      </svg>
      <span>Buka Riwayat Live Chat BK</span>
    </a>
  </div>

  <!-- Navigation Tabs (Pemisah Jelas antara Chatbot AI & Live Chat Guru BK) -->
  <div class="flex items-center gap-2 border-b border-gray-200 dark:border-gray-800 pb-3">
    <a
      href="{{ route('bk.percakapan') }}"
      class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold bg-brand-600 text-white shadow-sm transition-all"
    >
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a1.5 1.5 0 100 3 1.5 1.5 0 000-3zM12 5v3M4 11a3 3 0 013-3h10a3 3 0 013 3v6a3 3 0 01-3 3H7a3 3 0 01-3-3v-6zM2 13v2m20-2v2M9 13v2m6-2v2M10 17h4" />
      </svg>
      <span>Riwayat Chatbot AI</span>
      <span class="px-1.5 py-0.5 rounded-full text-[10px] font-extrabold bg-white/20 text-white">
        {{ $totalAi ?? $sessions->total() }}
      </span>
    </a>

    <a
      href="{{ route('bk.live-chat.riwayat') }}"
      class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all"
    >
      <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
      </svg>
      <span>Riwayat Live Chat Guru BK</span>
      <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
        {{ $totalLive ?? 0 }}
      </span>
    </a>
  </div>

  <!-- Search & Filter Card -->
  <div class="rounded-2xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 p-5 shadow-xs">
    <form method="GET" action="{{ route('bk.percakapan') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3.5 items-end">
      
      <!-- Filter Kelas Siswa -->
      <div class="sm:col-span-1 lg:col-span-3 space-y-1.5">
        <label for="filterKelasAi" class="block text-xs font-bold text-gray-700 dark:text-gray-300">
          Filter Kelas Siswa
        </label>
        <select
          id="filterKelasAi"
          name="kelas"
          class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 text-gray-900 dark:text-white text-xs sm:text-sm focus:outline-hidden focus:ring-2 focus:ring-brand-500 transition-all cursor-pointer min-h-[42px]"
        >
          <option value="">Semua Kelas</option>
          @if(isset($kelasList))
            @foreach($kelasList as $k)
              <option value="{{ $k }}" {{ request('kelas') === $k ? 'selected' : '' }}>
                Kelas {{ $k }}
              </option>
            @endforeach
          @endif
        </select>
      </div>

      <!-- Filter Tanggal Konseling -->
      <div class="sm:col-span-1 lg:col-span-3 space-y-1.5">
        <label for="filterTanggalAi" class="block text-xs font-bold text-gray-700 dark:text-gray-300">
          Filter Tanggal Sesi
        </label>
        <input
          id="filterTanggalAi"
          type="date"
          name="tanggal"
          value="{{ request('tanggal') }}"
          class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 text-gray-900 dark:text-white text-xs sm:text-sm focus:outline-hidden focus:ring-2 focus:ring-brand-500 transition-all cursor-pointer min-h-[42px]"
        />
      </div>

      <!-- Pencarian Nama Siswa / Topik -->
      <div class="sm:col-span-2 lg:col-span-4 space-y-1.5">
        <label for="filterSearchAi" class="block text-xs font-bold text-gray-700 dark:text-gray-300">
          Pencarian Siswa / Topik
        </label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </span>
          <input
            id="filterSearchAi"
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Cari nama siswa, kelas, NISN, atau judul..."
            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 text-gray-900 dark:text-white placeholder-gray-400 text-xs sm:text-sm focus:outline-hidden focus:ring-2 focus:ring-brand-500 transition-all min-h-[42px]"
          />
        </div>
      </div>

      <!-- Tombol Aksi Filter -->
      <div class="sm:col-span-2 lg:col-span-2 flex items-center gap-2">
        <button
          type="submit"
          class="flex-1 min-h-[42px] px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs sm:text-sm shadow-sm transition-all cursor-pointer flex items-center justify-center gap-1.5"
        >
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
          </svg>
          <span>Terapkan</span>
        </button>

        @if(request()->hasAny(['kelas', 'tanggal', 'q']))
          <a
            href="{{ route('bk.percakapan') }}"
            class="min-h-[42px] px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 text-xs sm:text-sm font-semibold transition-all flex items-center justify-center"
            title="Reset semua filter"
          >
            Reset
          </a>
        @endif
      </div>
    </form>

    <!-- Ringkasan Filter Aktif -->
    @if(request()->hasAny(['kelas', 'tanggal', 'q']))
      <div class="flex items-center gap-2 mt-4 pt-3.5 border-t border-gray-100 dark:border-gray-800 text-xs text-gray-500 dark:text-gray-400 flex-wrap">
        <span class="font-bold text-gray-700 dark:text-gray-300">Filter Aktif:</span>

        @if(request('kelas'))
          <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 border border-blue-200/50 dark:border-blue-800/40 text-[11px] font-bold">
            Kelas: {{ request('kelas') }}
          </span>
        @endif

        @if(request('tanggal'))
          <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200/50 dark:border-emerald-800/40 text-[11px] font-bold">
            Tanggal: {{ \Carbon\Carbon::parse(request('tanggal'))->translatedFormat('d M Y') }}
          </span>
        @endif

        @if(request('q'))
          <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-200/50 dark:border-amber-800/40 text-[11px] font-bold">
            Pencarian: "{{ request('q') }}"
          </span>
        @endif

        <a href="{{ route('bk.percakapan') }}" class="text-[11px] text-rose-600 dark:text-rose-400 hover:underline font-bold ml-auto">
          Hapus Semua Filter &times;
        </a>
      </div>
    @endif
  </div>

  <!-- Sesi Percakapan List Card (TailAdmin) -->
  <div class="rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs overflow-hidden">
    <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
      <div class="flex items-center gap-2.5">
        <span class="h-3 w-3 rounded-full bg-emerald-500"></span>
        <h2 class="text-base font-bold text-gray-900 dark:text-white">Daftar Sesi Konsultasi Chatbot AI</h2>
      </div>
      <span class="text-xs text-gray-400 font-semibold">Total: {{ $sessions->total() }} Sesi AI</span>
    </div>

    <div class="divide-y divide-gray-100 dark:divide-gray-800">
      @forelse($sessions as $s)
        <div class="p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
          <div class="flex items-start gap-4">
            <div class="h-11 w-11 rounded-2xl bg-gradient-to-tr from-[#205A26] to-[#2E7D34] text-white font-bold flex items-center justify-center text-sm shrink-0 shadow-xs">
              {{ strtoupper(substr($s->user?->name ?? 'Tamu', 0, 2)) }}
            </div>
            <div class="space-y-1">
              <div class="flex items-center gap-2 flex-wrap">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $s->user?->name ?? 'Pengguna Tamu' }}</h3>
                <span class="text-[10px] px-2 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 font-bold border border-emerald-200/50 dark:border-emerald-800/40">
                  {{ $s->user?->kelas ?? 'Siswa' }}
                </span>
                @if($s->user?->nisn)
                  <span class="text-[10px] font-mono text-gray-400">
                    NISN: {{ $s->user->nisn }}
                  </span>
                @endif
              </div>

              <p class="text-xs text-gray-700 dark:text-gray-200 font-medium">
                {{ $s->title ?: 'Percakapan AI' }}
              </p>

              <div class="flex items-center gap-2.5 text-[11px] text-gray-400">
                <span>{{ $s->created_at->format('d M Y, H:i') }} WIB</span>
                <span>•</span>
                <span>{{ $s->messages->count() }} pesan dialog</span>
                <span>•</span>
                <span class="inline-flex items-center gap-1 text-emerald-600 dark:text-emerald-400 font-semibold">
                  <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                  Gemini AI
                </span>
              </div>
            </div>
          </div>

          <a
            href="{{ route('bk.percakapan.detail', $s->id) }}"
            class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-brand-50 hover:bg-brand-600 hover:text-white text-brand-700 dark:bg-brand-950/60 dark:text-brand-300 dark:hover:bg-brand-600 dark:hover:text-white text-xs font-bold transition-all shrink-0 shadow-2xs"
          >
            <span>Buka Transkrip AI</span>
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
          </a>
        </div>
      @empty
        <div class="p-12 text-center text-gray-400 text-xs">
          Belum ada riwayat sesi percakapan Chatbot AI siswa.
        </div>
      @endforelse
    </div>

    @if($sessions->hasPages())
      <div class="p-6 border-t border-gray-100 dark:border-gray-800">
        {{ $sessions->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
