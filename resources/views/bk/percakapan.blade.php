@extends('layouts.tailadmin')

@section('title', 'Monitoring Percakapan Siswa — SAPA BK')

@section('content')
<div class="space-y-6">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
        Monitoring Percakapan Siswa
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
        Pantau interaksi bimbingan konseling digital siswa dengan asisten AI Gemini dan tindak lanjuti jika diperlukan.
      </p>
    </div>
  </div>

  <!-- Sesi Percakapan List Card (TailAdmin) -->
  <div class="rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs overflow-hidden">
    <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
      <h2 class="text-base font-bold text-gray-900 dark:text-white">Daftar Sesi Konsultasi</h2>
      <span class="text-xs text-gray-400 font-semibold">Total: {{ $sessions->total() }} Sesi Terdaftar</span>
    </div>

    <div class="divide-y divide-gray-100 dark:divide-gray-800">
      @forelse($sessions as $s)
        <div class="p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
          <div class="flex items-start gap-4">
            <div class="h-11 w-11 rounded-2xl bg-gradient-to-tr from-[#205A26] to-[#2E7D34] text-white font-bold flex items-center justify-center text-sm shrink-0 shadow-xs">
              {{ strtoupper(substr($s->user?->name ?? 'Tamu', 0, 2)) }}
            </div>
            <div class="space-y-1">
              <div class="flex items-center gap-2">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $s->user?->name ?? 'Pengguna Tamu' }}</h3>
                <span class="text-[10px] px-2 py-0.5 rounded-md bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-bold">
                  {{ $s->user?->kelas ?? 'Umum' }}
                </span>
              </div>
              <p class="text-xs text-gray-600 dark:text-gray-300 font-medium">{{ $s->title }}</p>
              <div class="flex items-center gap-2.5 text-[11px] text-gray-400">
                <span>{{ $s->created_at->format('d M Y, H:i') }}</span>
                <span>•</span>
                <span>{{ $s->messages->count() }} pesan dialog</span>
              </div>
            </div>
          </div>

          <a
            href="{{ route('bk.percakapan.detail', $s->id) }}"
            class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-brand-50 hover:bg-brand-500 hover:text-white text-brand-700 dark:bg-brand-950/60 dark:text-brand-300 dark:hover:bg-brand-600 dark:hover:text-white text-xs font-bold transition-all shrink-0"
          >
            <span>Buka Transkrip Dialog</span>
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
          </a>
        </div>
      @empty
        <div class="p-12 text-center text-gray-400 text-xs">Belum ada sesi percakapan dari siswa.</div>
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
