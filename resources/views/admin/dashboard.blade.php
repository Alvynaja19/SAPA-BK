@extends('layouts.tailadmin')

@section('title', 'Superadmin Dashboard : SAPA BK SMAN 4 Jember')

@section('content')
@php
  $stats = $stats ?? [
    'total_users' => $totalUsers ?? \App\Models\User::count(),
    'total_siswa' => $totalSiswa ?? \App\Models\User::where('role', 'siswa')->count(),
    'total_guru_bk' => $totalGuruBk ?? \App\Models\User::where('role', 'guru_bk')->count(),
    'total_sessions' => $totalSessions ?? \App\Models\ChatSession::count(),
    'total_messages' => \App\Models\ChatMessage::count(),
    'total_knowledge' => \App\Models\KnowledgeDocument::count(),
    'total_ebooks' => \App\Models\Ebook::count(),
    'total_articles' => \App\Models\Article::count(),
    'total_evaluations' => \App\Models\ChatEvaluation::count(),
    'good_evaluations' => \App\Models\ChatEvaluation::where('rating', 'good')->count(),
  ];
  $recentUsers = $recentUsers ?? \App\Models\User::latest()->take(6)->get();
@endphp
<div class="space-y-6">

  <!-- Page Header Title -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
        Superadmin Dashboard
      </h1>
      <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1">
        Ringkasan infrastruktur, analitik asisten cerdas, dan manajemen pengguna sistem SAPA BK SMAN 4 Jember.
      </p>
    </div>

    <!-- Quick Action Shortcut Buttons -->
    <div class="flex items-center gap-3">
      <a
        href="{{ route('admin.users') }}"
        class="inline-flex items-center justify-center gap-2 min-h-[44px] px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-semibold text-xs shadow-md shadow-brand-600/20 transition-all"
      >
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
        </svg>
        <span>Kelola Pengguna</span>
      </a>

      <a
        href="{{ route('admin.konfigurasi') }}"
        class="inline-flex items-center justify-center gap-2 min-h-[44px] px-4 py-2.5 rounded-xl border border-gray-300 bg-white hover:bg-gray-50 text-gray-800 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-800/80 font-semibold text-xs transition-colors"
      >
        <svg class="h-4 w-4 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span>Konfigurasi AI</span>
      </a>
    </div>
  </div>

  <!-- Metric Statistics Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
    
    <!-- Card 1: Total Pengguna -->
    <div class="p-6 rounded-3xl bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 shadow-xs flex items-center justify-between">
      <div class="space-y-1">
        <span class="text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Total Pengguna</span>
        <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $stats['total_users'] }}</h3>
        <p class="text-[11px] text-gray-600 dark:text-gray-400 font-medium">
          <span class="text-emerald-700 dark:text-emerald-400 font-bold">{{ $stats['total_siswa'] }}</span> Siswa &bull; 
          <span class="text-[#205A26] dark:text-brand-300 font-bold">{{ $stats['total_guru_bk'] }}</span> Guru BK
        </p>
      </div>
      <div class="h-12 w-12 rounded-2xl bg-brand-50 text-brand-700 dark:bg-brand-950/60 dark:text-brand-400 flex items-center justify-center shrink-0">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
      </div>
    </div>

    <!-- Card 2: Sesi Percakapan -->
    <div class="p-6 rounded-3xl bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 shadow-xs flex items-center justify-between">
      <div class="space-y-1">
        <span class="text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Sesi Percakapan</span>
        <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $stats['total_sessions'] }}</h3>
        <p class="text-[11px] text-gray-600 dark:text-gray-400 font-medium">
          <span class="text-[#1C6EB4] font-bold">{{ $stats['total_messages'] }}</span> Total Pesan
        </p>
      </div>
      <div class="h-12 w-12 rounded-2xl bg-[#D9E9F6] text-[#1C6EB4] dark:bg-blue-950/60 dark:text-blue-300 flex items-center justify-center shrink-0">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
      </div>
    </div>

    <!-- Card 3: Dokumen Knowledge Base -->
    <div class="p-6 rounded-3xl bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 shadow-xs flex items-center justify-between">
      <div class="space-y-1">
        <span class="text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Dokumen Knowledge</span>
        <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $stats['total_knowledge'] }}</h3>
        <p class="text-[11px] text-gray-600 dark:text-gray-400 font-medium">
          <span class="text-[#7A5200] dark:text-amber-300 font-bold">ChromaDB</span> Terindeks
        </p>
      </div>
      <div class="h-12 w-12 rounded-2xl bg-[#FEFBF0] text-[#7A5200] dark:bg-amber-950/60 dark:text-amber-300 border border-[#FBE9AE]/80 dark:border-amber-800/40 flex items-center justify-center shrink-0">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
        </svg>
      </div>
    </div>

    <!-- Card 4: Kepuasan Evaluasi AI -->
    <div class="p-6 rounded-3xl bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 shadow-xs flex items-center justify-between">
      <div class="space-y-1">
        <span class="text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Akurasi Respons AI</span>
        <h3 class="text-2xl font-black text-gray-900 dark:text-white">
          {{ $stats['total_evaluations'] > 0 ? round(($stats['good_evaluations'] / $stats['total_evaluations']) * 100) . '%' : '100%' }}
        </h3>
        <p class="text-[11px] text-emerald-700 dark:text-emerald-400 font-semibold">
          {{ $stats['good_evaluations'] }} dari {{ $stats['total_evaluations'] }} dinilai Sesuai
        </p>
      </div>
      <div class="h-12 w-12 rounded-2xl bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400 flex items-center justify-center shrink-0">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
    </div>

  </div>

  <!-- Two Column Content Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Left Column: User Terbaru (2 Cols) -->
    <div class="lg:col-span-2 rounded-3xl bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 shadow-xs overflow-hidden">
      <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
        <div>
          <h2 class="text-base font-bold text-gray-900 dark:text-white">Pengguna Terbaru</h2>
          <p class="text-xs text-gray-600 dark:text-gray-400">Pendaftaran akun siswa dan staf BK di sistem.</p>
        </div>
        <a href="{{ route('admin.users') }}" class="text-xs font-bold text-brand-700 hover:text-brand-800 dark:text-brand-400 p-2">
          Lihat Semua
        </a>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="border-b border-gray-100 dark:border-gray-800 text-[11px] font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider bg-gray-50/80 dark:bg-gray-800/40">
              <th class="py-3.5 px-6">Nama Pengguna</th>
              <th class="py-3.5 px-6">Peran</th>
              <th class="py-3.5 px-6">NISN / Kelas</th>
              <th class="py-3.5 px-6">Status</th>
              <th class="py-3.5 px-6 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-xs text-gray-700 dark:text-gray-300">
            @forelse($recentUsers as $u)
              <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
                <td class="py-4 px-6 font-medium text-gray-900 dark:text-white">
                  <div class="flex items-center gap-3">
                    <div class="h-8 w-8 rounded-xl bg-gradient-to-tr from-[#205A26] to-[#2E7D34] text-white font-bold flex items-center justify-center text-xs shrink-0 shadow-xs">
                      {{ strtoupper(substr($u->name, 0, 2)) }}
                    </div>
                    <div>
                      <span class="block font-semibold">{{ $u->name }}</span>
                      <span class="block text-[11px] text-gray-500 dark:text-gray-400">{{ $u->email }}</span>
                    </div>
                  </div>
                </td>
                <td class="py-4 px-6">
                  @php
                    $badgeStyle = match($u->role) {
                      'admin' => 'bg-[#FEFBF0] text-[#7A5200] border-[#FBE9AE] dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800',
                      'guru_bk' => 'bg-[#EDF5EE] text-[#205A26] border-[#B4DAB7] dark:bg-brand-950/60 dark:text-brand-300 dark:border-brand-800',
                      default => 'bg-[#D9E9F6] text-[#1C6EB4] border-[#B8D5ED] dark:bg-blue-950/60 dark:text-blue-300 dark:border-blue-800'
                    };
                  @endphp
                  <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold border {{ $badgeStyle }} capitalize">
                    {{ str_replace('_', ' ', $u->role) }}
                  </span>
                </td>
                <td class="py-4 px-6 font-medium text-gray-800 dark:text-gray-200">
                  {{ $u->nisn ?? '-' }}
                  @if($u->kelas)
                    <span class="text-gray-500 dark:text-gray-400">({{ $u->kelas }})</span>
                  @endif
                </td>
                <td class="py-4 px-6">
                  @if($u->is_active)
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 dark:text-emerald-400">
                      <span class="h-1.5 w-1.5 rounded-full bg-emerald-600" aria-hidden="true"></span> Aktif
                    </span>
                  @else
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-rose-700 dark:text-rose-400">
                      <span class="h-1.5 w-1.5 rounded-full bg-rose-600" aria-hidden="true"></span> Nonaktif
                    </span>
                  @endif
                </td>
                <td class="py-4 px-6 text-right">
                  <a href="{{ route('admin.users.detail', $u->id) }}" class="min-h-[36px] px-3 py-1.5 inline-flex items-center justify-center rounded-lg bg-gray-100 hover:bg-brand-50 hover:text-brand-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 text-xs font-semibold transition-colors">
                    Detail
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="py-8 text-center text-gray-500 dark:text-gray-400 text-xs">Belum ada pengguna terdaftar.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Right Column: System Health & Status -->
    <div class="space-y-6">
      
      <!-- Box 1: Status Layanan Server -->
      <div class="p-6 rounded-3xl bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 shadow-xs space-y-4">
        <h2 class="text-base font-bold text-gray-900 dark:text-white flex items-center justify-between">
          <span>Kondisi Layanan</span>
          <span class="h-2.5 w-2.5 rounded-full bg-emerald-500 animate-ping" aria-hidden="true"></span>
        </h2>

        <div class="space-y-3 text-xs">
          <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-800">
            <span class="text-gray-600 dark:text-gray-400">Framework Core</span>
            <span class="font-bold text-gray-900 dark:text-white">Laravel 12 / PHP 8.3</span>
          </div>

          <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-800">
            <span class="text-gray-600 dark:text-gray-400">Model AI LLM</span>
            <span class="font-bold text-brand-700 dark:text-brand-400">Gemini 2.0 Flash</span>
          </div>

          <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-800">
            <span class="text-gray-600 dark:text-gray-400">Vector Store</span>
            <span class="font-bold text-[#7A5200] dark:text-amber-300">ChromaDB Service</span>
          </div>

          <div class="flex items-center justify-between py-2">
            <span class="text-gray-600 dark:text-gray-400">Basis Data Relasional</span>
            <span class="font-bold text-emerald-700 dark:text-emerald-400">Aktif &amp; Normal</span>
          </div>
        </div>

        <div class="pt-2">
          <a
            href="{{ route('admin.log') }}"
            class="min-h-[44px] flex items-center justify-center w-full px-4 py-2.5 text-center rounded-xl bg-gray-100 dark:bg-gray-800 text-xs font-semibold text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors"
          >
            Buka System Activity Log
          </a>
        </div>
      </div>

      <!-- Box 2: Quick Shortcut Menu Guru BK -->
      <div class="p-6 rounded-3xl bg-gradient-to-br from-[#1C2B18] via-[#205A26] to-[#2E7D34] text-white shadow-lg shadow-[#2E7D34]/20 space-y-3">
        <div class="flex items-center gap-2">
          <span class="p-2 rounded-xl bg-white/15 text-white flex items-center justify-center">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
          </span>
          <h3 class="text-base font-bold">Akses Superadmin</h3>
        </div>
        <p class="text-xs text-brand-100 leading-relaxed">
          Sebagai Administrator, Anda memiliki akses penuh ke modul Guru BK untuk supervisi data bimbingan, evaluasi respons, dan dokumen e-book.
        </p>
        <div class="pt-2 flex flex-wrap gap-2.5">
          <a href="{{ route('bk.dashboard') }}" class="min-h-[40px] px-4 py-2 rounded-xl bg-[#F4B400] text-[#1C2B18] font-bold text-xs shadow-xs hover:bg-[#D89E00] inline-flex items-center justify-center transition-colors">
            Masuk Portal BK
          </a>
          <a href="{{ route('admin.laporan') }}" class="min-h-[40px] px-4 py-2 rounded-xl bg-white/20 text-white font-semibold text-xs hover:bg-white/30 inline-flex items-center justify-center transition-colors">
            Rekap Laporan
          </a>
        </div>
      </div>

    </div>

  </div>

</div>
@endsection
