@extends('layouts.tailadmin')

@section('title', 'Dashboard Administrator | SAPA BK SMAN 4 Jember')

@section('content')
<div class="space-y-6" x-data="adminDashboard()">

  <!-- Page Title Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <div>
      <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white tracking-tight">
        Dashboard Bimbingan &amp; Konseling
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
        Pusat monitoring layanan konseling siswa, analitik asisten cerdas AI, dan alur penanganan terpadu SMA Negeri 4 Jember.
      </p>
    </div>

    <!-- System Status Badge (Without pulsing loop) -->
    <div class="flex items-center gap-2">
      <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/40">
        <span class="h-2 w-2 rounded-full bg-emerald-500" aria-hidden="true"></span>
        <span>Layanan Konseling Aktif</span>
      </span>
    </div>
  </div>

  <!-- Grafik Utama: Tren Konsultasi Siswa (Dengan 3 Sub-Kartu Metrik Terintegrasi) -->
  <div class="bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl p-4 sm:p-5 shadow-xs space-y-3">
    
    <!-- Header Grafik & Filter Periode -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-2 border-b border-gray-100 dark:border-gray-800/70">
      
      <!-- Judul & Subjudul -->
      <div class="flex items-center gap-2.5">
        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/40">
          <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
          </svg>
        </div>
        <div>
          <h2 class="text-sm sm:text-base font-bold text-gray-900 dark:text-white tracking-tight">
            Tren Konsultasi Siswa
          </h2>
          <p class="text-xs text-gray-500 dark:text-gray-400">
            Perkembangan konsultasi siswa berdasarkan layanan
          </p>
        </div>
      </div>

      <!-- Segmented Pill Controls: Minggu, Bulan, Tahun -->
      <div class="inline-flex p-1 rounded-xl bg-gray-100/90 dark:bg-gray-800/90 text-xs font-semibold text-gray-600 dark:text-gray-300 self-start sm:self-auto border border-gray-200/50 dark:border-gray-700/50">
        <button
          type="button"
          @click="switchPeriod('week')"
          :class="period === 'week' ? 'bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-xs' : 'hover:text-gray-900 dark:hover:text-white'"
          class="px-3 py-1 rounded-lg transition-all min-h-[30px] flex items-center justify-center"
        >
          Minggu
        </button>
        <button
          type="button"
          @click="switchPeriod('month')"
          :class="period === 'month' ? 'bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-xs' : 'hover:text-gray-900 dark:hover:text-white'"
          class="px-3 py-1 rounded-lg transition-all min-h-[30px] flex items-center justify-center"
        >
          Bulan
        </button>
        <button
          type="button"
          @click="switchPeriod('year')"
          :class="period === 'year' ? 'bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-xs' : 'hover:text-gray-900 dark:hover:text-white'"
          class="px-3 py-1 rounded-lg transition-all min-h-[30px] flex items-center justify-center"
        >
          Tahun
        </button>
      </div>

    </div>

    <!-- 3 Sub-Kartu Metrik: Pasti 1 Baris & Dikecilkan (Sleek Compact Row) -->
    <div class="grid grid-cols-3 gap-2 sm:gap-3.5 pt-0.5">
      
      <!-- Sub-Card 1: Konsultasi Chatbot AI -->
      <div class="bg-gray-50/80 dark:bg-gray-800/40 border border-gray-200/70 dark:border-gray-800 rounded-xl p-2.5 sm:p-3 transition-all min-w-0">
        <div class="flex items-center justify-between gap-1 flex-wrap">
          <div class="flex items-center gap-1.5 min-w-0">
            <span class="h-2 w-2 rounded-full bg-emerald-500 shrink-0" aria-hidden="true"></span>
            <span class="text-[11px] sm:text-xs font-semibold text-gray-700 dark:text-gray-300 truncate">Konsultasi Chatbot AI</span>
          </div>
          <span
            class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] sm:text-[11px] font-semibold shrink-0"
            :class="activePeriodData.pct_val_ai < 0 ? 'bg-rose-50 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300 border border-rose-200/50' : 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200/50'"
            x-text="activePeriodData.pct_ai_badge || activePeriodData.pct_ai"
          >
            0.0%
          </span>
        </div>
        <div
          class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white tracking-tight mt-1"
          x-text="activePeriodData.ai_count"
        >
          0
        </div>
      </div>

      <!-- Sub-Card 2: Live Chat Guru BK -->
      <div class="bg-gray-50/80 dark:bg-gray-800/40 border border-gray-200/70 dark:border-gray-800 rounded-xl p-2.5 sm:p-3 transition-all min-w-0">
        <div class="flex items-center justify-between gap-1 flex-wrap">
          <div class="flex items-center gap-1.5 min-w-0">
            <span class="h-2 w-2 rounded-full bg-blue-500 shrink-0" aria-hidden="true"></span>
            <span class="text-[11px] sm:text-xs font-semibold text-gray-700 dark:text-gray-300 truncate">Live Chat Guru BK</span>
          </div>
          <span
            class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] sm:text-[11px] font-semibold shrink-0"
            :class="activePeriodData.pct_val_live < 0 ? 'bg-rose-50 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300 border border-rose-200/50' : 'bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 border border-blue-200/50'"
            x-text="activePeriodData.pct_live_badge || activePeriodData.pct_live"
          >
            0.0%
          </span>
        </div>
        <div
          class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white tracking-tight mt-1"
          x-text="activePeriodData.live_count"
        >
          0
        </div>
      </div>

      <!-- Sub-Card 3: Total Konsultasi -->
      <div class="bg-gray-50/80 dark:bg-gray-800/40 border border-gray-200/70 dark:border-gray-800 rounded-xl p-2.5 sm:p-3 transition-all min-w-0">
        <div class="flex items-center justify-between gap-1 flex-wrap">
          <div class="flex items-center gap-1.5 min-w-0">
            <span class="h-2 w-2 rounded-full bg-slate-700 dark:bg-slate-300 shrink-0" aria-hidden="true"></span>
            <span class="text-[11px] sm:text-xs font-semibold text-gray-700 dark:text-gray-300 truncate">Total Konsultasi</span>
          </div>
          <span
            class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] sm:text-[11px] font-semibold shrink-0"
            :class="activePeriodData.pct_val_total < 0 ? 'bg-rose-50 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300 border border-rose-200/50' : 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300 border border-slate-200/60'"
            x-text="activePeriodData.pct_total_badge || activePeriodData.pct_total"
          >
            0.0%
          </span>
        </div>
        <div
          class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white tracking-tight mt-1"
          x-text="activePeriodData.total_count"
        >
          0
        </div>
      </div>

    </div>

    <!-- Chart Canvas Dikecilkan (Hanya 180px - 210px) -->
    <div class="relative w-full h-[180px] sm:h-[210px] pt-1">
      <canvas id="adminTrendChart" class="w-full h-full"></canvas>
    </div>

    <!-- Chart Footer: Perbandingan & Legenda -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 pt-3 border-t border-gray-100 dark:border-gray-800 text-xs">
      <div class="flex items-center gap-1.5 font-medium text-emerald-700 dark:text-emerald-400">
        <span x-text="activePeriodData.comparison_text"></span>
      </div>

      <div class="flex items-center gap-4 text-xs font-medium text-gray-600 dark:text-gray-300">
        <div class="flex items-center gap-1.5">
          <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
          <span>Chatbot AI</span>
        </div>
        <div class="flex items-center gap-1.5">
          <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>
          <span>Live Chat Guru BK</span>
        </div>
      </div>
    </div>

  </div>

  <!-- Baris 1 di Bawah Grafik: Kategori Konsultasi BK & Status Penanganan Konseling -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Card 1: Kategori Konsultasi (4 Bidang Standar BK) -->
    <div class="bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between space-y-4">
      
      <div>
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-800">
          <div class="flex items-center gap-2.5">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-900/40">
              <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
              </svg>
            </span>
            <div>
              <h2 class="text-sm sm:text-base font-bold text-gray-900 dark:text-white">
                Kategori Konsultasi
              </h2>
              <p class="text-xs text-gray-500 dark:text-gray-400">
                Distribusi 4 bidang bimbingan standar BK
              </p>
            </div>
          </div>
          <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
            {{ $bkCategories['total'] ?? 0 }} sesi/pesan
          </span>
        </div>

        <!-- 4 Bidang Standar: Pribadi, Sosial, Belajar, Karir -->
        <div class="space-y-3.5 mt-4">
          @foreach($bkCategories['items'] as $item)
            <div class="p-3.5 rounded-xl bg-gray-50/70 dark:bg-gray-800/40 border border-gray-100 dark:border-gray-800/80 space-y-2">
              <div class="flex items-center justify-between text-xs">
                <div class="flex items-center gap-2">
                  <span class="h-2.5 w-2.5 rounded-full {{ $item['dot_color'] }}"></span>
                  <span class="font-bold text-gray-900 dark:text-white text-xs sm:text-sm">{{ $item['title'] }}</span>
                </div>
                <div class="flex items-center gap-2">
                  <span class="text-gray-500 dark:text-gray-400 font-mono">{{ $item['count'] }} pembahasan</span>
                  <span class="font-bold px-2 py-0.5 rounded-md text-[11px] {{ $item['badge'] }}">
                    {{ $item['percentage'] }}%
                  </span>
                </div>
              </div>
              <p class="text-[11px] text-gray-500 dark:text-gray-400">
                {{ $item['subtitle'] }}
              </p>
              <div class="w-full h-1.5 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                <div class="h-full rounded-full {{ $item['bar_color'] }}" style="width: {{ max(4, $item['percentage']) }}%"></div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="pt-2 border-t border-gray-100 dark:border-gray-800 text-right">
        <a href="{{ route('admin.laporan') }}" class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 hover:underline inline-flex items-center gap-1">
          <span>Lihat rincian laporan bidang BK</span>
          <span aria-hidden="true">&rarr;</span>
        </a>
      </div>

    </div>

    <!-- Card 2: Status Penanganan Konseling -->
    <div class="bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between space-y-4">
      
      <div>
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-800">
          <div class="flex items-center gap-2.5">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-900/40">
              <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
              </svg>
            </span>
            <div>
              <h2 class="text-sm sm:text-base font-bold text-gray-900 dark:text-white">
                Status Penanganan Konseling
              </h2>
              <p class="text-xs text-gray-500 dark:text-gray-400">
                Alur tahapan penanganan kasus bimbingan siswa
              </p>
            </div>
          </div>
          <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200/50">
            {{ $handlingStatus['total_cases'] ?? 0 }} Total Kasus
          </span>
        </div>

        <!-- 4 Tahapan Penanganan: Menunggu Respon, Sedang Ditangani, Selesai, Tindak Lanjut -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
          
          <!-- Tahap 1: Menunggu Respon -->
          <div class="p-3.5 rounded-xl bg-amber-50/50 dark:bg-amber-950/20 border border-amber-200/60 dark:border-amber-900/40 flex flex-col justify-between space-y-2">
            <div class="flex items-center justify-between">
              <span class="text-xs font-bold text-amber-900 dark:text-amber-200">{{ $handlingStatus['waiting']['title'] }}</span>
              <span class="text-lg font-black text-amber-600 dark:text-amber-400">{{ $handlingStatus['waiting']['count'] }}</span>
            </div>
            <p class="text-[11px] text-amber-700 dark:text-amber-300/80 leading-relaxed">
              {{ $handlingStatus['waiting']['subtitle'] }}
            </p>
            <div class="pt-1">
              <a href="{{ route('bk.live-chat') }}" class="text-[11px] font-semibold text-amber-800 dark:text-amber-300 hover:underline">
                Periksa antrean &rarr;
              </a>
            </div>
          </div>

          <!-- Tahap 2: Sedang Ditangani -->
          <div class="p-3.5 rounded-xl bg-blue-50/50 dark:bg-blue-950/20 border border-blue-200/60 dark:border-blue-900/40 flex flex-col justify-between space-y-2">
            <div class="flex items-center justify-between">
              <span class="text-xs font-bold text-blue-900 dark:text-blue-200">{{ $handlingStatus['in_progress']['title'] }}</span>
              <span class="text-lg font-black text-blue-600 dark:text-blue-400">{{ $handlingStatus['in_progress']['count'] }}</span>
            </div>
            <p class="text-[11px] text-blue-700 dark:text-blue-300/80 leading-relaxed">
              {{ $handlingStatus['in_progress']['subtitle'] }}
            </p>
            <div class="pt-1">
              <a href="{{ route('bk.live-chat') }}" class="text-[11px] font-semibold text-blue-800 dark:text-blue-300 hover:underline">
                Buka ruang chat &rarr;
              </a>
            </div>
          </div>

          <!-- Tahap 3: Selesai Ditangani -->
          <div class="p-3.5 rounded-xl bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-200/60 dark:border-emerald-900/40 flex flex-col justify-between space-y-2">
            <div class="flex items-center justify-between">
              <span class="text-xs font-bold text-emerald-900 dark:text-emerald-200">{{ $handlingStatus['completed']['title'] }}</span>
              <span class="text-lg font-black text-emerald-600 dark:text-emerald-400">{{ $handlingStatus['completed']['count'] }}</span>
            </div>
            <p class="text-[11px] text-emerald-700 dark:text-emerald-300/80 leading-relaxed">
              {{ $handlingStatus['completed']['subtitle'] }}
            </p>
            <div class="pt-1">
              <a href="{{ route('admin.laporan') }}" class="text-[11px] font-semibold text-emerald-800 dark:text-emerald-300 hover:underline">
                Buka rekap arsip &rarr;
              </a>
            </div>
          </div>

          <!-- Tahap 4: Tindak Lanjut / Rujukan -->
          <div class="p-3.5 rounded-xl bg-indigo-50/50 dark:bg-indigo-950/20 border border-indigo-200/60 dark:border-indigo-900/40 flex flex-col justify-between space-y-2">
            <div class="flex items-center justify-between">
              <span class="text-xs font-bold text-indigo-900 dark:text-indigo-200">{{ $handlingStatus['follow_up']['title'] }}</span>
              <span class="text-lg font-black text-indigo-600 dark:text-indigo-400">{{ $handlingStatus['follow_up']['count'] }}</span>
            </div>
            <p class="text-[11px] text-indigo-700 dark:text-indigo-300/80 leading-relaxed">
              {{ $handlingStatus['follow_up']['subtitle'] }}
            </p>
            <div class="pt-1">
              <a href="{{ route('bk.tes') }}" class="text-[11px] font-semibold text-indigo-800 dark:text-indigo-300 hover:underline">
                Kelola tindak lanjut &rarr;
              </a>
            </div>
          </div>

        </div>
      </div>

      <div class="pt-2 border-t border-gray-100 dark:border-gray-800 text-right">
        <a href="{{ route('admin.users') }}" class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 hover:underline inline-flex items-center gap-1">
          <span>Kelola data pengguna &amp; siswa</span>
          <span aria-hidden="true">&rarr;</span>
        </a>
      </div>

    </div>

  </div>

  <!-- Baris 2 di Bawah Grafik: Aktivitas Siswa & Topik Chatbot Terpopuler -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Kolom Kiri (~65% / 2 Cols): Aktivitas Siswa Terkini -->
    <div class="lg:col-span-2 bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl shadow-xs overflow-hidden flex flex-col justify-between">
      
      <div>
        <div class="p-5 sm:px-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
          <div class="flex items-center gap-2.5">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/40">
              <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </span>
            <div>
              <h2 class="text-base font-bold text-gray-900 dark:text-white">
                Aktivitas Siswa
              </h2>
              <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                Percakapan &amp; Konseling Terbaru serta pengerjaan asesmen terkini
              </p>
            </div>
          </div>
          <a href="{{ route('admin.laporan') }}" class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 hover:underline flex items-center gap-1">
            <span>Lihat semua</span>
            <span aria-hidden="true">&rarr;</span>
          </a>
        </div>

        <div class="divide-y divide-gray-100 dark:divide-gray-800">
          @forelse($studentActivities as $activity)
            <div class="p-4 sm:px-6 hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors flex items-center justify-between gap-4">
              <div class="flex items-center gap-3.5 min-w-0">
                
                <!-- Avatar Initial Siswa -->
                <div class="h-10 w-10 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-bold flex items-center justify-center shrink-0 border border-gray-200/60 dark:border-gray-700">
                  {{ $activity['avatar_letter'] }}
                </div>

                <div class="min-w-0 flex-1">
                  <div class="flex items-center gap-2 flex-wrap">
                    <span class="font-bold text-gray-900 dark:text-white text-xs sm:text-sm truncate">
                      {{ $activity['student_name'] }}
                    </span>
                    <span class="text-[11px] text-gray-500 dark:text-gray-400 font-mono">
                      {{ $activity['student_meta'] }}
                    </span>
                  </div>
                  <div class="text-xs text-gray-700 dark:text-gray-300 font-medium truncate mt-0.5">
                    {{ $activity['title'] }}
                  </div>
                  <div class="text-[11px] text-gray-500 dark:text-gray-400 truncate">
                    {{ $activity['detail'] }}
                  </div>
                </div>

              </div>

              <!-- Right: Waktu & Link Aksi -->
              <div class="text-right shrink-0">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                  {{ $activity['time_ago'] }}
                </span>
                <div class="mt-1">
                  <a href="{{ $activity['action_url'] }}" class="text-[11px] font-semibold text-emerald-700 dark:text-emerald-400 hover:underline">
                    Lihat detail &rarr;
                  </a>
                </div>
              </div>
            </div>
          @empty
            <div class="py-12 text-center text-gray-500 dark:text-gray-400 text-xs">
              Belum ada aktivitas siswa yang tercatat hari ini.
            </div>
          @endforelse
        </div>
      </div>

      <div class="p-4 border-t border-gray-100 dark:border-gray-800 text-right">
        <a href="{{ route('admin.laporan') }}" class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 hover:underline">
          Buka Rekapitulasi Laporan Lengkap &rarr;
        </a>
      </div>

    </div>

    <!-- Kolom Kanan (~35% / 1 Col): Topik Chatbot Terpopuler -->
    <div class="space-y-5">
      
      <!-- Topik Chatbot Terpopuler -->
      <div class="bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl p-5 shadow-xs space-y-4">
        
        <div class="flex items-center justify-between pb-2 border-b border-gray-100 dark:border-gray-800">
          <div class="flex items-center gap-2">
            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400">
              <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
              </svg>
            </span>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">
              Topik Chatbot Terpopuler
            </h3>
          </div>
          <span class="text-[11px] font-semibold text-gray-500 dark:text-gray-400">Minggu Ini</span>
        </div>

        @if(count($popularTopics) > 0 && array_sum(array_column($popularTopics, 'count')) > 0)
          <div class="space-y-3.5">
            @foreach($popularTopics as $topic)
              <div class="space-y-1.5">
                <div class="flex items-center justify-between text-xs">
                  <span class="font-medium text-gray-700 dark:text-gray-300 truncate max-w-[180px]">{{ $topic['title'] }}</span>
                  <span class="text-gray-500 dark:text-gray-400 font-mono">{{ $topic['count'] }} pesan ({{ $topic['percentage'] }}%)</span>
                </div>
                <div class="w-full h-2 rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                  <div class="h-full rounded-full {{ $topic['color'] }}" style="width: {{ max(6, $topic['percentage']) }}%"></div>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div class="py-8 text-center text-xs text-gray-500 dark:text-gray-400">
            Belum ada topik pertanyaan siswa minggu ini.
          </div>
        @endif

        <!-- Kata Kunci Populer Siswa -->
        <div class="pt-3 border-t border-gray-100 dark:border-gray-800 space-y-2">
          <div class="text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
            Kata Kunci Sering Ditanyakan
          </div>
          <div class="flex flex-wrap gap-1.5">
            <span class="px-2 py-0.5 rounded-md text-[11px] font-semibold bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300">SNBT / SNBP</span>
            <span class="px-2 py-0.5 rounded-md text-[11px] font-semibold bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300">Jurusan Kuliah</span>
            <span class="px-2 py-0.5 rounded-md text-[11px] font-semibold bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300">Stres Belajar</span>
            <span class="px-2 py-0.5 rounded-md text-[11px] font-semibold bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300">Teman Sebaya</span>
            <span class="px-2 py-0.5 rounded-md text-[11px] font-semibold bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300">Minat &amp; Karir</span>
          </div>
        </div>

      </div>

      <!-- Quick Shortcuts (Aksi Cepat Admin) -->
      <div class="bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl p-5 shadow-xs space-y-3">
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Aksi Cepat Administrator</h3>
        
        <div class="space-y-2">
          <a
            href="{{ route('admin.users') }}"
            class="w-full min-h-[42px] px-4 py-2.5 rounded-xl bg-[#205A26] hover:bg-[#16421c] text-white font-semibold text-xs inline-flex items-center justify-center gap-2 shadow-xs transition-colors"
          >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            <span>Kelola Akun Pengguna</span>
          </a>

          <a
            href="{{ route('admin.konfigurasi') }}"
            class="w-full min-h-[40px] px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-750 text-gray-800 dark:text-gray-200 font-semibold text-xs inline-flex items-center justify-center gap-2 transition-colors"
          >
            <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Konfigurasi Model AI &amp; RAG</span>
          </a>
        </div>
      </div>

    </div>

  </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  function adminDashboard() {
    return {
      period: 'month',
      chartInstance: null,
      trendData: @json($trendData),

      get activePeriodData() {
        if (this.trendData && this.trendData.periods && this.trendData.periods[this.period]) {
          return this.trendData.periods[this.period];
        }
        return {
          ai_count: 0,
          live_count: 0,
          total_count: 0,
          pct_ai: '+0.0%',
          pct_live: '+0.0%',
          pct_total: '+0.0%',
          pct_ai_badge: '0.0%',
          pct_live_badge: '0.0%',
          pct_total_badge: '0.0%',
          pct_val_ai: 0,
          pct_val_live: 0,
          pct_val_total: 0,
          comparison_text: 'Stabil dibanding periode sebelumnya',
          labels: [],
          ai: [],
          live: []
        };
      },

      init() {
        this.$nextTick(() => {
          this.initChart();
        });
      },

      switchPeriod(newPeriod) {
        if (this.period === newPeriod) return;
        this.period = newPeriod;
        this.updateChart();
      },

      initChart() {
        const ctx = document.getElementById('adminTrendChart');
        if (!ctx) return;

        const isDark = document.documentElement.classList.contains('dark');
        const activeData = this.activePeriodData;
        const gridColor = isDark ? 'rgba(51, 65, 85, 0.35)' : 'rgba(226, 232, 240, 0.7)';
        const tickColor = isDark ? '#94a3b8' : '#64748b';

        // Buat gradien halus
        const ctx2d = ctx.getContext('2d');
        const greenGradient = ctx2d.createLinearGradient(0, 0, 0, 260);
        greenGradient.addColorStop(0, 'rgba(16, 185, 129, 0.28)');
        greenGradient.addColorStop(1, 'rgba(16, 185, 129, 0.01)');

        const blueGradient = ctx2d.createLinearGradient(0, 0, 0, 260);
        blueGradient.addColorStop(0, 'rgba(59, 130, 246, 0.25)');
        blueGradient.addColorStop(1, 'rgba(59, 130, 246, 0.01)');

        this.chartInstance = new Chart(ctx, {
          type: 'line',
          data: {
            labels: activeData.labels || [],
            datasets: [
              {
                label: 'Chatbot AI',
                data: activeData.ai || [],
                borderColor: '#10b981',
                backgroundColor: greenGradient,
                borderWidth: 2.5,
                pointRadius: 3,
                pointHoverRadius: 6,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 1.5,
                tension: 0.4,
                fill: true
              },
              {
                label: 'Live Chat Guru BK',
                data: activeData.live || [],
                borderColor: '#3b82f6',
                backgroundColor: blueGradient,
                borderWidth: 2.5,
                pointRadius: 3,
                pointHoverRadius: 6,
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 1.5,
                tension: 0.4,
                fill: true
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
              intersect: false,
              mode: 'index'
            },
            plugins: {
              legend: {
                display: false
              },
              tooltip: {
                enabled: true,
                backgroundColor: 'rgba(15, 23, 42, 0.94)',
                titleColor: '#ffffff',
                bodyColor: '#cbd5e1',
                borderColor: 'rgba(255, 255, 255, 0.1)',
                borderWidth: 1,
                padding: 12,
                cornerRadius: 12,
                displayColors: true,
                boxWidth: 8,
                boxHeight: 8,
                usePointStyle: true,
                titleFont: { size: 12, weight: 'bold' },
                bodyFont: { size: 12 },
                callbacks: {
                  title: (items) => {
                    const label = items[0]?.label || '';
                    return label + (this.period === 'month' ? ' Okt 2026' : '');
                  },
                  label: (context) => {
                    return ' ' + context.dataset.label + ': ' + context.parsed.y;
                  },
                  footer: (items) => {
                    const total = items.reduce((acc, curr) => acc + curr.parsed.y, 0);
                    return 'Total: ' + total;
                  }
                },
                footerColor: '#34d399',
                footerFont: { size: 12, weight: 'bold' },
                footerMarginTop: 6
              }
            },
            scales: {
              x: {
                grid: {
                  color: gridColor,
                  drawBorder: false
                },
                ticks: {
                  color: tickColor,
                  font: { size: 11, weight: '500' }
                }
              },
              y: {
                beginAtZero: true,
                suggestedMax: 10,
                grid: {
                  color: gridColor,
                  drawBorder: false
                },
                ticks: {
                  precision: 0,
                  color: tickColor,
                  font: { size: 11 }
                }
              }
            }
          }
        });
      },

      updateChart() {
        if (!this.chartInstance) return;

        const activeData = this.activePeriodData;
        this.chartInstance.data.labels = activeData.labels || [];
        this.chartInstance.data.datasets[0].data = activeData.ai || [];
        this.chartInstance.data.datasets[1].data = activeData.live || [];
        this.chartInstance.update();
      }
    };
  }
</script>
@endpush
