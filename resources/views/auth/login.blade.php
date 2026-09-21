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

  <!-- Quick Demo Login Presets -->
  <div class="preset-box">
    <span class="preset-label">Akses Cepat Akun Demo:</span>
    <div class="preset-grid">
      <button type="button" onclick="fillCredentials('siswa@sman4jember.sch.id', 'password')" class="preset-btn">
        Siswa
      </button>
      <button type="button" onclick="fillCredentials('gurubk@sman4jember.sch.id', 'password')" class="preset-btn">
        Guru BK
      </button>
      <button type="button" onclick="fillCredentials('admin@gmail.com', 'Admin123456')" class="preset-btn">
        Admin
      </button>
    </div>
  </div>

  <!-- Flash / Error Alerts -->
  @if (isset($errors) && $errors->any())
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
      <label for="email" class="form-label">Alamat Email</label>
      <div class="input-wrap">
        <span class="input-icon">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
        </span>
        <input
          type="email"
          id="email"
          name="email"
          value="{{ old('email', 'siswa@sman4jember.sch.id') }}"
          required
          autofocus
          class="form-input"
          placeholder="nama@sman4jember.sch.id"
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
          value="password"
          required
          class="form-input"
          placeholder="••••••••"
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

@section('scripts')
<script>
  function fillCredentials(email, pass) {
    document.getElementById('email').value = email;
    document.getElementById('password').value = pass;
  }
</script>
@endsection
