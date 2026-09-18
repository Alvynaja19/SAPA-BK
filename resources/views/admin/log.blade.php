@extends('layouts.tailadmin')

@section('title', 'System Log & Aktivitas : SAPA BK')

@section('content')
<div class="space-y-6">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
        System Log & Audit Trail (SRS F-54)
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
        Pemantauan aktivitas autentikasi, indexing dokumen RAG, dan eksekusi inferensi AI Chatbot.
      </p>
    </div>

    <button
      type="button"
      onclick="window.location.reload()"
      class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 font-semibold text-xs transition-colors self-start sm:self-auto"
    >
      <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
      </svg>
      <span>Segarkan Log</span>
    </button>
  </div>

  <!-- System Components Diagnostics Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    
    <div class="p-5 rounded-2xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs flex items-center gap-4">
      <div class="h-10 w-10 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-400 flex items-center justify-center shrink-0">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
      </div>
      <div>
        <span class="text-[11px] text-gray-400 block font-medium">Basis Data Utama</span>
        <span class="text-xs font-bold text-gray-900 dark:text-white">Connected (Active)</span>
      </div>
    </div>

    <div class="p-5 rounded-2xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs flex items-center gap-4">
      <div class="h-10 w-10 rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-950/60 dark:text-brand-400 flex items-center justify-center shrink-0">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
      </div>
      <div>
        <span class="text-[11px] text-gray-400 block font-medium">Gemini 2.0 Flash Core</span>
        <span class="text-xs font-bold text-gray-900 dark:text-white">Standby / Ready</span>
      </div>
    </div>

    <div class="p-5 rounded-2xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs flex items-center gap-4">
      <div class="h-10 w-10 rounded-xl bg-[#FEFBF0] text-[#7A5200] dark:bg-amber-950/60 dark:text-amber-300 border border-[#FBE9AE]/60 dark:border-amber-800/40 flex items-center justify-center shrink-0">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7" /></svg>
      </div>
      <div>
        <span class="text-[11px] text-gray-400 block font-medium">ChromaDB Vector Store</span>
        <span class="text-xs font-bold text-gray-900 dark:text-white">Ready for Queries</span>
      </div>
    </div>

    <div class="p-5 rounded-2xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs flex items-center gap-4">
      <div class="h-10 w-10 rounded-xl bg-[#D9E9F6] text-[#1C6EB4] dark:bg-blue-950/60 dark:text-blue-300 border border-[#B8D5ED]/60 dark:border-blue-800/40 flex items-center justify-center shrink-0">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
      </div>
      <div>
        <span class="text-[11px] text-gray-400 block font-medium">Storage Dokumen</span>
        <span class="text-xs font-bold text-gray-900 dark:text-white">Symlink Valid</span>
      </div>
    </div>

  </div>

  <!-- Log Activity Table -->
  <div class="rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs overflow-hidden">
    <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
      <div>
        <h2 class="text-base font-bold text-gray-900 dark:text-white">Log Aktivitas Terkini</h2>
        <p class="text-xs text-gray-400">Daftar operasi sistem terbaru yang dicatat oleh aplikasi.</p>
      </div>
      <span class="text-xs font-semibold text-gray-400">Total: {{ count($logs) }} Log Tercatat</span>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="border-b border-gray-100 dark:border-gray-800 text-[11px] font-bold text-gray-400 dark:text-gray-400 uppercase tracking-wider bg-gray-50/50 dark:bg-gray-800/30">
            <th class="py-3.5 px-6">Level</th>
            <th class="py-3.5 px-6">Modul / Kategori</th>
            <th class="py-3.5 px-6">Deskripsi Aktivitas</th>
            <th class="py-3.5 px-6">Waktu Kejadian</th>
            <th class="py-3.5 px-6 text-right">Hasil Operasi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-xs text-gray-600 dark:text-gray-300">
          @forelse($logs as $log)
            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
              <td class="py-3.5 px-6">
                @if($log['level'] === 'INFO')
                  <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                    INFO
                  </span>
                @elseif($log['level'] === 'WARNING')
                  <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                    WARN
                  </span>
                @else
                  <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-rose-50 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300 border border-rose-200 dark:border-rose-800">
                    ERROR
                  </span>
                @endif
              </td>
              <td class="py-3.5 px-6 font-bold text-gray-900 dark:text-white">
                {{ $log['category'] }}
              </td>
              <td class="py-3.5 px-6 max-w-md truncate">
                {{ $log['message'] }}
              </td>
              <td class="py-3.5 px-6 text-gray-400">
                {{ $log['time'] }}
              </td>
              <td class="py-3.5 px-6 text-right">
                <span class="inline-flex items-center gap-1 font-semibold text-emerald-600 dark:text-emerald-400">
                  <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                  {{ $log['status'] }}
                </span>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="py-8 text-center text-gray-400 text-xs">Belum ada catatan log sistem.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
