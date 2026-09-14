@extends('layouts.tailadmin')

@section('title', 'Laporan & Statistik Penggunaan — SAPA BK')

@section('content')
<div class="space-y-6">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
        Laporan & Statistik Penggunaan (SRS F-55)
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
        Rekapitulasi komprehensif konsultasi digital siswa, pemetaan topik konseling, dan keterlibatan asesmen.
      </p>
    </div>

    <!-- Print / Export Action -->
    <button
      type="button"
      onclick="window.print()"
      class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-semibold text-xs shadow-md shadow-brand-500/20 transition-all self-start sm:self-auto"
    >
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
      </svg>
      <span>Cetak / Ekspor Laporan</span>
    </button>
  </div>

  <!-- Metric Statistics -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
    
    <div class="p-6 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs">
      <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Total Sesi Konsultasi</span>
      <h3 class="text-3xl font-black text-gray-900 dark:text-white">{{ $totalSessions }}</h3>
      <p class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold mt-1">Aktif diakses siswa</p>
    </div>

    <div class="p-6 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs">
      <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Interaksi Pesan AI</span>
      <h3 class="text-3xl font-black text-gray-900 dark:text-white">{{ $totalMessages }}</h3>
      <p class="text-[11px] text-brand-600 dark:text-brand-400 font-semibold mt-1">Pesan tanya & jawab</p>
    </div>

    <div class="p-6 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs">
      <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Asesmen Diselesaikan</span>
      <h3 class="text-3xl font-black text-gray-900 dark:text-white">{{ $totalAssessments }}</h3>
      <p class="text-[11px] text-[#D89E00] dark:text-amber-400 font-semibold mt-1">Hasil kuesioner siswa</p>
    </div>

    <div class="p-6 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs">
      <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Siswa & Guru Terdaftar</span>
      <h3 class="text-3xl font-black text-gray-900 dark:text-white">{{ $totalUsers }}</h3>
      <p class="text-[11px] text-[#1C6EB4] dark:text-blue-300 font-semibold mt-1">Civitas SMAN 4 Jember</p>
    </div>

  </div>

  <!-- Two Columns: Topik Konsultasi & Rekapitulasi Asesmen -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <!-- Topik Dominan Konsultasi Siswa -->
    <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs space-y-6">
      <div>
        <h2 class="text-base font-bold text-gray-900 dark:text-white">Distribusi Topik Konsultasi Siswa</h2>
        <p class="text-xs text-gray-400">Analisis kata kunci pertanyaan terbanyak yang diajukan ke asisten AI.</p>
      </div>

      <div class="space-y-4">
        @foreach($topicStats as $topic => $count)
          @php
            $percentage = $totalMessages > 0 ? min(100, round(($count / max(1, $totalMessages)) * 100)) : 0;
            $barColor = match($topic) {
              'Akademik & Studi Lanjut' => 'bg-brand-500',
              'Manajemen Diri & Stres' => 'bg-emerald-500',
              default => 'bg-[#F4B400]'
            };
          @endphp
          <div class="space-y-1.5">
            <div class="flex items-center justify-between text-xs font-semibold">
              <span class="text-gray-700 dark:text-gray-300">{{ $topic }}</span>
              <span class="text-gray-500 dark:text-gray-400">{{ $count }} Pesan ({{ $percentage }}%)</span>
            </div>
            <div class="w-full h-2.5 rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
              <div class="h-full rounded-full {{ $barColor }}" style="width: {{ max(8, $percentage) }}%"></div>
            </div>
          </div>
        @endforeach
      </div>

      <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-800 text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
        <strong class="text-gray-800 dark:text-gray-200">Insight Konseling:</strong> Siswa paling aktif berkonsultasi mengenai persiapan masuk perguruan tinggi (SNBP/SNBT) dan pemilihan mata pelajaran pilihan pada Kurikulum Merdeka.
      </div>
    </div>

    <!-- Rekapitulasi Partisipasi Kuesioner -->
    <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs space-y-6">
      <div>
        <h2 class="text-base font-bold text-gray-900 dark:text-white">Partisipasi Asesmen & Kuesioner</h2>
        <p class="text-xs text-gray-400">Tingkat pengisian instrumen kuesioner oleh peserta didik.</p>
      </div>

      <div class="divide-y divide-gray-100 dark:divide-gray-800">
        @forelse($questionnaires as $q)
          <div class="py-4 flex items-center justify-between gap-4">
            <div class="space-y-1">
              <h3 class="text-xs font-bold text-gray-900 dark:text-white">{{ $q->title }}</h3>
              <p class="text-[11px] text-gray-400 line-clamp-1">{{ $q->description }}</p>
            </div>
            <div class="text-right shrink-0">
              <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-[#EDF5EE] text-[#205A26] dark:bg-brand-950/60 dark:text-brand-300">
                {{ $q->results_count }} Siswa
              </span>
              <a href="{{ route('bk.tes.hasil', $q->id) }}" class="block text-[10px] text-brand-600 hover:text-brand-700 mt-1 font-semibold">
                Lihat Rekap &rarr;
              </a>
            </div>
          </div>
        @empty
          <div class="py-8 text-center text-gray-400 text-xs">Belum ada data kuesioner.</div>
        @endforelse
      </div>
    </div>

  </div>

</div>
@endsection
