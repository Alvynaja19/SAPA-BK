@extends('layouts.tailadmin')

@section('title', 'Profil Guru BK | SAPA BK SMAN 4 Jember')

@section('content')
<div class="space-y-6">

  <!-- Breadcrumb & Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs font-semibold text-brand-600 dark:text-brand-400 uppercase tracking-wider mb-1">
        <span>Dashboard BK</span>
        <svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span>Pengaturan Akun</span>
        <svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-500 dark:text-gray-400">Profil Saya</span>
      </div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
        Profil Akun Guru BK
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
        Kelola identitas konselor bimbingan, foto profil resmi, kontak koordinasi, dan kredensial keamanan akun Anda.
      </p>
    </div>

    <!-- Status Badge -->
    <div class="flex items-center gap-2 self-start sm:self-auto">
      <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/60 shadow-xs">
        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
        <span>Akun Guru BK Terverifikasi</span>
      </span>
    </div>
  </div>

  <!-- Identity Card Overview -->
  <div class="rounded-3xl bg-white dark:bg-gray-900 p-6 sm:p-7 border border-gray-100 dark:border-gray-800 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
    <div class="flex items-center gap-5">
      <!-- Avatar Big Box -->
      <div class="h-20 w-20 rounded-2xl bg-gradient-to-tr from-brand-700 to-brand-500 text-white font-extrabold text-2xl flex items-center justify-center shrink-0 shadow-md shadow-brand-700/20 overflow-hidden">
        <img
          id="overviewAvatarImg"
          src="{{ $user->avatar_url }}"
          alt="{{ $user->name }}"
          class="h-full w-full object-cover"
          style="{{ !$user->avatar ? 'display: none;' : '' }}"
        />
        <span id="overviewAvatarInitials" style="{{ $user->avatar ? 'display: none;' : '' }}">
          {{ strtoupper(substr($user->name, 0, 2)) }}
        </span>
      </div>

      <!-- Identity Metadata -->
      <div class="space-y-1">
        <div class="flex items-center gap-2.5 flex-wrap">
          <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white" id="overviewName">
            {{ $user->name }}
          </h2>
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-brand-950/50 dark:text-brand-300 dark:border-brand-800">
            {{ $user->isAdmin() ? 'Administrator' : 'Guru Bimbingan Konseling' }}
          </span>
        </div>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
          <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
          </svg>
          <span>{{ $user->email }}</span>
        </p>

        <!-- Quick Tags -->
        <div class="flex items-center gap-2 pt-1 flex-wrap text-xs text-gray-600 dark:text-gray-300">
          <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-gray-50 dark:bg-gray-800 border border-gray-200/80 dark:border-gray-700/80 font-medium">
            <svg class="h-3.5 w-3.5 text-brand-600 dark:text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <span>SMAN 4 Jember</span>
          </span>

          <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-gray-50 dark:bg-gray-800 border border-gray-200/80 dark:border-gray-700/80 font-medium">
            <svg class="h-3.5 w-3.5 text-brand-600 dark:text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>
            <span id="overviewPhone">{{ $user->no_hp ? preg_replace('/\.0+$/', '', (string)$user->no_hp) : 'Belum ada nomor kontak' }}</span>
          </span>

          <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50/60 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/40 font-semibold">
            <svg class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Aktif Melayani Siswa</span>
          </span>
        </div>
      </div>
    </div>

    <!-- Quick Tips -->
    <div class="w-full md:w-auto p-4 rounded-2xl bg-brand-50/50 dark:bg-brand-950/20 border border-brand-100 dark:border-brand-900/40 text-xs text-brand-900 dark:text-brand-200 md:max-w-xs space-y-1">
      <div class="font-bold flex items-center gap-1.5 text-brand-800 dark:text-brand-300">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>Informasi Akun</span>
      </div>
      <p class="text-gray-600 dark:text-gray-300 text-[11.5px] leading-relaxed">
        Foto profil dan nama lengkap Anda akan ditampilkan pada halaman sesi bimbingan siswa saat konsultasi tatap muka digital.
      </p>
    </div>
  </div>

  <!-- Form Card -->
  <div class="rounded-3xl bg-white dark:bg-gray-900 p-6 sm:p-8 border border-gray-100 dark:border-gray-800 shadow-xs">
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-8" id="profileForm">
      @csrf
      @method('PUT')

      <!-- Hidden inputs for camera capture & remove avatar -->
      <input type="hidden" name="captured_avatar" id="capturedAvatarInput" value="">
      <input type="hidden" name="remove_avatar" id="removeAvatarInput" value="0">

      <!-- ================= SECTION 1: FOTO PROFIL ================= -->
      <div class="space-y-4">
        <div>
          <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="h-5 w-5 text-brand-600 dark:text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span>Foto Profil Resmi Guru BK</span>
          </h3>
          <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            Gunakan foto formal atau semi-formal berlatar rapi agar siswa mudah mengenali guru pembimbing mereka.
          </p>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-6 p-5 rounded-2xl bg-gray-50/70 dark:bg-gray-800/40 border border-gray-100 dark:border-gray-800">
          <!-- Avatar Preview Frame -->
          <div class="relative group">
            <div class="h-24 w-24 rounded-2xl bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 shadow-sm flex items-center justify-center font-extrabold text-2xl text-gray-700 dark:text-gray-200 overflow-hidden shrink-0">
              <img
                id="formAvatarImg"
                src="{{ $user->avatar_url }}"
                alt="{{ $user->name }}"
                class="h-full w-full object-cover"
                style="{{ !$user->avatar ? 'display: none;' : '' }}"
              />
              <span id="formAvatarInitials" style="{{ $user->avatar ? 'display: none;' : '' }}">
                {{ strtoupper(substr($user->name, 0, 2)) }}
              </span>
            </div>
          </div>

          <!-- Buttons & Instruction -->
          <div class="space-y-3 text-center sm:text-left flex-1">
            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3">
              <!-- Upload Button -->
              <label
                for="inputAvatarFile"
                class="min-h-[44px] px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-semibold text-xs inline-flex items-center gap-2 cursor-pointer shadow-md shadow-brand-600/20 transition-all focus:outline-hidden focus:ring-2 focus:ring-brand-500"
              >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                <span>Unggah Berkas</span>
              </label>
              <input
                type="file"
                id="inputAvatarFile"
                name="avatar"
                accept="image/png,image/jpeg,image/jpg,image/webp"
                class="hidden"
                onchange="handleFileSelect(this)"
              />

              <!-- Camera Button -->
              <button
                type="button"
                onclick="openCameraModal()"
                class="min-h-[44px] px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-750 text-gray-700 dark:text-gray-200 font-semibold text-xs inline-flex items-center gap-2 cursor-pointer shadow-xs transition-colors focus:outline-hidden focus:ring-2 focus:ring-gray-300"
              >
                <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Gunakan Kamera</span>
              </button>

              <!-- Remove Avatar Button -->
              <button
                type="button"
                id="btnRemoveAvatar"
                onclick="resetAvatar()"
                class="min-h-[44px] px-4 py-2.5 rounded-xl border border-rose-200 dark:border-rose-900/60 bg-rose-50/70 hover:bg-rose-100 dark:bg-rose-950/40 dark:hover:bg-rose-900/60 text-rose-700 dark:text-rose-300 font-semibold text-xs inline-flex items-center gap-2 cursor-pointer transition-colors focus:outline-hidden focus:ring-2 focus:ring-rose-300"
                style="{{ !$user->avatar ? 'display: none;' : '' }}"
              >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                <span>Hapus Foto</span>
              </button>
            </div>
            <p class="text-[11px] text-gray-500 dark:text-gray-400">
              Format yang didukung: JPG, PNG, atau WEBP dengan ukuran berkas maksimal 2MB. Foto disimpan setelah menekan "Simpan Perubahan Profil".
            </p>
          </div>
        </div>
      </div>

      <div class="border-t border-gray-100 dark:border-gray-800" style="margin-top: 2.25rem; margin-bottom: 2.25rem;"></div>

      <!-- ================= SECTION 2: DATA POKOK GURU BK ================= -->
      <div class="space-y-4">
        <div>
          <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="h-5 w-5 text-brand-600 dark:text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span>Data Identitas Guru Bimbingan Konseling</span>
          </h3>
          <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            Pastikan nama lengkap dan nomor kontak koordinasi sudah sesuai untuk kebutuhan bimbingan siswa.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <!-- Nama Lengkap (Editable) -->
          <div class="space-y-1.5">
            <label for="inputName" class="block text-xs font-bold text-gray-700 dark:text-gray-300">
              Nama Lengkap beserta Gelar Akademik <span class="text-rose-500">*</span>
            </label>
            <input
              type="text"
              id="inputName"
              name="name"
              value="{{ old('name', $user->name) }}"
              required
              class="w-full px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all font-medium"
              placeholder="Contoh: Habibie S.T, M.Pd"
            />
            <p class="text-[11px] text-gray-500 dark:text-gray-400">
              Nama resmi yang tampil pada sesi bimbingan konseling dan rekapitulasi siswa.
            </p>
          </div>

          <!-- Email Terdaftar (Terkunci) -->
          <div class="space-y-1.5">
            <div class="flex items-center justify-between">
              <label for="inputEmail" class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                Alamat Email Resmi
              </label>
              <span class="inline-flex items-center gap-1 text-[10.5px] font-semibold text-gray-400 dark:text-gray-500">
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Terkunci
              </span>
            </div>
            <input
              type="email"
              id="inputEmail"
              value="{{ $user->email }}"
              disabled
              class="w-full px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-gray-200 dark:border-gray-700 bg-gray-100/80 dark:bg-gray-800/80 text-gray-500 dark:text-gray-400 cursor-not-allowed font-medium"
            />
            <p class="text-[11px] text-gray-500 dark:text-gray-400">
              Email resmi sekolah terhubung dengan autentikasi akun SAPA BK SMAN 4 Jember.
            </p>
          </div>

          <!-- Nomor Telepon / WhatsApp (Editable) -->
          <div class="space-y-1.5">
            <label for="inputNoHp" class="block text-xs font-bold text-gray-700 dark:text-gray-300">
              Nomor Telepon / WhatsApp Aktif
            </label>
            <input
              type="text"
              id="inputNoHp"
              name="no_hp"
              value="{{ old('no_hp', preg_replace('/\.0+$/', '', (string)$user->no_hp)) }}"
              class="w-full px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all font-medium"
              placeholder="Contoh: 081234567890"
            />
            <p class="text-[11px] text-gray-500 dark:text-gray-400">
              Digunakan saat koordinasi sesi konsultasi lanjutan atau notifikasi konseling siswa.
            </p>
          </div>

          <!-- Unit Penugasan (Terkunci) -->
          <div class="space-y-1.5">
            <div class="flex items-center justify-between">
              <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                Unit Penugasan Layanan
              </label>
              <span class="inline-flex items-center gap-1 text-[10.5px] font-semibold text-gray-400 dark:text-gray-500">
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Terkunci
              </span>
            </div>
            <input
              type="text"
              value="SMA Negeri 4 Jember : Layanan Bimbingan Konseling"
              disabled
              class="w-full px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-gray-200 dark:border-gray-700 bg-gray-100/80 dark:bg-gray-800/80 text-gray-500 dark:text-gray-400 cursor-not-allowed font-medium"
            />
            <p class="text-[11px] text-gray-500 dark:text-gray-400">
              Unit organisasi resmi bimbingan konseling di bawah naungan SMA Negeri 4 Jember.
            </p>
          </div>
        </div>
      </div>

      <div class="border-t border-gray-100 dark:border-gray-800" style="margin-top: 2.25rem; margin-bottom: 2.25rem;"></div>

      <!-- ================= SECTION 3: KEAMANAN & KATA SANDI ================= -->
      <div class="space-y-4">
        <div>
          <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="h-5 w-5 text-brand-600 dark:text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <span>Keamanan &amp; Perubahan Kata Sandi</span>
          </h3>
          <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            Kosongkan kedua kolom di bawah jika Anda tidak berencana mengganti kata sandi saat ini.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <!-- Kata Sandi Baru -->
          <div class="space-y-1.5">
            <label for="inputPassword" class="block text-xs font-bold text-gray-700 dark:text-gray-300">
              Kata Sandi Baru
            </label>
            <input
              type="password"
              id="inputPassword"
              name="password"
              autocomplete="new-password"
              class="w-full px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all font-medium"
              placeholder="Minimal 8 karakter"
            />
            <p class="text-[11px] text-gray-500 dark:text-gray-400">
              Gunakan kombinasi huruf, angka, dan simbol untuk keamanan maksimal.
            </p>
          </div>

          <!-- Konfirmasi Kata Sandi Baru -->
          <div class="space-y-1.5">
            <label for="inputPasswordConfirmation" class="block text-xs font-bold text-gray-700 dark:text-gray-300">
              Ulangi Kata Sandi Baru
            </label>
            <input
              type="password"
              id="inputPasswordConfirmation"
              name="password_confirmation"
              autocomplete="new-password"
              class="w-full px-4 py-2.5 rounded-xl text-xs sm:text-sm border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all font-medium"
              placeholder="Ulangi kata sandi baru"
            />
            <p class="text-[11px] text-gray-500 dark:text-gray-400">
              Pastikan kata sandi sama persis dengan kolom sebelumnya.
            </p>
          </div>
        </div>
      </div>

      <!-- ================= SUBMIT ACTION BAR ================= -->
      <div class="border-t border-gray-100 dark:border-gray-800 pt-8 sm:pt-10 mt-8 sm:mt-12 flex flex-col sm:flex-row items-center justify-between gap-5" style="margin-top: 3rem; padding-top: 2rem;">
        <div class="flex items-center gap-2.5 text-xs text-gray-500 dark:text-gray-400 text-center sm:text-left max-w-md">
          <svg class="h-4 w-4 text-brand-600 dark:text-brand-400 shrink-0 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span class="leading-relaxed">Perubahan profil langsung aktif di seluruh sistem SAPA BK setelah disimpan.</span>
        </div>

        <button
          type="submit"
          class="w-full sm:w-auto min-h-[46px] px-7 py-3 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs sm:text-sm shadow-md shadow-brand-600/25 transition-all inline-flex items-center justify-center gap-2 cursor-pointer focus:outline-hidden focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 shrink-0"
        >
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          <span>Simpan Perubahan Profil</span>
        </button>
      </div>

    </form>
  </div>

