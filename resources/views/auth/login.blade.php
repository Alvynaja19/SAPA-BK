@extends('layouts.auth')

@section('title', 'Masuk ke SAPA BK — SMA Negeri 4 Jember')

@section('content')
  <!-- Card Header -->
  <div class="auth-header">
    <div class="auth-badge">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
      <span>Portal Konseling & BK</span>
    </div>
    <h1 class="auth-title">Selamat Datang Kembali</h1>
    <p class="auth-lede">Silakan masuk untuk mengakses riwayat percakapan, tes peminatan, dan layanan konseling siswa.</p>
  </div>

  <!-- Flash / Error Alerts -->
  @if (request('reason') === 'session_terminated')
    <div class="alert-box" style="background: var(--accent-soft); border: 1px solid var(--accent); color: var(--accent-ink); padding: 14px 16px; margin-bottom: 22px; border-radius: var(--radius-m); display: flex; gap: 12px; align-items: flex-start;">
      <div class="alert-icon" style="color: var(--accent); flex-shrink: 0; margin-top: 2px;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
      </div>
      <div>
        <strong style="font-size: 14px; font-weight: 700; display: block; margin-bottom: 4px; color: var(--accent-ink);">
          Sesi Otomatis Berakhir
        </strong>
        <p style="font-size: 13px; line-height: 1.45; margin: 0; color: var(--accent-ink);">
          Akun Anda telah otomatis keluar dari perangkat ini karena akun ini telah masuk di perangkat lain. Silakan login kembali jika ingin menggunakan perangkat ini.
        </p>
      </div>
    </div>
  @elseif (session('concurrent_session_blocked'))
    <div class="alert-box" style="background: var(--accent-soft); border: 1px solid var(--accent); color: var(--accent-ink); padding: 14px 16px; margin-bottom: 22px; border-radius: var(--radius-m); display: flex; gap: 12px; align-items: flex-start;">
      <div class="alert-icon" style="color: var(--accent); flex-shrink: 0; margin-top: 2px;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
      </div>
      <div>
        <strong style="font-size: 14px; font-weight: 700; display: block; margin-bottom: 4px; color: var(--accent-ink);">
          Login Ditolak: Akun Sedang Aktif di Perangkat Lain
        </strong>
        <p style="font-size: 13px; line-height: 1.45; margin: 0 0 8px 0; color: var(--accent-ink);">
          Akun Anda saat ini terdeteksi sedang digunakan pada perangkat lain{{ session('active_minutes_ago') ? ' (terakhir aktif sekitar ' . session('active_minutes_ago') . ' menit yang lalu)' : '' }}. Demi privasi data konseling dan keamanan akun, 1 akun tidak dapat diakses di dua perangkat secara bersamaan.
        </p>
        <p style="font-size: 12px; line-height: 1.4; margin: 0; color: var(--accent-ink); opacity: 0.9;">
          Silakan logout dari perangkat tersebut, atau centang opsi <em>"Keluarkan akun dari perangkat lain"</em> di bawah formulir lalu masukkan kata sandi kembali untuk beralih ke perangkat ini.
        </p>
      </div>
    </div>
  @elseif (isset($errors) && $errors->any())
    <div class="alert-box alert-danger">
      <div class="alert-icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
      </div>
      <div>
        <strong>Gagal Masuk:</strong>
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

  <!-- Login Form -->
  <form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="form-group">
      <label for="email" class="form-label">Email, NIS, atau NISN</label>
      <div class="input-wrap">
        <span class="input-icon">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
        </span>
        <input
          type="text"
          id="email"
          name="email"
          value="{{ old('email') }}"
          required
          autofocus
          autocapitalize="none"
          autocorrect="off"
          spellcheck="false"
          autocomplete="username"
          class="form-input"
          placeholder="Masukkan email, NIS, atau NISN"
        />
      </div>
    </div>

    <div class="form-group">
      <label for="password" class="form-label">Kata Sandi</label>
      <div class="input-wrap">
        <span class="input-icon">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        </span>
        <input
          type="password"
          id="password"
          name="password"
          required
          autocapitalize="none"
          autocorrect="off"
          spellcheck="false"
          autocomplete="current-password"
          class="form-input"
          placeholder="Masukkan kata sandi Anda"
        />
        <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password', this)" aria-label="Lihat kata sandi">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
        </button>
      </div>
    </div>

    <div class="form-options">
      <label class="checkbox-label">
        <input type="checkbox" name="remember" id="remember" />
        <span>Ingat sesi saya di perangkat ini</span>
      </label>
    </div>

    @if (session('concurrent_session_blocked'))
      <div style="background: var(--accent-soft); border: 1px solid var(--accent); border-radius: var(--radius-s); padding: 12px 14px; margin-bottom: 18px;">
        <label class="checkbox-label" style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer; color: var(--accent-ink);">
          <input type="checkbox" name="force_logout" value="1" id="force_logout" checked style="margin-top: 3px;" />
          <span style="font-size: 13px; font-weight: 600; line-height: 1.4;">
            Keluarkan akun dari perangkat lain dan masuk di perangkat ini
          </span>
        </label>
        <p style="font-size: 11.5px; color: var(--accent-ink); margin: 5px 0 0 26px; line-height: 1.4; opacity: 0.9;">
          Perangkat sebelumnya akan otomatis logout saat Anda masuk di perangkat ini.
        </p>
      </div>
    @endif

    <button type="submit" class="btn-submit">
      <span>Masuk Sekarang</span>
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
    </button>
  </form>

  <!-- Switch to Register & Aktivasi -->
  <div class="auth-switch" style="display: flex; flex-direction: column; gap: 6px;">
    <div>
      Siswa SMAN 4 Jember?
      <a href="{{ route('aktivasi') }}" style="font-weight: 700; color: var(--primary);">Aktivasi Akun di Sini</a>
    </div>
    <div>
      Belum memiliki akun?
      <a href="{{ route('register') }}">Daftar Akun Baru</a>
    </div>
  </div>
@endsection
