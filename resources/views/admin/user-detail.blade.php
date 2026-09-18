@extends('layouts.tailadmin')

@section('title', "Detail Pengguna : {$user->name}")

@section('content')
<div class="space-y-6">

  <!-- Breadcrumb & Navigation -->
  <div class="flex items-center justify-between">
    <a href="{{ route('admin.users') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-400 transition-colors">
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
      </svg>
      <span>Kembali ke Daftar Pengguna</span>
    </a>

    <!-- Status Toggle Action -->
    <form id="toggle-detail-form" method="POST" action="{{ route('admin.users.toggle', $user->id) }}">
      @csrf
      @method('PATCH')
      @if($user->is_active)
        <button
          type="button"
          onclick="showConfirmModal({
            title: 'Nonaktifkan Akun Pengguna?',
            message: 'Apakah Anda yakin ingin menonaktifkan akun {{ addslashes($user->name) }}? Pengguna ini tidak akan dapat login ke sistem hingga diaktifkan kembali.',
            confirmText: 'Ya, Nonaktifkan',
            cancelText: 'Batal',
            type: 'warning',
            onConfirm: () => document.getElementById('toggle-detail-form').submit()
          })"
          class="px-3.5 py-1.5 rounded-xl border border-rose-200 bg-rose-50 text-rose-700 hover:bg-rose-100 dark:bg-rose-950/40 dark:border-rose-800 dark:text-rose-300 font-bold text-xs transition-colors cursor-pointer"
        >
          Nonaktifkan Akun
        </button>
      @else
        <button
          type="button"
          onclick="showConfirmModal({
            title: 'Aktifkan Akun Pengguna?',
            message: 'Apakah Anda yakin ingin mengaktifkan akun {{ addslashes($user->name) }}? Pengguna ini akan dapat login dan menggunakan hak aksesnya kembali.',
            confirmText: 'Ya, Aktifkan',
            cancelText: 'Batal',
            type: 'success',
            onConfirm: () => document.getElementById('toggle-detail-form').submit()
          })"
          class="px-3.5 py-1.5 rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 dark:bg-emerald-950/40 dark:border-emerald-800 dark:text-emerald-300 font-bold text-xs transition-colors cursor-pointer"
        >
          Aktifkan Akun
        </button>
      @endif
    </form>
  </div>

  <!-- Profile Overview Card -->
  <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
      
      <div class="flex items-center gap-5">
        <div class="h-16 w-16 rounded-3xl bg-gradient-to-tr from-[#205A26] to-[#2E7D34] text-white font-extrabold flex items-center justify-center text-2xl shadow-lg shadow-brand-500/25 shrink-0">
          {{ strtoupper(substr($user->name, 0, 2)) }}
        </div>
        <div class="space-y-1">
          <div class="flex items-center gap-3">
            <h1 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white">{{ $user->name }}</h1>
            @php
              $badgeStyle = match($user->role) {
                'admin' => 'bg-[#FEFBF0] text-[#7A5200] border-[#FBE9AE] dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800',
                'guru_bk' => 'bg-[#EDF5EE] text-[#205A26] border-[#B4DAB7] dark:bg-brand-950/60 dark:text-brand-300 dark:border-brand-800',
                default => 'bg-[#D9E9F6] text-[#1C6EB4] border-[#B8D5ED] dark:bg-blue-950/60 dark:text-blue-300 dark:border-blue-800'
              };
            @endphp
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold border {{ $badgeStyle }} uppercase">
              {{ str_replace('_', ' ', $user->role) }}
            </span>
          </div>
          <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }} • Terdaftar sejak {{ $user->created_at->format('d F Y') }}</p>
        </div>
      </div>

      <!-- Quick Metrics -->
      <div class="flex items-center gap-4 border-t sm:border-t-0 sm:border-l border-gray-100 dark:border-gray-800 pt-4 sm:pt-0 sm:pl-6">
        <div class="text-center px-3">
          <span class="block text-xl font-black text-gray-900 dark:text-white">{{ $totalChats }}</span>
          <span class="block text-[11px] text-gray-400">Sesi Chat</span>
        </div>
        <div class="text-center px-3">
          <span class="block text-xl font-black text-gray-900 dark:text-white">{{ $totalAssessments }}</span>
          <span class="block text-[11px] text-gray-400">Tes Diisi</span>
        </div>
      </div>

    </div>

    <!-- Data Grid Detail -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6 pt-6 border-t border-gray-100 dark:border-gray-800 text-xs">
      <div>
        <span class="text-gray-400 block mb-0.5">Nomor Induk Siswa (NISN)</span>
        <span class="font-bold text-gray-800 dark:text-gray-200">{{ $user->nisn ?? 'Tidak Terdata' }}</span>
      </div>
      <div>
        <span class="text-gray-400 block mb-0.5">Rombongan Belajar / Kelas</span>
        <span class="font-bold text-gray-800 dark:text-gray-200">{{ $user->kelas ?? 'Bukan Siswa' }}</span>
      </div>
      <div>
        <span class="text-gray-400 block mb-0.5">Kontak WhatsApp</span>
        <span class="font-bold text-gray-800 dark:text-gray-200">{{ $user->no_hp ?? '-' }}</span>
      </div>
      <div>
        <span class="text-gray-400 block mb-0.5">Status Akun</span>
        <span class="font-bold {{ $user->is_active ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600' }}">
          {{ $user->is_active ? 'Aktif Penuh' : 'Dinonaktifkan' }}
        </span>
      </div>
    </div>
  </div>

  <!-- Two Columns: Riwayat Konsultasi & Hasil Asesmen -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <!-- Riwayat Sesi Chatbot -->
    <div class="p-6 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs space-y-4">
      <h2 class="text-base font-bold text-gray-900 dark:text-white">Riwayat Sesi Konsultasi</h2>

      <div class="divide-y divide-gray-100 dark:divide-gray-800">
        @forelse($user->chatSessions as $session)
          <div class="py-3.5 flex items-center justify-between gap-4">
            <div class="space-y-0.5">
              <h3 class="text-xs font-bold text-gray-900 dark:text-white line-clamp-1">{{ $session->title }}</h3>
              <p class="text-[11px] text-gray-400">{{ $session->created_at->format('d M Y, H:i') }} • {{ $session->messages_count }} Pesan</p>
            </div>
            <a href="{{ route('bk.percakapan.detail', $session->id) }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700 dark:text-brand-400">
              Lihat Chat &rarr;
            </a>
          </div>
        @empty
          <div class="py-8 text-center text-gray-400 text-xs">Belum ada sesi konsultasi yang dimulai.</div>
        @endforelse
      </div>
    </div>

    <!-- Hasil Asesmen Kuesioner -->
    <div class="p-6 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs space-y-4">
      <h2 class="text-base font-bold text-gray-900 dark:text-white">Hasil Asesmen Minat / Kuesioner</h2>

      <div class="divide-y divide-gray-100 dark:divide-gray-800">
        @forelse($user->questionnaireResults as $res)
          <div class="py-3.5 flex items-center justify-between gap-4">
            <div class="space-y-0.5">
              <h3 class="text-xs font-bold text-gray-900 dark:text-white">{{ $res->questionnaire?->title ?? 'Kuesioner' }}</h3>
              <p class="text-[11px] text-gray-400">Dikerjakan {{ $res->created_at->format('d M Y, H:i') }}</p>
            </div>
            <span class="px-2.5 py-1 rounded-lg text-xs font-black bg-[#EDF5EE] text-[#205A26] dark:bg-brand-950/60 dark:text-brand-300 border border-[#B4DAB7]/60 dark:border-brand-800/40">
              Skor: {{ $res->score ?? 0 }}
            </span>
          </div>
        @empty
          <div class="py-8 text-center text-gray-400 text-xs">Belum ada asesmen yang diselesaikan.</div>
        @endforelse
      </div>
    </div>

  </div>

</div>
@endsection
