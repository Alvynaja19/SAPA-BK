@extends('layouts.tailadmin')

@section('title', 'Dashboard Administrator | SAPA BK SMAN 4 Jember')

@section('content')
<div class="space-y-6" x-data="adminDashboard()">

  <!-- Page Title Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <div>
      <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white tracking-tight">
        Dashboard Administrator
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
        Pusat monitoring bimbingan konseling, performa asisten cerdas AI, dan audit layanan terpadu SMA Negeri 4 Jember.
      </p>
    </div>

    <!-- Status Layanan -->
    <div class="flex items-center gap-2">
      <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/40">
        <span class="h-2 w-2 rounded-full bg-emerald-500" aria-hidden="true"></span>
        <span>Sistem SAPA BK Aktif</span>
      </span>
    </div>
  </div>

  <!-- Styling Khusus Kartu Gradient Able & Activity Feed -->
  <style>
    .order-card {
      color: #ffffff;
      border-radius: 1rem;
      position: relative;
      overflow: hidden;
      box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.08);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .order-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px -4px rgba(15, 23, 42, 0.14);
    }
    .order-card .card-body {
      padding: 1.25rem 1.35rem;
    }
    .bg-grd-primary {
      background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 50%, #3b82f6 100%);
    }
    .bg-grd-success {
      background: linear-gradient(135deg, #047857 0%, #059669 50%, #10b981 100%);
    }
    .bg-grd-warning {
      background: linear-gradient(135deg, #b45309 0%, #d97706 50%, #f59e0b 100%);
    }
    .bg-grd-danger {
      background: linear-gradient(135deg, #be123c 0%, #e11d48 50%, #f43f5e 100%);
    }
    .feed-blog {
      border-left: 2px solid #e2e8f0;
      margin-left: 20px;
      padding-left: 24px;
      position: relative;
    }
    .dark .feed-blog {
      border-left-color: #334155;
    }
    .feed-item {
      position: relative;
      padding-bottom: 1.5rem;
    }
    .feed-item:last-child {
      padding-bottom: 0;
    }
    .feed-user-avatar {
      position: absolute;
      left: -37px;
      top: 0;
      width: 26px;
      height: 26px;
      border-radius: 9999px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 11px;
      border: 2px solid #ffffff;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
    }
    .dark .feed-user-avatar {
      border-color: #111827;
    }
  </style>

  <!-- 1. Empat Kartu Metrik Utama Gradient Able (Order Cards) -->
  <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-5">
    
    <!-- Kartu 1: Konsultasi Chatbot AI (Blue Gradient) -->
    <div class="order-card bg-grd-primary">
      <div class="card-body">
        <h6 class="text-xs font-semibold text-white/90 uppercase tracking-wider mb-2">
          Konsultasi Chatbot AI
        </h6>
        <div class="flex items-center justify-between my-2">
          <i class="ti ti-robot text-3xl sm:text-4xl text-white/80" aria-hidden="true"></i>
          <span class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight" x-text="activePeriodData.ai_count">
            {{ number_format($stats['total_ai_sessions'] ?? 0) }}
          </span>
        </div>
        <div class="flex items-center justify-between text-xs text-white/90 pt-2 border-t border-white/20 mt-2">
          <span>Sesi Terselesaikan</span>
          <span class="font-bold font-mono" x-text="activePeriodData.pct_ai_badge || '+0.0%'">
            +0.0%
          </span>
        </div>
      </div>
    </div>

    <!-- Kartu 2: Live Chat Guru BK (Green Gradient) -->
    <div class="order-card bg-grd-success">
      <div class="card-body">
        <h6 class="text-xs font-semibold text-white/90 uppercase tracking-wider mb-2">
          Live Chat Guru BK
        </h6>
        <div class="flex items-center justify-between my-2">
          <i class="ti ti-headset text-3xl sm:text-4xl text-white/80" aria-hidden="true"></i>
          <span class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight" x-text="activePeriodData.live_count">
            {{ number_format($stats['total_live_sessions'] ?? 0) }}
          </span>
        </div>
        <div class="flex items-center justify-between text-xs text-white/90 pt-2 border-t border-white/20 mt-2">
          <span>Total Sesi Guru BK</span>
          <span class="font-bold font-mono" x-text="activePeriodData.pct_live_badge || '+0.0%'">
            +0.0%
          </span>
        </div>
      </div>
    </div>

    <!-- Kartu 3: Total Siswa Terdaftar (Amber Gradient) -->
    <div class="order-card bg-grd-warning">
      <div class="card-body">
        <h6 class="text-xs font-semibold text-white/90 uppercase tracking-wider mb-2">
          Total Siswa Terdaftar
        </h6>
        <div class="flex items-center justify-between my-2">
          <i class="ti ti-school text-3xl sm:text-4xl text-white/80" aria-hidden="true"></i>
          <span class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
            {{ number_format($stats['total_siswa'] ?? 0) }}
          </span>
        </div>
        <div class="flex items-center justify-between text-xs text-white/90 pt-2 border-t border-white/20 mt-2">
          <span>Dari {{ number_format($stats['total_users'] ?? 0) }} Akun</span>
          <span class="font-semibold">SMAN 4 Jember</span>
        </div>
      </div>
    </div>

    <!-- Kartu 4: Kasus Ditangani & Tuntas (Red/Rose Gradient) -->
    <div class="order-card bg-grd-danger">
      <div class="card-body">
        <h6 class="text-xs font-semibold text-white/90 uppercase tracking-wider mb-2">
          Status Penanganan Tuntas
        </h6>
        <div class="flex items-center justify-between my-2">
          <i class="ti ti-circle-check text-3xl sm:text-4xl text-white/80" aria-hidden="true"></i>
          <span class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
            {{ number_format($handlingStatus['completed']['count'] ?? $stats['total_sessions'] ?? 0) }}
          </span>
        </div>
        <div class="flex items-center justify-between text-xs text-white/90 pt-2 border-t border-white/20 mt-2">
          <span>Tingkat Penyelesaian</span>
          <span class="font-bold">{{ $handlingStatus['completed']['percentage'] ?? 100 }}% Kasus</span>
        </div>
      </div>
    </div>

  </div>

  <!-- 2. Baris Grafik Utama: Tren Konsultasi (Unique Visitor Style) & Donut Customer Analytics -->
  <div class="grid grid-cols-1 xl:grid-cols-12 gap-5 sm:gap-6">
    
    <!-- Kolom Kiri (~60% / xl:col-span-7): Tren Konsultasi Siswa (Line Chart) -->
    <div class="xl:col-span-7 bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl p-5 shadow-xs flex flex-col justify-between space-y-4">
      
      <div>
        <!-- Header & Segmented Pill Selector -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-gray-100 dark:border-gray-800">
          <div>
            <h2 class="text-base font-bold text-gray-900 dark:text-white tracking-tight">
              Tren Konsultasi Siswa
            </h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
              Perkembangan sesi konsultasi Chatbot AI vs Live Chat Guru BK
            </p>
          </div>

          <!-- Periode Switcher -->
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

        <!-- Legend (Model Dot Arts & Commerce pada Gradient Able) -->
        <div class="flex items-center justify-end gap-5 pt-3 pb-1 text-xs font-medium text-gray-600 dark:text-gray-300">
          <div class="flex items-center gap-1.5">
            <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>
            <span>Chatbot AI</span>
          </div>
          <div class="flex items-center gap-1.5">
            <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
            <span>Live Chat Guru BK</span>
          </div>
        </div>

        <!-- Line Chart Canvas -->
        <div class="relative w-full h-[230px] sm:h-[260px] pt-1">
          <canvas id="adminTrendChart" class="w-full h-full"></canvas>
        </div>
      </div>

      <!-- Footer Perbandingan Periode -->
      <div class="pt-3 border-t border-gray-100 dark:border-gray-800 text-xs font-medium text-emerald-700 dark:text-emerald-400 flex items-center justify-between">
        <span x-text="activePeriodData.comparison_text">
          {{ $trendData['periods']['month']['comparison_text'] ?? 'Perkembangan konsultasi stabil' }}
        </span>
        <span class="text-gray-400 dark:text-gray-500 text-[11px]" x-text="activePeriodData.period_subtitle"></span>
      </div>

    </div>

    <!-- Kolom Kanan (~40% / xl:col-span-5): 2 Donut Cards (Customers Style) -->
    <div class="xl:col-span-5 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-1 gap-4">
      
      <!-- Donut Card 1: Rasio Layanan Konseling (Light Surface Card) -->
      <div class="bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl p-4 sm:p-5 shadow-xs flex flex-col justify-between">
        <div class="flex items-center justify-between">
          <span class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
            Rasio Layanan
          </span>
          <div class="text-right">
            <span class="text-lg sm:text-xl font-extrabold text-gray-900 dark:text-white">
              {{ number_format($stats['total_sessions'] ?? 0) }}
            </span>
            <span class="block text-[11px] font-semibold text-emerald-600 dark:text-emerald-400">
              {{ $trendData['periods']['month']['pct_total'] ?? '+0.0%' }}
              <i class="ti ti-trending-up ml-0.5" aria-hidden="true"></i>
            </span>
          </div>
        </div>

        <!-- Donut Chart 1 Canvas -->
        <div class="relative w-full h-[140px] my-2 flex items-center justify-center">
          <canvas id="adminRatioDonutChart" class="max-h-[140px]"></canvas>
        </div>

        <!-- Breakdown Counters -->
        <div class="grid grid-cols-2 gap-2 pt-2 border-t border-gray-100 dark:border-gray-800 text-center text-xs">
          <div class="p-1">
            <div class="flex items-center justify-center gap-1.5 font-bold text-gray-900 dark:text-white text-sm">
              <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
              <span>{{ number_format($stats['total_ai_sessions'] ?? 0) }}</span>
            </div>
            <span class="text-[11px] text-gray-500 dark:text-gray-400">Chatbot AI</span>
          </div>
          <div class="p-1 border-l border-gray-100 dark:border-gray-800">
            <div class="flex items-center justify-center gap-1.5 font-bold text-gray-900 dark:text-white text-sm">
              <span class="h-2 w-2 rounded-full bg-blue-500"></span>
              <span>{{ number_format($stats['total_live_sessions'] ?? 0) }}</span>
            </div>
            <span class="text-[11px] text-gray-500 dark:text-gray-400">Live Guru BK</span>
          </div>
        </div>
      </div>

      <!-- Donut Card 2: Status Penanganan Kasus (Vibrant Primary Style) -->
      <div class="bg-gradient-to-br from-blue-600 to-indigo-700 text-white rounded-2xl p-4 sm:p-5 shadow-xs flex flex-col justify-between">
        <div class="flex items-center justify-between">
          <span class="text-xs font-bold text-white/90 uppercase tracking-wider">
            Alur Penanganan
          </span>
          <div class="text-right">
            <span class="text-lg sm:text-xl font-extrabold text-white">
              {{ number_format($handlingStatus['total_cases'] ?? 0) }}
            </span>
            <span class="block text-[11px] font-semibold text-emerald-300">
              {{ $handlingStatus['completed']['percentage'] ?? 100 }}% Tuntas
              <i class="ti ti-check ml-0.5" aria-hidden="true"></i>
            </span>
          </div>
        </div>

        <!-- Donut Chart 2 Canvas -->
        <div class="relative w-full h-[140px] my-2 flex items-center justify-center">
          <canvas id="adminStatusDonutChart" class="max-h-[140px]"></canvas>
        </div>

        <!-- Breakdown Counters -->
        <div class="grid grid-cols-2 gap-2 pt-2 border-t border-white/20 text-center text-xs">
          <div class="p-1">
            <div class="flex items-center justify-center gap-1.5 font-bold text-white text-sm">
              <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
              <span>{{ number_format($handlingStatus['completed']['count'] ?? 0) }}</span>
            </div>
            <span class="text-[11px] text-white/80">Tuntas</span>
          </div>
          <div class="p-1 border-l border-white/20">
            <div class="flex items-center justify-center gap-1.5 font-bold text-white text-sm">
              <span class="h-2 w-2 rounded-full bg-blue-200"></span>
              <span>{{ number_format(($handlingStatus['in_progress']['count'] ?? 0) + ($handlingStatus['waiting']['count'] ?? 0)) }}</span>
            </div>
            <span class="text-[11px] text-white/80">Dalam Proses</span>
          </div>
        </div>
      </div>

    </div>

  </div>

  <!-- 3. Baris Ketiga: Quick Widget Cards & Activity Feed (Gradient Able Style) -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6">
    
    <!-- Kolom Kiri (lg:col-span-4): Dua Widget Aksi Cepat (Model Subscribers & Followers) -->
    <div class="lg:col-span-4 space-y-4 sm:space-y-5">
      
      <!-- Widget 1: Manajemen Akun Pengguna -->
      <div class="bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl p-5 shadow-xs text-center flex flex-col items-center justify-between">
        <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center mb-3 border border-blue-100 dark:border-blue-900/40">
          <i class="ti ti-users-group text-2xl" aria-hidden="true"></i>
        </div>
        <div class="mb-3">
          <h3 class="text-xl sm:text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">
            {{ number_format($stats['total_users'] ?? 0) }} Pengguna
          </h3>
          <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 mt-0.5">
            Manajemen Akun Siswa &amp; Guru
          </p>
          <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">
            {{ $stats['total_siswa'] ?? 0 }} Siswa, {{ $stats['total_guru_bk'] ?? 0 }} Guru BK, {{ $stats['total_admin'] ?? 0 }} Admin
          </p>
        </div>
        <a
          href="{{ route('admin.users') }}"
          class="w-full min-h-[42px] px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs inline-flex items-center justify-center gap-1.5 transition-colors shadow-xs"
        >
          <span>Kelola Pengguna</span>
          <i class="ti ti-arrow-right text-sm" aria-hidden="true"></i>
        </a>
      </div>

      <!-- Widget 2: Knowledge Base & Pengaturan AI -->
      <div class="bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl p-5 shadow-xs text-center flex flex-col items-center justify-between">
        <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mb-3 border border-emerald-100 dark:border-emerald-900/40">
          <i class="ti ti-settings-cog text-2xl" aria-hidden="true"></i>
        </div>
        <div class="mb-3">
          <h3 class="text-xl sm:text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">
            {{ number_format($stats['total_knowledge'] ?? 0) }} Dokumen
          </h3>
          <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 mt-0.5">
            Knowledge Base &amp; RAG AI
          </p>
          <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">
            Basis data pengetahuan &amp; model kecerdasan buatan Gemini
          </p>
        </div>
        <a
          href="{{ route('admin.konfigurasi') }}"
          class="w-full min-h-[42px] px-4 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-xs inline-flex items-center justify-center gap-1.5 transition-colors shadow-xs"
        >
          <span>Konfigurasi AI</span>
          <i class="ti ti-arrow-right text-sm" aria-hidden="true"></i>
        </a>
      </div>

    </div>

    <!-- Kolom Kanan (lg:col-span-8): Activity Feed (Gaya Timeline Gradient Able) -->
    <div class="lg:col-span-8 bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl shadow-xs overflow-hidden flex flex-col justify-between">
      
      <div>
        <div class="p-5 sm:px-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
          <div class="flex items-center gap-2.5">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/40">
              <i class="ti ti-activity text-lg" aria-hidden="true"></i>
            </span>
            <div>
              <h2 class="text-base font-bold text-gray-900 dark:text-white tracking-tight">
                Activity Feed
              </h2>
              <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                Riwayat bimbingan, konsultasi AI, dan aktivitas siswa terkini
              </p>
            </div>
          </div>
          <a href="{{ route('admin.laporan') }}" class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 hover:underline flex items-center gap-1">
            <span>Lihat laporan</span>
            <i class="ti ti-arrow-right text-xs" aria-hidden="true"></i>
          </a>
        </div>

        <div class="p-5 sm:px-6">
          <div class="feed-blog">
            @forelse($studentActivities as $activity)
              <div class="feed-item">
                <!-- Avatar Initial Siswa pada Timeline Line -->
                <div class="feed-user-avatar bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">
                  {{ $activity['avatar_letter'] ?? 'S' }}
                </div>

                <div class="min-w-0">
                  <div class="flex items-center justify-between gap-2 flex-wrap mb-1">
                    <div class="flex items-center gap-2 flex-wrap">
                      <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200">
                        {{ $activity['badge'] ?? 'Konsultasi' }}
                      </span>
                      <span class="font-bold text-gray-900 dark:text-white text-xs sm:text-sm">
                        {{ $activity['student_name'] }}
                      </span>
                      <span class="text-[11px] text-gray-500 dark:text-gray-400 font-mono">
                        {{ $activity['student_meta'] }}
                      </span>
                    </div>
                    <span class="text-[11px] text-gray-500 dark:text-gray-400 font-medium">
                      {{ $activity['time_ago'] }}
                    </span>
                  </div>

                  <p class="text-xs text-gray-700 dark:text-gray-300 font-medium leading-relaxed mb-1">
                    {{ $activity['title'] }}
                  </p>
                  
                  @if(!empty($activity['detail']))
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 line-clamp-2 mb-2">
                      {{ $activity['detail'] }}
                    </p>
                  @endif

                  <div>
                    <a href="{{ $activity['action_url'] }}" class="text-[11px] font-semibold text-emerald-700 dark:text-emerald-400 hover:underline inline-flex items-center gap-1">
                      <span>Periksa sesi konsultasi</span>
                      <i class="ti ti-chevron-right text-xs" aria-hidden="true"></i>
                    </a>
                  </div>
                </div>
              </div>
            @empty
              <div class="py-8 text-center text-gray-500 dark:text-gray-400 text-xs">
                Belum ada aktivitas bimbingan siswa yang tercatat hari ini.
              </div>
            @endforelse
          </div>
        </div>
      </div>

      <div class="p-4 border-t border-gray-100 dark:border-gray-800 text-right bg-gray-50/50 dark:bg-gray-800/30">
        <a href="{{ route('admin.laporan') }}" class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 hover:underline inline-flex items-center gap-1">
          <span>Buka Laporan Terpadu</span>
          <i class="ti ti-arrow-right text-xs" aria-hidden="true"></i>
        </a>
      </div>

    </div>

  </div>

  <!-- 4. Baris Informasi Tambahan: Distribusi Kategori BK & Topik Chatbot Populer -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Card: Kategori Konsultasi (4 Bidang Standar BK) -->
    <div class="bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between space-y-4">
      <div>
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-800">
          <div class="flex items-center gap-2.5">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-900/40">
              <i class="ti ti-category-2 text-lg" aria-hidden="true"></i>
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

        <div class="space-y-3 mt-4">
          @foreach($bkCategories['items'] as $item)
            <div class="p-3 rounded-xl bg-gray-50/70 dark:bg-gray-800/40 border border-gray-100 dark:border-gray-800/80 space-y-2">
              <div class="flex items-center justify-between text-xs">
                <div class="flex items-center gap-2">
                  <span class="h-2.5 w-2.5 rounded-full {{ $item['dot_color'] }}"></span>
                  <span class="font-bold text-gray-900 dark:text-white text-xs sm:text-sm">{{ $item['title'] }}</span>
                </div>
                <div class="flex items-center gap-2">
                  <span class="text-gray-500 dark:text-gray-400 font-mono">{{ $item['count'] }} sesi</span>
                  <span class="font-bold px-2 py-0.5 rounded-md text-[11px] {{ $item['badge'] }}">
                    {{ $item['percentage'] }}%
                  </span>
                </div>
              </div>
              <div class="w-full h-1.5 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                <div class="h-full rounded-full {{ $item['bar_color'] }}" style="width: {{ max(4, $item['percentage']) }}%"></div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="pt-2 border-t border-gray-100 dark:border-gray-800 text-right">
        <a href="{{ route('admin.laporan') }}" class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 hover:underline inline-flex items-center gap-1">
          <span>Lihat rincian laporan bimbingan</span>
          <i class="ti ti-arrow-right text-xs" aria-hidden="true"></i>
        </a>
      </div>
    </div>

    <!-- Card: Topik Chatbot Terpopuler -->
    <div class="bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between space-y-4">
      <div>
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-800">
          <div class="flex items-center gap-2.5">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-900/40">
              <i class="ti ti-bulb text-lg" aria-hidden="true"></i>
            </span>
            <div>
              <h2 class="text-sm sm:text-base font-bold text-gray-900 dark:text-white">
                Topik Chatbot Terpopuler
              </h2>
              <p class="text-xs text-gray-500 dark:text-gray-400">
                Pertanyaan paling sering diajukan siswa ke AI
              </p>
            </div>
          </div>
          <span class="text-[11px] font-semibold text-gray-500 dark:text-gray-400">Minggu Ini</span>
        </div>

        @if(count($popularTopics) > 0 && array_sum(array_column($popularTopics, 'count')) > 0)
          <div class="space-y-3 mt-4">
            @foreach($popularTopics as $topic)
              <div class="space-y-1.5">
                <div class="flex items-center justify-between text-xs">
                  <span class="font-medium text-gray-700 dark:text-gray-300 truncate max-w-[200px]">{{ $topic['title'] }}</span>
                  <span class="text-gray-500 dark:text-gray-400 font-mono">{{ $topic['count'] }} tanya ({{ $topic['percentage'] }}%)</span>
                </div>
                <div class="w-full h-1.5 rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
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
      </div>

      <!-- Kata Kunci Populer -->
      <div class="pt-3 border-t border-gray-100 dark:border-gray-800 space-y-2">
        <div class="text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
          Kata Kunci Populer
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

  </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  function adminDashboard() {
    return {
      period: 'month',
      trendChartInstance: null,
      ratioDonutInstance: null,
      statusDonutInstance: null,
      trendData: @json($trendData),
      stats: @json($stats),
      handlingStatus: @json($handlingStatus),

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
          pct_ai_badge: '↗ +0.0%',
          pct_live_badge: '↗ +0.0%',
          pct_total_badge: '↗ +0.0%',
          pct_val_ai: 0,
          pct_val_live: 0,
          pct_val_total: 0,
          comparison_text: 'Stabil dibanding periode sebelumnya',
          period_subtitle: '',
          labels: [],
          ai: [],
          live: []
        };
      },

      init() {
        this.$nextTick(() => {
          this.initTrendChart();
          this.initRatioDonut();
          this.initStatusDonut();
        });
      },

      switchPeriod(newPeriod) {
        if (this.period === newPeriod) return;
        this.period = newPeriod;
        this.updateTrendChart();
      },

      initTrendChart() {
        const ctx = document.getElementById('adminTrendChart');
        if (!ctx) return;

        const isDark = document.documentElement.classList.contains('dark');
        const activeData = this.activePeriodData;
        const gridColor = isDark ? 'rgba(51, 65, 85, 0.35)' : 'rgba(226, 232, 240, 0.7)';
        const tickColor = isDark ? '#94a3b8' : '#64748b';

        const ctx2d = ctx.getContext('2d');
        const blueGradient = ctx2d.createLinearGradient(0, 0, 0, 260);
        blueGradient.addColorStop(0, 'rgba(59, 130, 246, 0.28)');
        blueGradient.addColorStop(1, 'rgba(59, 130, 246, 0.01)');

        const greenGradient = ctx2d.createLinearGradient(0, 0, 0, 260);
        greenGradient.addColorStop(0, 'rgba(16, 185, 129, 0.28)');
        greenGradient.addColorStop(1, 'rgba(16, 185, 129, 0.01)');

        this.trendChartInstance = new Chart(ctx, {
          type: 'line',
          data: {
            labels: activeData.labels || [],
            datasets: [
              {
                label: 'Chatbot AI',
                data: activeData.ai || [],
                borderColor: '#3b82f6',
                backgroundColor: blueGradient,
                borderWidth: 2.5,
                pointRadius: 4,
                pointHoverRadius: 7,
                pointBackgroundColor: '#2563eb',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                tension: 0.4,
                fill: true
              },
              {
                label: 'Live Chat Guru BK',
                data: activeData.live || [],
                borderColor: '#10b981',
                backgroundColor: greenGradient,
                borderWidth: 2.5,
                pointRadius: 4,
                pointHoverRadius: 7,
                pointBackgroundColor: '#059669',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
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
                  label: (context) => ' ' + context.dataset.label + ': ' + context.parsed.y + ' sesi',
                  footer: (items) => {
                    const total = items.reduce((acc, curr) => acc + curr.parsed.y, 0);
                    return 'Total Konsultasi: ' + total;
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
                suggestedMax: 8,
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

      updateTrendChart() {
        if (!this.trendChartInstance) return;
        const activeData = this.activePeriodData;
        this.trendChartInstance.data.labels = activeData.labels || [];
        this.trendChartInstance.data.datasets[0].data = activeData.ai || [];
        this.trendChartInstance.data.datasets[1].data = activeData.live || [];
        this.trendChartInstance.update();
      },

      initRatioDonut() {
        const ctx = document.getElementById('adminRatioDonutChart');
        if (!ctx) return;
        const aiCount = this.stats.total_ai_sessions || 0;
        const liveCount = this.stats.total_live_sessions || 0;
        const dataValues = (aiCount === 0 && liveCount === 0) ? [1, 1] : [aiCount, liveCount];

        this.ratioDonutInstance = new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: ['Chatbot AI', 'Live Chat Guru BK'],
            datasets: [{
              data: dataValues,
              backgroundColor: ['#10b981', '#3b82f6'],
              borderWidth: 0,
              hoverOffset: 4
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
              legend: { display: false },
              tooltip: {
                callbacks: {
                  label: (ctx) => ` ${ctx.label}: ${ctx.raw} sesi`
                }
              }
            }
          }
        });
      },

      initStatusDonut() {
        const ctx = document.getElementById('adminStatusDonutChart');
        if (!ctx) return;
        const completed = this.handlingStatus?.completed?.count || 0;
        const inProgress = (this.handlingStatus?.in_progress?.count || 0) + (this.handlingStatus?.waiting?.count || 0);
        const dataValues = (completed === 0 && inProgress === 0) ? [1, 0] : [completed, inProgress];

        this.statusDonutInstance = new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: ['Kasus Tuntas', 'Dalam Proses'],
            datasets: [{
              data: dataValues,
              backgroundColor: ['#34d399', '#93c5fd'],
              borderWidth: 0,
              hoverOffset: 4
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
              legend: { display: false },
              tooltip: {
                callbacks: {
                  label: (ctx) => ` ${ctx.label}: ${ctx.raw} kasus`
                }
              }
            }
          }
        });
      }
    };
  }
</script>
@endpush
