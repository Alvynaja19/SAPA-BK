@extends('layouts.app')

@section('title', 'Profil Akun Siswa : SAPA BK SMAN 4 Jember')
@section('page_title', 'Profil Akun Siswa')

@push('styles')
<style>
  /* ===================================================
     SAPA BK - PROFIL PENGGUNA SISWA (WARM EDITORIAL)
     Antislop: No em dash, WCAG AA contrast, Vanilla CSS
     =================================================== */

  .profil-container {
    max-width: 860px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 22px;
  }

  /* Editorial Header */
  .profil-header {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-l);
    padding: 24px 28px;
    box-shadow: var(--shadow-card);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 18px;
  }
  .profil-header-info {
    max-width: 580px;
  }
  .profil-breadcrumb {
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: var(--primary);
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .profil-header h2 {
    font-size: 24px;
    font-weight: 600;
    color: var(--ink);
    line-height: 1.25;
  }
  .profil-header p {
    color: var(--ink-soft);
    font-size: 14px;
    margin-top: 6px;
    line-height: 1.55;
  }
  .profil-badge-status {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--primary-soft);
    color: var(--primary);
    padding: 8px 16px;
    border-radius: 99px;
    font-size: 13px;
    font-weight: 600;
    border: 1px solid rgba(36, 70, 63, 0.18);
  }
  .status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--good);
    box-shadow: 0 0 0 3px rgba(46, 125, 52, 0.25);
  }

  /* Identity Card */
  .profil-id-card {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-l);
    padding: 24px 28px;
    box-shadow: var(--shadow-card);
    display: flex;
    align-items: center;
    gap: 22px;
    flex-wrap: wrap;
  }
  .profil-avatar-box {
    width: 72px;
    height: 72px;
    border-radius: var(--radius-m);
    background: var(--primary);
    color: #FFFFFF;
    font-family: 'Fraunces', Georgia, serif;
    font-weight: 700;
    font-size: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(36, 70, 63, 0.22);
    overflow: hidden;
  }
  .profil-avatar-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .profil-id-meta {
    flex: 1;
    min-width: 240px;
  }
  .profil-id-name {
    font-size: 21px;
    font-weight: 600;
    color: var(--ink);
    margin-bottom: 4px;
  }
  .profil-id-sub {
    font-size: 13.5px;
    color: var(--ink-soft);
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
  }
  .role-tag {
    display: inline-block;
    padding: 2px 9px;
    background: var(--accent-soft);
    color: var(--accent-ink);
    border-radius: 6px;
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: .04em;
    text-transform: uppercase;
  }
  .profil-quick-tags {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 10px;
  }
  .quick-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12.5px;
    color: var(--ink-soft);
    background: var(--bg);
    padding: 5px 12px;
    border-radius: var(--radius-s);
    border: 1px solid var(--line);
  }
  .quick-tag svg {
    width: 14px;
    height: 14px;
    stroke: var(--primary);
  }

  /* Form Card */
  .profil-card {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-l);
    padding: 28px 32px;
    box-shadow: var(--shadow-card);
  }
  .profil-section-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 17px;
    font-weight: 600;
    color: var(--ink);
    margin-bottom: 6px;
  }
  .profil-section-title svg {
    width: 20px;
    height: 20px;
    stroke: var(--primary);
    flex-shrink: 0;
  }
  .profil-section-desc {
    font-size: 13.5px;
    color: var(--ink-faint);
    margin-bottom: 20px;
    line-height: 1.5;
  }

  /* Avatar Management Row */
  .avatar-manager {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 18px 22px;
    background: var(--bg);
    border: 1px dashed var(--line);
    border-radius: var(--radius-m);
    margin-bottom: 26px;
    flex-wrap: wrap;
  }
  .avatar-frame {
    position: relative;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    background: var(--primary);
    color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Fraunces', Georgia, serif;
    font-weight: 700;
    font-size: 28px;
    box-shadow: 0 4px 12px rgba(36, 70, 63, 0.18);
    border: 3px solid var(--surface);
    flex-shrink: 0;
  }
  .avatar-frame img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .avatar-controls {
    flex: 1;
    min-width: 240px;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  .avatar-btn-group {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
  }
  .avatar-help-text {
    font-size: 12px;
    color: var(--ink-faint);
    line-height: 1.45;
    margin: 0;
  }

  /* Form Grid & Inputs */
  .form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
  }
  .form-group {
    display: flex;
    flex-direction: column;
    gap: 7px;
  }
  .form-group.span-full {
    grid-column: 1 / -1;
  }
  .form-label {
    font-size: 12.5px;
    font-weight: 600;
    color: var(--ink-soft);
    text-transform: uppercase;
    letter-spacing: .04em;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .form-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
  }
  .form-input-icon {
    position: absolute;
    left: 14px;
    width: 17px;
    height: 17px;
    stroke: var(--ink-faint);
    pointer-events: none;
  }
  .form-input {
    width: 100%;
    min-height: 46px;
    padding: 10px 14px 10px 42px;
    border: 1px solid var(--line);
    border-radius: var(--radius-s);
    background: var(--surface);
    color: var(--ink);
    font-size: 14px;
    font-family: inherit;
    transition: border-color .15s ease, box-shadow .15s ease;
  }
  .form-input:focus {
    border-color: var(--primary);
    outline: 3px solid var(--accent);
    outline-offset: 1px;
  }
  .form-input:disabled {
    background: var(--bg);
    color: var(--ink-faint);
    cursor: not-allowed;
    border-color: var(--line);
  }
  .form-hint {
    font-size: 12px;
    color: var(--ink-faint);
    margin-top: 2px;
    line-height: 1.4;
  }

  /* Form Section Divider */
  .form-divider {
    border: 0;
    height: 1px;
    background: var(--line);
    margin: 28px 0 24px;
  }

  /* Form Actions */
  .profil-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
    margin-top: 26px;
    padding-top: 20px;
    border-top: 1px solid var(--line);
  }

  /* Camera Modal Backdrop & Container */
  .camera-modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(18, 28, 26, 0.72);
    backdrop-filter: blur(4px);
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 16px;
  }
  .camera-modal-backdrop.active {
    display: flex;
  }
  .camera-modal {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-l);
    width: 100%;
    max-width: 520px;
    box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    animation: modalIn .2s ease-out;
  }
  @keyframes modalIn {
    from { opacity: 0; transform: scale(0.96); }
    to { opacity: 1; transform: scale(1); }
  }
  .camera-modal-header {
    padding: 16px 20px;
    border-bottom: 1px solid var(--line);
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .camera-modal-title {
    font-size: 16px;
    font-weight: 600;
    color: var(--ink);
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .camera-modal-close {
    background: none;
    border: none;
    color: var(--ink-faint);
    cursor: pointer;
    padding: 6px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .camera-modal-close:hover {
    background: var(--bg);
    color: var(--ink);
  }
  .camera-viewfinder {
    position: relative;
    width: 100%;
    height: 320px;
    background: #0D1614;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .camera-video, .camera-canvas-preview {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .camera-placeholder-msg {
    color: #E2E8F0;
    text-align: center;
    padding: 24px;
    font-size: 13.5px;
    line-height: 1.5;
  }
  .camera-modal-footer {
    padding: 16px 20px;
    border-top: 1px solid var(--line);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    flex-wrap: wrap;
    background: var(--surface);
  }

  @media (max-width: 720px) {
    .form-grid-2 {
      grid-template-columns: 1fr;
      gap: 16px;
    }
    .profil-header,
    .profil-id-card,
    .profil-card {
      padding: 20px;
    }
    .profil-actions {
      flex-direction: column-reverse;
      align-items: stretch;
    }
    .profil-actions .btn {
      width: 100%;
    }
    .camera-viewfinder {
      height: 260px;
    }
  }

  @media (max-width: 540px) {
    .profil-id-card {
      flex-direction: column;
      align-items: center;
      text-align: center;
      gap: 14px;
      padding: 18px 16px;
    }
    .profil-id-meta {
      min-width: 0;
      width: 100%;
    }
    .profil-id-sub {
      justify-content: center;
    }
    .profil-quick-tags {
      justify-content: center;
    }
    .profil-header {
      padding: 16px;
    }
    .profil-card {
      padding: 18px 16px;
    }
    .form-input {
      font-size: 16px;
    }
    .avatar-manager {
      flex-direction: column;
      align-items: center;
      text-align: center;
      padding: 16px;
    }
    .avatar-btn-group {
      justify-content: center;
    }
  }
</style>
@endpush

@section('content')
<div class="profil-container">

  <!-- Header Card -->
  <div class="profil-header">
    <div class="profil-header-info">
      <div class="profil-breadcrumb">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polygon points="12 8 8 12 12 16 12 8"/></svg>
        <span>Portal Bimbingan : SMAN 4 Jember</span>
      </div>
      <h2>Pengaturan Profil Siswa</h2>
      <p>Kelola data identitas siswa, nomor induk sekolah, foto profil, dan kata sandi akun Anda secara mandiri.</p>
    </div>
    <div>
      <span class="profil-badge-status">
        <span class="status-dot"></span>
        <span>Akun Siswa Aktif</span>
      </span>
    </div>
  </div>

  <!-- Identity Card -->
  <div class="profil-id-card">
    <div class="profil-avatar-box">
      <img id="topAvatarImg" src="{{ $user->avatar_url }}" alt="{{ $user->name }}" style="{{ !$user->avatar ? 'display: none;' : '' }}">
      <span id="topAvatarInitials" style="{{ $user->avatar ? 'display: none;' : '' }}">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
    </div>
    <div class="profil-id-meta">
      <h3 class="profil-id-name">{{ $user->name }}</h3>
      <div class="profil-id-sub">
        <span>{{ $user->email }}</span>
        <span class="role-tag">{{ str_replace('_', ' ', $user->role) }}</span>
      </div>
      <div class="profil-quick-tags">
        @if($user->kelas)
          <span class="quick-tag">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            <span>Kelas {{ $user->kelas }}</span>
          </span>
        @endif
        @if($user->nis)
          <span class="quick-tag">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><line x1="7" y1="8" x2="17" y2="8"/><line x1="7" y1="12" x2="13" y2="12"/></svg>
            <span id="topTagNis">NIS: {{ $user->nis }}</span>
          </span>
        @endif
        @if($user->nisn)
          <span class="quick-tag">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><line x1="7" y1="8" x2="17" y2="8"/><line x1="7" y1="12" x2="13" y2="12"/></svg>
            <span>NISN: {{ $user->nisn }}</span>
          </span>
        @endif
        @if($user->no_hp)
          <span class="quick-tag">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            <span>{{ $user->no_hp }}</span>
          </span>
        @endif
      </div>
    </div>
  </div>

  <!-- Form Card -->
  <div class="profil-card">
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <!-- Hidden inputs for Camera Capture and Remove Avatar -->
      <input type="hidden" name="captured_avatar" id="capturedAvatarInput" value="">
      <input type="hidden" name="remove_avatar" id="removeAvatarInput" value="0">

      <!-- Section: Foto Profil -->
      <h3 class="profil-section-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
        <span>Foto Profil Siswa</span>
      </h3>
      <p class="profil-section-desc">Unggah berkas foto atau ambil foto secara langsung menggunakan kamera perangkat Anda.</p>

      <div class="avatar-manager">
        <div class="avatar-frame">
          <img id="formAvatarImg" src="{{ $user->avatar_url }}" alt="{{ $user->name }}" style="{{ !$user->avatar ? 'display: none;' : '' }}">
          <span id="formAvatarInitials" style="{{ $user->avatar ? 'display: none;' : '' }}">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
        </div>

        <div class="avatar-controls">
          <div class="avatar-btn-group">
            <!-- Unggah Berkas Gambar -->
            <label for="inputAvatarFile" class="btn btn-primary btn-sm" style="cursor: pointer; margin: 0;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
              <span>Unggah Berkas</span>
            </label>
            <input type="file" id="inputAvatarFile" name="avatar" accept="image/png,image/jpeg,image/jpg,image/webp" style="display: none;" onchange="handleFileSelect(this)">

            <!-- Gunakan Kamera -->
            <button type="button" class="btn btn-ghost btn-sm" onclick="openCameraModal()">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
              <span>Gunakan Kamera</span>
            </button>

            <!-- Hapus / Reset Foto Profil -->
            <button type="button" class="btn btn-ghost btn-sm" id="btnRemoveAvatar" onclick="resetAvatar()" style="color: var(--bad); border-color: rgba(198, 40, 40, 0.35); {{ !$user->avatar ? 'display: none;' : '' }}">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
              <span>Hapus Foto</span>
            </button>
          </div>
          <p class="avatar-help-text">Format yang didukung: JPG, PNG, atau WEBP dengan ukuran berkas maksimal 2MB. Foto akan disimpan permanen setelah Anda menekan tombol "Simpan Perubahan Profil".</p>
        </div>
      </div>

      <hr class="form-divider" />

      <!-- Section 1: Biodata -->
      <h3 class="profil-section-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        <span>Data Pokok Identitas Siswa</span>
      </h3>
      <p class="profil-section-desc">Pastikan nama, NIS, NISN, dan nomor kontak sesuai agar Guru BK dapat memberikan bimbingan belajar dan karir dengan optimal.</p>

      <div class="form-grid-2">
        <!-- Nama Lengkap -->
        <div class="form-group">
          <label class="form-label" for="inputName">Nama Lengkap</label>
          <div class="form-input-wrap">
            <svg class="form-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <input type="text" id="inputName" name="name" class="form-input" value="{{ old('name', $user->name) }}" required autocomplete="name" />
          </div>
        </div>

        <!-- Alamat Email (Terkunci) -->
        <div class="form-group">
          <label class="form-label" for="inputEmail">Email Terdaftar (Terkunci)</label>
          <div class="form-input-wrap">
            <svg class="form-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            <input type="email" id="inputEmail" class="form-input" value="{{ $user->email }}" disabled />
          </div>
          <span class="form-hint">Email sekolah terhubung dengan sistem autentikasi dan akun bimbingan.</span>
        </div>

        @if($user->isSiswa())
          <!-- Nomor Induk Sekolah (NIS) -->
          <div class="form-group">
            <label class="form-label" for="inputNis">Nomor Induk Sekolah (NIS)</label>
            <div class="form-input-wrap">
              <svg class="form-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><line x1="7" y1="8" x2="17" y2="8"/><line x1="7" y1="12" x2="13" y2="12"/></svg>
              <input type="text" id="inputNis" name="nis" class="form-input" value="{{ old('nis', $user->nis) }}" placeholder="Contoh: 12345" />
            </div>
            <span class="form-hint">Nomor induk resmi siswa pada buku induk SMA Negeri 4 Jember.</span>
          </div>

          <!-- Nomor Induk Siswa Nasional (NISN) -->
          <div class="form-group">
            <label class="form-label" for="inputNisn">Nomor Induk Siswa Nasional (NISN)</label>
            <div class="form-input-wrap">
              <svg class="form-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><line x1="7" y1="8" x2="17" y2="8"/><line x1="7" y1="12" x2="13" y2="12"/></svg>
              <input type="text" id="inputNisn" name="nisn" class="form-input" value="{{ old('nisn', $user->nisn) }}" placeholder="Contoh: 0054321987" />
            </div>
            <span class="form-hint">Nomor identitas siswa nasional dari Kementerian Pendidikan.</span>
          </div>

          <!-- Kelas -->
          <div class="form-group">
            <label class="form-label" for="inputKelas">Kelas &amp; Rombel</label>
            <div class="form-input-wrap">
              <svg class="form-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
              <input type="text" id="inputKelas" name="kelas" class="form-input" value="{{ old('kelas', $user->kelas) }}" placeholder="Contoh: XII MIPA 1" />
            </div>
          </div>
        @endif

        <!-- Nomor Telepon / WhatsApp -->
        <div class="form-group {{ !$user->isSiswa() ? 'span-full' : '' }}">
          <label class="form-label" for="inputNoHp">Nomor Telepon / WhatsApp</label>
          <div class="form-input-wrap">
            <svg class="form-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            <input type="text" id="inputNoHp" name="no_hp" class="form-input" value="{{ old('no_hp', $user->no_hp) }}" placeholder="Contoh: 082198765432" />
          </div>
          <span class="form-hint">Digunakan saat Guru BK membutuhkan konfirmasi jadwal konseling tatap muka.</span>
        </div>
      </div>

      <hr class="form-divider" />

      <!-- Section 2: Kata Sandi -->
      <h3 class="profil-section-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        <span>Keamanan &amp; Kata Sandi Akun</span>
      </h3>
      <p class="profil-section-desc">Kosongkan kedua kolom di bawah jika Anda tidak berencana mengganti kata sandi saat ini.</p>

      <div class="form-grid-2">
        <!-- Kata Sandi Baru -->
        <div class="form-group">
          <label class="form-label" for="inputPassword">Kata Sandi Baru</label>
          <div class="form-input-wrap">
            <svg class="form-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M3 7v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2z"/></svg>
            <input type="password" id="inputPassword" name="password" class="form-input" placeholder="Minimal 8 karakter" autocomplete="new-password" />
          </div>
        </div>

        <!-- Konfirmasi Kata Sandi Baru -->
        <div class="form-group">
          <label class="form-label" for="inputPasswordConfirmation">Ulangi Kata Sandi Baru</label>
          <div class="form-input-wrap">
            <svg class="form-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            <input type="password" id="inputPasswordConfirmation" name="password_confirmation" class="form-input" placeholder="Ketik ulang kata sandi baru" autocomplete="new-password" />
          </div>
        </div>
      </div>

      <!-- Action Footer -->
      <div class="profil-actions">
        <a href="{{ route('siswa.dashboard') }}" class="btn btn-ghost btn-sm">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
          <span>Kembali ke Dashboard</span>
        </a>
        <button type="submit" class="btn btn-primary">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
          <span>Simpan Perubahan Profil</span>
        </button>
      </div>
    </form>
  </div>

</div>

<!-- Camera Modal Dialog -->
<div id="cameraModalBackdrop" class="camera-modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="cameraModalTitle">
  <div class="camera-modal">
    <div class="camera-modal-header">
      <div class="camera-modal-title" id="cameraModalTitle">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
        <span>Ambil Foto Profil via Kamera</span>
      </div>
      <button type="button" class="camera-modal-close" onclick="closeCameraModal()" aria-label="Tutup kamera">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>

    <div class="camera-viewfinder">
      <!-- Live Video Element -->
      <video id="cameraVideo" class="camera-video" autoplay playsinline muted></video>

      <!-- Canvas for Capturing Frame -->
      <canvas id="cameraCanvas" style="display: none;"></canvas>

      <!-- Preview Image after Capture -->
      <img id="cameraCapturedImg" class="camera-canvas-preview" style="display: none;" alt="Hasil Jepretan Kamera">

      <!-- Status or Error Message -->
      <div id="cameraPlaceholder" class="camera-placeholder-msg" style="display: none;">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#F87171" stroke-width="2" style="margin: 0 auto 10px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div id="cameraErrorMessage">Sedang menghubungkan ke kamera perangkat...</div>
      </div>
    </div>

    <div class="camera-modal-footer">
      <!-- State 1: Streaming Live -->
      <div id="cameraLiveControls" style="display: flex; width: 100%; justify-content: space-between; align-items: center; gap: 10px;">
        <button type="button" class="btn btn-ghost btn-sm" onclick="closeCameraModal()">
          Batal
        </button>
        <button type="button" class="btn btn-primary btn-sm" id="btnCaptureFrame" onclick="capturePhoto()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/></svg>
          <span>Ambil Foto</span>
        </button>
      </div>

      <!-- State 2: Reviewing Captured Photo -->
      <div id="cameraReviewControls" style="display: none; width: 100%; justify-content: space-between; align-items: center; gap: 10px;">
        <button type="button" class="btn btn-ghost btn-sm" onclick="retakePhoto()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
          <span>Foto Ulang</span>
        </button>
        <button type="button" class="btn btn-primary btn-sm" onclick="useCapturedPhoto()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
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

  const topAvatarImg = document.getElementById('topAvatarImg');
  const topAvatarInitials = document.getElementById('topAvatarInitials');

  async function openCameraModal() {
    cameraModalBackdrop.classList.add('active');
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
    cameraModalBackdrop.classList.remove('active');
  }

  function capturePhoto() {
    if (!cameraStream || !cameraVideo.videoWidth) return;
    const width = cameraVideo.videoWidth;
    const height = cameraVideo.videoHeight;
    cameraCanvas.width = width;
    cameraCanvas.height = height;

    const ctx = cameraCanvas.getContext('2d');
    ctx.drawImage(cameraVideo, 0, 0, width, height);

    const dataUrl = cameraCanvas.toDataURL('image/jpeg', 0.9);
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

    if (topAvatarImg) {
      topAvatarImg.src = dataUrl;
      topAvatarImg.style.display = 'block';
    }
    if (topAvatarInitials) topAvatarInitials.style.display = 'none';

    if (btnRemoveAvatar) btnRemoveAvatar.style.display = 'inline-flex';
    closeCameraModal();
  }

  function handleFileSelect(input) {
    if (input.files && input.files[0]) {
      const file = input.files[0];
      if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran berkas melebihi batas maksimal 2MB. Silakan pilih foto dengan ukuran lebih kecil.');
        input.value = '';
        return;
      }
      const reader = new FileReader();
      reader.onload = function(e) {
        capturedAvatarInput.value = '';
        removeAvatarInput.value = '0';

        formAvatarImg.src = e.target.result;
        formAvatarImg.style.display = 'block';
        if (formAvatarInitials) formAvatarInitials.style.display = 'none';

        if (topAvatarImg) {
          topAvatarImg.src = e.target.result;
          topAvatarImg.style.display = 'block';
        }
        if (topAvatarInitials) topAvatarInitials.style.display = 'none';

        if (btnRemoveAvatar) btnRemoveAvatar.style.display = 'inline-flex';
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

    if (topAvatarImg) {
      topAvatarImg.src = '';
      topAvatarImg.style.display = 'none';
    }
    if (topAvatarInitials) topAvatarInitials.style.display = 'block';

    if (btnRemoveAvatar) btnRemoveAvatar.style.display = 'none';
  }

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && cameraModalBackdrop.classList.contains('active')) {
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
