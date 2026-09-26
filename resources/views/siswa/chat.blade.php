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
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: transparent;
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

  /* Live Counselor Banner & High Contrast Picker */
  .live-counselor-banner {
    padding: 10px 20px;
    background: #F1F6FB;
    border-bottom: 1px solid #CFE2F2;
    font-size: 13px;
    color: #0F172A;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
  }
  .live-counselor-banner.hidden {
    display: none !important;
  }
  .counselor-picker-left {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    flex: 1;
    min-width: 260px;
  }
  .counselor-picker-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 11px;
    background: #1C6EB4;
    color: #FFFFFF;
    font-size: 11px;
    font-weight: 700;
    border-radius: 6px;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    flex-shrink: 0;
  }
  .counselor-picker-desc {
    color: #1E293B;
    font-size: 13px;
    line-height: 1.4;
  }
  .counselor-picker-right {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
  }
  .counselor-select-box {
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }
  .counselor-select-label {
    font-size: 12.5px;
    font-weight: 700;
    color: #0F172A;
    white-space: nowrap;
  }
  .counselor-select-dropdown-wrap {
    position: relative;
    display: inline-flex;
    align-items: center;
  }
  .counselor-select-element {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    font-size: 13px;
    font-weight: 700;
    color: #0F172A !important;
    background-color: #FFFFFF !important;
    border: 1.5px solid #1C6EB4;
    border-radius: 8px;
    padding: 7px 36px 7px 12px;
    min-height: 38px;
    cursor: pointer;
    box-shadow: 0 1px 3px rgba(28, 110, 180, 0.12);
    transition: border-color .15s ease, box-shadow .15s ease;
    max-width: 320px;
  }
  .counselor-select-element:hover {
    border-color: #14558F;
  }
  .counselor-select-element:focus {
    outline: none;
    border-color: #14558F;
    box-shadow: 0 0 0 3px rgba(28, 110, 180, 0.25);
  }
  .counselor-select-element option {
    font-size: 13.5px;
    font-weight: 600;
    color: #0F172A !important;
    background-color: #FFFFFF !important;
    padding: 10px 12px;
  }
  .counselor-select-arrow {
    position: absolute;
    right: 11px;
    pointer-events: none;
    stroke: #1C6EB4;
  }
  .counselor-location-tag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11.5px;
    font-weight: 600;
    color: #334155;
    background: #E2E8F0;
    padding: 5px 10px;
    border-radius: 6px;
    white-space: nowrap;
  }
  .counselor-active-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12.5px;
    font-weight: 700;
    color: #1C6EB4;
    background: #EBF4FC;
    padding: 5px 12px;
    border-radius: 8px;
    border: 1px solid #BBD8F2;
  }
  .counselor-dot-online {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #16A34A;
    display: inline-block;
  }

  /* Interactive Counselor Selection Cards (Stream) */
  .counselor-choice-container {
    background: #FFFFFF;
    border: 1.5px solid #CFE2F2;
    border-radius: 14px;
    padding: 20px 22px;
    margin: 4px 0 12px;
    box-shadow: 0 4px 14px rgba(28, 110, 180, 0.06);
  }
  .counselor-choice-header {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 16px;
  }
  .counselor-choice-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #1C6EB4;
    color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 2px 6px rgba(28, 110, 180, 0.25);
  }
  .counselor-choice-title {
    font-size: 15px;
    font-weight: 700;
    color: #0F172A;
    margin: 0 0 3px;
  }
  .counselor-choice-subtitle {
    font-size: 13px;
    color: #475569;
    margin: 0;
    line-height: 1.45;
  }
  .counselor-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 12px;
  }
  .counselor-card {
    background: #FFFFFF;
    border: 2px solid #E2E8F0;
    border-radius: 12px;
    padding: 15px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    gap: 14px;
    cursor: pointer;
    transition: all .18s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
  }
  .counselor-card:hover {
    border-color: #93C5FD;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(28, 110, 180, 0.12);
  }
  .counselor-card.selected {
    border-color: #1C6EB4;
    background: #F4F8FC;
    box-shadow: 0 4px 14px rgba(28, 110, 180, 0.18);
  }
  .counselor-card-top {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .counselor-card-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #1C6EB4;
    color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 15px;
    position: relative;
    flex-shrink: 0;
    border: 2px solid #FFFFFF;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  }
  .counselor-card-avatar img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
  }
  .counselor-card-online-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #16A34A;
    border: 2px solid #FFFFFF;
    position: absolute;
    bottom: 0;
    right: 0;
  }
  .counselor-card-info {
    flex: 1;
    min-width: 0;
  }
  .counselor-card-name {
    font-size: 14px;
    font-weight: 700;
    color: #0F172A;
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .counselor-card-role {
    font-size: 11.5px;
    font-weight: 500;
    color: #475569;
    margin-bottom: 4px;
  }
  .counselor-card-room {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 600;
    color: #1C6EB4;
    background: #EBF4FC;
    padding: 2px 6px;
    border-radius: 4px;
  }
  .btn-select-counselor {
    width: 100%;
    min-height: 38px;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 600;
    border: 1.5px solid #CBD5E1;
    background: #FFFFFF;
    color: #334155;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    cursor: pointer;
    transition: all .15s ease;
  }
  .btn-select-counselor:hover {
    background: #F8FAFC;
    border-color: #94A3B8;
  }
  .counselor-card.selected .btn-select-counselor {
    background: #1C6EB4;
    color: #FFFFFF;
    border-color: #1C6EB4;
    font-weight: 700;
    box-shadow: 0 2px 6px rgba(28, 110, 180, 0.25);
  }
  .btn-select-counselor-icon {
    display: inline-flex;
    align-items: center;
  }
  .counselor-choice-footer {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 14px;
    padding-top: 12px;
    border-top: 1px dashed #CBD5E1;
    font-size: 12px;
    color: #475569;
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

  /* Pending Attachment Bar above Input */
  .pending-attachment-bar {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    background: #F0F7FD;
    border: 1.5px solid #BAdaf5;
    border-radius: 12px;
    margin-bottom: 10px;
    animation: slideDownAttachment .2s ease;
  }
  @keyframes slideDownAttachment {
    from { opacity: 0; transform: translateY(6px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .pending-attachment-icon-box {
    width: 36px;
    height: 36px;
    border-radius: 9px;
    background: #1C6EB4;
    color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .pending-attachment-content {
    flex: 1;
    min-width: 0;
  }
  .pending-attachment-tag {
    font-size: 11px;
    font-weight: 700;
    color: #1C6EB4;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 1px;
  }
  .pending-attachment-title {
    font-size: 13.5px;
    font-weight: 700;
    color: #0F172A;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .pending-attachment-subtitle {
    font-size: 11.5px;
    color: #475569;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .pending-attachment-action-wrap {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
  }
  .btn-preview-attachment {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    font-weight: 600;
    color: #1C6EB4;
    background: #FFFFFF;
    border: 1px solid #BAdaf5;
    padding: 5px 10px;
    border-radius: 6px;
    text-decoration: none;
    transition: all .15s ease;
  }
  .btn-preview-attachment:hover {
    background: #E0EFFC;
    border-color: #1C6EB4;
  }
  .btn-remove-attachment {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    background: transparent;
    border: 1px solid #CBD5E1;
    color: #64748B;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all .15s ease;
  }
  .btn-remove-attachment:hover {
    background: #FEE2E2;
    border-color: #F87171;
    color: #DC2626;
  }

  /* Message Attachment Card inside bubbles */
  .msg-attachment-card {
    background: #FFFFFF;
    border: 1.5px solid #CBD5E1;
    border-radius: 10px;
    padding: 12px 14px;
    margin-bottom: 10px;
    text-align: left;
    color: #0F172A !important;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
  }
  .msg-attachment-badge {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 6px;
    flex-wrap: wrap;
  }
  .msg-attachment-type {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 10.5px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 4px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    background: #1C6EB4;
    color: #FFFFFF !important;
  }
  .msg-attachment-type.ebook { background: #1C6EB4; color: #FFFFFF !important; }
  .msg-attachment-type.tes, .msg-attachment-type.kuis { background: #15803D; color: #FFFFFF !important; }
  .msg-attachment-type.artikel, .msg-attachment-type.article { background: #7C3AED; color: #FFFFFF !important; }
  .msg-attachment-score {
    font-size: 11px;
    font-weight: 700;
    color: #15803D !important;
    background: #DCFCE7;
    padding: 2px 7px;
    border-radius: 4px;
    border: 1px solid #86EFAC;
  }
  .msg-attachment-title {
    font-size: 13.5px;
    font-weight: 700;
    color: #0F172A !important;
    line-height: 1.35;
    margin-bottom: 2px;
  }
  .msg-attachment-sub {
    font-size: 11.5px;
    font-weight: 600;
    color: #475569 !important;
    margin-bottom: 4px;
  }
  .msg-attachment-desc {
    font-size: 12px;
    color: #334155 !important;
    line-height: 1.4;
    margin-bottom: 8px;
  }
  .msg-attachment-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11.5px;
    font-weight: 700;
    color: #1C6EB4 !important;
    background: #FFFFFF;
    border: 1px solid #B8D5ED;
    padding: 5px 11px;
    border-radius: 6px;
    text-decoration: none;
    transition: all .15s ease;
  }
  .msg-attachment-btn:hover {
    background: #1C6EB4;
    color: #FFFFFF !important;
    border-color: #1C6EB4;
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
      width: 40px;
      height: 40px;
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
    .live-counselor-banner {
      flex-direction: column;
      align-items: flex-start;
      gap: 10px;
      padding: 12px 14px;
    }
    .counselor-picker-left {
      min-width: 0;
      width: 100%;
    }
    .counselor-picker-right {
      width: 100%;
      flex-direction: column;
      align-items: stretch;
      gap: 8px;
    }
    .counselor-select-box {
      width: 100%;
      flex-direction: column;
      align-items: flex-start;
      gap: 6px;
    }
    .counselor-select-dropdown-wrap {
      width: 100%;
    }
    .counselor-select-element {
      width: 100%;
      max-width: 100%;
    }
    .counselor-cards-grid {
      grid-template-columns: 1fr;
    }
    .counselor-choice-container {
      padding: 16px 14px;
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
      @forelse($guruSessions ?? [] as $s)
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
        <div class="counselor-avatar" id="header-avatar" style="background: transparent; overflow: hidden; width: 48px; height: 48px;">
          <img src="{{ asset('images/logo-sman4.png') }}" alt="Logo SMAN 4 Jember" style="width: 48px; height: 48px; object-fit: contain; filter: drop-shadow(0 1px 3px rgba(0,0,0,0.2));" />
        </div>
        <div>
          <div class="counselor-name">
            <span id="chat-title">{{ $activeAiSession ? $activeAiSession->title : 'SAPA BK : Asisten Konseling Cerdas' }}</span>
          </div>
          <div class="counselor-status">
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
      <div class="counselor-picker-left">
        <span class="counselor-picker-badge">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
          </svg>
          Live Konseling
        </span>
        <span id="live-banner-desc" class="counselor-picker-desc">
          @if($activeGuruSession && $activeGuruSession->status === 'active')
            <strong>Sesi Aktif</strong>: Berdiskusi langsung dengan <strong>{{ $activeGuruSession->teacher?->name ?? 'Guru BK' }}</strong> (Jam Layanan: 08.00 - 15.00 WIB).
          @elseif($activeGuruSession && $activeGuruSession->status === 'closed')
            <strong>Sesi Selesai</strong>: Ruang obrolan telah ditutup oleh Guru BK. Klik "Konsultasi Guru BK Baru" jika ingin bimbingan baru.
          @else
            <strong>Pilih Guru BK</strong>: Pilih guru tujuan bimbingan di bawah ini atau melalui menu pilihan di samping.
          @endif
        </span>
      </div>

      <div class="counselor-picker-right">
        @if(!$activeGuruSession || $activeGuruSession->status === 'closed')
          <div class="counselor-select-box" id="counselor-select-container">
            <label for="select-guru-bk" class="counselor-select-label">Pilih Guru BK:</label>
            <div class="counselor-select-dropdown-wrap">
              <select id="select-guru-bk" class="counselor-select-element" aria-label="Pilih Guru BK Tujuan">
                @foreach($guruList ?? [] as $g)
                  <option value="{{ $g->id }}" data-name="{{ $g->name }}" {{ $loop->first ? 'selected' : '' }}>
                    Konselor: {{ $g->name }}
                  </option>
                @endforeach
              </select>
              <svg class="counselor-select-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"></polyline>
              </svg>
            </div>
          </div>
        @else
          <div class="counselor-active-badge">
            <span class="counselor-dot-online"></span>
            <span class="counselor-active-name">{{ $activeGuruSession->teacher?->name ?? 'Guru BK Piket' }}</span>
          </div>
        @endif
        <span class="counselor-location-tag">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
            <circle cx="12" cy="10" r="3"></circle>
          </svg>
          Ruang BK Lt. 1
        </span>
      </div>
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
                  @if(!empty($msg->metadata['attachment']))
                    @php $att = $msg->metadata['attachment']; @endphp
                    <div class="msg-attachment-card">
                      <div class="msg-attachment-badge">
                        <span class="msg-attachment-type {{ $att['type'] ?? 'info' }}">
                          {{ $att['type_label'] ?? strtoupper($att['type'] ?? 'Lampiran') }}
                        </span>
                        @if(!empty($att['score']))
                          <span class="msg-attachment-score">{{ $att['score'] }}</span>
                        @endif
                      </div>
                      <div class="msg-attachment-title">{{ $att['title'] ?? 'Dokumen Bimbingan' }}</div>
                      @if(!empty($att['subtitle']))
                        <div class="msg-attachment-sub">{{ $att['subtitle'] }}</div>
                      @endif
                      @if(!empty($att['description']))
                        <div class="msg-attachment-desc">{{ \Illuminate\Support\Str::limit($att['description'], 130) }}</div>
                      @endif
                      @if(!empty($att['url']))
                        <a href="{{ $att['url'] }}" target="_blank" class="msg-attachment-btn">
                          <span>Buka Lampiran</span>
                          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                        </a>
                      @endif
                    </div>
                  @endif
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

      <!-- Kartu Profil Pilihan Guru BK (Tampil saat belum ada sesi aktif atau sesi tertutup) -->
      @if(!$activeGuruSession || $activeGuruSession->status === 'closed')
        <div class="counselor-choice-container" id="counselor-choice-container">
          <div class="counselor-choice-header">
            <div class="counselor-choice-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
              </svg>
            </div>
            <div>
              <h3 class="counselor-choice-title">Pilih Guru BK untuk Bimbingan Konseling</h3>
              <p class="counselor-choice-subtitle">
                Silakan tentukan Guru BK tujuan bimbingan Anda. Pesan pertama yang Anda kirim akan langsung diteruskan ke Guru BK yang dipilih.
              </p>
            </div>
          </div>

          <div class="counselor-cards-grid">
            @foreach($guruList ?? [] as $g)
              <div class="counselor-card {{ $loop->first ? 'selected' : '' }}" 
                   id="counselor-card-{{ $g->id }}" 
                   data-id="{{ $g->id }}" 
                   data-name="{{ $g->name }}"
                   onclick="selectCounselorTeacher({{ $g->id }}, '{{ addslashes($g->name) }}')">
                <div class="counselor-card-top">
                  <div class="counselor-card-avatar">
                    @if($g->avatar_url)
                      <img src="{{ $g->avatar_url }}" alt="{{ $g->name }}" />
                    @else
                      <span>{{ strtoupper(substr($g->name, 0, 2)) }}</span>
                    @endif
                    <span class="counselor-card-online-dot" title="Konselor Piket Aktif"></span>
                  </div>
                  <div class="counselor-card-info">
                    <div class="counselor-card-name" title="{{ $g->name }}">{{ $g->name }}</div>
                    <div class="counselor-card-role">Konselor Bimbingan Konseling</div>
                    <div class="counselor-card-room">
                      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                      </svg>
                      <span>Ruang BK Lt. 1 &bull; Siap Bimbingan</span>
                    </div>
                  </div>
                </div>

                <div class="counselor-card-action">
                  <button type="button" class="btn-select-counselor" id="btn-select-counselor-{{ $g->id }}" onclick="event.stopPropagation(); selectCounselorTeacher({{ $g->id }}, '{{ addslashes($g->name) }}');">
                    <span class="btn-select-counselor-icon" style="{{ $loop->first ? 'display: inline-flex;' : 'display: none;' }}">
                      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                      </svg>
                    </span>
                    <span class="btn-select-counselor-text">{{ $loop->first ? 'Konselor Terpilih' : 'Pilih Konselor Ini' }}</span>
                  </button>
                </div>
              </div>
            @endforeach
          </div>

          <div class="counselor-choice-footer">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1C6EB4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"></circle>
              <line x1="12" y1="16" x2="12" y2="12"></line>
              <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>
            <span>Setelah memilih guru, ketikkan pesan Anda pada kolom di bawah dan tekan tombol kirim untuk memulai sesi.</span>
          </div>
        </div>
      @endif

      <!-- Render Pesan Khusus Sesi Live Chat Guru BK -->
      @if($activeGuruSession)
        @foreach($activeGuruSession->messages as $msg)
          @if($msg->role === 'user')
            <div class="bubble-row user" data-msg-id="{{ $msg->id }}">
              <div class="bubble-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
              <div class="bubble-body">
                <div class="bubble-card">
                  @if(!empty($msg->metadata['attachment']))
                    @php $att = $msg->metadata['attachment']; @endphp
                    <div class="msg-attachment-card">
                      <div class="msg-attachment-badge">
                        <span class="msg-attachment-type {{ $att['type'] ?? 'info' }}">
                          {{ $att['type_label'] ?? strtoupper($att['type'] ?? 'Lampiran') }}
                        </span>
                        @if(!empty($att['score']))
                          <span class="msg-attachment-score">{{ $att['score'] }}</span>
                        @endif
                      </div>
                      <div class="msg-attachment-title">{{ $att['title'] ?? 'Dokumen Bimbingan' }}</div>
                      @if(!empty($att['subtitle']))
                        <div class="msg-attachment-sub">{{ $att['subtitle'] }}</div>
                      @endif
                      @if(!empty($att['description']))
                        <div class="msg-attachment-desc">{{ \Illuminate\Support\Str::limit($att['description'], 130) }}</div>
                      @endif
                      @if(!empty($att['url']))
                        <a href="{{ $att['url'] }}" target="_blank" class="msg-attachment-btn">
                          <span>Buka Lampiran</span>
                          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                        </a>
                      @endif
                    </div>
                  @endif
                  {{ $msg->content }}
                </div>
                <span class="bubble-time">{{ $msg->created_at ? $msg->created_at->format('H:i') : '' }} WIB</span>
              </div>
            </div>
          @else
            <div class="bubble-row counselor" data-msg-id="{{ $msg->id }}">
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
      @if(!empty($initialAttachment))
        <div class="pending-attachment-bar" id="pending-attachment-bar">
          <div class="pending-attachment-icon-box">
            @if($initialAttachment['type'] === 'ebook')
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/></svg>
            @elseif(in_array($initialAttachment['type'], ['tes', 'kuis']))
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            @else
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            @endif
          </div>
          <div class="pending-attachment-content">
            <div class="pending-attachment-tag">{{ $initialAttachment['type_label'] }}</div>
            <div class="pending-attachment-title" title="{{ $initialAttachment['title'] }}">{{ $initialAttachment['title'] }}</div>
            @if(!empty($initialAttachment['subtitle']) || !empty($initialAttachment['score']))
              <div class="pending-attachment-subtitle">
                @if(!empty($initialAttachment['score']))
                  <strong style="color: #15803D;">{{ $initialAttachment['score'] }}</strong> &bull;
                @endif
                {{ $initialAttachment['subtitle'] }}
              </div>
            @endif
          </div>
          <div class="pending-attachment-action-wrap">
            @if(!empty($initialAttachment['url']))
              <a href="{{ $initialAttachment['url'] }}" target="_blank" class="btn-preview-attachment" title="Buka Dokumen Asli">
                <span>Lihat</span>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
              </a>
            @endif
            <button type="button" class="btn-remove-attachment" onclick="removePendingAttachment()" title="Batal Lampirkan" aria-label="Batal Lampirkan">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="18" x2="18" y2="6"/></svg>
            </button>
          </div>
        </div>
      @endif
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
  let currentGuruSessionStatus = "{{ $activeGuruSession?->status ?? 'none' }}";
  let hasActiveLiveSession = {{ (isset($guruSessions) && $guruSessions->where('status', 'active')->count() > 0) ? 'true' : 'false' }};
  let pendingAttachment = @json($initialAttachment ?? null);

  window.removePendingAttachment = function() {
    pendingAttachment = null;
    const bar = document.getElementById('pending-attachment-bar');
    if (bar) bar.remove();
  };

  function renderAttachmentHtml(att) {
    if (!att) return '';
    const type = escapeHtml(att.type || 'info');
    const typeLabel = escapeHtml(att.type_label || (att.type ? att.type.toUpperCase() : 'LAMPIRAN'));
    const title = escapeHtml(att.title || 'Dokumen Bimbingan');
    const subtitle = att.subtitle ? escapeHtml(att.subtitle) : '';
    const desc = att.description ? escapeHtml(att.description) : '';
    const score = att.score ? escapeHtml(att.score) : '';
    const url = att.url ? escapeHtml(att.url) : '';

    return `
      <div class="msg-attachment-card">
        <div class="msg-attachment-badge">
          <span class="msg-attachment-type ${type}">${typeLabel}</span>
          ${score ? `<span class="msg-attachment-score">${score}</span>` : ''}
        </div>
        <div class="msg-attachment-title">${title}</div>
        ${subtitle ? `<div class="msg-attachment-sub">${subtitle}</div>` : ''}
        ${desc ? `<div class="msg-attachment-desc">${desc.length > 130 ? desc.substring(0, 130) + '...' : desc}</div>` : ''}
        ${url ? `
          <a href="${url}" target="_blank" class="msg-attachment-btn">
            <span>Buka Lampiran</span>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
          </a>
        ` : ''}
      </div>
    `;
  }

  // Lacak seluruh ID pesan live chat yang sudah ditampilkan di layar
  const knownLiveMsgIds = new Set();
  document.querySelectorAll('#messages-stream-live [data-msg-id]').forEach(el => {
    const id = parseInt(el.getAttribute('data-msg-id'), 10);
    if (!isNaN(id)) knownLiveMsgIds.add(id);
  });

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
      if (hasActiveLiveSession) {
        showAlertModal({
          title: 'Sesi Masih Aktif',
          message: 'Anda masih memiliki 1 sesi konseling aktif dengan Guru BK. Harap selesaikan sesi konseling tersebut sebelum memulai konsultasi baru.',
          type: 'info'
        });
        return;
      }
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
            showToast('Percakapan AI berhasil dihapus.', 'success');
          } else {
            showToast(data.message || 'Gagal menghapus percakapan.', 'error');
            if (rowEl) {
              rowEl.style.opacity = '1';
              rowEl.style.pointerEvents = 'auto';
            }
          }
        } catch (err) {
          showToast('Terjadi kendala jaringan saat menghapus sesi percakapan.', 'error');
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
      chatDisclaimer.innerHTML = 'Sesi dialog privat dengan Guru BK SMAN 4 Jember &bull; Terlindungi Kode Etik ABKIN';

      if (currentGuruSessionStatus === 'closed') {
        chatInput.disabled = true;
        chatInput.placeholder = 'Sesi konseling ini telah diakhiri. Klik Konsultasi Guru BK Baru untuk memulai sesi baru.';
        sendBtn.disabled = true;
      } else {
        chatInput.disabled = false;
        const currentTeacherSelect = document.getElementById('select-guru-bk');
        const selectedTeacherName = (currentTeacherSelect && currentTeacherSelect.selectedIndex >= 0) 
          ? (currentTeacherSelect.options[currentTeacherSelect.selectedIndex].getAttribute('data-name') || '') 
          : '';
        chatInput.placeholder = activeGuruSessionId 
          ? 'Ketik pesan konsultasi langsung untuk Guru BK piket...' 
          : (selectedTeacherName ? `Ketik pesan konsultasi untuk ${selectedTeacherName}...` : 'Ketik pesan konsultasi langsung untuk Guru BK piket...');
        sendBtn.disabled = false;
      }

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
      headerAvatar.style.background = 'transparent';
      headerAvatar.innerHTML = `
        <img src="{{ asset('images/logo-sman4.png') }}" alt="Logo SMAN 4 Jember" style="width: 48px; height: 48px; object-fit: contain; filter: drop-shadow(0 1px 3px rgba(0,0,0,0.2));" />
      `;
      sendBtn.classList.remove('btn-send-guru');
      chatTitle.innerText = "{{ $activeAiSession ? $activeAiSession->title : 'SAPA BK : Asisten Konseling Cerdas' }}";
      headerStatusDesc.innerHTML = 'Core RAG Bimbingan SMAN 4 Jember &bull; Online 24 Jam';
      chatInput.disabled = false;
      sendBtn.disabled = false;
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

    const targetMode = currentMode;

    if (targetMode === 'live' && currentGuruSessionStatus === 'closed') {
      showToast('Sesi konseling ini telah diakhiri oleh Guru BK. Silakan klik Konsultasi Guru BK Baru untuk memulai bimbingan baru.', 'warning');
      return;
    }

    chatInput.value = '';

    const targetSessionId = (targetMode === 'live') ? activeGuruSessionId : activeAiSessionId;
    const targetIndicator = (targetMode === 'live') ? typingIndicatorLive : typingIndicatorAi;
    const teacherSelectEl = document.getElementById('select-guru-bk');
    const selectedTeacherId = teacherSelectEl ? teacherSelectEl.value : null;

    // Simpan salinan pending attachment untuk pesan ini
    const sendingAttachment = pendingAttachment ? { ...pendingAttachment } : null;

    // Pasang pesan siswa HANYA ke stream yang sedang aktif dengan lampiran jika ada
    appendMessage(targetMode, 'user', text, sendingAttachment ? { attachment: sendingAttachment } : null);
    targetIndicator.style.display = 'flex';
    scrollStreamToBottom(targetMode);

    // Hapus pending attachment bar setelah terpasang ke pengiriman pesan
    if (pendingAttachment) {
      removePendingAttachment();
    }

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
          mode: (targetMode === 'live') ? 'guru_bk' : 'ai',
          teacher_id: (targetMode === 'live' && !targetSessionId) ? selectedTeacherId : null,
          attachment: sendingAttachment || null
        })
      });

      const data = await response.json();
      targetIndicator.style.display = 'none';

      if (data.success) {
        if (targetMode === 'live') {
          if (!activeGuruSessionId && data.session_id) {
            activeGuruSessionId = data.session_id;
            currentGuruSessionStatus = data.status || 'active';
            hasActiveLiveSession = true;
            chatTitle.innerText = data.user_message.content.substring(0, 30) + '...';
            window.history.replaceState(null, '', '/chat/' + data.session_id);
            addSessionToSidebar('live', data.session_id, data.user_message.content);
            if (teacherSelectEl) teacherSelectEl.style.display = 'none';
            const counselorSelectBox = document.getElementById('counselor-select-container');
            if (counselorSelectBox) counselorSelectBox.style.display = 'none';
            const counselorChoiceEl = document.getElementById('counselor-choice-container');
            if (counselorChoiceEl) counselorChoiceEl.style.display = 'none';
            const bannerDesc = document.getElementById('live-banner-desc');
            if (bannerDesc && data.teacher) {
              bannerDesc.innerHTML = `<strong>Live Konseling Terhubung</strong>: Berdiskusi langsung dengan <strong>${escapeHtml(data.teacher.name)}</strong>.`;
            }
            listenLiveChatChannel(data.session_id);
          }
          if (data.status === 'closed') {
            currentGuruSessionStatus = 'closed';
            chatInput.disabled = true;
            chatInput.placeholder = 'Sesi konseling ini telah diakhiri oleh Guru BK.';
            sendBtn.disabled = true;
          }
          if (data.user_message && data.user_message.id) {
            knownLiveMsgIds.add(data.user_message.id);
          }
          if (data.assistant_message && data.assistant_message.id) {
            knownLiveMsgIds.add(data.assistant_message.id);
          }
          if (data.assistant_message && data.assistant_message.content) {
            appendMessage('live', 'counselor', data.assistant_message.content, null, data.assistant_message.id);
          }
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
        appendMessage(targetMode, targetMode === 'live' ? 'counselor' : 'assistant', data.message || 'Maaf, terjadi kendala saat mencatat pesan bimbingan. Silakan coba kembali.');
        if (data.message && data.message.includes('masih memiliki 1 sesi konseling aktif')) {
          hasActiveLiveSession = true;
        }
      }
    } catch (err) {
      targetIndicator.style.display = 'none';
      appendMessage(targetMode, targetMode === 'live' ? 'counselor' : 'assistant', 'Koneksi jaringan terputus. Pastikan server aktif dan coba beberapa saat lagi.');
    }

    scrollStreamToBottom(targetMode);
  }

  // Polling update berkala saat siswa berada dalam mode live chat (Fallback Real-Time Cerdas)
  async function pollStudentLiveChat() {
    if (currentMode !== 'live' || !activeGuruSessionId) return;

    try {
      const response = await fetch(`/api/chat/history/${activeGuruSessionId}`, {
        headers: { 'Accept': 'application/json' }
      });
      const res = await response.json();
      if (res.success && res.data) {
        const session = res.data;
        if (session.status === 'closed' && currentGuruSessionStatus !== 'closed') {
          currentGuruSessionStatus = 'closed';
          hasActiveLiveSession = false;
          chatInput.disabled = true;
          chatInput.placeholder = 'Sesi konseling ini telah diakhiri oleh Guru BK. Klik Konsultasi Guru BK Baru untuk memulai sesi baru.';
          sendBtn.disabled = true;
          const bannerDesc = document.getElementById('live-banner-desc');
          if (bannerDesc) {
            bannerDesc.innerHTML = '<strong>Sesi Konseling Selesai</strong>: Ruang obrolan telah ditutup oleh Guru BK.';
          }
        }

        // Sinkronisasi pesan masuk otomatis dari Guru BK tanpa refresh
        if (session.messages && Array.isArray(session.messages)) {
          let hasNewMessage = false;
          session.messages.forEach(m => {
            if (!knownLiveMsgIds.has(m.id)) {
              const timeStr = m.created_at ? new Date(m.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB' : null;
              appendMessage('live', m.role, m.content, m.metadata, m.id, timeStr);
              hasNewMessage = true;
            }
          });
          if (hasNewMessage) {
            scrollStreamToBottom('live');
          }
        }
      }
    } catch (e) {
      // Silent error
    }
  }

  // Interval polling 2 detik sebagai jaminan real-time andal
  setInterval(pollStudentLiveChat, 2000);

  // Inisialisasi WebSocket Laravel Reverb via Echo
  let activeEchoChannel = null;
  function listenLiveChatChannel(sessionId) {
    if (!window.Echo || !sessionId) return;
    try {
      if (activeEchoChannel && activeEchoChannel !== sessionId) {
        window.Echo.leave(`chat.session.${activeEchoChannel}`);
      }
      activeEchoChannel = sessionId;
      window.Echo.private(`chat.session.${sessionId}`)
        .listen('.message.sent', (event) => {
          if (event && event.message) {
            const m = event.message;
            if (!knownLiveMsgIds.has(m.id)) {
              appendMessage('live', m.role, m.content, m.metadata, m.id, m.time);
              scrollStreamToBottom('live');
            }
          }
        })
        .listen('.session.closed', (event) => {
          currentGuruSessionStatus = 'closed';
          hasActiveLiveSession = false;
          chatInput.disabled = true;
          chatInput.placeholder = 'Sesi konseling ini telah diakhiri oleh Guru BK.';
          sendBtn.disabled = true;
          const bannerDesc = document.getElementById('live-banner-desc');
          if (bannerDesc) {
            bannerDesc.innerHTML = '<strong>Sesi Konseling Selesai</strong>: Ruang obrolan telah ditutup oleh Guru BK.';
          }
        });
    } catch (err) {
      console.warn('Reverb listener fallback to polling:', err);
    }
  }

  try {
    if (typeof Pusher !== 'undefined' && typeof Echo !== 'undefined') {
      window.Pusher = Pusher;
      window.Echo = new Echo({
        broadcaster: 'reverb',
        key: '{{ env('REVERB_APP_KEY', 'sapabk-reverb-key') }}',
        wsHost: '{{ env('REVERB_HOST', 'localhost') }}',
        wsPort: {{ (int) env('REVERB_PORT', 8080) }},
        wssPort: {{ (int) env('REVERB_PORT', 8080) }},
        forceTLS: {{ env('REVERB_SCHEME', 'http') === 'https' ? 'true' : 'false' }},
        enabledTransports: ['ws', 'wss'],
        authEndpoint: '/broadcasting/auth',
        auth: {
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          }
        }
      });

      if (activeGuruSessionId) {
        listenLiveChatChannel(activeGuruSessionId);
      }
    }
  } catch (err) {
    console.warn('Inisialisasi Echo ditangguhkan ke polling fallback:', err);
  }

  // Menyisipkan bubble ke stream yang dituju secara presisi
  function appendMessage(streamMode, role, content, metadata = null, msgId = null, customTime = null) {
    if (streamMode === 'live' && msgId && knownLiveMsgIds.has(msgId)) {
      if (streamLive && streamLive.querySelector(`[data-msg-id="${msgId}"]`)) {
        return;
      }
    }
    if (streamMode === 'live' && msgId) {
      knownLiveMsgIds.add(msgId);
    }

    const targetStream = (streamMode === 'live') ? streamLive : streamAi;
    const targetIndicator = (streamMode === 'live') ? typingIndicatorLive : typingIndicatorAi;

    const row = document.createElement('div');
    if (msgId) {
      row.setAttribute('data-msg-id', msgId);
    }
    const nowTime = customTime || (new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB');

    if (role === 'user') {
      row.className = 'bubble-row user';
      let attHtml = '';
      if (metadata && metadata.attachment) {
        attHtml = renderAttachmentHtml(metadata.attachment);
      }
      row.innerHTML = `
        <div class="bubble-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
        <div class="bubble-body">
          <div class="bubble-card">
            ${attHtml}
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

  // Sinkronisasi Pemilihan Guru BK Antara Dropdown Banner dan Kartu Profil di Stream
  window.selectCounselorTeacher = function(teacherId, teacherName) {
    const teacherSelectEl = document.getElementById('select-guru-bk');
    if (teacherSelectEl) {
      teacherSelectEl.value = teacherId;
    }

    // Perbarui status aktif seluruh kartu konselor di stream
    const cards = document.querySelectorAll('.counselor-card');
    cards.forEach(card => {
      const isCurrent = (card.getAttribute('data-id') == teacherId);
      const btnText = card.querySelector('.btn-select-counselor-text');
      const btnIcon = card.querySelector('.btn-select-counselor-icon');

      if (isCurrent) {
        card.classList.add('selected');
        if (btnText) btnText.textContent = 'Konselor Terpilih';
        if (btnIcon) btnIcon.style.display = 'inline-flex';
      } else {
        card.classList.remove('selected');
        if (btnText) btnText.textContent = 'Pilih Konselor Ini';
        if (btnIcon) btnIcon.style.display = 'none';
      }
    });

    // Sesuaikan placeholder pada input pesan
    if (chatInput && currentMode === 'live' && !activeGuruSessionId && currentGuruSessionStatus !== 'closed') {
      chatInput.placeholder = teacherName ? `Ketik pesan konsultasi untuk ${teacherName}...` : 'Ketik pesan konsultasi langsung untuk Guru BK piket...';
      chatInput.focus();
    }
  };

  // Event listener saat dropdown di banner diubah oleh siswa
  const bannerTeacherSelectEl = document.getElementById('select-guru-bk');
  if (bannerTeacherSelectEl) {
    bannerTeacherSelectEl.addEventListener('change', function() {
      const selectedOpt = this.options[this.selectedIndex];
      const name = selectedOpt ? (selectedOpt.getAttribute('data-name') || selectedOpt.text) : '';
      selectCounselorTeacher(this.value, name);
    });
  }

  // Inisialisasi awal pada saat memuat halaman
  if (currentMode === 'live') {
    switchChatMode('live');
  } else {
    scrollStreamToBottom('ai');
  }

  // Pre-fill input pesan jika ada attachment bimbingan yang dilampirkan
  if (pendingAttachment && chatInput && !chatInput.value.trim()) {
    if (pendingAttachment.type === 'ebook') {
      chatInput.value = `Halo Bapak/Ibu Guru BK, saya ingin berkonsultasi mengenai materi e-book "${pendingAttachment.title}".`;
    } else if (pendingAttachment.type === 'tes' || pendingAttachment.type === 'kuis') {
      chatInput.value = `Halo Bapak/Ibu Guru BK, saya ingin mendiskusikan hasil asesmen "${pendingAttachment.title}".`;
    } else if (pendingAttachment.type === 'artikel' || pendingAttachment.type === 'article') {
      chatInput.value = `Halo Bapak/Ibu Guru BK, saya ingin menanyakan lebih lanjut mengenai topik artikel "${pendingAttachment.title}".`;
    }
    chatInput.focus();
  }
</script>
@endpush
