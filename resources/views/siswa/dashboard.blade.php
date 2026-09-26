@extends('layouts.app')

@section('title', 'Dashboard Siswa : SAPA BK SMAN 4 Jember')
@section('page_title', 'Dashboard')

@push('styles')
<style>
  /* ---------- DASHBOARD (sapa-bk-dashboard-siswa spec) ---------- */
  .greeting-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 26px;
  }
  .greeting h1 {
    font-size: 26px;
    font-weight: 600;
  }
  .greeting p {
    color: var(--ink-soft);
    font-size: 14.5px;
    margin-top: 4px;
  }
  .greeting-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
  }

  .stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 28px;
  }
  @media (max-width: 1100px) {
    .stat-grid { grid-template-columns: repeat(2, 1fr); }
  }
  @media (max-width: 560px) {
    .stat-grid { grid-template-columns: 1fr; }
  }

  .stat-card {
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 6px;
  }
  .stat-card .label {
    font-size: 13px;
    color: var(--ink-faint);
    font-weight: 500;
  }
  .stat-card .value {
    font-family: 'Fraunces', Georgia, serif;
    font-size: 26px;
    font-weight: 600;
    color: var(--ink);
  }
  .stat-card .caption {
    font-size: 12.5px;
    color: var(--ink-faint);
  }
  .stat-card.live .value {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 20px;
  }
  .stat-dot {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: var(--good);
    box-shadow: 0 0 0 3px rgba(46, 125, 52, 0.25);
    flex-shrink: 0;
  }

  .dash-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 20px;
    align-items: start;
  }
  @media (max-width: 900px) {
    .dash-grid { grid-template-columns: 1fr; }
  }

  .panel {
    padding: 22px;
  }
  .panel-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
  }
  .panel-head h3 {
    font-size: 16px;
    font-weight: 600;
  }
  .panel-head a {
    font-size: 13px;
    color: var(--primary);
    font-weight: 600;
    text-decoration: none;
    transition: text-decoration .15s ease;
  }
  .panel-head a:hover {
    text-decoration: underline;
  }

  .activity-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 13px 4px;
    border-bottom: 1px solid var(--line);
    transition: background-color .15s ease;
  }
  .activity-item:last-child {
    border-bottom: none;
  }
  .activity-item-info {
    flex: 1;
    min-width: 0;
  }
  .activity-item .qtext {
    font-size: 14.5px;
    font-weight: 600;
    color: var(--ink);
    display: block;
    text-decoration: none;
    line-height: 1.4;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .activity-item .qtext:hover {
    color: var(--primary);
  }
  .activity-item .meta {
    font-size: 12px;
    color: var(--ink-faint);
    margin-top: 5px;
    display: flex;
    align-items: center;
    gap: 7px;
    flex-wrap: wrap;
  }
  .badge-channel-tag {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 2px 7px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .02em;
    text-transform: uppercase;
  }
  .badge-channel-ai {
    background: rgba(36, 70, 63, 0.08);
    color: var(--primary);
    border: 1px solid rgba(36, 70, 63, 0.2);
  }
  .badge-channel-guru {
    background: rgba(28, 110, 180, 0.08);
    color: #1C6EB4;
    border: 1px solid rgba(28, 110, 180, 0.22);
  }
  .btn-open-session {
    font-size: 13px;
    font-weight: 600;
    color: var(--primary);
    background: var(--bg);
    border: 1px solid var(--line);
    padding: 7px 14px;
    border-radius: var(--radius-s);
    flex-shrink: 0;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    min-height: 36px;
    transition: all .15s ease;
  }
  .btn-open-session:hover {
    background: var(--primary);
    color: #FFFFFF;
    border-color: var(--primary);
    box-shadow: 0 2px 6px rgba(36, 70, 63, 0.2);
  }
  .btn-open-session.btn-open-guru {
    color: #1C6EB4;
    border-color: rgba(28, 110, 180, 0.3);
  }
  .btn-open-session.btn-open-guru:hover {
    background: #1C6EB4;
    color: #FFFFFF;
    border-color: #1C6EB4;
    box-shadow: 0 2px 6px rgba(28, 110, 180, 0.25);
  }

  .side-panels {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }
  .reco-book {
    display: flex;
    gap: 12px;
    align-items: center;
  }
  .reco-cover {
    width: 44px;
    height: 58px;
    border-radius: 5px;
    background: linear-gradient(160deg, #2F5D52, #1B2A24);
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #FFFFFF;
    font-size: 10px;
    font-weight: 700;
    overflow: hidden;
  }
  .reco-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .reco-book .title {
    font-size: 13.5px;
    font-weight: 600;
    color: var(--ink);
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  .progress-bar {
    margin-top: 8px;
    height: 5px;
    background: var(--bg-alt);
    border-radius: 99px;
    overflow: hidden;
  }
  .progress-bar span {
    display: block;
    height: 100%;
    background: var(--accent);
  }

  .reminder-card {
    background: var(--accent-soft);
    border: 1px solid #E4C68F;
    border-radius: var(--radius-m);
    padding: 18px;
  }
  .reminder-card .title {
    font-size: 14px;
    font-weight: 600;
    color: var(--accent-ink);
  }
  .reminder-card p {
    font-size: 13px;
    color: var(--accent-ink);
    margin-top: 4px;
    line-height: 1.45;
  }
  .reminder-card .btn {
    margin-top: 12px;
  }

  .empty-state-card {
    padding: 28px 16px;
    text-align: center;
    color: var(--ink-faint);
    font-size: 13.5px;
  }

  @media (max-width: 560px) {
    .greeting-row {
      margin-bottom: 18px;
      gap: 12px;
    }
    .greeting h1 {
      font-size: 20px;
      line-height: 1.25;
    }
    .greeting p {
      font-size: 13px;
    }
    .greeting-actions {
      width: 100%;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 8px;
    }
    .greeting-actions .btn {
      min-height: 42px;
      padding: 8px 10px;
      font-size: 12.5px;
      width: 100%;
    }
    .stat-card {
      padding: 12px 14px;
      gap: 4px;
      border-radius: var(--radius-s);
    }
    .stat-card .label {
      font-size: 11px;
      line-height: 1.3;
    }
    .stat-card .value {
      font-size: 20px;
    }
    .stat-card .caption {
      font-size: 10px;
      line-height: 1.3;
    }
    .stat-card.live .value {
      font-size: 16px;
    }
    .panel {
      padding: 16px 14px;
    }
    .panel-head h3 {
      font-size: 15px;
    }
  }
</style>
@endpush

@section('content')
<!-- Greeting Row -->
<div class="greeting-row">
  <div class="greeting">
    <h1>Halo, {{ explode(' ', trim($user->name))[0] }}</h1>
    <p>Semoga harimu berjalan baik. Ini ringkasan aktivitasmu di SAPA BK.</p>
  </div>
  <div class="greeting-actions">
    <a href="{{ route('siswa.ebook') }}" class="btn btn-ghost">Lihat e-book</a>
    <a href="{{ route('siswa.chat') }}" class="btn btn-primary">Mulai konsultasi baru</a>
  </div>
</div>

<!-- Stat Grid -->
<div class="stat-grid">
  <div class="card stat-card">
    <span class="label">Sesi Konsultasi</span>
    <span class="value">{{ $totalSessions }}</span>
    <span class="caption">sepanjang semester ini</span>
  </div>

  <div class="card stat-card">
    <span class="label">E-book Dibaca</span>
    <span class="value">{{ $ebooks->count() }}</span>
    <span class="caption">dari {{ max($totalEbooks, $ebooks->count()) }} koleksi tersedia</span>
  </div>

  <div class="card stat-card">
    <span class="label">Tes Selesai</span>
    <span class="value">{{ $completedTesCount }}/{{ max($totalActiveTes, 1) }}</span>
    <span class="caption">
      @if(($totalActiveTes - $completedTesCount) > 0)
        {{ $totalActiveTes - $completedTesCount }} tes menunggu diisi
      @else
        Semua kuesioner terisi
      @endif
    </span>
  </div>

  <div class="card stat-card live">
    <span class="label">Live Chat Guru BK</span>
    <span class="value">
      <span class="stat-dot" aria-hidden="true"></span>
      <span>Online</span>
    </span>
    <span class="caption">Jam layanan 08.00 - 15.00 WIB</span>
  </div>
</div>

<!-- Dash Grid -->
<div class="dash-grid">
  <!-- Left Panel: Aktivitas Terbaru -->
  <div class="card panel">
    <div class="panel-head">
      <h3>Aktivitas Terbaru</h3>
      <a href="{{ route('siswa.riwayat') }}">Lihat semua</a>
    </div>

    <div>
      @forelse($recentSessions as $s)
        @php
          $isGuru = ($s->mode === 'guru_bk');
        @endphp
        <div class="activity-item">
          <div class="activity-item-info">
            <a href="{{ route('siswa.chat.session', $s->id) }}" class="qtext" title="{{ $s->title }}">
              {{ $s->title }}
            </a>
            <div class="meta">
              @if($isGuru)
                <span class="badge-channel-tag badge-channel-guru">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                  </svg>
                  <span>Guru BK</span>
                </span>
              @else
                <span class="badge-channel-tag badge-channel-ai">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                  </svg>
                  <span>Chatbot AI</span>
                </span>
              @endif
              <span>&bull;</span>
              <span>{{ $s->created_at->diffForHumans() }}</span>
              <span>&bull;</span>
              <span>{{ $s->messages_count ?? $s->messages()->count() }} pesan</span>
            </div>
          </div>
          <a href="{{ route('siswa.chat.session', $s->id) }}" class="btn-open-session {{ $isGuru ? 'btn-open-guru' : '' }}" title="Buka percakapan {{ $s->title }}">
            <span>Buka Obrolan</span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
          </a>
        </div>
      @empty
        <div class="empty-state-card">
          Belum ada sesi konsultasi tersimpan. Klik <strong>Mulai konsultasi baru</strong> untuk berdiskusi dengan SAPA BK.
        </div>
      @endforelse
    </div>
  </div>

  <!-- Right Side Panels -->
  <div class="side-panels">
    <!-- Panel Lanjutkan Membaca -->
    <div class="card panel">
      <div class="panel-head">
        <h3>Lanjutkan membaca</h3>
      </div>
      <div class="reco-book">
        <div class="reco-cover">
          @if(isset($latestEbook) && $latestEbook && $latestEbook->cover_path)
            <img src="{{ asset('storage/' . $latestEbook->cover_path) }}" alt="{{ $latestEbook->title }}">
          @else
            <span>BK</span>
          @endif
        </div>
        <div style="flex: 1; min-width: 0;">
          <div class="title">{{ $latestEbook->title ?? 'Strategi Belajar Efektif' }}</div>
          <div class="progress-bar" aria-label="Progress membaca buku 50%">
            <span style="width: 50%;"></span>
          </div>
        </div>
      </div>
      <div style="display: flex; gap: 8px; margin-top: 14px;">
        <a href="{{ route('siswa.ebook') }}" class="btn btn-ghost btn-sm" style="flex: 1; justify-content: center;">
          Baca Modul
        </a>
        @if(isset($latestEbook) && $latestEbook)
          <a href="{{ route('siswa.chat', ['mode' => 'live', 'ref' => 'ebook', 'ref_id' => $latestEbook->id]) }}" class="btn btn-primary btn-sm" style="flex: 1; justify-content: center;" title="Diskusikan modul ini dengan Guru BK">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            <span>Diskusikan</span>
          </a>
        @endif
      </div>
    </div>

    <!-- Reminder Card -->
    <div class="reminder-card">
      <div class="title">
        {{ $pendingQuestionnaire ? $pendingQuestionnaire->title : 'Kuesioner Gaya Belajar' }}
      </div>
      <p>
        @if($pendingQuestionnaire)
          {{ \Illuminate\Support\Str::limit($pendingQuestionnaire->description, 115) }}
        @else
          Belum kamu isi. Hasilnya membantu Guru BK memahami cara belajar dan pengembangan dirimu yang paling cocok.
        @endif
      </p>
      <div style="display: flex; gap: 8px; flex-wrap: wrap;">
        <a href="{{ $pendingQuestionnaire ? route('siswa.tes.isi', $pendingQuestionnaire->id) : route('siswa.tes') }}" class="btn btn-primary btn-sm">
          Isi Sekarang
        </a>
        @if($pendingQuestionnaire)
          <a href="{{ route('siswa.chat', ['mode' => 'live', 'ref' => 'tes', 'ref_id' => $pendingQuestionnaire->id]) }}" class="btn btn-ghost btn-sm" style="background: rgba(255,255,255,0.15); color: #FFFFFF; border-color: rgba(255,255,255,0.3);" title="Tanyakan kuesioner ini ke Guru BK">
            <span>Tanya Guru BK</span>
          </a>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
