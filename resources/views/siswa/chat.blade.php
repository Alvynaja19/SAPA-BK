@extends('layouts.app')

@section('title', 'Ruang Bimbingan & Konsultasi Siswa : SAPA BK SMAN 4 Jember')
@section('page_title', 'Ruang Bimbingan Konseling')

@push('styles')
<style>
  /* ===================================================
     SAPA BK - STUDENT COUNSELING & LIVE CHAT (ANTISLOP)
     Dual-Channel Architecture: Chatbot AI (24/7) vs Live Chat Guru BK
     Forest Green (#24463F), Slate Blue (#1C6EB4), Cream (#EDF1EC, #FBF8EA)
     =================================================== */

  :root {
    --chat-bg-bubble-user: #24463F;
    --chat-bg-bubble-ai: #FFFFFF;
    --chat-bg-bubble-counselor: #FFFFFF;
    --chat-line: #D3DCCC;
    --chat-radius-bubble: 14px;
  }

  .chat-layout {
    display: grid;
    grid-template-columns: 310px 1fr;
    gap: 20px;
    height: calc(100vh - 128px);
    min-height: 580px;
  }

  /* SIDEBAR KIRI: Arsip Sesi & Privasi */
  .chat-sidebar {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-l);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    box-shadow: var(--shadow-card);
  }

  .chat-sidebar-head {
    padding: 16px;
    border-bottom: 1px solid var(--line);
  }
  .btn-new-chat {
    width: 100%;
    min-height: 44px;
    background: var(--primary);
    color: #FFFFFF;
    border: none;
    border-radius: var(--radius-s);
    font-weight: 600;
    font-size: 13.5px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    transition: background-color .15s ease, transform .12s ease;
  }
  .btn-new-chat:hover {
    background: var(--primary-hover);
  }
  .btn-new-chat.btn-new-guru {
    background: #1C6EB4 !important;
  }
  .btn-new-chat.btn-new-guru:hover {
    background: #14558F !important;
  }

  .chat-session-list {
    flex: 1;
    overflow-y: auto;
    padding: 12px;
    display: flex;
    flex-direction: column;
    gap: 4px;
  }
  .session-channel-title {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: var(--ink-faint);
    padding: 8px 8px 4px;
  }

  .session-item,
  .session-item-row {
    display: flex;
    align-items: center;
    border-radius: var(--radius-s);
    text-decoration: none;
    color: var(--ink);
    transition: background-color .15s ease, border-color .15s ease;
    border: 1px solid transparent;
    position: relative;
  }
  .session-item {
    align-items: flex-start;
    gap: 10px;
    padding: 11px 12px;
  }
  .session-item:hover,
  .session-item-row:hover {
    background: var(--bg);
  }
  .session-item.active,
  .session-item-row.active {
    background: var(--primary-soft);
    border-color: rgba(36,70,63,0.18);
    font-weight: 600;
  }
  .session-item.active-guru,
  .session-item-row.active-guru {
    background: rgba(28, 110, 180, 0.12) !important;
    border-color: rgba(28, 110, 180, 0.25) !important;
    font-weight: 600;
  }
  .session-item-link {
    flex: 1;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 10px 6px 10px 10px;
    text-decoration: none;
    color: var(--ink);
    min-width: 0;
  }
  .btn-delete-session-sidebar {
    width: 30px;
    height: 30px;
    min-width: 30px;
    margin-right: 6px;
    border-radius: 6px;
    border: none;
    background: transparent;
    color: var(--ink-faint);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all .15s ease;
    opacity: 0.35;
  }
  .session-item-row:hover .btn-delete-session-sidebar,
  .btn-delete-session-sidebar:focus-visible {
    opacity: 1;
  }
  .btn-delete-session-sidebar:hover {
    background: rgba(201, 96, 59, 0.12);
    color: var(--warn);
    opacity: 1;
  }
  .session-icon {
    width: 28px;
    height: 28px;
    border-radius: 7px;
    background: var(--bg);
    border: 1px solid var(--line);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 1px;
  }
  .session-icon-guru {
    background: rgba(28, 110, 180, 0.1) !important;
    border-color: rgba(28, 110, 180, 0.2) !important;
    color: #1C6EB4 !important;
  }
  .session-info {
    flex: 1;
    min-width: 0;
  }
  .session-title {
    font-size: 13px;
    color: var(--ink);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: block;
    line-height: 1.35;
  }
  .session-time {
    font-size: 11px;
    color: var(--ink-faint);
    margin-top: 2px;
    display: block;
  }

  .chat-sidebar-foot {
    padding: 14px 16px;
    border-top: 1px solid var(--line);
    background: var(--bg);
    font-size: 11.5px;
    color: var(--ink-soft);
    line-height: 1.5;
    display: flex;
    align-items: flex-start;
    gap: 8px;
  }
  .chat-sidebar-foot svg {
    width: 16px;
    height: 16px;
    stroke: var(--primary);
    flex-shrink: 0;
    margin-top: 1px;
  }

  /* RUANG CHAT UTAMA */
  .chat-room {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--radius-l);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    box-shadow: var(--shadow-card);
    position: relative;
  }

  /* Header Chat Room */
  .chat-room-head {
    padding: 14px 20px;
    border-bottom: 1px solid var(--line);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    background: #FFFFFF;
    z-index: 10;
  }
  .chat-counselor-info {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .counselor-avatar {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: var(--primary);
    color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-family: 'Fraunces', serif;
    font-weight: 700;
  }
  .counselor-name {
    font-size: 15px;
    font-weight: 600;
    color: var(--ink);
    margin-bottom: 2px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .counselor-status {
    font-size: 12px;
    color: var(--ink-faint);
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .status-dot-pulse {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #2E7D34;
    box-shadow: 0 0 0 3px rgba(46,125,52,0.2);
    display: inline-block;
  }

  /* Mode Switcher Tabs */
  .mode-switch {
    display: inline-flex;
    align-items: center;
    background: var(--bg);
    border: 1px solid var(--line);
    border-radius: 999px;
    padding: 3px;
    gap: 3px;
  }
  .mode-btn {
    padding: 8px 18px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 600;
    border: none;
    background: transparent;
    color: var(--ink-soft);
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all .15s ease;
    min-height: 40px;
  }
  .mode-btn svg {
    width: 15px;
    height: 15px;
    stroke: currentColor;
  }
  .mode-btn.active {
    background: var(--primary);
    color: #FFFFFF;
    box-shadow: 0 2px 5px rgba(36,70,63,0.2);
  }
  .mode-btn.active-live {
    background: #1C6EB4 !important;
    color: #FFFFFF !important;
    box-shadow: 0 2px 5px rgba(28,110,180,0.25) !important;
  }

  /* Live Counselor Banner */
  .live-counselor-banner {
    padding: 10px 20px;
    background: #EBF3FA;
    border-bottom: 1px solid #D0E3F3;
    font-size: 12.5px;
    color: #124A7A;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
  }
  .live-counselor-banner.hidden {
    display: none !important;
  }

  /* Chat Stream Container */
  .chat-stream {
    flex: 1;
    overflow-y: auto;
    padding: 24px;
    background: #FAFBF9;
    display: flex;
    flex-direction: column;
    gap: 18px;
  }

  /* Bubbles */
  .bubble-row {
    display: flex;
    gap: 12px;
    max-width: 82%;
    align-items: flex-start;
  }
  .bubble-row.user {
    align-self: flex-end;
    flex-direction: row-reverse;
  }
  .bubble-row.assistant, .bubble-row.counselor {
    align-self: flex-start;
  }

  .bubble-avatar {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    flex-shrink: 0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
  }
  .bubble-row.user .bubble-avatar {
    background: var(--accent);
    color: #2A1C08;
  }
  .bubble-row.assistant .bubble-avatar {
    background: var(--primary);
    color: #FFFFFF;
  }
  .bubble-row.counselor .bubble-avatar {
    background: #1C6EB4;
    color: #FFFFFF;
  }

  .bubble-body {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }
  .bubble-card {
    padding: 14px 18px;
    border-radius: var(--chat-radius-bubble);
    font-size: 14px;
    line-height: 1.6;
    box-shadow: 0 1px 2px rgba(27,42,36,0.05);
    position: relative;
    word-break: break-word;
  }
  .bubble-row.user .bubble-card {
    background: var(--chat-bg-bubble-user);
    color: #FFFFFF;
    border-bottom-right-radius: 4px;
  }
  .bubble-row.assistant .bubble-card, 
  .bubble-row.counselor .bubble-card {
    background: #FFFFFF;
    color: var(--ink);
    border: 1px solid var(--chat-line);
    border-bottom-left-radius: 4px;
  }
  .bubble-row.counselor .bubble-card {
    border-left: 3px solid #1C6EB4;
  }

  .bubble-time {
    font-size: 11px;
    color: var(--ink-faint);
    padding: 0 4px;
  }
  .bubble-row.user .bubble-time {
    text-align: right;
  }

  /* Sources & Recommendation Chips */
  .meta-box {
    margin-top: 12px;
    padding-top: 10px;
    border-top: 1px solid var(--line);
    font-size: 12px;
  }
  .meta-title {
    font-weight: 600;
    color: var(--ink-soft);
    display: block;
    margin-bottom: 6px;
    font-size: 11.5px;
  }
  .chips-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
  }
  .source-chip {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    background: var(--bg);
    border: 1px solid var(--line);
    border-radius: 6px;
    color: var(--ink);
    font-size: 11.5px;
  }
  .ebook-card-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: #FFFFFF;
    border: 1px solid var(--line);
    border-radius: 8px;
    color: var(--primary);
    font-weight: 600;
    font-size: 12px;
    text-decoration: none;
    transition: all .15s ease;
    box-shadow: 0 1px 2px rgba(0,0,0,0.04);
  }
  .ebook-card-chip:hover {
    border-color: var(--primary);
    background: var(--primary-soft);
  }

  /* Typing Indicator */
  .typing-indicator {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 12px 18px;
    background: #FFFFFF;
    border: 1px solid var(--line);
    border-radius: var(--chat-radius-bubble);
    width: fit-content;
    box-shadow: 0 1px 2px rgba(0,0,0,0.04);
  }
  .typing-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--ink-faint);
    animation: typingBounce 1.3s infinite ease-in-out;
  }
  .typing-dot:nth-child(2) { animation-delay: 0.2s; }
  .typing-dot:nth-child(3) { animation-delay: 0.4s; }
  @keyframes typingBounce {
    0%, 80%, 100% { transform: translateY(0); opacity: 0.4; }
    40% { transform: translateY(-5px); opacity: 1; }
  }

  /* Quick Suggestions */
  .quick-bar {
    padding: 10px 20px;
    background: #FFFFFF;
    border-top: 1px solid var(--line);
    display: flex;
    align-items: center;
    gap: 8px;
    overflow-x: auto;
    white-space: nowrap;
  }
  .quick-label {
    font-size: 11.5px;
    font-weight: 600;
    color: var(--ink-faint);
    flex-shrink: 0;
  }
  .quick-pill {
    background: var(--bg);
    border: 1px solid var(--line);
    border-radius: 999px;
    padding: 6px 14px;
    font-size: 12px;
    font-weight: 500;
    color: var(--ink-soft);
    cursor: pointer;
    flex-shrink: 0;
    transition: all .15s ease;
  }
  .quick-pill:hover {
    border-color: var(--primary);
    color: var(--primary);
    background: #FFFFFF;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
  }

  /* Chat Input Area */
  .chat-input-box {
    padding: 16px 20px;
    background: #FFFFFF;
    border-top: 1px solid var(--line);
  }
  .chat-form {
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .input-wrapper {
    flex: 1;
    position: relative;
    display: flex;
    align-items: center;
  }
  .input-wrapper input {
    width: 100%;
    min-height: 46px;
    padding: 10px 42px 10px 18px;
    border-radius: 999px;
    border: 1.5px solid var(--line);
    font-size: 14px;
    background: var(--bg);
    color: var(--ink);
    outline: none;
    transition: border-color .15s ease, background-color .15s ease;
  }
  .input-wrapper input:focus {
    border-color: var(--primary);
    background: #FFFFFF;
    box-shadow: 0 0 0 3px rgba(36,70,63,0.12);
  }
  .input-clear-btn {
    position: absolute;
    right: 12px;
    background: none;
    border: none;
    color: var(--ink-faint);
    cursor: pointer;
    padding: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
  }
  .input-clear-btn:hover {
    color: var(--ink);
  }

  .btn-send {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    background: var(--primary);
    color: #FFFFFF;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    flex-shrink: 0;
    box-shadow: 0 2px 6px rgba(36,70,63,0.25);
    transition: background-color .15s ease, transform .12s ease;
  }
  .btn-send:hover {
    background: var(--primary-hover);
  }
  .btn-send:active {
    transform: scale(0.96);
  }
  .btn-send svg {
    width: 18px;
    height: 18px;
    stroke: #FFFFFF;
    fill: none;
  }
  .btn-send.btn-send-guru {
    background: #1C6EB4 !important;
  }

  .chat-disclaimer {
    font-size: 11px;
    color: var(--ink-faint);
    text-align: center;
    margin-top: 8px;
  }

  /* Mobile Toggle Archive Button */
  .btn-toggle-archive-mobile {
    display: none;
    align-items: center;
    gap: 6px;
    padding: 7px 11px;
    min-height: 38px;
    border-radius: var(--radius-s);
    background: var(--bg);
    border: 1px solid var(--line);
    color: var(--ink-soft);
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all .15s ease;
    white-space: nowrap;
    flex-shrink: 0;
  }
  .btn-toggle-archive-mobile:hover {
    color: var(--primary);
    border-color: var(--primary);
  }
  .chat-sidebar-mobile-backdrop {
    display: none;
  }
  .btn-close-archive-mobile {
    display: none;
  }
  .chat-sidebar-head-row {
    display: none;
  }

  /* Responsive Adjustments */
  @media (max-width: 860px) {
    .chat-layout {
      grid-template-columns: 1fr;
      height: calc(100dvh - 138px);
      min-height: 480px;
      gap: 0;
      position: relative;
    }
    .btn-toggle-archive-mobile {
      display: inline-flex;
    }
    .chat-sidebar {
      position: fixed;
      left: -320px;
      top: 0;
      bottom: 0;
      width: 300px;
      max-width: 85vw;
      z-index: 50;
      border-radius: 0;
      transition: left .25s cubic-bezier(0.16, 1, 0.3, 1);
      box-shadow: 16px 0 32px rgba(15, 29, 19, 0.25);
      background: var(--surface);
    }
    .chat-sidebar.open {
      left: 0;
    }
    .chat-sidebar-mobile-backdrop {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(15, 29, 19, 0.45);
      backdrop-filter: blur(2px);
      -webkit-backdrop-filter: blur(2px);
      z-index: 49;
    }
    .chat-sidebar-mobile-backdrop.open {
      display: block;
    }
    .chat-sidebar-head-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 8px;
      margin-bottom: 12px;
      padding-bottom: 8px;
      border-bottom: 1px solid var(--line);
    }
    .btn-close-archive-mobile {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 36px;
      min-height: 36px;
      border: 1px solid var(--line);
      border-radius: 8px;
      background: transparent;
      color: var(--ink-soft);
      cursor: pointer;
    }
    .chat-room {
      height: 100%;
      border-radius: var(--radius-m);
    }
    .chat-room-head {
      padding: 10px 12px;
      gap: 8px;
    }
    .chat-counselor-info {
      gap: 8px;
    }
    .counselor-avatar {
      width: 36px;
      height: 36px;
    }
    .counselor-name span {
      font-size: 13.5px;
      max-width: 140px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      display: inline-block;
    }
    .counselor-status {
      font-size: 11px;
    }
    .mode-switch {
      width: 100%;
      justify-content: space-between;
      margin-top: 4px;
    }
    .mode-btn {
      flex: 1;
      justify-content: center;
      padding: 6px 8px;
      font-size: 11px;
      min-height: 36px;
    }
    .mode-btn span {
      white-space: nowrap;
    }
    .bubble-row {
      max-width: 92%;
    }
    .chat-stream {
      padding: 14px 10px;
      gap: 12px;
    }
    .quick-bar {
      padding: 8px 10px;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: none;
    }
    .quick-bar::-webkit-scrollbar {
      display: none;
    }
    .chat-input-box {
      padding: 10px;
    }
    .chat-input {
      font-size: 16px !important;
    }
    .btn-send-chat {
      min-width: 44px;
      min-height: 44px;
      padding: 10px;
    }
  }
