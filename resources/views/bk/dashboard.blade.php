@extends('layouts.tailadmin')

@section('title', 'Dashboard Guru BK : SAPA BK SMAN 4 Jember')

@section('content')
<div class="space-y-6">

  <!-- Welcome Greeting Hero Banner -->
  <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#1C2B18] via-[#205A26] to-[#2E7D34] text-white p-6 sm:p-10 shadow-xl shadow-[#2E7D34]/20 border border-[#B4DAB7]/20">
    <div class="relative z-10 max-w-2xl space-y-3">
      <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#F4B400]/20 text-[#FBE9AE] text-xs font-semibold backdrop-blur-md border border-[#F4B400]/30">
        <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse" aria-hidden="true"></span>
        <span>Portal Guru BK : SMA Negeri 4 Jember</span>
      </span>
      <h1 class="text-2xl sm:text-4xl font-black tracking-tight">
        Selamat Datang, {{ auth()->user()->name }} 👋
      </h1>
      <p class="text-xs sm:text-sm text-brand-100 leading-relaxed font-normal">
        Pantau kebutuhan konseling siswa, tinjau kualitas jawaban asisten cerdas, kelola dokumen bimbingan, serta fasilitasi konsultasi daring dengan siswa SMA Negeri 4 Jember.
      </p>
      <div class="pt-3 flex flex-wrap items-center gap-3">
        <a href="{{ route('bk.knowledge') }}" class="inline-flex items-center justify-center gap-2 min-h-[44px] px-5 py-2.5 rounded-xl bg-white text-[#205A26] font-bold text-xs shadow-lg hover:bg-brand-50 transition-all">
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
          </svg>
          <span>Kelola Materi Knowledge Base</span>
        </a>
        <a href="{{ route('bk.live-chat') }}" class="inline-flex items-center justify-center gap-2 min-h-[44px] px-5 py-2.5 rounded-xl bg-white/15 hover:bg-white/25 text-white font-semibold text-xs border border-white/20 backdrop-blur-md transition-all">
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
          </svg>
          <span>Live Chat Konseling (08.00 - 15.00)</span>
        </a>
      </div>
    </div>
  </div>

  <!-- Metric Statistics Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
    
    <div class="p-6 rounded-3xl bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 shadow-xs flex items-center justify-between">
      <div class="space-y-1">
        <span class="text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Siswa Terdaftar</span>
        <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $totalSiswa }}</h3>
        <p class="text-[11px] text-emerald-700 dark:text-emerald-400 font-semibold">Peserta didik aktif</p>
      </div>
      <div class="h-12 w-12 rounded-2xl bg-brand-50 text-brand-700 dark:bg-brand-950/60 dark:text-brand-400 flex items-center justify-center shrink-0">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
      </div>
    </div>

    <div class="p-6 rounded-3xl bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 shadow-xs flex items-center justify-between">
      <div class="space-y-1">
        <span class="text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Sesi Percakapan</span>
        <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $totalPercakapan }}</h3>
        <p class="text-[11px] text-[#1C6EB4] font-semibold">Konsultasi siswa</p>
      </div>
      <div class="h-12 w-12 rounded-2xl bg-[#D9E9F6] text-[#1C6EB4] dark:bg-blue-950/60 dark:text-blue-300 flex items-center justify-center shrink-0">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
      </div>
    </div>

    <div class="p-6 rounded-3xl bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 shadow-xs flex items-center justify-between">
      <div class="space-y-1">
        <span class="text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">E-Book Bimbingan</span>
        <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $totalEbook }}</h3>
        <p class="text-[11px] text-[#7A5200] dark:text-amber-300 font-semibold">Buku panduan digital</p>
      </div>
      <div class="h-12 w-12 rounded-2xl bg-[#FEFBF0] text-[#7A5200] dark:bg-amber-950/60 dark:text-amber-300 border border-[#FBE9AE]/80 dark:border-amber-800/40 flex items-center justify-center shrink-0">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
        </svg>
      </div>
    </div>

    <div class="p-6 rounded-3xl bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 shadow-xs flex items-center justify-between">
      <div class="space-y-1">
        <span class="text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Artikel Layanan</span>
        <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $totalArtikel }}</h3>
        <p class="text-[11px] text-amber-700 dark:text-amber-400 font-semibold">Materi edukasi BK</p>
      </div>
      <div class="h-12 w-12 rounded-2xl bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-400 flex items-center justify-center shrink-0">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
        </svg>
      </div>
    </div>

  </div>

  <!-- Two Columns: Sesi Percakapan Terbaru & Antrean Evaluasi -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <!-- Sesi Percakapan Terkini -->
    <div class="rounded-3xl bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 shadow-xs overflow-hidden">
      <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
        <div>
          <h2 class="text-base font-bold text-gray-900 dark:text-white">Percakapan Siswa Terbaru</h2>
          <p class="text-xs text-gray-600 dark:text-gray-400">Sesi bimbingan siswa yang baru saja berlangsung.</p>
        </div>
        <a href="{{ route('bk.percakapan') }}" class="text-xs font-bold text-brand-700 hover:text-brand-800 dark:text-brand-400 p-2">
          Lihat Semua
        </a>
      </div>

      <div class="divide-y divide-gray-100 dark:divide-gray-800 text-xs">
        @forelse($recentPercakapan as $session)
          <div class="p-4 sm:px-6 flex items-center justify-between gap-4 hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
            <div class="flex items-center gap-3 min-w-0">
              <div class="h-9 w-9 rounded-xl bg-gradient-to-tr from-[#205A26] to-[#2E7D34] text-white font-bold flex items-center justify-center text-xs shrink-0 shadow-xs">
                {{ strtoupper(substr($session->user?->name ?? 'Tamu', 0, 2)) }}
              </div>
              <div class="min-w-0">
                <span class="font-bold text-gray-900 dark:text-white block truncate">{{ $session->title }}</span>
                <span class="text-[11px] text-gray-500 dark:text-gray-400 block truncate">
                  {{ $session->user ? $session->user->name . ' (' . ($session->user->kelas ?? 'Siswa') . ')' : 'Pengunjung Tamu' }} &bull; {{ $session->created_at->diffForHumans() }}
                </span>
              </div>
            </div>
            <a href="{{ route('bk.percakapan.detail', $session->id) }}" class="min-h-[36px] px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-brand-50 hover:text-brand-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 text-xs font-semibold shrink-0 inline-flex items-center justify-center transition-colors">
              Detail Sesi
            </a>
          </div>
        @empty
          <div class="p-8 text-center text-gray-500 dark:text-gray-400 text-xs">Belum ada percakapan siswa.</div>
        @endforelse
      </div>
    </div>

    <!-- Antrean Evaluasi Chatbot AI -->
    <div class="rounded-3xl bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 shadow-xs overflow-hidden">
      <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
        <div>
          <h2 class="text-base font-bold text-gray-900 dark:text-white">Menunggu Evaluasi Jawaban</h2>
          <p class="text-xs text-gray-600 dark:text-gray-400">Tinjau akurasi jawaban asisten untuk menyempurnakan referensi materi.</p>
        </div>
        <a href="{{ route('bk.evaluasi') }}" class="text-xs font-bold text-brand-700 hover:text-brand-800 dark:text-brand-400 p-2">
          Semua Evaluasi
        </a>
      </div>

      <div class="divide-y divide-gray-100 dark:divide-gray-800 text-xs">
        @forelse($pendingEvaluations as $msg)
          <div class="p-4 sm:px-6 space-y-2 hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
            <p class="text-gray-800 dark:text-gray-200 line-clamp-2 leading-relaxed">
              "{{ $msg->content }}"
            </p>
            <div class="flex items-center justify-between pt-1">
              <span class="text-[11px] text-gray-500 dark:text-gray-400">Model: {{ $msg->metadata['model'] ?? 'Gemini 2.0 Flash' }}</span>
              <form method="POST" action="{{ route('bk.evaluasi.store', $msg->id) }}" class="flex items-center gap-2">
                @csrf
                <button type="submit" name="rating" value="good" class="min-h-[34px] px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-800 hover:bg-emerald-100 dark:bg-emerald-950/60 dark:text-emerald-300 text-xs font-bold transition-colors inline-flex items-center justify-center">
                  Sesuai
                </button>
                <button type="submit" name="rating" value="bad" class="min-h-[34px] px-3 py-1.5 rounded-lg bg-rose-50 text-rose-800 hover:bg-rose-100 dark:bg-rose-950/60 dark:text-rose-300 text-xs font-bold transition-colors inline-flex items-center justify-center">
                  Perlu Perbaikan
                </button>
              </form>
            </div>
          </div>
        @empty
          <div class="p-8 text-center text-gray-500 dark:text-gray-400 text-xs">Semua respons asisten terkini telah selesai ditinjau.</div>
        @endforelse
      </div>
    </div>

  </div>

</div>
@endsection
