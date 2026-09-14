@extends('layouts.auth')

@section('title', 'Daftar Akun Siswa — SAPA BK SMAN 4 Jember')

@section('styles')
<style>
  :root {
    --maxw-form: 580px;
  }
</style>
@endsection

@section('content')
  <!-- Card Header -->
  <div class="auth-header">
    <div class="auth-badge">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
      <span>Registrasi Siswa Baru</span>
    </div>
    <h1 class="auth-title">Buat Akun Siswa</h1>
    <p class="auth-lede">Daftarkan diri Anda untuk mulai berkonsultasi, membaca modul BK, dan mengikuti tes minat bakat digital.</p>
  </div>

  <!-- Flash / Error Alerts -->
  @if (isset($errors) && $errors->any())
    <div class="alert-box alert-danger">
      <div class="alert-icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
      </div>
      <div>
        <strong>Pendaftaran Belum Berhasil:</strong>
        <ul class="alert-list">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  @endif

  <!-- Register Form -->
  <form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="form-group">
      <label for="name" class="form-label">Nama Lengkap Siswa</label>
      <div class="input-wrap">
        <span class="input-icon">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </span>
        <input
          type="text"
          id="name"
          name="name"
          value="{{ old('name') }}"
          required
          autofocus
          class="form-input"
          placeholder="Contoh: Budi Santoso"
        />
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label for="nisn" class="form-label">NISN (Nomor Induk Siswa)</label>
        <div class="input-wrap">
          <span class="input-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="14" x="3" y="5" rx="2"/><path d="M3 10h18"/><path d="M7 15h2"/></svg>
          </span>
          <input
            type="text"
            id="nisn"
            name="nisn"
            value="{{ old('nisn') }}"
            required
            class="form-input"
            placeholder="Contoh: 0054321987"
          />
        </div>
      </div>

      <div class="form-group">
        <label for="kelas" class="form-label">Kelas Saat Ini</label>
        <div class="input-wrap">
          <span class="input-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10"/><path d="M6 10h10"/></svg>
          </span>
          <input
            type="text"
            id="kelas"
            name="kelas"
            value="{{ old('kelas') }}"
            required
            class="form-input"
            placeholder="Contoh: X-E1 / XI MIPA 2"
          />
        </div>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label for="email" class="form-label">Alamat Email Aktif</label>
        <div class="input-wrap">
          <span class="input-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
          </span>
          <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            required
            class="form-input"
            placeholder="siswa@domain.com"
          />
        </div>
      </div>

      <div class="form-group">
        <label for="no_hp" class="form-label">No. WhatsApp (Opsional)</label>
        <div class="input-wrap">
          <span class="input-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
          </span>
          <input
            type="tel"
            id="no_hp"
            name="no_hp"
            value="{{ old('no_hp') }}"
            class="form-input"
            placeholder="081234567890"
          />
        </div>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label for="password" class="form-label">Kata Sandi (Min. 8)</label>
        <div class="input-wrap">
          <span class="input-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          </span>
          <input
            type="password"
            id="password"
            name="password"
            required
            class="form-input"
            placeholder="Min. 8 karakter"
          />
          <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password', this)" aria-label="Lihat kata sandi">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>

      <div class="form-group">
        <label for="password_confirmation" class="form-label">Ulangi Kata Sandi</label>
        <div class="input-wrap">
          <span class="input-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
          </span>
          <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            required
            class="form-input"
            placeholder="Konfirmasi sandi"
          />
          <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password_confirmation', this)" aria-label="Lihat konfirmasi sandi">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>
    </div>

    <div style="margin-top: 10px;">
      <button type="submit" class="btn-submit">
        <span>Buat Akun Siswa</span>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
      </button>
    </div>
  </form>

  <!-- Switch to Login -->
  <div class="auth-switch">
    Sudah memiliki akun?
    <a href="{{ route('login') }}">Masuk Sekarang</a>
  </div>
@endsection