</div>

<!-- TailAdmin Modern Camera Modal Dialog -->
<div
  id="cameraModalBackdrop"
  class="fixed inset-0 z-[99999] bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 transition-opacity duration-200 opacity-0 pointer-events-none"
  role="dialog"
  aria-modal="true"
  aria-labelledby="cameraModalTitle"
>
  <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-2xl max-w-md w-full overflow-hidden transform scale-95 transition-transform duration-200">
    
    <!-- Modal Header -->
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800">
      <div class="flex items-center gap-2 text-sm font-bold text-gray-900 dark:text-white" id="cameraModalTitle">
        <svg class="h-5 w-5 text-brand-600 dark:text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span>Ambil Foto Profil via Kamera</span>
      </div>
      <button
        type="button"
        onclick="closeCameraModal()"
        class="h-8 w-8 rounded-xl flex items-center justify-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer"
        aria-label="Tutup kamera"
      >
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <!-- Viewfinder Area -->
    <div class="p-6 bg-gray-50 dark:bg-gray-950 flex flex-col items-center justify-center min-h-[300px] relative">
      <!-- Live Video Element -->
      <video
        id="cameraVideo"
        class="w-full aspect-square object-cover rounded-2xl border-2 border-brand-500 shadow-md bg-black"
        autoplay
        playsinline
        muted
        style="display: none;"
      ></video>

      <!-- Canvas for Capturing Frame -->
      <canvas id="cameraCanvas" style="display: none;"></canvas>

      <!-- Preview Image after Capture -->
      <img
        id="cameraCapturedImg"
        class="w-full aspect-square object-cover rounded-2xl border-2 border-brand-500 shadow-md bg-black"
        style="display: none;"
        alt="Hasil Jepretan Kamera"
      />

      <!-- Status or Error Message Placeholder -->
      <div id="cameraPlaceholder" class="text-center p-6 space-y-3">
        <div class="h-12 w-12 rounded-2xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center mx-auto">
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
          </svg>
        </div>
        <p id="cameraErrorMessage" class="text-xs text-gray-600 dark:text-gray-300 max-w-xs mx-auto leading-relaxed">
          Sedang menghubungkan ke modul kamera perangkat...
        </p>
      </div>
    </div>

    <!-- Modal Controls Footer -->
    <div class="p-5 border-t border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900">
      <!-- State 1: Streaming Live -->
      <div id="cameraLiveControls" class="flex items-center justify-between gap-3">
        <button
          type="button"
          onclick="closeCameraModal()"
          class="min-h-[44px] px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-750 text-gray-700 dark:text-gray-200 font-semibold text-xs cursor-pointer transition-colors"
        >
          Batal
        </button>
        <button
          type="button"
          id="btnCaptureFrame"
          onclick="capturePhoto()"
          class="min-h-[44px] px-5 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs inline-flex items-center gap-2 cursor-pointer shadow-md shadow-brand-600/20 transition-all"
        >
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
          </svg>
          <span>Ambil Foto</span>
        </button>
      </div>

      <!-- State 2: Reviewing Captured Photo -->
      <div id="cameraReviewControls" class="flex items-center justify-between gap-3" style="display: none;">
        <button
          type="button"
          onclick="retakePhoto()"
          class="min-h-[44px] px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-750 text-gray-700 dark:text-gray-200 font-semibold text-xs inline-flex items-center gap-1.5 cursor-pointer transition-colors"
        >
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
          </svg>
          <span>Foto Ulang</span>
        </button>
        <button
          type="button"
          onclick="useCapturedPhoto()"
          class="min-h-[44px] px-5 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs inline-flex items-center gap-2 cursor-pointer shadow-md shadow-brand-600/20 transition-all"
        >
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          <span>Gunakan Foto Ini</span>
        </button>
      </div>
    </div>

  </div>
