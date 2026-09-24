@extends('layouts.tailadmin')

@section('title', 'Riwayat Live Chat Guru BK - SAPA BK')

@section('content')
<div class="space-y-6">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
        Riwayat Live Chat Guru BK
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 max-w-2xl">
        Dokumentasi rekam jejak bimbingan konseling tatap maya langsung antara siswa dan Guru BK.
      </p>
    </div>

    <!-- Quick Link ke Ruang Live Chat Aktif -->
    <a
      href="{{ route('bk.live-chat') }}"
      class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold transition-all shadow-md shadow-brand-600/20 shrink-0 self-start sm:self-auto"
      title="Buka Ruang Konseling Langsung"
    >
      <span class="relative flex h-2 w-2">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-300 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-200"></span>
      </span>
      <span>Buka Ruang Live Chat Aktif</span>
    </a>
  </div>

  <!-- Navigation Tabs (Pemisah Jelas antara Chatbot AI & Live Chat Guru BK) -->
  <div class="flex items-center gap-2 border-b border-gray-200 dark:border-gray-800 pb-3 flex-wrap">
    <a
      href="{{ route('bk.percakapan') }}"
      class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl text-xs font-bold text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all"
    >
      <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a1.5 1.5 0 100 3 1.5 1.5 0 000-3zM12 5v3M4 11a3 3 0 013-3h10a3 3 0 013 3v6a3 3 0 01-3 3H7a3 3 0 01-3-3v-6zM2 13v2m20-2v2M9 13v2m6-2v2M10 17h4" />
      </svg>
      <span>Riwayat Chatbot AI</span>
      <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
        {{ $totalAi ?? 0 }}
      </span>
    </a>

    <a
      href="{{ route('bk.live-chat.riwayat') }}"
      class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl text-xs font-bold bg-brand-600 text-white shadow-sm shadow-brand-600/20 transition-all"
    >
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
      </svg>
      <span>Riwayat Live Chat Guru BK</span>
      <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-white/20 text-white">
        {{ $totalLive ?? $sessions->total() }}
      </span>
    </a>
  </div>

  <!-- Search & Filter Card (Tata Letak 2 Baris Presisi, Bebas Tumpang Tindih) -->
  <div class="rounded-2xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 p-5 shadow-xs">
    <form method="GET" action="{{ route('bk.live-chat.riwayat') }}" class="space-y-4">
      
      <!-- Baris 1: Pencarian Siswa / Topik -->
      <div class="space-y-1.5">
        <label for="filterSearchLive" class="block text-xs font-bold text-gray-700 dark:text-gray-300">
          Pencarian Siswa / Topik Konseling
        </label>
        <div class="relative">
          <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </div>
          <input
            id="filterSearchLive"
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Ketik nama siswa atau topik konseling..."
            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 text-gray-900 dark:text-white placeholder-gray-400 text-xs sm:text-sm focus:outline-hidden focus:ring-2 focus:ring-brand-500 transition-all min-h-[42px]"
          />
        </div>
      </div>

      <!-- Baris 2: Filter Kelas, Tanggal, dan Tombol Terapkan (3 Kolom Proporsional) -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-12 gap-3.5 items-end">
        
        <!-- Filter Kelas Siswa (4 kolom) -->
        <div class="md:col-span-4 space-y-1.5">
          <label for="filterKelasLive" class="block text-xs font-bold text-gray-700 dark:text-gray-300">
            Filter Kelas Siswa
          </label>
          <select
            id="filterKelasLive"
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

        <!-- Filter Tanggal Konseling (4 kolom) -->
        <div class="md:col-span-4 space-y-1.5">
          <label for="filterTanggalLive" class="block text-xs font-bold text-gray-700 dark:text-gray-300">
            Filter Tanggal Konseling
          </label>
          <input
            id="filterTanggalLive"
            type="date"
            name="tanggal"
            value="{{ request('tanggal') }}"
            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 text-gray-900 dark:text-white text-xs sm:text-sm focus:outline-hidden focus:ring-2 focus:ring-brand-500 transition-all cursor-pointer min-h-[42px]"
          />
        </div>

        <!-- Tombol Aksi Terapkan & Reset (4 kolom) -->
        <div class="sm:col-span-2 md:col-span-4 flex items-center gap-2">
          <button
            type="submit"
            class="flex-1 min-h-[42px] px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs sm:text-sm shadow-sm transition-all cursor-pointer flex items-center justify-center gap-1.5"
          >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            <span>Terapkan Filter</span>
          </button>

          @if(request()->hasAny(['kelas', 'tanggal', 'q', 'status', 'teacher_id']))
            <a
              href="{{ route('bk.live-chat.riwayat') }}"
              class="min-h-[42px] px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 text-xs sm:text-sm font-semibold transition-all flex items-center justify-center"
              title="Reset semua filter"
            >
              Reset
            </a>
          @endif
        </div>

      </div>
    </form>

    <!-- Ringkasan Filter Aktif -->
    @if(request()->hasAny(['kelas', 'tanggal', 'q']))
      <div class="flex items-center gap-2 mt-4 pt-3.5 border-t border-gray-100 dark:border-gray-800 text-xs text-gray-500 dark:text-gray-400 flex-wrap">
        <span class="font-bold text-gray-700 dark:text-gray-300">Filter Aktif:</span>

        @if(request('kelas'))
          <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 border border-blue-200/50 dark:border-blue-800/40 text-[11px] font-bold">
            <span>Kelas: {{ request('kelas') }}</span>
            <a href="{{ route('bk.live-chat.riwayat', request()->except('kelas')) }}" class="hover:text-blue-900 dark:hover:text-white" title="Hapus filter kelas">&times;</a>
          </span>
        @endif

        @if(request('tanggal'))
          <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200/50 dark:border-emerald-800/40 text-[11px] font-bold">
            <span>Tanggal: {{ \Carbon\Carbon::parse(request('tanggal'))->translatedFormat('d M Y') }}</span>
            <a href="{{ route('bk.live-chat.riwayat', request()->except('tanggal')) }}" class="hover:text-emerald-900 dark:hover:text-white" title="Hapus filter tanggal">&times;</a>
          </span>
        @endif

        @if(request('q'))
          <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-200/50 dark:border-amber-800/40 text-[11px] font-bold">
            <span>Pencarian: "{{ request('q') }}"</span>
            <a href="{{ route('bk.live-chat.riwayat', request()->except('q')) }}" class="hover:text-amber-900 dark:hover:text-white" title="Hapus pencarian">&times;</a>
          </span>
        @endif

        <a href="{{ route('bk.live-chat.riwayat') }}" class="text-[11px] text-rose-600 dark:text-rose-400 hover:underline font-bold ml-auto">
          Hapus Semua Filter &times;
        </a>
      </div>
    @endif
  </div>

  <!-- Sesi Percakapan List Card (TailAdmin) -->
  <div class="rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs overflow-hidden">
    
    <!-- Table Header -->
    <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
      <div class="flex items-center gap-2.5">
        <span class="h-3 w-3 rounded-full bg-blue-500 ring-4 ring-blue-50 dark:ring-blue-950/60"></span>
        <h2 class="text-base font-bold text-gray-900 dark:text-white">
          Rekam Sesi Konseling Guru BK
        </h2>
      </div>
      <span class="text-xs text-gray-400 font-semibold">
        Menampilkan {{ $sessions->count() }} dari {{ $sessions->total() }} Sesi Konseling
      </span>
    </div>

    <!-- Sesi Items -->
    <div class="divide-y divide-gray-100 dark:divide-gray-800">
      @forelse($sessions as $s)
        <div class="p-5 sm:p-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4 hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
          
          <div class="flex items-start gap-4 min-w-0 flex-1">
            <div class="h-11 w-11 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-700 text-white font-bold flex items-center justify-center text-sm shrink-0 shadow-xs">
              {{ strtoupper(substr($s->user?->name ?? 'S', 0, 2)) }}
            </div>

            <div class="space-y-1.5 min-w-0 flex-1">
              <div class="flex items-center gap-2 flex-wrap">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                  {{ $s->user?->name ?? 'Siswa' }}
                </h3>
                
                <span class="text-[10px] px-2 py-0.5 rounded-md bg-blue-50 dark:bg-blue-950/60 text-blue-800 dark:text-blue-300 font-bold border border-blue-200/50 dark:border-blue-800/40">
                  {{ $s->user?->kelas ? 'Kelas ' . $s->user->kelas : 'Siswa' }}
                </span>

                @if($s->status === 'active')
                  <span class="inline-flex items-center gap-1.5 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800/50">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Aktif Berlangsung
                  </span>
                @else
                  <span class="inline-flex items-center text-[10px] font-bold px-2 py-0.5 rounded-full bg-gray-100 text-gray-700 border border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700">
                    Selesai (Closed)
                  </span>
                @endif
              </div>

              <p class="text-xs text-gray-700 dark:text-gray-200 font-medium truncate">
                {{ $s->title ?: 'Konseling Siswa bersama Guru BK' }}
              </p>

              <div class="flex items-center gap-2.5 text-[11px] text-gray-500 dark:text-gray-400 flex-wrap">
                <span class="font-semibold text-gray-700 dark:text-gray-300">
                  Guru BK: {{ $s->teacher?->name ?? 'Belum ditentukan' }}
                </span>
                <span>•</span>
                <span>Mulai: {{ $s->created_at->format('d M Y, H:i') }} WIB</span>
                @if($s->closed_at)
                  <span>•</span>
                  <span>Ditutup: {{ $s->closed_at->format('d M Y, H:i') }} WIB</span>
                @endif
                <span>•</span>
                <span>{{ $s->messages->count() }} pesan terkirim</span>
              </div>
            </div>
          </div>

          <div class="flex items-center gap-2 shrink-0 self-end lg:self-center">
            @if($s->status === 'active')
              <a
                href="{{ route('bk.live-chat') }}"
                class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all shadow-2xs"
                title="Buka ruang live chat aktif"
              >
                <span>Masuk Chat</span>
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </a>
            @endif

            <a
              href="{{ route('bk.percakapan.detail', $s->id) }}"
              class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-brand-50 hover:bg-brand-600 hover:text-white text-brand-700 dark:bg-brand-950/60 dark:text-brand-300 dark:hover:bg-brand-600 dark:hover:text-white text-xs font-bold transition-all shadow-2xs"
            >
              <span>Transkrip Konseling</span>
              <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </a>
          </div>
        </div>
      @empty
        <div class="p-12 text-center text-gray-400 text-xs space-y-2">
          <p>
            @if(request()->hasAny(['kelas', 'tanggal', 'q']))
              Tidak ada riwayat sesi yang sesuai dengan kriteria filter pencarian.
            @else
              Belum ada riwayat sesi live chat konseling antara siswa dan Guru BK.
            @endif
          </p>
          @if(request()->hasAny(['kelas', 'tanggal', 'q']))
            <a
              href="{{ route('bk.live-chat.riwayat') }}"
              class="inline-block text-brand-600 dark:text-brand-400 hover:underline font-bold"
            >
              Reset semua filter
            </a>
          @endif
        </div>
      @endforelse
    </div>

    <!-- Pagination -->
    @if($sessions->hasPages())
      <div class="p-6 border-t border-gray-100 dark:border-gray-800">
        {{ $sessions->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
