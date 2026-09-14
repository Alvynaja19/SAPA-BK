@extends('layouts.tailadmin')

@section('title', 'Direktori Siswa — SAPA BK')

@section('content')
<div class="space-y-6">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
        Direktori Siswa Bimbingan
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
        Daftar peserta didik SMA Negeri 4 Jember yang terdaftar pada sistem konseling digital SAPA BK.
      </p>
    </div>
  </div>

  <!-- Siswa Table (TailAdmin Layout) -->
  <div class="rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="border-b border-gray-100 dark:border-gray-800 text-[11px] font-bold text-gray-400 dark:text-gray-400 uppercase tracking-wider bg-gray-50/50 dark:bg-gray-800/30">
            <th class="py-4 px-6">Nama & Email Siswa</th>
            <th class="py-4 px-6">NISN</th>
            <th class="py-4 px-6">Rombongan Belajar (Kelas)</th>
            <th class="py-4 px-6">Kontak WhatsApp</th>
            <th class="py-4 px-6">Status</th>
            <th class="py-4 px-6 text-right">Opsi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-xs text-gray-600 dark:text-gray-300">
          @forelse($siswa as $s)
            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
              <td class="py-4 px-6 font-medium text-gray-900 dark:text-white">
                <div class="flex items-center gap-3">
                  <div class="h-9 w-9 rounded-xl bg-gradient-to-tr from-[#205A26] to-[#2E7D34] text-white font-bold flex items-center justify-center text-xs shrink-0 shadow-xs">
                    {{ strtoupper(substr($s->name, 0, 2)) }}
                  </div>
                  <div>
                    <span class="font-bold block">{{ $s->name }}</span>
                    <span class="text-[11px] text-gray-400 block">{{ $s->email }}</span>
                  </div>
                </div>
              </td>
              <td class="py-4 px-6 font-semibold text-gray-700 dark:text-gray-300">
                {{ $s->nisn ?? '—' }}
              </td>
              <td class="py-4 px-6">
                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-bold bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200">
                  {{ $s->kelas ?? '—' }}
                </span>
              </td>
              <td class="py-4 px-6">
                {{ $s->no_hp ?? '—' }}
              </td>
              <td class="py-4 px-6">
                @if($s->is_active)
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Aktif
                  </span>
                @else
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300 border border-rose-200 dark:border-rose-800">
                    <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Nonaktif
                  </span>
                @endif
              </td>
              <td class="py-4 px-6 text-right">
                <a
                  href="{{ route('bk.live-chat') }}"
                  class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-brand-50 hover:bg-brand-100 text-brand-700 dark:bg-brand-950/60 dark:text-brand-300 dark:hover:bg-brand-900/60 text-xs font-bold transition-colors"
                >
                  <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                  <span>Konseling Live</span>
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="py-12 text-center text-gray-400 text-xs">Belum ada siswa terdaftar.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($siswa->hasPages())
      <div class="p-6 border-t border-gray-100 dark:border-gray-800">
        {{ $siswa->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