</div>
@endsection

@push('scripts')
<script>
  let cameraStream = null;
  const cameraModalBackdrop = document.getElementById('cameraModalBackdrop');
  const cameraVideo = document.getElementById('cameraVideo');
  const cameraCanvas = document.getElementById('cameraCanvas');
  const cameraCapturedImg = document.getElementById('cameraCapturedImg');
  const cameraPlaceholder = document.getElementById('cameraPlaceholder');
  const cameraErrorMessage = document.getElementById('cameraErrorMessage');
  const cameraLiveControls = document.getElementById('cameraLiveControls');
  const cameraReviewControls = document.getElementById('cameraReviewControls');

  const capturedAvatarInput = document.getElementById('capturedAvatarInput');
  const removeAvatarInput = document.getElementById('removeAvatarInput');
  const inputAvatarFile = document.getElementById('inputAvatarFile');
  const formAvatarImg = document.getElementById('formAvatarImg');
  const formAvatarInitials = document.getElementById('formAvatarInitials');
  const btnRemoveAvatar = document.getElementById('btnRemoveAvatar');

  const overviewAvatarImg = document.getElementById('overviewAvatarImg');
  const overviewAvatarInitials = document.getElementById('overviewAvatarInitials');

  async function openCameraModal() {
    cameraModalBackdrop.classList.remove('opacity-0', 'pointer-events-none');
    cameraModalBackdrop.classList.add('opacity-100', 'pointer-events-auto');
    const box = cameraModalBackdrop.querySelector('div');
    if (box) {
      box.classList.remove('scale-95');
      box.classList.add('scale-100');
    }

    cameraVideo.style.display = 'none';
    cameraCapturedImg.style.display = 'none';
    cameraPlaceholder.style.display = 'block';
    cameraErrorMessage.textContent = 'Meminta izin akses kamera perangkat...';
    cameraLiveControls.style.display = 'flex';
    cameraReviewControls.style.display = 'none';

    try {
      cameraStream = await navigator.mediaDevices.getUserMedia({
        video: {
          width: { ideal: 720 },
          height: { ideal: 720 },
          facingMode: 'user'
        },
        audio: false
      });
      cameraVideo.srcObject = cameraStream;
      cameraVideo.onloadedmetadata = () => {
        cameraVideo.play();
        cameraVideo.style.display = 'block';
        cameraPlaceholder.style.display = 'none';
      };
    } catch (err) {
      console.error('Camera access error:', err);
      cameraPlaceholder.style.display = 'block';
      let msg = 'Kamera tidak dapat diakses. Pastikan Anda telah memberikan izin akses kamera pada peramban, atau gunakan opsi unggah berkas.';
      if (err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError') {
        msg = 'Izin kamera ditolak oleh pengguna. Silakan aktifkan izin kamera pada peramban Anda untuk mengambil foto.';
      } else if (err.name === 'NotFoundError' || err.name === 'DevicesNotFoundError') {
        msg = 'Perangkat kamera tidak terdeteksi pada perangkat ini. Silakan gunakan opsi unggah berkas foto.';
      }
      cameraErrorMessage.textContent = msg;
    }
  }

  function stopCameraStream() {
    if (cameraStream) {
      cameraStream.getTracks().forEach(track => track.stop());
      cameraStream = null;
    }
    if (cameraVideo) {
      cameraVideo.srcObject = null;
    }
  }

  function closeCameraModal() {
    stopCameraStream();
    cameraModalBackdrop.classList.remove('opacity-100', 'pointer-events-auto');
    cameraModalBackdrop.classList.add('opacity-0', 'pointer-events-none');
    const box = cameraModalBackdrop.querySelector('div');
    if (box) {
      box.classList.remove('scale-100');
      box.classList.add('scale-95');
    }
  }

  function capturePhoto() {
    if (!cameraStream || !cameraVideo.videoWidth) return;
    const maxDim = 800;
    let width = cameraVideo.videoWidth;
    let height = cameraVideo.videoHeight;

    if (width > height) {
      if (width > maxDim) {
        height = Math.round((height * maxDim) / width);
        width = maxDim;
      }
    } else {
      if (height > maxDim) {
        width = Math.round((width * maxDim) / height);
        height = maxDim;
      }
    }

    cameraCanvas.width = width;
    cameraCanvas.height = height;

    const ctx = cameraCanvas.getContext('2d');
    ctx.drawImage(cameraVideo, 0, 0, width, height);

    const dataUrl = cameraCanvas.toDataURL('image/jpeg', 0.85);
    cameraCapturedImg.src = dataUrl;
    cameraCapturedImg.style.display = 'block';
    cameraVideo.style.display = 'none';

    cameraLiveControls.style.display = 'none';
    cameraReviewControls.style.display = 'flex';
  }

  function retakePhoto() {
    cameraCapturedImg.style.display = 'none';
    cameraVideo.style.display = 'block';
    cameraLiveControls.style.display = 'flex';
    cameraReviewControls.style.display = 'none';
  }

  function useCapturedPhoto() {
    const dataUrl = cameraCapturedImg.src;
    capturedAvatarInput.value = dataUrl;
    inputAvatarFile.value = '';
    removeAvatarInput.value = '0';

    formAvatarImg.src = dataUrl;
    formAvatarImg.style.display = 'block';
    if (formAvatarInitials) formAvatarInitials.style.display = 'none';

    if (overviewAvatarImg) {
      overviewAvatarImg.src = dataUrl;
      overviewAvatarImg.style.display = 'block';
    }
    if (overviewAvatarInitials) overviewAvatarInitials.style.display = 'none';

    if (btnRemoveAvatar) btnRemoveAvatar.style.display = 'inline-flex';
    closeCameraModal();
  }

  function handleFileSelect(input) {
    if (input.files && input.files[0]) {
      const file = input.files[0];
      const reader = new FileReader();
      reader.onload = function(e) {
        const img = new Image();
        img.onload = function() {
          const maxDim = 800;
          let width = img.width;
          let height = img.height;

          if (width > height) {
            if (width > maxDim) {
              height = Math.round((height * maxDim) / width);
              width = maxDim;
            }
          } else {
            if (height > maxDim) {
              width = Math.round((width * maxDim) / height);
              height = maxDim;
            }
          }

          const canvas = document.createElement('canvas');
          canvas.width = width;
          canvas.height = height;
          const ctx = canvas.getContext('2d');
          ctx.drawImage(img, 0, 0, width, height);

          // Kompresi otomatis gambar ke JPEG kualitas 85% untuk efisiensi transfer data
          const compressedDataUrl = canvas.toDataURL('image/jpeg', 0.85);

          capturedAvatarInput.value = compressedDataUrl;
          input.value = '';
          removeAvatarInput.value = '0';

          formAvatarImg.src = compressedDataUrl;
          formAvatarImg.style.display = 'block';
          if (formAvatarInitials) formAvatarInitials.style.display = 'none';

          if (overviewAvatarImg) {
            overviewAvatarImg.src = compressedDataUrl;
            overviewAvatarImg.style.display = 'block';
          }
          if (overviewAvatarInitials) overviewAvatarInitials.style.display = 'none';

          if (btnRemoveAvatar) btnRemoveAvatar.style.display = 'inline-flex';
        };
        img.src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  }

  function resetAvatar() {
    inputAvatarFile.value = '';
    capturedAvatarInput.value = '';
    removeAvatarInput.value = '1';

    formAvatarImg.src = '';
    formAvatarImg.style.display = 'none';
    if (formAvatarInitials) formAvatarInitials.style.display = 'block';

    if (overviewAvatarImg) {
      overviewAvatarImg.src = '';
      overviewAvatarImg.style.display = 'none';
    }
    if (overviewAvatarInitials) overviewAvatarInitials.style.display = 'block';

    if (btnRemoveAvatar) btnRemoveAvatar.style.display = 'none';
  }

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && cameraModalBackdrop.classList.contains('opacity-100')) {
      closeCameraModal();
    }
  });

  cameraModalBackdrop.addEventListener('click', function(e) {
    if (e.target === cameraModalBackdrop) {
      closeCameraModal();
    }
  });
</script>
@endpush