</style>
@endpush

@section('content')
<div class="chat-layout">
  
  <!-- Mobile Backdrop for Session Archive Drawer -->
  <div class="chat-sidebar-mobile-backdrop" id="chatSidebarBackdrop"></div>

  <!-- ================= LEFT: DAFTAR SESI & PRIVASI ================= -->
  <aside class="chat-sidebar" id="chatSidebar">
    <div class="chat-sidebar-head">
      <div class="chat-sidebar-head-row">
        <span style="font-size: 13.5px; font-weight: 700; color: var(--ink);">Arsip Sesi Bimbingan</span>
        <button type="button" class="btn-close-archive-mobile" id="btnCloseArchiveMobile" aria-label="Tutup Arsip Sesi">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </button>
      </div>

      <!-- Tombol Buat Sesi Baru Sesuai Kanal Aktif -->
      <button type="button" onclick="startNewSession('ai')" id="btn-new-ai" class="btn-new-chat">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="12" y1="5" x2="12" y2="19"></line>
          <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
        <span>Percakapan AI Baru</span>
      </button>

      <button type="button" onclick="startNewSession('live')" id="btn-new-live" class="btn-new-chat btn-new-guru" style="display: none;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 5v14M5 12h14"></path>
        </svg>
        <span>Konsultasi Guru BK Baru</span>
      </button>
    </div>

    <!-- 1. Daftar Sesi Chatbot AI (Tampil saat mode AI) -->
    <div class="chat-session-list custom-scrollbar" id="sessions-list-ai">
      <div class="session-channel-title">Arsip Chatbot AI (24/7)</div>
      @forelse($aiSessions as $s)
        <div class="session-item-row {{ ($activeAiSession && $activeAiSession->id === $s->id) ? 'active' : '' }}" id="session-row-{{ $s->id }}">
          <a href="{{ route('siswa.chat.session', $s->id) }}" class="session-item-link" title="Buka percakapan AI">
            <div class="session-icon">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
              </svg>
            </div>
            <div class="session-info">
              <span class="session-title">{{ $s->title }}</span>
              <span class="session-time">{{ $s->created_at ? $s->created_at->format('d M H:i') : '' }} WIB</span>
            </div>
          </a>
          <button type="button" 
                  class="btn-delete-session-sidebar" 
                  onclick="deleteAiSession({{ $s->id }}, event)" 
                  title="Hapus percakapan AI ini" 
                  aria-label="Hapus percakapan {{ $s->title }}">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="3 6 5 6 21 6"></polyline>
              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            </svg>
          </button>
        </div>
      @empty
        <div class="empty-sessions-notice" style="text-align: center; padding: 32px 16px; color: var(--ink-faint); font-size: 12.5px;">
          Belum ada percakapan AI. Tanyakan apa saja kepada asisten cerdas.
        </div>
      @endforelse
    </div>

    <!-- 2. Daftar Sesi Live Chat Guru BK (Tampil saat mode Live Chat) -->
    <div class="chat-session-list custom-scrollbar" id="sessions-list-live" style="display: none;">
      <div class="session-channel-title" style="color: #1C6EB4;">Arsip Live Chat Guru BK</div>
      @forelse($guruSessions as $s)
        <a href="{{ route('siswa.chat.session', $s->id) }}" 
           class="session-item {{ ($activeGuruSession && $activeGuruSession->id === $s->id) ? 'active-guru' : '' }}">
          <div class="session-icon session-icon-guru">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
              <circle cx="9" cy="7" r="4"></circle>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
          </div>
          <div class="session-info">
            <span class="session-title">{{ $s->title }}</span>
            <span class="session-time">{{ $s->created_at ? $s->created_at->format('d M H:i') : '' }} WIB</span>
          </div>
        </a>
      @empty
        <div style="text-align: center; padding: 32px 16px; color: var(--ink-faint); font-size: 12.5px;">
          Belum ada sesi Live Chat Guru BK. Mulai konsultasi langsung Anda sekarang.
        </div>
      @endforelse
    </div>

    <!-- Informasi Privasi & Keamanan ABKIN -->
    <div class="chat-sidebar-foot">
      <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
      </svg>
      <div>
        <strong>Asas Kerahasiaan ABKIN</strong>: Seluruh percakapan bimbingan tersimpan aman dan terenkripsi.
      </div>
    </div>
  </aside>

  <!-- ================= RIGHT: JENDELA CHAT UTAMA ================= -->
  <main class="chat-room">
    
    <!-- Top Header & Channel Switcher -->
    <header class="chat-room-head">
      <div class="chat-counselor-info">
        <!-- Tombol Buka Arsip Sesi di Layar Mobile -->
        <button type="button" class="btn-toggle-archive-mobile" id="btnToggleArchiveMobile" title="Buka Arsip Sesi">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="21 8 21 21 3 21 3 8"></polyline>
            <rect x="1" y="3" width="22" height="5"></rect>
            <line x1="10" y1="12" x2="14" y2="12"></line>
          </svg>
          <span>Sesi</span>
        </button>
        <div class="counselor-avatar" id="header-avatar">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 3v4M4.5 8.5 7 10M19.5 8.5 17 10M12 21v-7M6 14h12"/>
            <circle cx="12" cy="7" r="3.2"/>
          </svg>
        </div>
        <div>
          <div class="counselor-name">
            <span id="chat-title">{{ $activeAiSession ? $activeAiSession->title : 'SAPA BK : Asisten Konseling Cerdas' }}</span>
          </div>
          <div class="counselor-status">
            <span class="status-dot-pulse"></span>
            <span id="header-status-desc">Core RAG Bimbingan SMAN 4 Jember &bull; Online 24 Jam</span>
          </div>
        </div>
      </div>

      <!-- Mode Switcher: AI Chatbot vs Live Chat Guru BK -->
      <div class="mode-switch" role="tablist" aria-label="Pilih Mode Konseling">
        <button type="button" class="mode-btn active" id="btn-mode-ai" onclick="switchChatMode('ai')">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
          </svg>
          <span>Asisten Mandiri (24/7)</span>
        </button>
        <button type="button" class="mode-btn" id="btn-mode-live" onclick="switchChatMode('live')">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
          </svg>
          <span>Live Chat Guru BK</span>
        </button>
      </div>
    </header>

    <!-- Banner Info Khusus Live Chat Guru BK -->
    <div class="live-counselor-banner hidden" id="live-chat-banner">
      <div style="display: flex; align-items: center; gap: 8px;">
        <span class="status-dot-pulse"></span>
        <span><strong>Live Konseling Terhubung</strong>: Guru BK piket SMAN 4 Jember siap berdiskusi langsung denganmu (Jam Layanan: 08.00 - 15.00 WIB).</span>
      </div>
      <span style="font-size: 11px; font-weight: 600;">Ruang BK Lt. 1</span>
    </div>

    <!-- ========================================================
         STREAM 1: CHATBOT AI (ASISTEN MANDIRI 24/7)
         ======================================================== -->
    <div class="chat-stream custom-scrollbar" id="messages-stream-ai">
      
      <!-- Welcome Intro Bubble Chatbot AI -->
      <div class="bubble-row assistant">
        <div class="bubble-avatar">BK</div>
        <div class="bubble-body">
          <div class="bubble-card">
            <p>
              Halo, <strong>{{ auth()->user()->name }}</strong>! Selamat datang di ruang asisten bimbingan cerdas SAPA BK SMA Negeri 4 Jember.
            </p>
            <p style="margin-top: 8px; color: var(--ink-soft); font-size: 13.5px;">
              Saya siap membantu menjawab pertanyaan seputar pemilihan jurusan kuliah, persiapan seleksi SNBP/SNBT, modul belajar mandiri, dan informasi kurikulum sekolah secara instan 24 jam.
            </p>
          </div>
          <span class="bubble-time">{{ now()->format('H:i') }} WIB</span>
        </div>
      </div>

      <!-- Render Pesan Khusus Sesi AI -->
      @if($activeAiSession)
        @foreach($activeAiSession->messages as $msg)
          @if($msg->role === 'user')
            <div class="bubble-row user">
              <div class="bubble-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
              <div class="bubble-body">
                <div class="bubble-card">
                  {{ $msg->content }}
                </div>
                <span class="bubble-time">{{ $msg->created_at ? $msg->created_at->format('H:i') : '' }} WIB</span>
              </div>
            </div>
          @else
            <div class="bubble-row assistant">
              <div class="bubble-avatar">BK</div>
              <div class="bubble-body">
                <div class="bubble-card">
                  <p>{{ $msg->content }}</p>

                  @if(!empty($msg->metadata['sources']))
                    <div class="meta-box">
                      <span class="meta-title">Rujukan Pedoman Resmi SMAN 4:</span>
                      <div class="chips-wrap">
                        @foreach($msg->metadata['sources'] as $source)
                          <span class="source-chip">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                            {{ $source }}
                          </span>
                        @endforeach
                      </div>
                    </div>
                  @endif

                  @if(!empty($msg->metadata['recommended_ebooks']))
                    <div class="meta-box">
                      <span class="meta-title">E-Book &amp; Modul Pendukung:</span>
                      <div class="chips-wrap">
                        @foreach($msg->metadata['recommended_ebooks'] as $reb)
                          <a href="{{ $reb['url'] ?? route('ebook.index') }}" class="ebook-card-chip">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/></svg>
                            <span>{{ $reb['title'] }}</span>
                            <span>&rarr;</span>
                          </a>
                        @endforeach
                      </div>
                    </div>
                  @endif
                </div>
                <span class="bubble-time">{{ $msg->created_at ? $msg->created_at->format('H:i') : '' }} WIB</span>
              </div>
            </div>
          @endif
        @endforeach
      @endif

      <!-- Typing Indicator AI -->
      <div id="typing-indicator-ai" class="bubble-row assistant" style="display: none;">
        <div class="bubble-avatar">BK</div>
        <div class="bubble-body">
          <div class="typing-indicator">
            <span class="typing-dot"></span>
            <span class="typing-dot"></span>
            <span class="typing-dot"></span>
          </div>
        </div>
      </div>

    </div>

    <!-- ========================================================
         STREAM 2: LIVE CHAT GURU BK (KONSELING PRIVAT LANGSUNG)
         ======================================================== -->
    <div class="chat-stream custom-scrollbar" id="messages-stream-live" style="display: none;">
      
      <!-- Welcome Intro Bubble Live Chat Guru BK -->
      <div class="bubble-row counselor">
        <div class="bubble-avatar">BK</div>
        <div class="bubble-body">
          <div class="bubble-card">
            <p>
              Halo <strong>{{ auth()->user()->name }}</strong>! Selamat datang di ruang <strong>Live Chat Konseling Privat Guru BK</strong> SMAN 4 Jember.
            </p>
            <p style="margin-top: 8px; color: var(--ink-soft); font-size: 13.5px;">
              Di ruang ini Anda terhubung langsung dengan Tim Konselor Guru BK piket sekolah. Anda dapat berkonsultasi mengenai permasalahan belajar pribadi, rencana studi lanjut, maupun membuat janji tatap muka di Ruang BK. Seluruh percakapan dijamin kerahasiaannya sesuai Kode Etik ABKIN.
            </p>
          </div>
          <span class="bubble-time">{{ now()->format('H:i') }} WIB</span>
        </div>
      </div>

      <!-- Render Pesan Khusus Sesi Live Chat Guru BK -->
      @if($activeGuruSession)
        @foreach($activeGuruSession->messages as $msg)
          @if($msg->role === 'user')
            <div class="bubble-row user">
              <div class="bubble-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
              <div class="bubble-body">
                <div class="bubble-card">
                  {{ $msg->content }}
                </div>
                <span class="bubble-time">{{ $msg->created_at ? $msg->created_at->format('H:i') : '' }} WIB</span>
              </div>
            </div>
          @else
            <div class="bubble-row counselor">
              <div class="bubble-avatar">BK</div>
              <div class="bubble-body">
                <div class="bubble-card">
                  <div style="font-size: 11px; font-weight: 700; color: #1C6EB4; margin-bottom: 4px; text-transform: uppercase; letter-spacing: .04em;">
                    {{ $msg->metadata['counselor'] ?? 'Konselor Guru BK SMAN 4 Jember' }}
                  </div>
                  <p>{{ $msg->content }}</p>
                </div>
                <span class="bubble-time">{{ $msg->created_at ? $msg->created_at->format('H:i') : '' }} WIB</span>
              </div>
            </div>
          @endif
        @endforeach
      @endif

      <!-- Typing Indicator Live Chat -->
      <div id="typing-indicator-live" class="bubble-row counselor" style="display: none;">
        <div class="bubble-avatar">BK</div>
        <div class="bubble-body">
          <div class="typing-indicator">
            <span class="typing-dot"></span>
            <span class="typing-dot"></span>
            <span class="typing-dot"></span>
          </div>
        </div>
      </div>

    </div>

    <!-- Quick Suggestions Bar: Khusus AI -->
    <div class="quick-bar" id="quick-bar-ai">
      <span class="quick-label">Topik Chatbot AI:</span>
      <button type="button" class="quick-pill" onclick="sendQuick('Bagaimana strategi memilih jurusan kuliah untuk SNBP?')">
        Strategi Pemilihan Jurusan SNBP
      </button>
      <button type="button" class="quick-pill" onclick="sendQuick('Bagaimana cara mengatur jadwal belajar harian yang seimbang?')">
        Jadwal Belajar Efektif
      </button>
      <button type="button" class="quick-pill" onclick="sendQuick('Apa saja materi bimbingan karir untuk kelas 12?')">
        Materi Bimbingan Karir
      </button>
      <button type="button" class="quick-pill" onclick="sendQuick('Tips mengatasi kejenuhan dan stres belajar menghadapi ujian')">
        Pengelolaan Stres Belajar
      </button>
    </div>

    <!-- Quick Suggestions Bar: Khusus Live Chat Guru BK -->
    <div class="quick-bar" id="quick-bar-live" style="display: none;">
      <span class="quick-label" style="color: #1C6EB4;">Bimbingan Guru BK:</span>
      <button type="button" class="quick-pill" onclick="sendQuick('Selamat pagi Bapak/Ibu Guru BK, saya ingin konsultasi mengenai pilihan prodi SNBP')">
        Konsultasi Pilihan Prodi SNBP
      </button>
      <button type="button" class="quick-pill" onclick="sendQuick('Saya ingin membuat janji temu bimbingan tatap muka di Ruang BK sekolah')">
        Jadwalkan Konsultasi Tatap Muka
      </button>
      <button type="button" class="quick-pill" onclick="sendQuick('Bapak/Ibu Guru BK, saya mengalami kesulitan berkonsentrasi belajar di kelas')">
        Konsultasi Kendala Belajar
      </button>
      <button type="button" class="quick-pill" onclick="sendQuick('Saya bingung menentukan pilihan antara kuliah atau bekerja setelah lulus')">
        Rencana Masa Depan Pasca Lulus
      </button>
    </div>

    <!-- Input Form Area -->
    <div class="chat-input-box">
      <form id="chat-form" onsubmit="handleChatSubmit(event)" class="chat-form">
        <div class="input-wrapper">
          <input 
            type="text" 
            id="chat-input" 
            required 
            autocomplete="off"
            placeholder="Tanyakan apa saja seputar studi dan informasi sekolah kepada Asisten AI..."
            aria-label="Ketik pesan untuk konselor"
          />
          <button type="button" onclick="clearInput()" class="input-clear-btn" title="Hapus ketikan" aria-label="Hapus ketikan">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="18" y1="6" x2="6" y2="18"></line>
              <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
          </button>
        </div>

        <button type="submit" id="send-btn" class="btn-send" title="Kirim pesan" aria-label="Kirim pesan">
          <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="22" y1="2" x2="11" y2="13"></line>
            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
          </svg>
        </button>
      </form>
      <div class="chat-disclaimer" id="chat-disclaimer">
        SAPA BK didukung oleh basis pengetahuan resmi Guru BK SMA Negeri 4 Jember &bull; Kerahasiaan data terjamin
      </div>
    </div>

  </main>

