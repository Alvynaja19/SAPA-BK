@extends('layouts.tailadmin')

@section('title', "Detail Pengguna : {$user->name}")

@section('content')
<div class="space-y-6" x-data="{ modalEdit: false }">

  <!-- Breadcrumb & Navigation -->
  <div class="flex items-center justify-between flex-wrap gap-3">
    <a href="{{ route('admin.users') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-400 transition-colors">
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
      </svg>
      <span>Kembali ke Daftar Pengguna</span>
    </a>

    <!-- Action Buttons -->
    <div class="flex items-center gap-2 flex-wrap">
      <!-- Edit Button -->
      <button
        type="button"
        @click="modalEdit = true"
        class="px-3.5 py-1.5 rounded-xl border border-blue-200 bg-blue-50 text-blue-700 hover:bg-blue-100 dark:bg-blue-950/40 dark:border-blue-800 dark:text-blue-300 font-bold text-xs transition-colors cursor-pointer inline-flex items-center gap-1.5"
      >
        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        <span>Edit Akun</span>
      </button>

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
            class="px-3.5 py-1.5 rounded-xl border border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100 dark:bg-amber-950/40 dark:border-amber-800 dark:text-amber-300 font-bold text-xs transition-colors cursor-pointer"
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

      <!-- Delete Action -->
      <form id="delete-detail-form" method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
        @csrf
        @method('DELETE')
        <button
          type="button"
          onclick="showConfirmModal({
            title: 'Hapus Akun Pengguna?',
            message: 'Apakah Anda yakin ingin menghapus akun {{ addslashes($user->name) }} ({{ $user->email }})? Tindakan ini akan menghapus data akun secara permanen.',
            confirmText: 'Ya, Hapus Akun',
            cancelText: 'Batal',
            type: 'danger',
            onConfirm: () => document.getElementById('delete-detail-form').submit()
          })"
          class="px-3.5 py-1.5 rounded-xl border border-rose-200 bg-rose-50 text-rose-700 hover:bg-rose-100 dark:bg-rose-950/40 dark:border-rose-800 dark:text-rose-300 font-bold text-xs transition-colors cursor-pointer inline-flex items-center gap-1.5"
        >
          <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
          </svg>
          <span>Hapus Akun</span>
        </button>
      </form>
    </div>
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

  <!-- Modal Form Edit Data Pengguna -->
  <div
    x-show="modalEdit"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-xs flex items-center justify-center p-4"
    style="display: none;"
  >
    <div
      @click.outside="modalEdit = false"
      class="w-full max-w-lg rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-2xl p-6 sm:p-8 space-y-6"
    >
      <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
        <div>
          <h3 class="text-lg font-bold text-gray-900 dark:text-white">Edit Akun Pengguna</h3>
          <p class="text-xs text-gray-400">Perbarui informasi profil, hak akses, atau kata sandi akun.</p>
        </div>
        <button type="button" @click="modalEdit = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 cursor-pointer">
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
      </div>

      <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Nama Lengkap -->
        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap & Gelar *</label>
          <input
            type="text"
            name="name"
            value="{{ old('name', $user->name) }}"
            required
            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
          />
        </div>

        <!-- Email & Role Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Alamat Email *</label>
            <input
              type="email"
              name="email"
              value="{{ old('email', $user->email) }}"
              required
              class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
            />
          </div>

          <div>
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Role Akun *</label>
            <select
              name="role"
              required
              class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
            >
              <option value="guru_bk" {{ old('role', $user->role) === 'guru_bk' ? 'selected' : '' }}>Guru BK</option>
              <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator</option>
              <option value="siswa" {{ old('role', $user->role) === 'siswa' ? 'selected' : '' }}>Siswa</option>
            </select>
          </div>
        </div>

        <!-- NISN & Kelas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">NISN (Khusus Siswa)</label>
            <input
              type="text"
              name="nisn"
              value="{{ old('nisn', $user->nisn) }}"
              placeholder="0071234567"
              class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
            />
          </div>

          <div>
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Kelas (Khusus Siswa)</label>
            <input
              type="text"
              name="kelas"
              value="{{ old('kelas', $user->kelas) }}"
              placeholder="XII MIPA 1"
              class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
            />
          </div>
        </div>

        <!-- No HP & Status -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">No. WhatsApp / HP</label>
            <input
              type="text"
              name="no_hp"
              value="{{ old('no_hp', $user->no_hp) }}"
              placeholder="081234567890"
              class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
            />
          </div>

          <div>
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Status Akun *</label>
            <select
              name="is_active"
              class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
            >
              <option value="1" {{ old('is_active', $user->is_active) ? 'selected' : '' }}>Aktif</option>
              <option value="0" {{ !old('is_active', $user->is_active) ? 'selected' : '' }}>Nonaktif</option>
            </select>
          </div>
        </div>

        <!-- Ubah Password (Opsional) -->
        <div class="pt-2 border-t border-gray-100 dark:border-gray-800">
          <p class="text-[11px] font-bold text-gray-500 dark:text-gray-400 mb-2">Ganti Kata Sandi (Opsional, kosongkan jika tidak ingin diubah)</p>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Kata Sandi Baru</label>
              <input
                type="password"
                name="password"
                placeholder="Minimal 8 karakter"
                class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
              />
            </div>

            <div>
              <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Ulangi Sandi Baru</label>
              <input
                type="password"
                name="password_confirmation"
                placeholder="Ulangi sandi baru"
                class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
              />
            </div>
          </div>
        </div>

        <div class="pt-4 border-t border-gray-100 dark:border-gray-800 flex items-center justify-end gap-3">
          <button
            type="button"
            @click="modalEdit = false"
            class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer"
          >
            Batal
          </button>
          <button
            type="submit"
            class="px-5 py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-md shadow-brand-500/20 cursor-pointer"
          >
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection
