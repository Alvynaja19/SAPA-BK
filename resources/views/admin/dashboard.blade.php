@extends('layouts.tailadmin')

@section('title', 'Dashboard Administrator | SAPA BK SMAN 4 Jember')

@section('content')
<div class="space-y-6" x-data="adminDashboard()">

  <!-- Page Title Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <div>
      <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white tracking-tight">
        Dashboard
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
        Ringkasan analitik asisten cerdas AI, statistik live chat konseling Guru BK, dan infrastruktur sistem SAPA BK.
      </p>
    </div>

    <!-- System Health Status Badge -->
    <div class="flex items-center gap-2">
      <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/40">
        <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse" aria-hidden="true"></span>
        <span>Sistem Berjalan Normal</span>
      </span>
    </div>
  </div>

  <!-- 4 Top Metric Cards (Matches Mockup) -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
    
    <!-- Card 1: Anggota / Siswa Aktif (Soft Blue Icon) -->
    <div class="bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl p-5 shadow-xs flex items-center gap-4">
      <div class="h-12 w-12 rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400 flex items-center justify-center shrink-0">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
      </div>
      <div class="min-w-0 flex-1">
        <div class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white leading-tight">
          {{ number_format($stats['total_siswa'] ?? 0) }}
        </div>
        <div class="text-xs text-gray-500 dark:text-gray-400 font-medium truncate mt-0.5">
          Siswa Aktif ({{ number_format($stats['total_users'] ?? 0) }} Total Akun)
        </div>
      </div>
    </div>

    <!-- Card 2: Konsultasi Chatbot AI (Soft Amber Icon) -->
    <div class="bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl p-5 shadow-xs flex items-center gap-4">
      <div class="h-12 w-12 rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-950/60 dark:text-amber-400 flex items-center justify-center shrink-0">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
      </div>
      <div class="min-w-0 flex-1">
        <div class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white leading-tight">
          {{ number_format($stats['total_ai_sessions'] ?? 0) }}
        </div>
        <div class="text-xs text-gray-500 dark:text-gray-400 font-medium truncate mt-0.5">
          Konsultasi Chatbot AI
        </div>
      </div>
    </div>

    <!-- Card 3: Sesi Live Chat Guru BK (Soft Red/Rose Icon) -->
    <div class="bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl p-5 shadow-xs flex items-center gap-4">
      <div class="h-12 w-12 rounded-xl bg-rose-50 text-rose-600 dark:bg-rose-950/60 dark:text-rose-400 flex items-center justify-center shrink-0">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
        </svg>
      </div>
      <div class="min-w-0 flex-1">
        <div class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white leading-tight">
          {{ number_format($stats['total_live_sessions'] ?? 0) }}
        </div>
        <div class="text-xs text-gray-500 dark:text-gray-400 font-medium truncate mt-0.5">
          Live Chat Guru BK
        </div>
      </div>
    </div>

    <!-- Card 4: Total Interaksi Pesan (Soft Emerald Icon) -->
    <div class="bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl p-5 shadow-xs flex items-center gap-4">
      <div class="h-12 w-12 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-400 flex items-center justify-center shrink-0">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
      </div>
      <div class="min-w-0 flex-1">
        <div class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white leading-tight">
          {{ number_format($stats['total_messages'] ?? 0) }}
        </div>
        <div class="text-xs text-gray-500 dark:text-gray-400 font-medium truncate mt-0.5">
          Total Pesan ({{ $stats['total_knowledge'] ?? 0 }} Dokumen RAG)
        </div>
      </div>
    </div>

  </div>

  <!-- Wide Card: Tren Konsultasi Siswa (Chatbot AI & Live Chat Guru BK Terpadu) -->
  <div class="bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl p-4 sm:p-5 shadow-xs space-y-3.5">
    
    <!-- Chart Header & Controls -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-gray-100 dark:border-gray-800">
      
      <!-- Title & Subtitle -->
      <div class="space-y-0.5">
        <div class="flex items-center gap-2">
          <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400">
            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
          </span>
          <h2 class="text-sm sm:text-base font-bold text-gray-900 dark:text-white">Tren Konsultasi Siswa</h2>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400">
          Chatbot AI vs Live Chat Guru BK
        </p>
      </div>

      <!-- Controls: Legend with Sesi Count & Period Toggle -->
      <div class="flex flex-wrap items-center gap-3 sm:gap-5">
        
        <!-- Legend & Counts -->
        <div class="flex items-center gap-3.5 text-xs font-medium text-gray-700 dark:text-gray-300">
          <div class="flex items-center gap-1.5">
            <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
            <span>Chatbot AI: <strong class="text-gray-900 dark:text-white">{{ $trendData['summary']['ai']['total_current_month'] ?? 0 }}</strong></span>
          </div>
          <div class="flex items-center gap-1.5">
            <span class="inline-block w-2.5 h-2.5 rounded-full bg-slate-700 dark:bg-slate-400"></span>
            <span>Live Chat: <strong class="text-gray-900 dark:text-white">{{ $trendData['summary']['live']['total_current_month'] ?? 0 }}</strong></span>
          </div>
          <div class="hidden md:flex items-center gap-1.5 text-gray-500 dark:text-gray-400 border-l border-gray-200 dark:border-gray-700 pl-3">
            <span>Total: <strong class="text-gray-900 dark:text-white">{{ $trendData['summary']['total_current_month'] }}</strong></span>
          </div>
        </div>

        <!-- Period Toggle (Minggu, Bulan, Tahun) -->
        <div class="inline-flex p-0.5 rounded-lg bg-gray-100 dark:bg-gray-800 text-xs font-semibold text-gray-600 dark:text-gray-300">
          <button
            type="button"
            @click="switchPeriod('week')"
            :class="period === 'week' ? 'bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-xs' : 'hover:text-gray-900 dark:hover:text-white'"
            class="px-2.5 py-1 rounded-md transition-all"
          >
            Minggu
          </button>
          <button
            type="button"
            @click="switchPeriod('month')"
            :class="period === 'month' ? 'bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-xs' : 'hover:text-gray-900 dark:hover:text-white'"
            class="px-2.5 py-1 rounded-md transition-all"
          >
            Bulan
          </button>
          <button
            type="button"
            @click="switchPeriod('year')"
            :class="period === 'year' ? 'bg-white dark:bg-gray-900 text-gray-900 dark:text-white shadow-xs' : 'hover:text-gray-900 dark:hover:text-white'"
            class="px-2.5 py-1 rounded-md transition-all"
          >
            Tahun
          </button>
        </div>

      </div>
    </div>

    <!-- Chart Canvas (Kompak) -->
    <div class="relative w-full h-[200px]">
      <canvas id="adminTrendChart" class="w-full h-full"></canvas>
    </div>

  </div>

  <!-- Bottom Section: 2 Columns Grid (Table ~65% & Side Cards ~35%) -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Left Column: Percakapan & Konseling Terbaru (2 Columns on Large Screens) -->
    <div class="lg:col-span-2 bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl shadow-xs overflow-hidden flex flex-col justify-between">
      <div>
        <div class="p-5 sm:px-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
          <div>
            <h2 class="text-base font-bold text-gray-900 dark:text-white">Percakapan &amp; Konseling Terbaru</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">10 sesi percakapan terakhir (Chatbot AI &amp; Live Chat)</p>
          </div>
          <a href="{{ route('admin.laporan') }}" class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 hover:underline flex items-center gap-1">
            <span>Lihat semua</span>
            <span aria-hidden="true">&rarr;</span>
          </a>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="border-b border-gray-100 dark:border-gray-800 text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50/50 dark:bg-gray-800/30">
                <th class="py-3.5 px-6">Anggota / Siswa</th>
                <th class="py-3.5 px-6">Layanan</th>
                <th class="py-3.5 px-6">Waktu</th>
                <th class="py-3.5 px-6 text-center">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-xs">
              @forelse($recentSessions as $session)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
                  <!-- Siswa / Anggota -->
                  <td class="py-3.5 px-6">
                    <div class="font-bold text-gray-900 dark:text-white uppercase tracking-tight">
                      {{ $session->user?->name ?? 'Siswa Tamu' }}
                    </div>
                    <div class="text-[11px] text-gray-500 dark:text-gray-400 font-mono mt-0.5">
                      {{ $session->user?->nisn ? 'NISN: ' . $session->user->nisn : ($session->user?->kelas ? 'Kelas ' . $session->user->kelas : 'Sesi #' . $session->id) }}
                    </div>
                  </td>

                  <!-- Layanan (Chatbot AI vs Live Chat) -->
                  <td class="py-3.5 px-6 font-medium text-gray-800 dark:text-gray-200">
                    @if($session->mode === 'guru_bk')
                      <div class="flex items-center gap-1.5 text-slate-800 dark:text-slate-200 font-semibold">
                        <span class="h-2 w-2 rounded-full bg-slate-700 dark:bg-slate-300"></span>
                        <span>Live Chat Guru BK</span>
                      </div>
                      <div class="text-[11px] text-gray-500 dark:text-gray-400 truncate max-w-[180px]">
                        {{ $session->title ?: 'Konsultasi Interaktif' }}
                      </div>
                    @else
                      <div class="flex items-center gap-1.5 text-emerald-700 dark:text-emerald-400 font-semibold">
                        <span class="h-2 w-2 rounded-full bg-emerald-600"></span>
                        <span>Chatbot AI</span>
                      </div>
                      <div class="text-[11px] text-gray-500 dark:text-gray-400 truncate max-w-[180px]">
                        {{ $session->title ?: 'Tanya Jawab AI' }}
                      </div>
                    @endif
                  </td>

                  <!-- Waktu -->
                  <td class="py-3.5 px-6 text-gray-600 dark:text-gray-400 whitespace-nowrap">
                    <div>{{ $session->created_at->translatedFormat('d M Y') }}</div>
                    <div class="text-[11px] text-gray-500 dark:text-gray-400 font-mono">{{ $session->created_at->format('H:i') }} WIB</div>
                  </td>

                  <!-- Status -->
                  <td class="py-3.5 px-6 text-center">
                    @if($session->status === 'active')
                      <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300">
                        Aktif
                      </span>
                    @else
                      <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300">
                        Selesai
                      </span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="py-8 text-center text-gray-500 dark:text-gray-400 text-xs">
                    Belum ada riwayat percakapan sistem.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div class="p-4 border-t border-gray-100 dark:border-gray-800 text-right">
        <a href="{{ route('admin.laporan') }}" class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 hover:underline">
          Buka Rekapitulasi Laporan Lengkap &rarr;
        </a>
      </div>
    </div>

    <!-- Right Column: 3 Stacked Cards (Topik Terpopuler, Status Layanan, Aksi Cepat) -->
    <div class="space-y-5">
      
      <!-- Card 1: Topik Konseling Terpopuler (Star Icon) -->
      <div class="bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl p-5 shadow-xs space-y-4">
        <div class="flex items-center gap-2">
          <span class="text-amber-500 text-base" aria-hidden="true">&#9733;</span>
          <h3 class="text-sm font-bold text-gray-900 dark:text-white">Topik Terpopuler Minggu Ini</h3>
        </div>

        @if(count($popularTopics) > 0 && array_sum(array_column($popularTopics, 'count')) > 0)
          <div class="space-y-3">
            @foreach($popularTopics as $topic)
              <div class="space-y-1">
                <div class="flex items-center justify-between text-xs">
                  <span class="font-medium text-gray-700 dark:text-gray-300 truncate">{{ $topic['title'] }}</span>
                  <span class="text-gray-500 dark:text-gray-400 font-mono">{{ $topic['count'] }} pesan</span>
                </div>
                <div class="w-full h-2 rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                  <div class="h-full rounded-full {{ $topic['color'] }}" style="width: {{ max(6, $topic['percentage']) }}%"></div>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div class="py-6 text-center text-xs text-gray-500 dark:text-gray-400">
            Belum ada topik konseling minggu ini.
          </div>
        @endif
      </div>

      <!-- Card 2: Kondisi Layanan & Sesi Aktif -->
      <div class="bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl p-5 shadow-xs space-y-3">
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">
          Sesi Aktif &amp; Kondisi Layanan
        </h3>

        <div class="space-y-2 text-xs">
          <div class="flex items-center justify-between py-1.5 border-b border-gray-100 dark:border-gray-800">
            <span class="text-gray-500 dark:text-gray-400">Live Chat Berjalan</span>
            <span class="font-bold text-gray-900 dark:text-white">{{ $stats['active_live_sessions'] ?? 0 }} sesi</span>
          </div>
          <div class="flex items-center justify-between py-1.5 border-b border-gray-100 dark:border-gray-800">
            <span class="text-gray-500 dark:text-gray-400">Model AI LLM</span>
            <span class="font-bold text-emerald-700 dark:text-emerald-400">Gemini 2.0 Flash</span>
          </div>
          <div class="flex items-center justify-between py-1.5">
            <span class="text-gray-500 dark:text-gray-400">Vector Store RAG</span>
            <span class="font-bold text-emerald-700 dark:text-emerald-400">Normal &amp; Terhubung</span>
          </div>
        </div>

        <div class="pt-1">
          <a
            href="{{ route('admin.log') }}"
            class="w-full py-2 px-3 text-center rounded-xl bg-gray-100 dark:bg-gray-800 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors block"
          >
            System Activity Log
          </a>
        </div>
      </div>

      <!-- Card 3: Aksi Cepat (Primary Green Button) -->
      <div class="bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl p-5 shadow-xs space-y-3">
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Aksi Cepat</h3>
        
        <div class="space-y-2">
          <!-- Primary Green Action Button -->
          <a
            href="{{ route('admin.users') }}"
            class="w-full min-h-[42px] px-4 py-2.5 rounded-xl bg-[#205A26] hover:bg-[#16421c] text-white font-semibold text-xs inline-flex items-center justify-center gap-2 shadow-xs transition-colors"
          >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            <span>Kelola Akun Pengguna</span>
          </a>

          <!-- Secondary Action Button -->
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

      init() {
        this.$nextTick(() => {
          this.initChart();
        });
      },

      switchPeriod(newPeriod) {
        this.period = newPeriod;
        this.updateChart();
      },

      initChart() {
        const ctx = document.getElementById('adminTrendChart');
        if (!ctx) return;

        const isDark = document.documentElement.classList.contains('dark');
        const activeData = this.trendData[this.period];
        const gridColor = isDark ? 'rgba(51, 65, 85, 0.3)' : 'rgba(226, 232, 240, 0.7)';
        const tickColor = isDark ? '#94a3b8' : '#64748b';

        this.chartInstance = new Chart(ctx, {
          type: 'line',
          data: {
            labels: activeData.labels,
            datasets: [
              {
                label: 'Chatbot AI',
                data: activeData.ai,
                borderColor: '#16a34a', // emerald-600
                backgroundColor: 'rgba(22, 163, 74, 0.08)',
                borderWidth: 2.2,
                pointRadius: 2.5,
                pointHoverRadius: 5,
                pointBackgroundColor: '#16a34a',
                tension: 0.35,
                fill: true
              },
              {
                label: 'Live Chat Guru BK',
                data: activeData.live,
                borderColor: isDark ? '#94a3b8' : '#334155', // slate-700
                backgroundColor: isDark ? 'rgba(148, 163, 184, 0.06)' : 'rgba(51, 65, 85, 0.04)',
                borderWidth: 2.2,
                borderDash: [4, 4],
                pointRadius: 2.5,
                pointHoverRadius: 5,
                pointBackgroundColor: isDark ? '#94a3b8' : '#334155',
                tension: 0.35,
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
                backgroundColor: isDark ? '#0f172a' : '#1e293b',
                titleColor: '#ffffff',
                bodyColor: '#cbd5e1',
                padding: 10,
                cornerRadius: 8,
                boxPadding: 4,
                callbacks: {
                  title: function(items) {
                    return 'Periode: ' + items[0].label;
                  },
                  label: function(item) {
                    return item.dataset.label + ': ' + item.raw + ' sesi';
                  }
                }
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
                  font: {
                    size: 11,
                    family: 'Plus Jakarta Sans'
                  },
                  maxTicksLimit: 12
                }
              },
              y: {
                beginAtZero: true,
                suggestedMax: 5,
                grid: {
                  color: gridColor,
                  drawBorder: false
                },
                ticks: {
                  precision: 0,
                  color: tickColor,
                  font: {
                    size: 11,
                    family: 'Plus Jakarta Sans'
                  }
                }
              }
            }
          }
        });
      },

      updateChart() {
        if (!this.chartInstance) return;
        const activeData = this.trendData[this.period];
        this.chartInstance.data.labels = activeData.labels;
        this.chartInstance.data.datasets[0].data = activeData.ai;
        this.chartInstance.data.datasets[1].data = activeData.live;
        this.chartInstance.update();
      }
    };
  }
</script>
@endpush
