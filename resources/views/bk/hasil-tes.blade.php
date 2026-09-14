@extends('layouts.tailadmin')

@section('title', 'Rekapitulasi Hasil Kuesioner — SAPA BK')

@section('content')
<div class="space-y-6">

  <!-- Breadcrumb Back -->
  <div class="flex items-center justify-between">
    <a href="{{ route('bk.tes') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-400 transition-colors">
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
      <span>Kembali ke Daftar Kuesioner</span>
    </a>

    <button
      type="button"
      onclick="window.print()"
      class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200 text-xs font-semibold hover:bg-gray-50 transition-colors"
    >
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
      <span>Cetak Rekap Nilai</span>
    </button>
  </div>

  <!-- Header Card -->
  <div class="rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs p-6 sm:p-8 space-y-2">
    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-brand-50 text-brand-700 dark:bg-brand-950/60 dark:text-brand-300 border border-brand-200 dark:border-brand-800 uppercase">
      Rekapitulasi Asesmen Siswa (SRS F-47)
    </span>
    <h1 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white">{{ $questionnaire->title }}</h1>
    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $questionnaire->description }}</p>
  </div>

  <!-- Results Table (TailAdmin Layout) -->
  <div class="rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs overflow-hidden">
    <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
      <h2 class="text-base font-bold text-gray-900 dark:text-white">Daftar Pengerjaan Peserta Didik</h2>
      <span class="text-xs text-gray-400 font-semibold">Total: {{ $results->total() }} Responden</span>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="border-b border-gray-100 dark:border-gray-800 text-[11px] font-bold text-gray-400 dark:text-gray-400 uppercase tracking-wider bg-gray-50/50 dark:bg-gray-800/30">
            <th class="py-4 px-6">Nama Siswa</th>
            <th class="py-4 px-6">NISN / Kelas</th>
            <th class="py-4 px-6">Waktu Pengerjaan</th>
            <th class="py-4 px-6">Skor Asesmen</th>
            <th class="py-4 px-6">Rekomendasi Profil</th>
            <th class="py-4 px-6 text-right">Tindakan Konselor</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-xs text-gray-600 dark:text-gray-300">
          @forelse($results as $r)
            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
              <td class="py-4 px-6 font-bold text-gray-900 dark:text-white">
                <div class="flex items-center gap-3">
                  <div class="h-8 w-8 rounded-xl bg-gradient-to-tr from-[#205A26] to-[#2E7D34] text-white font-bold flex items-center justify-center text-xs shrink-0">
                    {{ strtoupper(substr($r->user->name, 0, 2)) }}
                  </div>
                  <span>{{ $r->user->name }}</span>
                </div>
              </td>
              <td class="py-4 px-6">
                {{ $r->user->nisn ?? '—' }} ({{ $r->user->kelas ?? 'Siswa' }})
              </td>
              <td class="py-4 px-6 text-gray-400">
                {{ $r->created_at->format('d M Y, H:i') }}
              </td>
              <td class="py-4 px-6">
                <span class="font-black text-brand-600 dark:text-brand-400 text-sm">
                  {{ $r->score }} / 30
                </span>
              </td>
              <td class="py-4 px-6">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-[#FEFBF0] text-[#7A5200] dark:bg-amber-950/60 dark:text-amber-300 border border-[#FBE9AE]/60 dark:border-amber-800/40">
                  Visual - Auditori
                </span>
              </td>
              <td class="py-4 px-6 text-right">
                <a
                  href="{{ route('bk.live-chat') }}"
                  class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-brand-50 hover:bg-brand-100 text-brand-700 dark:bg-brand-950/60 dark:text-brand-300 font-semibold text-xs transition-colors"
                >
                  <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                  <span>Tindak Lanjut</span>
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="py-12 text-center text-gray-400 text-xs">Belum ada siswa yang mengisi kuesioner ini.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($results->hasPages())
      <div class="p-6 border-t border-gray-100 dark:border-gray-800">
        {{ $results->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
