@extends('layouts.tailadmin')

@section('title', 'Riwayat Chatbot AI - SAPA BK')

@section('content')
<div class="space-y-6">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 mb-1">
        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold tracking-wide uppercase bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/40">
          Layanan Bimbingan Konseling Digital
        </span>
      </div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
        Riwayat Chatbot AI
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 max-w-2xl">
        Pantau interaksi bimbingan konseling digital siswa bersama Asisten Cerdas AI (Gemini) dan evaluasi kualitas jawaban.
      </p>
    </div>

    <!-- Quick Live Chat Shortcut -->
    <div class="flex items-center gap-3 shrink-0">
      <a
        href="{{ route('bk.live-chat') }}"
        class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700/80 transition-all shadow-2xs"
        title="Buka Ruang Konseling Langsung"
      >
        <span class="relative flex h-2 w-2">
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
          <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
        </span>
        <span>Ruang Live Chat Aktif</span>
      </a>
    </div>
  </div>

  <!-- Segmented Navigation (Pemisah Jelas & Terintegrasi antara Chatbot AI & Live Chat Guru BK) -->
  <div class="inline-flex p-1 rounded-2xl bg-gray-100/90 dark:bg-gray-800/90 border border-gray-200/70 dark:border-gray-700/60 shadow-2xs">
    <a
      href="{{ route('bk.percakapan') }}"
      class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all bg-white dark:bg-gray-900 text-brand-700 dark:text-brand-400 shadow-xs"
    >
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a1.5 1.5 0 100 3 1.5 1.5 0 000-3zM12 5v3M4 11a3 3 0 013-3h10a3 3 0 013 3v6a3 3 0 01-3 3H7a3 3 0 01-3-3v-6zM2 13v2m20-2v2M9 13v2m6-2v2M10 17h4" />
      </svg>
      <span>Riwayat Chatbot AI</span>
      <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-brand-50 text-brand-700 dark:bg-brand-950 dark:text-brand-300 border border-brand-200/50 dark:border-brand-800/50">
        {{ $totalAi ?? $sessions->total() }}
      </span>
    </a>

    <a
      href="{{ route('bk.live-chat.riwayat') }}"
      class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-all"
    >
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
      </svg>
      <span>Riwayat Live Chat Guru BK</span>
      <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-200/80 dark:bg-gray-700/80 text-gray-700 dark:text-gray-300">
        {{ $totalLive ?? 0 }}
      </span>
    </a>
  </div>

  <!-- Search & Filter Card (Desain Responsif, Lega, Tidak Terpotong) -->
  <div class="rounded-2xl bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 p-4 sm:p-5 shadow-xs space-y-4">
    <form method="GET" action="{{ route('bk.percakapan') }}" class="space-y-3.5">
      
      <!-- Baris 1: Pencarian Utama Siswa / Topik -->
      <div class="relative">
        <label for="filterSearchAi" class="sr-only">Pencarian Siswa atau Topik Percakapan</label>
        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 dark:text-gray-500">
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </span>
        <input
          id="filterSearchAi"
          type="text"
          name="q"
          value="{{ request('q') }}"
          placeholder="Cari nama siswa, kelas, NISN, atau topik percakapan..."
          class="w-full pl-10 pr-24 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-800/60 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 text-xs sm:text-sm focus:outline-hidden focus:ring-2 focus:ring-brand-500 transition-all min-h-[44px]"
        />
        @if(request('q'))
          <a
            href="{{ route('bk.percakapan', request()->except('q')) }}"
            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-xs font-semibold text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
            title="Bersihkan kata kunci"
          >
            Hapus
          </a>
        @endif
      </div>

      <!-- Baris 2: Filter Kelas, Tanggal, & Tombol Aksi -->
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 pt-1">
        
        <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full md:w-auto">
          <!-- Filter Kelas Siswa -->
          <div class="w-full sm:w-56 shrink-0">
            <label for="filterKelasAi" class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">
              Filter Kelas Siswa
            </label>
            <div class="relative">
              <select
                id="filterKelasAi"
                name="kelas"
                class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-800/60 text-gray-900 dark:text-white text-xs sm:text-sm focus:outline-hidden focus:ring-2 focus:ring-brand-500 transition-all cursor-pointer min-h-[42px]"
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
          </div>

          <!-- Filter Tanggal Sesi -->
          <div class="w-full sm:w-56 shrink-0">
            <label for="filterTanggalAi" class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">
              Filter Tanggal Sesi
            </label>
            <div class="relative">
              <input
                id="filterTanggalAi"
                type="date"
                name="tanggal"
                value="{{ request('tanggal') }}"
                class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-800/60 text-gray-900 dark:text-white text-xs sm:text-sm focus:outline-hidden focus:ring-2 focus:ring-brand-500 transition-all cursor-pointer min-h-[42px]"
              />
            </div>
          </div>
        </div>

        <!-- Tombol Aksi Terapkan & Reset -->
        <div class="flex items-center gap-2 self-stretch sm:self-end md:self-auto shrink-0 pt-2 sm:pt-0">
          <button
            type="submit"
            class="flex-1 sm:flex-none min-h-[42px] px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs sm:text-sm shadow-sm hover:shadow transition-all cursor-pointer inline-flex items-center justify-center gap-2"
          >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            <span>Terapkan Filter</span>
          </button>

          @if(request()->hasAny(['kelas', 'tanggal', 'q']))
            <a
              href="{{ route('bk.percakapan') }}"
              class="min-h-[42px] px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 text-xs sm:text-sm font-semibold transition-all inline-flex items-center justify-center gap-1.5"
              title="Reset semua filter"
            >
              <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              <span>Reset</span>
            </a>
          @endif
        </div>

      </div>
    </form>

    <!-- Ringkasan Filter Aktif (Pill Badges) -->
    @if(request()->hasAny(['kelas', 'tanggal', 'q']))
      <div class="flex items-center gap-2 pt-3 border-t border-gray-100 dark:border-gray-800 text-xs text-gray-500 dark:text-gray-400 flex-wrap">
        <span class="font-bold text-gray-700 dark:text-gray-300">Filter Aktif:</span>

        @if(request('kelas'))
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 border border-blue-200/60 dark:border-blue-800/50 text-[11px] font-bold">
            <span>Kelas: {{ request('kelas') }}</span>
            <a href="{{ route('bk.percakapan', request()->except('kelas')) }}" class="hover:text-blue-900 dark:hover:text-white" title="Hapus filter kelas">&times;</a>
          </span>
        @endif

        @if(request('tanggal'))
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/50 text-[11px] font-bold">
            <span>Tanggal: {{ \Carbon\Carbon::parse(request('tanggal'))->translatedFormat('d M Y') }}</span>
            <a href="{{ route('bk.percakapan', request()->except('tanggal')) }}" class="hover:text-emerald-900 dark:hover:text-white" title="Hapus filter tanggal">&times;</a>
          </span>
        @endif

        @if(request('q'))
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-200/60 dark:border-amber-800/50 text-[11px] font-bold">
            <span>Pencarian: "{{ request('q') }}"</span>
            <a href="{{ route('bk.percakapan', request()->except('q')) }}" class="hover:text-amber-900 dark:hover:text-white" title="Hapus pencarian">&times;</a>
          </span>
        @endif

        <a href="{{ route('bk.percakapan') }}" class="text-[11px] text-rose-600 dark:text-rose-400 hover:underline font-bold ml-auto">
          Hapus Semua Filter &times;
        </a>
      </div>
    @endif
  </div>

  <!-- Sesi Percakapan List Card (TailAdmin) -->
  <div class="rounded-3xl bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 shadow-xs overflow-hidden">
    
    <!-- Table / List Header -->
    <div class="p-5 sm:p-6 border-b border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
      <div class="flex items-center gap-2.5">
        <span class="h-3 w-3 rounded-full bg-emerald-500 ring-4 ring-emerald-50 dark:ring-emerald-950/60"></span>
        <h2 class="text-base font-bold text-gray-900 dark:text-white">
          Daftar Sesi Konsultasi Chatbot AI
        </h2>
      </div>
      <span class="text-xs text-gray-500 dark:text-gray-400 font-semibold">
        Menampilkan {{ $sessions->count() }} dari {{ $sessions->total() }} Sesi AI
      </span>
    </div>

    <!-- Sesi Items -->
    <div class="divide-y divide-gray-100 dark:divide-gray-800">
      @forelse($sessions as $s)
        @php
          $lastMsg = $s->messages->last();
          $firstUserMsg = $s->messages->firstWhere('role', 'user');
          $previewMsg = $lastMsg ?: $firstUserMsg;
          $hasEvaluation = $s->messages->contains(fn($m) => $m->evaluation !== null);
        @endphp

        <div class="p-5 sm:p-6 flex flex-col lg:flex-row lg:items-center justify-between gap-5 hover:bg-gray-50/60 dark:hover:bg-gray-800/40 transition-colors">
          
          <div class="flex items-start gap-4 min-w-0 flex-1">
            <!-- Avatar Siswa -->
            <div class="h-12 w-12 rounded-2xl bg-gradient-to-tr from-[#205A26] to-[#2E7D34] text-white font-extrabold flex items-center justify-center text-sm shrink-0 shadow-xs">
              {{ strtoupper(substr($s->user?->name ?? 'Tamu', 0, 2)) }}
            </div>

            <div class="space-y-2 min-w-0 flex-1">
              <!-- Baris Nama, Kelas, NISN, & Badge Evaluasi -->
              <div class="flex items-center gap-2 flex-wrap">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                  {{ $s->user?->name ?? 'Pengguna Tamu' }}
                </h3>
                
                <span class="text-[10px] px-2.5 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 font-bold border border-emerald-200/50 dark:border-emerald-800/40">
                  {{ $s->user?->kelas ? 'Kelas ' . $s->user->kelas : 'Siswa' }}
                </span>

                @if($s->user?->nisn)
                  <span class="text-[11px] font-mono text-gray-400 dark:text-gray-500">
                    NISN: {{ $s->user->nisn }}
                  </span>
                @endif

                @if($hasEvaluation)
                  <span class="inline-flex items-center gap-1 text-[10px] px-2 py-0.5 rounded-md bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 font-bold border border-blue-200/50 dark:border-blue-800/40">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Sudah Dievaluasi
                  </span>
                @endif
              </div>

              <!-- Judul Percakapan -->
              <p class="text-xs sm:text-sm font-semibold text-gray-800 dark:text-gray-200 truncate">
                {{ $s->title ?: 'Percakapan Konseling AI' }}
              </p>

              <!-- Cuplikan Pesan Terakhir / Topik -->
              @if($previewMsg)
                <div class="flex items-start gap-2 text-xs text-gray-600 dark:text-gray-300 bg-gray-50/80 dark:bg-gray-800/60 px-3 py-2 rounded-xl border border-gray-100 dark:border-gray-800/80">
                  <span class="shrink-0 font-bold {{ $previewMsg->role === 'user' ? 'text-brand-600 dark:text-brand-400' : 'text-amber-600 dark:text-amber-400' }}">
                    {{ $previewMsg->role === 'user' ? 'Siswa:' : 'AI Gemini:' }}
                  </span>
                  <span class="line-clamp-1 italic text-gray-700 dark:text-gray-300">
                    "{{ Str::limit($previewMsg->content, 120) }}"
                  </span>
                </div>
              @endif

              <!-- Meta Info Waktu & Dialog -->
              <div class="flex items-center gap-2.5 text-[11px] text-gray-400 dark:text-gray-500 flex-wrap">
                <span class="inline-flex items-center gap-1">
                  <svg class="h-3.5 w-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  {{ $s->created_at->translatedFormat('d M Y, H:i') }} WIB ({{ $s->created_at->diffForHumans() }})
                </span>
                <span>•</span>
                <span>{{ $s->messages->count() }} pesan dialog</span>
                <span>•</span>
                <span class="inline-flex items-center gap-1 text-emerald-600 dark:text-emerald-400 font-semibold">
                  <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                  </svg>
                  Gemini AI
                </span>
              </div>

            </div>
          </div>

          <!-- Tombol Aksi Buka Transkrip -->
          <div class="lg:self-center shrink-0">
            <a
              href="{{ route('bk.percakapan.detail', $s->id) }}"
              class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-brand-50 hover:bg-brand-600 text-brand-700 hover:text-white dark:bg-brand-950/60 dark:text-brand-300 dark:hover:bg-brand-600 dark:hover:text-white text-xs font-bold transition-all shadow-2xs group"
            >
              <span>Buka Transkrip AI</span>
              <svg class="h-4 w-4 transform group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </a>
          </div>

        </div>
      @empty
        <!-- Empty State Elegan -->
        <div class="p-12 text-center space-y-3">
          <div class="h-16 w-16 mx-auto rounded-3xl bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-500 flex items-center justify-center">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
          </div>
          <div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">
              @if(request()->hasAny(['kelas', 'tanggal', 'q']))
                Tidak Ada Sesi yang Sesuai dengan Filter
              @else
                Belum Ada Riwayat Percakapan Chatbot AI
              @endif
            </h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">
              @if(request()->hasAny(['kelas', 'tanggal', 'q']))
                Coba sesuaikan kata kunci pencarian atau ubah filter kelas dan tanggal sesi.
              @else
                Sesi konsultasi digital siswa bersama Asisten Cerdas AI akan otomatis terekam pada halaman ini.
              @endif
            </p>
          </div>
          @if(request()->hasAny(['kelas', 'tanggal', 'q']))
            <div class="pt-2">
              <a
                href="{{ route('bk.percakapan') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs font-bold transition-all"
              >
                Reset Filter Pencarian
              </a>
            </div>
          @endif
        </div>
      @endforelse
    </div>

    <!-- Pagination -->
    @if($sessions->hasPages())
      <div class="p-6 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-850/50">
        {{ $sessions->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
