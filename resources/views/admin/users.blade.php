@extends('layouts.tailadmin')

@section('title', 'Manajemen Pengguna : SAPA BK')

@section('content')
<div class="space-y-6" x-data="{
  modalTambah: false,
  modalImport: false,
  modalEdit: false,
  editUser: {
    id: '',
    name: '',
    email: '',
    role: 'siswa',
    nisn: '',
    kelas: '',
    no_hp: '',
    is_active: 1
  },
  openEditModal(user) {
    this.editUser = {
      id: user.id,
      name: user.name,
      email: user.email,
      role: user.role,
      nisn: user.nisn || '',
      kelas: user.kelas || '',
      no_hp: user.no_hp || '',
      is_active: user.is_active ? 1 : 0
    };
    this.modalEdit = true;
  }
}">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
        Manajemen Pengguna
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
        Kelola hak akses dan akun Siswa, Guru BK, serta Administrator SAPA BK SMAN 4 Jember.
      </p>
    </div>

    <!-- Action Buttons -->
    <div class="flex items-center gap-2.5 self-start sm:self-auto flex-wrap">
      <!-- Unduh Template Link -->
      <a
        href="{{ route('admin.siswa.template') }}"
        class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/60 text-gray-700 dark:text-gray-200 font-semibold text-xs shadow-xs transition-colors"
        title="Unduh Template CSV"
      >
        <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
        </svg>
        <span>Unduh Template CSV</span>
      </a>

      <!-- Import Siswa Button -->
      <button
        type="button"
        @click="modalImport = true"
        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-brand-200 dark:border-brand-800/60 bg-brand-50 dark:bg-brand-950/40 hover:bg-brand-100 dark:hover:bg-brand-900/50 text-brand-700 dark:text-brand-300 font-semibold text-xs shadow-xs transition-colors cursor-pointer"
      >
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
        </svg>
        <span>Import Siswa (Excel/CSV)</span>
      </button>

      <!-- Tambah Pengguna Button (SRS F-06) -->
      <button
        type="button"
        @click="modalTambah = true"
        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-semibold text-xs shadow-md shadow-brand-500/20 transition-all cursor-pointer"
      >
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        <span>Tambah Pengguna Baru</span>
      </button>
    </div>
  </div>

  <!-- Filter & Search Toolbar -->
  <div class="p-4 sm:p-5 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
    
    <!-- Role Filter Pills -->
    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0">
      <a
        href="{{ route('admin.users', ['q' => request('q')]) }}"
        class="px-3.5 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition-colors {{ !request('role') ? 'bg-brand-500 text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}"
      >
        Semua Role
      </a>
      <a
        href="{{ route('admin.users', ['role' => 'siswa', 'q' => request('q')]) }}"
        class="px-3.5 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition-colors {{ request('role') === 'siswa' ? 'bg-brand-500 text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}"
      >
        Siswa
      </a>
      <a
        href="{{ route('admin.users', ['role' => 'guru_bk', 'q' => request('q')]) }}"
        class="px-3.5 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition-colors {{ request('role') === 'guru_bk' ? 'bg-brand-500 text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}"
      >
        Guru BK
      </a>
      <a
        href="{{ route('admin.users', ['role' => 'admin', 'q' => request('q')]) }}"
        class="px-3.5 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition-colors {{ request('role') === 'admin' ? 'bg-brand-500 text-white shadow-xs' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}"
      >
        Administrator
      </a>
    </div>

    <!-- Search Input Form -->
    <form method="GET" action="{{ route('admin.users') }}" class="flex items-center gap-2">
      @if(request('role'))
        <input type="hidden" name="role" value="{{ request('role') }}">
      @endif
      <div class="relative grow sm:w-64">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
        <input
          type="text"
          name="q"
          value="{{ request('q') }}"
          placeholder="Cari nama / email / NISN..."
          class="w-full pl-9 pr-4 py-2 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-hidden focus:border-brand-500"
        />
      </div>
      <button
        type="submit"
        class="px-3.5 py-2 rounded-xl bg-gray-100 dark:bg-gray-800 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors"
      >
        Cari
      </button>
    </form>
  </div>

  <!-- Users Table (TailAdmin Design) -->
  <div class="rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="border-b border-gray-100 dark:border-gray-800 text-[11px] font-bold text-gray-400 dark:text-gray-400 uppercase tracking-wider bg-gray-50/50 dark:bg-gray-800/30">
            <th class="py-4 px-6">Identitas Pengguna</th>
            <th class="py-4 px-6">Role</th>
            <th class="py-4 px-6">NISN / Kelas / Kontak</th>
            <th class="py-4 px-6">Status Akun</th>
            <th class="py-4 px-6 text-right">Opsi Tindakan</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-xs text-gray-600 dark:text-gray-300">
          @forelse($users as $u)
            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
              <!-- Name & Email -->
              <td class="py-4 px-6 font-medium text-gray-900 dark:text-white">
                <div class="flex items-center gap-3">
                  <div class="h-9 w-9 rounded-xl bg-gradient-to-tr from-[#205A26] to-[#2E7D34] text-white font-bold flex items-center justify-center text-xs shrink-0 shadow-xs">
                    {{ strtoupper(substr($u->name, 0, 2)) }}
                  </div>
                  <div>
                    <a href="{{ route('admin.users.detail', $u->id) }}" class="font-bold hover:text-brand-600 dark:hover:text-brand-400 transition-colors">
                      {{ $u->name }}
                    </a>
                    <span class="block text-[11px] text-gray-400">{{ $u->email }}</span>
                  </div>
                </div>
              </td>

              <!-- Role Badge -->
              <td class="py-4 px-6">
                @php
                  $badgeStyle = match($u->role) {
                    'admin' => 'bg-[#FEFBF0] text-[#7A5200] border-[#FBE9AE] dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800',
                    'guru_bk' => 'bg-[#EDF5EE] text-[#205A26] border-[#B4DAB7] dark:bg-brand-950/60 dark:text-brand-300 dark:border-brand-800',
                    default => 'bg-[#D9E9F6] text-[#1C6EB4] border-[#B8D5ED] dark:bg-blue-950/60 dark:text-blue-300 dark:border-blue-800'
                  };
                  $roleLabel = match($u->role) {
                    'admin' => 'Administrator',
                    'guru_bk' => 'Guru BK',
                    default => 'Siswa'
                  };
                @endphp
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold border {{ $badgeStyle }}">
                  {{ $roleLabel }}
                </span>
              </td>

              <!-- Detail Data -->
              <td class="py-4 px-6 text-gray-500 dark:text-gray-400">
                @if($u->role === 'siswa')
                  <div>NISN: <span class="font-semibold text-gray-700 dark:text-gray-200">{{ $u->nisn ?? '-' }}</span></div>
                  <div>Kelas: <span class="font-semibold text-gray-700 dark:text-gray-200">{{ $u->kelas ?? '-' }}</span></div>
                @else
                  <div>No. HP: <span class="font-semibold text-gray-700 dark:text-gray-200">{{ $u->no_hp ?? '-' }}</span></div>
                  <div class="text-[11px] text-gray-400">Staf Pendidikan</div>
                @endif
              </td>

              <!-- Status -->
              <td class="py-4 px-6">
                @if($u->is_active)
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Aktif
                  </span>
                @else
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300 border border-rose-200 dark:border-rose-800">
                    <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Nonaktif
                  </span>
                @endif
              </td>

              <!-- Actions -->
              <td class="py-4 px-6 text-right">
                <div class="flex items-center justify-end gap-1.5">
                  <!-- Detail Button -->
                  <a
                    href="{{ route('admin.users.detail', $u->id) }}"
                    class="p-2 rounded-xl text-gray-500 hover:text-brand-600 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-brand-400 transition-colors"
                    title="Lihat Detail Profil & Sesi"
                    aria-label="Detail {{ $u->name }}"
                  >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                  </a>

                  <!-- Edit Button -->
                  <button
                    type="button"
                    @click="openEditModal({{ json_encode([
                      'id' => $u->id,
                      'name' => $u->name,
                      'email' => $u->email,
                      'role' => $u->role,
                      'nisn' => $u->nisn,
                      'kelas' => $u->kelas,
                      'no_hp' => $u->no_hp,
                      'is_active' => (bool) $u->is_active,
                    ]) }})"
                    class="p-2 rounded-xl text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-950/50 transition-colors cursor-pointer"
                    title="Edit Akun Pengguna"
                    aria-label="Edit Akun {{ $u->name }}"
                  >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                  </button>

                  <!-- Toggle Status Form -->
                  <form id="toggle-user-form-{{ $u->id }}" method="POST" action="{{ route('admin.users.toggle', $u->id) }}">
                    @csrf
                    @method('PATCH')
                    @if($u->is_active)
                      <button
                        type="button"
                        onclick="showConfirmModal({
                          title: 'Nonaktifkan Akun Pengguna?',
                          message: 'Apakah Anda yakin ingin menonaktifkan akun {{ addslashes($u->name) }}? Pengguna ini tidak akan dapat login ke sistem hingga diaktifkan kembali.',
                          confirmText: 'Ya, Nonaktifkan',
                          cancelText: 'Batal',
                          type: 'warning',
                          onConfirm: () => document.getElementById('toggle-user-form-{{ $u->id }}').submit()
                        })"
                        class="p-2 rounded-xl text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-950/50 transition-colors cursor-pointer"
                        title="Nonaktifkan Akun"
                        aria-label="Nonaktifkan Akun {{ $u->name }}"
                      >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                      </button>
                    @else
                      <button
                        type="button"
                        onclick="showConfirmModal({
                          title: 'Aktifkan Akun Pengguna?',
                          message: 'Apakah Anda yakin ingin mengaktifkan akun {{ addslashes($u->name) }}? Pengguna ini akan dapat login dan menggunakan hak aksesnya kembali.',
                          confirmText: 'Ya, Aktifkan',
                          cancelText: 'Batal',
                          type: 'success',
                          onConfirm: () => document.getElementById('toggle-user-form-{{ $u->id }}').submit()
                        })"
                        class="p-2 rounded-xl text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-950/50 transition-colors cursor-pointer"
                        title="Aktifkan Akun"
                        aria-label="Aktifkan Akun {{ $u->name }}"
                      >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                      </button>
                    @endif
                  </form>

                  <!-- Delete User Form -->
                  <form id="delete-user-form-{{ $u->id }}" method="POST" action="{{ route('admin.users.destroy', $u->id) }}">
                    @csrf
                    @method('DELETE')
                    <button
                      type="button"
                      onclick="showConfirmModal({
                        title: 'Hapus Akun Pengguna?',
                        message: 'Apakah Anda yakin ingin menghapus akun {{ addslashes($u->name) }} ({{ $u->email }})? Tindakan ini akan menghapus data akun secara permanen.',
                        confirmText: 'Ya, Hapus Akun',
                        cancelText: 'Batal',
                        type: 'danger',
                        onConfirm: () => document.getElementById('delete-user-form-{{ $u->id }}').submit()
                      })"
                      class="p-2 rounded-xl text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/50 transition-colors cursor-pointer"
                      title="Hapus Akun Pengguna"
                      aria-label="Hapus Akun {{ $u->name }}"
                    >
                      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </svg>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="py-12 text-center text-gray-400 text-xs">
                Tidak ada pengguna yang cocok dengan kriteria filter.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
      <div class="p-6 border-t border-gray-100 dark:border-gray-800">
        {{ $users->links() }}
      </div>
    @endif
  </div>

  <!-- Modal Form Tambah Pengguna Baru (SRS F-06) -->
  <div
    x-show="modalTambah"
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
      @click.outside="modalTambah = false"
      class="w-full max-w-lg rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-2xl p-6 sm:p-8 space-y-6"
    >
      <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
        <div>
          <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tambah Pengguna Baru</h3>
          <p class="text-xs text-gray-400">Buat akun Guru BK, Admin, atau Siswa secara manual (SRS F-06).</p>
        </div>
        <button type="button" @click="modalTambah = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
      </div>

      <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
        @csrf

        <!-- Nama Lengkap -->
        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap & Gelar *</label>
          <input
            type="text"
            name="name"
            required
            placeholder="Contoh: Dra. Siti Rahmawati, M.Pd"
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
              required
              placeholder="siti.rahma@sman4jember.sch.id"
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
              <option value="guru_bk" selected>Guru BK</option>
              <option value="admin">Administrator</option>
              <option value="siswa">Siswa</option>
            </select>
          </div>
        </div>

        <!-- NISN & Kelas (Opsional untuk Siswa) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">NISN (Khusus Siswa)</label>
            <input
              type="text"
              name="nisn"
              placeholder="0071234567"
              class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
            />
          </div>

          <div>
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Kelas (Khusus Siswa)</label>
            <input
              type="text"
              name="kelas"
              placeholder="XII MIPA 1"
              class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
            />
          </div>
        </div>

        <!-- No HP -->
        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">No. WhatsApp / HP</label>
          <input
            type="text"
            name="no_hp"
            placeholder="081234567890"
            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
          />
        </div>

        <!-- Password Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Kata Sandi (Min 8) *</label>
            <input
              type="password"
              name="password"
              required
              class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
            />
          </div>

          <div>
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Konfirmasi Sandi *</label>
            <input
              type="password"
              name="password_confirmation"
              required
              class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
            />
          </div>
        </div>

        <div class="pt-4 border-t border-gray-100 dark:border-gray-800 flex items-center justify-end gap-3">
          <button
            type="button"
            @click="modalTambah = false"
            class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800"
          >
            Batal
          </button>
          <button
            type="submit"
            class="px-5 py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-md shadow-brand-500/20"
          >
            Simpan Akun
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Form Import Data Siswa (Excel/CSV) -->
  <div
    x-show="modalImport"
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
      @click.outside="modalImport = false"
      class="w-full max-w-lg rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-2xl p-6 sm:p-8 space-y-6"
    >
      <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
        <div>
          <h3 class="text-lg font-bold text-gray-900 dark:text-white">Import Data Siswa</h3>
          <p class="text-xs text-gray-400">Unggah file Excel (.xlsx, .xls) atau CSV (.csv) data siswa untuk prapendaftaran.</p>
        </div>
        <button type="button" @click="modalImport = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 cursor-pointer">
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
      </div>

      <!-- Info Box & Template Link -->
      <div class="p-4 rounded-2xl bg-brand-50 dark:bg-brand-950/40 border border-brand-200 dark:border-brand-800/60 text-xs text-brand-800 dark:text-brand-300 space-y-2">
        <div class="flex items-center justify-between font-bold">
          <span>Panduan Format Data</span>
          <a href="{{ route('admin.siswa.template') }}" class="underline hover:text-brand-600 flex items-center gap-1">
            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
            Unduh Template CSV
          </a>
        </div>
        <p class="text-[11px] leading-relaxed text-brand-700 dark:text-brand-400">
          Pastikan file memuat kolom header: <strong>Nama</strong>, <strong>NISN</strong>, <strong>NIS</strong>, <strong>Kelas</strong>, <strong>Jenis Kelamin (L/P)</strong>, dan <strong>No HP</strong>. Siswa yang diimpor dapat langsung mengaktivasi akunnya secara mandiri menggunakan NIS atau NISN.
        </p>
      </div>

      <form method="POST" action="{{ route('admin.siswa.import') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-2">Pilih File Excel / CSV *</label>
          <input
            type="file"
            name="file"
            accept=".csv, .xlsx, .xls, text/csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
            required
            class="w-full text-xs text-gray-500 dark:text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 dark:file:bg-brand-950/60 dark:file:text-brand-300 border border-gray-200 dark:border-gray-700 rounded-2xl p-2 bg-gray-50/50 dark:bg-gray-800"
          />
          <p class="text-[11px] text-gray-400 mt-1">Maksimum ukuran file: 5 MB.</p>
        </div>

        <div class="pt-4 border-t border-gray-100 dark:border-gray-800 flex items-center justify-end gap-3">
          <button
            type="button"
            @click="modalImport = false"
            class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer"
          >
            Batal
          </button>
          <button
            type="submit"
            class="px-5 py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-md shadow-brand-500/20 inline-flex items-center gap-1.5 cursor-pointer"
          >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
            <span>Mulai Impor Data</span>
          </button>
        </div>
      </form>
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

      <form method="POST" :action="'{{ url('admin/users') }}/' + editUser.id" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Nama Lengkap -->
        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap & Gelar *</label>
          <input
            type="text"
            name="name"
            x-model="editUser.name"
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
              x-model="editUser.email"
              required
              class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
            />
          </div>

          <div>
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Role Akun *</label>
            <select
              name="role"
              x-model="editUser.role"
              required
              class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
            >
              <option value="guru_bk">Guru BK</option>
              <option value="admin">Administrator</option>
              <option value="siswa">Siswa</option>
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
              x-model="editUser.nisn"
              placeholder="0071234567"
              class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
            />
          </div>

          <div>
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Kelas (Khusus Siswa)</label>
            <input
              type="text"
              name="kelas"
              x-model="editUser.kelas"
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
              x-model="editUser.no_hp"
              placeholder="081234567890"
              class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
            />
          </div>

          <div>
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Status Akun *</label>
            <select
              name="is_active"
              x-model="editUser.is_active"
              class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
            >
              <option :value="1">Aktif</option>
              <option :value="0">Nonaktif</option>
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
