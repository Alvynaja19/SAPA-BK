@extends('layouts.guest')

@section('title', $ebook->title . ' : SAPA BK SMAN 4 Jember')

@section('content')
<section class="page-section">
  <div class="wrap">
    
    <!-- Breadcrumb / Back Button -->
    <div style="margin-bottom: 28px;">
      <a href="{{ auth()->check() && auth()->user()->role === 'siswa' ? route('siswa.ebook') : route('ebook.index') }}" class="btn btn-ghost btn-sm" style="display: inline-flex; align-items: center; gap: 8px;">
        &larr; Kembali ke Katalog E-Book
      </a>
    </div>

    <!-- Detail Card Surface -->
    <div style="background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius-l); padding: clamp(24px, 4vw, 48px); box-shadow: var(--shadow-card);">
      <div style="display: grid; grid-template-columns: 320px 1fr; gap: 40px; align-items: start;">
        
        <!-- Left: 3D-Like Book Cover -->
        <div>
          <div class="ebook-cover" style="width: 100%; max-width: 320px; aspect-ratio: 3/4; padding: 24px; box-shadow: 0 12px 32px rgba(28,43,24,0.18);">
            <div class="ebook-badge">{{ $ebook->is_public ? 'Akses Publik' : 'Khusus Siswa SMAN 4' }}</div>
            <span style="font-size: 20px;">{{ $ebook->title }}</span>
          </div>
          <div style="margin-top: 16px; text-align: center; font-size: 12.5px; color: var(--ink-faint);">
            Format: Dokumen Digital (PDF) &bull; Publikasi Internal SMAN 4
          </div>
        </div>

        <!-- Right: Metadata & Synopsis -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
          <div>
            <div class="badge-pill" style="margin-bottom: 12px;">
              {{ $ebook->is_public ? 'Modul Terbuka' : 'Materi Siswa Terdaftar' }}
            </div>
            <h1 style="font-size: clamp(24px, 3.2vw, 36px); margin-bottom: 10px; line-height: 1.3;">
              {{ $ebook->title }}
            </h1>
            <div style="font-size: 13.5px; color: var(--ink-faint); display: flex; gap: 16px; flex-wrap: wrap;">
              <span><strong>Penyusun:</strong> Tim Guru BK SMAN 4 Jember</span>
              <span><strong>Tanggal Rilis:</strong> {{ $ebook->created_at ? $ebook->created_at->format('d F Y') : '-' }}</span>
            </div>
          </div>

          <div style="padding-top: 16px; border-top: 1px solid var(--line);">
            <h3 style="font-size: 16px; margin-bottom: 10px; font-family: 'Work Sans', sans-serif; font-weight: 600;">
              Ringkasan &amp; Deskripsi Modul
            </h3>
            <p style="font-size: 15px; color: var(--ink-soft); line-height: 1.7;">
              {{ $ebook->description ?? 'Modul panduan dan bimbingan komprehensif bagi peserta didik SMA Negeri 4 Jember untuk memperkuat kesiapan belajar, regulasi emosional, dan penentuan karir masa depan.' }}
            </p>
          </div>

          <div style="padding-top: 20px; border-top: 1px solid var(--line); display: flex; gap: 14px; flex-wrap: wrap;">
            <a href="{{ asset('storage/' . $ebook->file_path) }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
              <span>Baca Online</span>
            </a>
            <a href="{{ asset('storage/' . $ebook->file_path) }}" download class="btn btn-ghost">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="7 10 12 15 17 10"/>
                <line x1="12" x2="12" y1="15" y2="3"/>
              </svg>
              <span>Unduh Modul (PDF)</span>
            </a>
            <a href="{{ auth()->check() ? route('siswa.chat', ['mode' => 'live', 'ref' => 'ebook', 'ref_id' => $ebook->id]) : route('login') }}" class="btn btn-accent">
              <span>Diskusikan Modul Ini</span>
            </a>
          </div>

        </div>

      </div>
    </div>

  </div>
</section>

@push('styles')
<style>
  @media (max-width: 860px) {
    div[style*="grid-template-columns: 320px 1fr"] {
      grid-template-columns: 1fr !important;
      gap: 28px !important;
    }
  }
</style>
@endpush
@endsection
