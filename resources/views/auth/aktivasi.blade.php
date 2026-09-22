@extends('layouts.auth')

@section('title', 'Aktivasi Akun Siswa : SAPA BK SMAN 4 Jember')

@section('content')
  <!-- Card Header -->
  <div class="auth-header">
    <div class="auth-badge">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg>
      <span>Aktivasi Akun Siswa</span>
    </div>
    <h1 class="auth-title">Aktivasi Akun SAPA BK</h1>
    <p class="auth-lede">Khusus siswa SMA Negeri 4 Jember yang telah terdaftar dalam sistem bimbingan konseling.</p>
  </div>

  <!-- Flash / Error Alerts -->
  @if (isset($errors) && $errors->any())
    <div class="alert-box alert-danger">
      <div class="alert-icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
      </div>
      <div>
        <strong>Perhatian:</strong>
        <ul class="alert-list">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  @endif

  @if (session('success'))
    <div class="alert-box alert-success">
      <div class="alert-icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      </div>
      <div>
        {{ session('success') }}
      </div>
    </div>
  @endif

  @if (! $foundStudent)
    <!-- ==================== TAHAP 1: LOOKUP NIS/NISN ==================== -->
    <form method="POST" action="{{ route('aktivasi.lookup') }}" class="auth-form" novalidate>
      @csrf

      <div class="form-group">
        <label for="nis_nisn" class="form-label">
          <span>Nomor Induk Siswa (NIS atau NISN)</span>
          <span class="required">*</span>
        </label>
        <div class="input-wrap">
          <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
          <input
            type="text"
            id="nis_nisn"
            name="nis_nisn"
            value="{{ old('nis_nisn') }}"
            placeholder="Masukkan NIS atau NISN terdaftar"
            required
            autofocus
            class="form-input @error('nis_nisn') is-invalid @enderror"
          />
        </div>
        <p class="form-hint">Contoh: 0054321987 (NISN) atau 12345 (NIS sekolah).</p>
      </div>

      <button type="submit" class="btn-submit">
        <span>Cari Data Siswa</span>
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
      </button>
    </form>

  @elseif ($foundStudent && ! $otpSent)
    <!-- ==================== TAHAP 2: SET EMAIL & PASSWORD ==================== -->
    <!-- Card Data Siswa Ditemukan -->
    <div style="background: var(--bg-alt); border: 1px solid var(--line); border-radius: var(--radius-m); padding: 18px 20px; margin-bottom: 24px;">
      <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 12px;">
        <div>
          <span style="font-size: 11px; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 1px;">Siswa Terdaftar</span>
          <h3 style="font-size: 16px; font-weight: 700; color: var(--ink); margin: 2px 0;">{{ $foundStudent['nama'] }}</h3>
          <p style="font-size: 12px; color: var(--ink-soft); margin: 0;">
            Kelas: <strong>{{ $foundStudent['kelas'] ?? 'Belum terdata' }}</strong> |
            NISN: <strong>{{ $foundStudent['nisn'] ?? '-' }}</strong> |
            NIS: <strong>{{ $foundStudent['nis'] ?? '-' }}</strong>
          </p>
        </div>
        <form method="POST" action="{{ route('aktivasi.reset') }}">
          @csrf
          <button type="submit" style="background: none; border: 1px solid var(--line); border-radius: var(--radius-s); padding: 4px 10px; font-size: 11px; font-weight: 600; color: var(--ink-faint); cursor: pointer;">
            Ganti NIS / NISN
          </button>
        </form>
      </div>
    </div>

    <form method="POST" action="{{ route('aktivasi.send-otp') }}" class="auth-form" novalidate>
      @csrf
      <input type="hidden" name="student_id" value="{{ $foundStudent['id'] }}">

      <div class="form-group">
        <label for="email" class="form-label">
          <span>Alamat Email Pribadi (Aktif)</span>
          <span class="required">*</span>
        </label>
        <div class="input-wrap">
          <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
          <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            placeholder="siswa@gmail.com"
            required
            class="form-input @error('email') is-invalid @enderror"
          />
        </div>
        <p class="form-hint">Kode verifikasi OTP akan dikirimkan ke alamat email ini.</p>
      </div>

      <div class="form-group">
        <label for="password" class="form-label">
          <span>Buat Kata Sandi Baru</span>
          <span class="required">*</span>
        </label>
        <div class="input-wrap">
          <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Minimal 8 karakter"
            required
            class="form-input @error('password') is-invalid @enderror"
          />
          <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password', this)" aria-label="Lihat kata sandi">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>

      <div class="form-group">
        <label for="password_confirmation" class="form-label">
          <span>Konfirmasi Kata Sandi</span>
          <span class="required">*</span>
        </label>
        <div class="input-wrap">
          <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            placeholder="Ulangi kata sandi"
            required
            class="form-input"
          />
          <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password_confirmation', this)" aria-label="Lihat konfirmasi kata sandi">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>

      <button type="submit" class="btn-submit">
        <span>Kirim Kode Verifikasi OTP</span>
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
      </button>
    </form>

  @else
    <!-- ==================== TAHAP 3: VERIFIKASI KODE OTP ==================== -->
    <div style="background: var(--bg-alt); border: 1px solid var(--line); border-radius: var(--radius-m); padding: 18px 20px; margin-bottom: 24px; text-align: center;">
      <span style="font-size: 11px; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 1px;">Kode Terkirim</span>
      <p style="font-size: 13px; color: var(--ink-soft); margin-top: 4px;">
        Kode verifikasi 6 digit telah dikirim ke: <br>
        <strong style="color: var(--ink);">{{ $otpEmail }}</strong>
      </p>
    </div>

    <form method="POST" action="{{ route('aktivasi.verify-otp') }}" class="auth-form" novalidate>
      @csrf
      <input type="hidden" name="student_id" value="{{ $foundStudent['id'] }}">
      <input type="hidden" name="email" value="{{ $otpEmail }}">

      <div class="form-group">
        <label for="otp" class="form-label" style="text-align: center; display: block;">
          <span>Masukkan 6 Digit Kode OTP</span>
          <span class="required">*</span>
        </label>
        <div class="input-wrap">
          <input
            type="text"
            id="otp"
            name="otp"
            maxlength="6"
            placeholder="123456"
            required
            autofocus
            style="text-align: center; letter-spacing: 8px; font-size: 24px; font-weight: 700; font-family: monospace;"
            class="form-input @error('otp') is-invalid @enderror"
          />
        </div>
        <p class="form-hint" style="text-align: center;">Periksa kotak masuk atau folder spam email Anda.</p>
      </div>

      <button type="submit" class="btn-submit">
        <span>Verifikasi & Aktifkan Akun</span>
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      </button>
    </form>

    <div style="margin-top: 16px; text-align: center;">
      <form method="POST" action="{{ route('aktivasi.reset') }}" style="display: inline;">
        @csrf
        <button type="submit" style="background: none; border: none; font-size: 12px; color: var(--ink-faint); text-decoration: underline; cursor: pointer;">
          Salah email? Ulangi proses aktivasi
        </button>
      </form>
    </div>
  @endif

  <!-- Auth Footer Navigation -->
  <div class="auth-footer" style="margin-top: 32px; border-top: 1px solid var(--line); padding-top: 20px; text-align: center;">
    <p style="font-size: 13px; color: var(--ink-soft);">
      Sudah memiliki akun aktif?
      <a href="{{ route('login') }}" style="font-weight: 700; color: var(--primary); text-decoration: none;">
        Masuk di sini
      </a>
    </p>
  </div>
@endsection