</div>
@endsection

@push('scripts')
<script>
  let currentMode = "{{ $currentMode === 'guru_bk' ? 'live' : 'ai' }}";
  let activeAiSessionId = "{{ $activeAiSession?->id ?? '' }}";
  let activeGuruSessionId = "{{ $activeGuruSession?->id ?? '' }}";

  // Elemen DOM Stream
  const streamAi = document.getElementById('messages-stream-ai');
  const streamLive = document.getElementById('messages-stream-live');
  const typingIndicatorAi = document.getElementById('typing-indicator-ai');
  const typingIndicatorLive = document.getElementById('typing-indicator-live');

  // Elemen DOM Sidebar
  const sessionsListAi = document.getElementById('sessions-list-ai');
  const sessionsListLive = document.getElementById('sessions-list-live');
  const btnNewAi = document.getElementById('btn-new-ai');
  const btnNewLive = document.getElementById('btn-new-live');

  // Elemen DOM Quick Bars
  const quickBarAi = document.getElementById('quick-bar-ai');
  const quickBarLive = document.getElementById('quick-bar-live');

  // Elemen DOM Header & Form
  const chatInput = document.getElementById('chat-input');
  const chatTitle = document.getElementById('chat-title');
  const headerAvatar = document.getElementById('header-avatar');
  const headerStatusDesc = document.getElementById('header-status-desc');
  const liveBanner = document.getElementById('live-chat-banner');
  const sendBtn = document.getElementById('send-btn');
  const chatDisclaimer = document.getElementById('chat-disclaimer');

  const btnModeAi = document.getElementById('btn-mode-ai');
  const btnModeLive = document.getElementById('btn-mode-live');

  function scrollStreamToBottom(mode) {
    const el = (mode === 'live') ? streamLive : streamAi;
    if (el) el.scrollTop = el.scrollHeight;
  }

  function startNewSession(mode) {
    if (mode === 'live') {
      window.location.href = "{{ route('siswa.chat') }}?mode=live&new=1";
    } else {
      window.location.href = "{{ route('siswa.chat') }}?new=1";
    }
  }

  function sendQuick(text) {
    chatInput.value = text;
    document.getElementById('chat-form').dispatchEvent(new Event('submit'));
  }

  function clearInput() {
    chatInput.value = '';
    chatInput.focus();
  }

  function addSessionToSidebar(mode, sessionId, titleText) {
    const listEl = (mode === 'live') ? sessionsListLive : sessionsListAi;
    const shortTitle = titleText.length > 28 ? titleText.substring(0, 28) + '...' : titleText;
    const isLive = (mode === 'live');

    // Hapus placeholder teks jika sebelumnya kosong
    const emptyPlaceholder = listEl.querySelector('.empty-sessions-notice, div[style*="text-align: center"]');
    if (emptyPlaceholder) emptyPlaceholder.remove();

    // Matikan status active dari item lain
    listEl.querySelectorAll('.session-item, .session-item-row').forEach(el => {
      el.classList.remove('active', 'active-guru');
    });

    if (isLive) {
      const a = document.createElement('a');
      a.href = '/chat/' + sessionId;
      a.className = 'session-item active-guru';
      a.innerHTML = `
        <div class="session-icon session-icon-guru">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
          </svg>
        </div>
        <div class="session-info">
          <span class="session-title">${escapeHtml(shortTitle)}</span>
          <span class="session-time">Baru saja</span>
        </div>
      `;

      const titleEl = listEl.querySelector('.session-channel-title');
      if (titleEl && titleEl.nextElementSibling) {
        listEl.insertBefore(a, titleEl.nextElementSibling);
      } else {
        listEl.appendChild(a);
      }
    } else {
      const row = document.createElement('div');
      row.className = 'session-item-row active';
      row.id = 'session-row-' + sessionId;
      row.innerHTML = `
        <a href="/chat/${sessionId}" class="session-item-link" title="Buka percakapan AI">
          <div class="session-icon">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
          </div>
          <div class="session-info">
            <span class="session-title">${escapeHtml(shortTitle)}</span>
            <span class="session-time">Baru saja</span>
          </div>
        </a>
        <button type="button" 
                class="btn-delete-session-sidebar" 
                onclick="deleteAiSession(${sessionId}, event)" 
                title="Hapus percakapan AI ini" 
                aria-label="Hapus percakapan ${escapeHtml(shortTitle)}">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="3 6 5 6 21 6"></polyline>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
          </svg>
        </button>
      `;

      const titleEl = listEl.querySelector('.session-channel-title');
      if (titleEl && titleEl.nextElementSibling) {
        listEl.insertBefore(row, titleEl.nextElementSibling);
      } else {
        listEl.appendChild(row);
      }
    }
  }

  // Hapus arsip percakapan khusus Chatbot AI
  function deleteAiSession(sessionId, event) {
    if (event) {
      event.preventDefault();
      event.stopPropagation();
    }

    showConfirmModal({
      title: 'Hapus Arsip Percakapan AI?',
      message: 'Seluruh riwayat percakapan dan respons asisten cerdas pada sesi ini akan dihapus permanen dari akun Anda.',
      confirmText: 'Ya, Hapus Percakapan',
      cancelText: 'Batal',
      onConfirm: async function() {
        const rowEl = document.getElementById('session-row-' + sessionId);
        if (rowEl) {
          rowEl.style.opacity = '0.4';
          rowEl.style.pointerEvents = 'none';
        }

        try {
          const response = await fetch('/api/chat/session/' + sessionId, {
            method: 'DELETE',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
          });

          const data = await response.json();

          if (data.success) {
            if (rowEl) {
              rowEl.remove();
            }

            // Cek apakah masih ada sesi AI tersisa di sidebar
            const remainingAiRows = sessionsListAi.querySelectorAll('.session-item-row');
            if (remainingAiRows.length === 0) {
              const emptyNotice = document.createElement('div');
              emptyNotice.className = 'empty-sessions-notice';
              emptyNotice.style.cssText = 'text-align: center; padding: 32px 16px; color: var(--ink-faint); font-size: 12.5px;';
              emptyNotice.innerText = 'Belum ada percakapan AI. Tanyakan apa saja kepada asisten cerdas.';
              sessionsListAi.appendChild(emptyNotice);
            }

            // Jika sesi yang dihapus sedang aktif dibuka di layar, reset ke sesi baru
            if (activeAiSessionId == sessionId) {
              window.location.href = "{{ route('siswa.chat') }}?new=1";
            }
          } else {
            alert(data.message || 'Gagal menghapus percakapan.');
            if (rowEl) {
              rowEl.style.opacity = '1';
              rowEl.style.pointerEvents = 'auto';
            }
          }
        } catch (err) {
          alert('Terjadi kendala jaringan saat menghapus sesi percakapan.');
          if (rowEl) {
            rowEl.style.opacity = '1';
            rowEl.style.pointerEvents = 'auto';
          }
        }
      }
    });
  }

  // Pengalihan Tab Antara Chatbot AI dan Live Chat Guru BK
  function switchChatMode(mode) {
    currentMode = mode;

    if (mode === 'live') {
      // 1. Tombol Mode
      btnModeAi.classList.remove('active');
      btnModeLive.classList.add('active-live');

      // 2. Tampilkan Stream Live Chat, Sembunyikan AI (Tanpa menghapus chat AI!)
      streamAi.style.display = 'none';
      streamLive.style.display = 'flex';

      // 3. Tampilkan Sidebar Sesi Guru BK
      sessionsListAi.style.display = 'none';
      sessionsListLive.style.display = 'flex';
      btnNewAi.style.display = 'none';
      btnNewLive.style.display = 'flex';

      // 4. Tampilkan Quick Bar Khusus Guru BK
      quickBarAi.style.display = 'none';
      quickBarLive.style.display = 'flex';

      // 5. Header & Banner Guru BK
      liveBanner.classList.remove('hidden');
      headerAvatar.style.background = '#1C6EB4';
      headerAvatar.innerHTML = 'BK';
      sendBtn.classList.add('btn-send-guru');
      chatTitle.innerText = "{{ $activeGuruSession ? $activeGuruSession->title : 'Konsultasi Live : Guru BK SMAN 4 Jember' }}";
      headerStatusDesc.innerHTML = 'Layanan Konseling Privat Siswa &bull; Piket Aktif (08.00 - 15.00 WIB)';
      chatInput.placeholder = 'Ketik pesan konsultasi langsung untuk Guru BK piket...';
      chatDisclaimer.innerHTML = 'Sesi dialog privat dengan Guru BK SMAN 4 Jember &bull; Terlindungi Kode Etik ABKIN';

      scrollStreamToBottom('live');
    } else {
      // 1. Tombol Mode
      btnModeLive.classList.remove('active-live');
      btnModeAi.classList.add('active');

      // 2. Tampilkan Stream AI, Sembunyikan Live Chat (Tanpa menghapus chat Guru BK!)
      streamLive.style.display = 'none';
      streamAi.style.display = 'flex';

      // 3. Tampilkan Sidebar Sesi AI
      sessionsListLive.style.display = 'none';
      sessionsListAi.style.display = 'flex';
      btnNewLive.style.display = 'none';
      btnNewAi.style.display = 'flex';

      // 4. Tampilkan Quick Bar Khusus AI
      quickBarLive.style.display = 'none';
      quickBarAi.style.display = 'flex';

      // 5. Header & Banner AI
      liveBanner.classList.add('hidden');
      headerAvatar.style.background = 'var(--primary)';
      headerAvatar.innerHTML = `
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 3v4M4.5 8.5 7 10M19.5 8.5 17 10M12 21v-7M6 14h12"/>
          <circle cx="12" cy="7" r="3.2"/>
        </svg>
      `;
      sendBtn.classList.remove('btn-send-guru');
      chatTitle.innerText = "{{ $activeAiSession ? $activeAiSession->title : 'SAPA BK : Asisten Konseling Cerdas' }}";
      headerStatusDesc.innerHTML = 'Core RAG Bimbingan SMAN 4 Jember &bull; Online 24 Jam';
      chatInput.placeholder = 'Tanyakan apa saja seputar studi dan informasi sekolah kepada Asisten AI...';
      chatDisclaimer.innerHTML = 'SAPA BK didukung oleh basis pengetahuan resmi Guru BK SMA Negeri 4 Jember &bull; Kerahasiaan data terjamin';

      scrollStreamToBottom('ai');
    }
  }

  // Penanganan Pengiriman Pesan
  async function handleChatSubmit(e) {
    e.preventDefault();
    const text = chatInput.value.trim();
    if (!text) return;

    chatInput.value = '';

    const targetMode = currentMode;
    const targetSessionId = (targetMode === 'live') ? activeGuruSessionId : activeAiSessionId;
    const targetIndicator = (targetMode === 'live') ? typingIndicatorLive : typingIndicatorAi;

    // Pasang pesan siswa HANYA ke stream yang sedang aktif
    appendMessage(targetMode, 'user', text);
    targetIndicator.style.display = 'flex';
    scrollStreamToBottom(targetMode);

    try {
      const response = await fetch("{{ route('api.chat.send') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
          session_id: targetSessionId || null,
          message: text,
          mode: (targetMode === 'live') ? 'guru_bk' : 'ai'
        })
      });

      const data = await response.json();
      targetIndicator.style.display = 'none';

      if (data.success) {
        if (targetMode === 'live') {
          if (!activeGuruSessionId && data.session_id) {
            activeGuruSessionId = data.session_id;
            chatTitle.innerText = data.user_message.content.substring(0, 30) + '...';
            window.history.replaceState(null, '', '/chat/' + data.session_id);
            addSessionToSidebar('live', data.session_id, data.user_message.content);
          }
          appendMessage('live', 'counselor', data.assistant_message.content);
        } else {
          if (!activeAiSessionId && data.session_id) {
            activeAiSessionId = data.session_id;
            chatTitle.innerText = data.user_message.content.substring(0, 30) + '...';
            window.history.replaceState(null, '', '/chat/' + data.session_id);
            addSessionToSidebar('ai', data.session_id, data.user_message.content);
          }
          appendMessage('ai', 'assistant', data.assistant_message.content, data.assistant_message.metadata);
        }
      } else {
        appendMessage(targetMode, targetMode === 'live' ? 'counselor' : 'assistant', 'Maaf, terjadi kendala saat mencatat pesan bimbingan. Silakan coba kembali.');
      }
    } catch (err) {
      targetIndicator.style.display = 'none';
      appendMessage(targetMode, targetMode === 'live' ? 'counselor' : 'assistant', 'Koneksi jaringan terputus. Pastikan server aktif dan coba beberapa saat lagi.');
    }

    scrollStreamToBottom(targetMode);
  }

  // Menyisipkan bubble ke stream yang dituju secara presisi
  function appendMessage(streamMode, role, content, metadata = null) {
    const targetStream = (streamMode === 'live') ? streamLive : streamAi;
    const targetIndicator = (streamMode === 'live') ? typingIndicatorLive : typingIndicatorAi;

    const row = document.createElement('div');
    const nowTime = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB';

    if (role === 'user') {
      row.className = 'bubble-row user';
      row.innerHTML = `
        <div class="bubble-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
        <div class="bubble-body">
          <div class="bubble-card">
            ${escapeHtml(content).replace(/\n/g, '<br>')}
          </div>
          <span class="bubble-time">${nowTime}</span>
        </div>
      `;
    } else {
      const isCounselor = (streamMode === 'live' || role === 'counselor');
      row.className = isCounselor ? 'bubble-row counselor' : 'bubble-row assistant';

      let metaHtml = '';
      if (metadata && metadata.sources && metadata.sources.length) {
        let chips = metadata.sources.map(s => `
          <span class="source-chip">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
            ${escapeHtml(s)}
          </span>
        `).join('');

        metaHtml += `
          <div class="meta-box">
            <span class="meta-title">Rujukan Pedoman Resmi SMAN 4:</span>
            <div class="chips-wrap">${chips}</div>
          </div>
        `;
      }

      let counselorTag = isCounselor ? `
        <div style="font-size: 11px; font-weight: 700; color: #1C6EB4; margin-bottom: 4px; text-transform: uppercase; letter-spacing: .04em;">
          Konselor Guru BK SMAN 4 Jember
        </div>
      ` : '';

      row.innerHTML = `
        <div class="bubble-avatar">${isCounselor ? 'BK' : 'BK'}</div>
        <div class="bubble-body">
          <div class="bubble-card">
            ${counselorTag}
            <p>${escapeHtml(content).replace(/\n/g, '<br>')}</p>
            ${metaHtml}
          </div>
          <span class="bubble-time">${nowTime}</span>
        </div>
      `;
    }

    targetStream.insertBefore(row, targetIndicator);
  }

  function escapeHtml(text) {
    const map = {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
  }

  // Mobile Archive Drawer Toggle Handler
  const chatSidebarEl = document.getElementById('chatSidebar');
  const chatBackdropEl = document.getElementById('chatSidebarBackdrop');
  const btnToggleArchiveEl = document.getElementById('btnToggleArchiveMobile');
  const btnCloseArchiveEl = document.getElementById('btnCloseArchiveMobile');

  if (btnToggleArchiveEl && chatSidebarEl && chatBackdropEl) {
    btnToggleArchiveEl.addEventListener('click', () => {
      chatSidebarEl.classList.add('open');
      chatBackdropEl.classList.add('open');
    });
    const closeDrawer = () => {
      chatSidebarEl.classList.remove('open');
      chatBackdropEl.classList.remove('open');
    };
    chatBackdropEl.addEventListener('click', closeDrawer);
    if (btnCloseArchiveEl) {
      btnCloseArchiveEl.addEventListener('click', closeDrawer);
    }
  }

  // Inisialisasi awal pada saat memuat halaman
  if (currentMode === 'live') {
    switchChatMode('live');
  } else {
    scrollStreamToBottom('ai');
  }
</script>
@endpush
