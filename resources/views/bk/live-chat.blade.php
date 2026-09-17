@extends('layouts.tailadmin')

@section('title', 'Live Chat Konseling Siswa — SAPA BK')

@section('content')
<div class="h-[calc(100vh-160px)] flex flex-col lg:flex-row gap-6">
  
  <!-- Left Column: Antrean Siswa Konseling (SRS F-29 & F-42b) -->
  <div class="w-full lg:w-80 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs flex flex-col shrink-0 overflow-hidden">
    
    <div class="p-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
      <div>
        <h3 class="font-bold text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">Antrean Siswa Konseling</h3>
        <p class="text-[10px] text-emerald-600 dark:text-emerald-400 font-semibold">Jam Operasional: 08:00 - 15:00 WIB</p>
      </div>
      <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse" title="Sistem Real-Time Aktif"></span>
    </div>

    <div class="flex-1 overflow-y-auto custom-scrollbar p-3 space-y-2" id="student-list-container">
      @forelse($activeQueue as $idx => $session)
        <div
          class="student-card p-3 rounded-2xl border transition-all flex items-center gap-3 cursor-pointer {{ $idx === 0 ? 'bg-brand-50/70 border-brand-200 dark:bg-brand-950/40 dark:border-brand-800' : 'border-gray-100 dark:border-gray-800 hover:border-brand-300 hover:bg-brand-50/50 dark:hover:bg-gray-800/60' }}"
          id="student-card-{{ $session->id }}"
          data-session-id="{{ $session->id }}"
          onclick="selectStudentSession(this, {{ $session->id }}, '{{ addslashes($session->user?->name ?? 'Siswa') }}', '{{ addslashes($session->user?->kelas ?? 'Kelas Siswa') }}', '{{ $session->status }}')"
        >
          <div class="h-9 w-9 rounded-xl bg-gradient-to-tr from-[#205A26] to-[#2E7D34] text-white font-bold flex items-center justify-center text-xs shrink-0">
            {{ strtoupper(substr($session->user?->name ?? 'S', 0, 2)) }}
          </div>
          <div class="truncate flex-1">
            <h4 class="font-bold text-xs text-gray-900 dark:text-white truncate">{{ $session->user?->name ?? 'Siswa' }}</h4>
            <p class="text-[11px] text-gray-400 font-medium">{{ $session->user?->kelas ?? 'Kelas Siswa' }}</p>
          </div>
          <span class="h-2 w-2 rounded-full bg-emerald-500 shrink-0"></span>
        </div>
      @empty
        <div id="queue-empty-notice" class="p-6 text-center text-xs text-gray-400 dark:text-gray-500">
          Belum ada antrean siswa konseling aktif saat ini.
        </div>
      @endforelse
    </div>

    <div class="p-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30 text-[11px] text-gray-400">
      Antrean otomatis terisolasi khusus untuk akun Guru BK Anda. Identitas siswa terverifikasi resmi.
    </div>

  </div>

  <!-- Right Column: Live Chat Room -->
  <div class="flex-1 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs flex flex-col overflow-hidden">
    
    <!-- Chat Header -->
    <div class="h-16 px-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between bg-white dark:bg-gray-900 shrink-0">
      <div class="flex items-center gap-3">
        <div class="h-9 w-9 rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-950/60 dark:text-brand-400 flex items-center justify-center font-bold">
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
        </div>
        <div>
          <h3 class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white" id="current-student-name">
            {{ $selectedSession ? ($selectedSession->user?->name ?? 'Siswa') : 'Pilih Antrean Siswa' }}
          </h3>
          <p class="text-[11px] text-gray-400 font-medium" id="current-student-class">
            {{ $selectedSession ? (($selectedSession->user?->kelas ?? 'Kelas Siswa') . ' • Status: Terhubung Sesi Konseling') : 'Belum ada sesi terpilih' }}
          </p>
        </div>
      </div>

      <div class="flex items-center gap-2.5">
        <span id="session-status-badge" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold {{ $selectedSession && $selectedSession->status === 'closed' ? 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700' : 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800' }}">
          <span id="status-pulse-dot" class="h-1.5 w-1.5 rounded-full {{ $selectedSession && $selectedSession->status === 'closed' ? 'bg-gray-400' : 'bg-emerald-500 animate-pulse' }}"></span>
          <span id="status-badge-text">{{ $selectedSession && $selectedSession->status === 'closed' ? 'Sesi Selesai (Closed)' : 'Live Counseling Active' }}</span>
        </span>

        <button
          type="button"
          id="btn-close-counseling"
          onclick="closeCurrentSession()"
          title="Selesaikan & Akhiri Sesi Konseling"
          class="px-3 py-1.5 rounded-xl text-[10px] font-bold bg-rose-50 text-rose-600 hover:bg-rose-100 dark:bg-rose-950/40 dark:text-rose-400 border border-rose-200 dark:border-rose-900 transition-all {{ (!$selectedSession || $selectedSession->status === 'closed') ? 'hidden' : '' }}"
        >
          Akhiri Konseling
        </button>
      </div>
    </div>

    <!-- Messages Container -->
    <div class="flex-1 p-6 overflow-y-auto space-y-4 bg-gray-50/50 dark:bg-gray-950/50 custom-scrollbar" id="chat-messages-container">
      @if($selectedSession && $initialMessages->count() > 0)
        @foreach($initialMessages as $m)
          @if($m->role === 'user')
            <!-- Student Bubble -->
            <div class="flex items-start gap-3 max-w-xl">
              <div class="h-8 w-8 rounded-xl bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-bold flex items-center justify-center shrink-0">
                {{ strtoupper(substr($selectedSession?->user?->name ?? 'S', 0, 1)) }}
              </div>
              <div class="space-y-1">
                <div class="p-4 rounded-2xl rounded-tl-none bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 text-xs sm:text-sm shadow-xs border border-gray-100 dark:border-gray-700/60 leading-relaxed">
                  {{ $m->content }}
                </div>
                <span class="text-[10px] text-gray-400 pl-1">{{ $m->created_at ? $m->created_at->format('H:i') . ' WIB' : '' }}</span>
              </div>
            </div>
          @else
            <!-- Counselor Bubble -->
            <div class="flex items-start justify-end gap-3 max-w-xl ml-auto">
              <div class="space-y-1 text-right">
                <div class="p-4 rounded-2xl rounded-tr-none bg-brand-500 text-white text-xs sm:text-sm shadow-md shadow-brand-500/20 text-left leading-relaxed">
                  {{ $m->content }}
                </div>
                <span class="text-[10px] text-gray-400 pr-1">{{ $m->created_at ? $m->created_at->format('H:i') . ' WIB' : '' }} • Terkirim</span>
              </div>
              <div class="h-8 w-8 rounded-xl bg-gradient-to-tr from-[#205A26] to-[#2E7D34] text-white text-xs font-bold flex items-center justify-center shrink-0">
                BK
              </div>
            </div>
          @endif
        @endforeach
      @elseif(!$selectedSession)
        <div id="no-session-placeholder" class="h-full flex flex-col items-center justify-center text-center p-6 text-gray-400 dark:text-gray-500">
          <div class="h-12 w-12 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-3 text-gray-400">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
          </div>
          <p class="text-xs font-semibold text-gray-600 dark:text-gray-300">Belum ada antrean konseling aktif.</p>
          <p class="text-[11px] text-gray-400 mt-1">Saat siswa memilih nama Anda dan mulai chat, pesan bimbingan langsung tampil di sini.</p>
        </div>
      @endif
    </div>

    <!-- Chat Input Box -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 shrink-0">
      <form class="flex items-center gap-2" onsubmit="event.preventDefault(); sendMessageLive();">
        <input
          type="text"
          id="input-pesan-guru"
          placeholder="{{ (!$selectedSession || $selectedSession->status === 'closed') ? 'Sesi konseling telah diakhiri / belum ada siswa dipilih...' : 'Tulis pesan bimbingan konseling untuk siswa...' }}"
          {{ (!$selectedSession || $selectedSession->status === 'closed') ? 'disabled' : '' }}
          class="grow px-4 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500 disabled:opacity-60 disabled:cursor-not-allowed"
        />
        <button
          type="submit"
          id="btn-send-guru"
          {{ (!$selectedSession || $selectedSession->status === 'closed') ? 'disabled' : '' }}
          class="px-5 py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-md shadow-brand-500/20 transition-all flex items-center gap-1.5 shrink-0 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <span>Kirim</span>
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
        </button>
      </form>
    </div>

  </div>

</div>

<script>
  let currentSessionId = {{ $selectedSession ? $selectedSession->id : 'null' }};
  let currentSessionStatus = "{{ $selectedSession ? $selectedSession->status : 'none' }}";
  let activeStudentName = "{{ addslashes($selectedSession?->user?->name ?? '') }}";

  const activeClasses = ['bg-brand-50/70', 'border-brand-200', 'dark:bg-brand-950/40', 'dark:border-brand-800'];
  const defaultClasses = ['border-gray-100', 'dark:border-gray-800'];

  function selectStudentSession(element, sessionId, name, kelas, status) {
    currentSessionId = sessionId;
    currentSessionStatus = status;
    activeStudentName = name;

    // Visual highlight kartu antrean
    document.querySelectorAll('.student-card').forEach(card => {
      card.classList.remove(...activeClasses);
      card.classList.add(...defaultClasses);
    });

    if (element) {
      element.classList.remove(...defaultClasses);
      element.classList.add(...activeClasses);
    }

    const nameEl = document.getElementById('current-student-name');
    if (nameEl) nameEl.innerText = name;

    const classEl = document.getElementById('current-student-class');
    if (classEl) classEl.innerText = (kelas || 'Kelas Siswa') + ' • Status: Terhubung Sesi Konseling';

    updateStatusBadge(status);
    fetchSessionMessages(sessionId, name);
  }

  function updateStatusBadge(status) {
    const badge = document.getElementById('session-status-badge');
    const dot = document.getElementById('status-pulse-dot');
    const text = document.getElementById('status-badge-text');
    const closeBtn = document.getElementById('btn-close-counseling');

    if (status === 'closed') {
      badge.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700';
      dot.className = 'h-1.5 w-1.5 rounded-full bg-gray-400';
      text.innerText = 'Sesi Selesai (Closed)';
      if (closeBtn) closeBtn.classList.add('hidden');
      lockChatInput(true, 'Sesi konseling telah diakhiri. Obrolan terkunci.');
    } else {
      badge.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800';
      dot.className = 'h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse';
      text.innerText = 'Live Counseling Active';
      if (closeBtn) closeBtn.classList.remove('hidden');
      lockChatInput(false, 'Tulis pesan bimbingan konseling untuk siswa...');
    }
  }

  function lockChatInput(locked, placeholderText) {
    const input = document.getElementById('input-pesan-guru');
    const btn = document.getElementById('btn-send-guru');
    if (input) {
      input.disabled = locked;
      input.placeholder = placeholderText;
    }
    if (btn) {
      btn.disabled = locked;
    }
  }

  async function fetchSessionMessages(sessionId, studentName) {
    const container = document.getElementById('chat-messages-container');
    try {
      const response = await fetch(`/bk/live-chat/api/session/${sessionId}/messages`, {
        headers: { 'Accept': 'application/json' }
      });
      const res = await response.json();
      if (res.success) {
        renderMessages(res.messages, studentName || res.session.student_name);
        currentSessionStatus = res.session.status;
        updateStatusBadge(res.session.status);
      }
    } catch (err) {
      console.error('Gagal memuat pesan:', err);
    }
  }

  function renderMessages(messages, studentName) {
    const container = document.getElementById('chat-messages-container');
    container.innerHTML = '';

    const initial = (studentName ? studentName.substring(0, 1) : 'S').toUpperCase();

    messages.forEach(m => {
      const bubble = document.createElement('div');
      if (m.role === 'user') {
        bubble.className = 'flex items-start gap-3 max-w-xl';
        bubble.innerHTML = `
          <div class="h-8 w-8 rounded-xl bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-bold flex items-center justify-center shrink-0">
            ${initial}
          </div>
          <div class="space-y-1">
            <div class="p-4 rounded-2xl rounded-tl-none bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 text-xs sm:text-sm shadow-xs border border-gray-100 dark:border-gray-700/60 leading-relaxed">
              ${escapeHtml(m.content).replace(/\n/g, '<br>')}
            </div>
            <span class="text-[10px] text-gray-400 pl-1">${m.time || ''}</span>
          </div>
        `;
      } else {
        bubble.className = 'flex items-start justify-end gap-3 max-w-xl ml-auto';
        bubble.innerHTML = `
          <div class="space-y-1 text-right">
            <div class="p-4 rounded-2xl rounded-tr-none bg-brand-500 text-white text-xs sm:text-sm shadow-md shadow-brand-500/20 text-left leading-relaxed">
              ${escapeHtml(m.content).replace(/\n/g, '<br>')}
            </div>
            <span class="text-[10px] text-gray-400 pr-1">${m.time || 'Baru saja'} • Terkirim</span>
          </div>
          <div class="h-8 w-8 rounded-xl bg-gradient-to-tr from-[#205A26] to-[#2E7D34] text-white text-xs font-bold flex items-center justify-center shrink-0">
            BK
          </div>
        `;
      }
      container.appendChild(bubble);
    });

    container.scrollTop = container.scrollHeight;
  }

  async function sendMessageLive() {
    const input = document.getElementById('input-pesan-guru');
    const text = input.value.trim();
    if (!text || !currentSessionId || currentSessionStatus === 'closed') return;

    input.value = '';

    const container = document.getElementById('chat-messages-container');
    const bubble = document.createElement('div');
    bubble.className = 'flex items-start justify-end gap-3 max-w-xl ml-auto';
    bubble.innerHTML = `
      <div class="space-y-1 text-right">
        <div class="p-4 rounded-2xl rounded-tr-none bg-brand-500 text-white text-xs sm:text-sm shadow-md shadow-brand-500/20 text-left leading-relaxed">
          ${escapeHtml(text).replace(/\n/g, '<br>')}
        </div>
        <span class="text-[10px] text-gray-400 pr-1">Mengirim...</span>
      </div>
      <div class="h-8 w-8 rounded-xl bg-gradient-to-tr from-[#205A26] to-[#2E7D34] text-white text-xs font-bold flex items-center justify-center shrink-0">
        BK
      </div>
    `;
    container.appendChild(bubble);
    container.scrollTop = container.scrollHeight;

    try {
      const response = await fetch(`/bk/live-chat/api/session/${currentSessionId}/send`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ message: text })
      });

      const res = await response.json();
      if (!res.success) {
        alert(res.message || 'Gagal mengirim pesan.');
      } else {
        const timeSpan = bubble.querySelector('span');
        if (timeSpan) timeSpan.innerText = res.message.time + ' • Terkirim';
      }
    } catch (err) {
      console.error(err);
      alert('Terjadi kendala jaringan saat mengirim pesan.');
    }
  }

  async function closeCurrentSession() {
    if (!currentSessionId || currentSessionStatus === 'closed') return;

    const confirmed = confirm('Apakah Anda yakin ingin menyelesaikan dan mengakhiri sesi konseling dengan ' + (activeStudentName || 'siswa ini') + '? Setelah ditutup, sesi akan berstatus closed dan chat terkunci.');
    if (!confirmed) return;

    try {
      const response = await fetch(`/bk/live-chat/api/session/${currentSessionId}/close`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
      });

      const res = await response.json();
      if (res.success) {
        currentSessionStatus = 'closed';
        updateStatusBadge('closed');

        // Hapus atau perbarui kartu siswa dari antrean aktif
        const card = document.getElementById(`student-card-${currentSessionId}`);
        if (card) {
          card.remove();
        }

        // Cek jika antrean kosong
        const listContainer = document.getElementById('student-list-container');
        if (listContainer && listContainer.querySelectorAll('.student-card').length === 0) {
          listContainer.innerHTML = `
            <div id="queue-empty-notice" class="p-6 text-center text-xs text-gray-400 dark:text-gray-500">
              Belum ada antrean siswa konseling aktif saat ini.
            </div>
          `;
        }
      } else {
        alert(res.message || 'Gagal mengakhiri konseling.');
      }
    } catch (err) {
      console.error(err);
      alert('Terjadi kendala saat mengakhiri sesi.');
    }
  }

  // Polling Real-Time Antrean Siswa Konseling (setiap 4 detik)
  async function pollQueue() {
    try {
      const response = await fetch('/bk/live-chat/api/queue', {
        headers: { 'Accept': 'application/json' }
      });
      const res = await response.json();
      if (res.success) {
        updateQueueUI(res.data);
      }
    } catch (e) {
      // Quiet fail during network glitches
    }
  }

  function updateQueueUI(items) {
    const container = document.getElementById('student-list-container');
    if (!container) return;

    if (!items || items.length === 0) {
      if (!container.querySelector('#queue-empty-notice')) {
        container.innerHTML = `
          <div id="queue-empty-notice" class="p-6 text-center text-xs text-gray-400 dark:text-gray-500">
            Belum ada antrean siswa konseling aktif saat ini.
          </div>
        `;
      }
      return;
    }

    const emptyNotice = document.getElementById('queue-empty-notice');
    if (emptyNotice) emptyNotice.remove();

    // Sinkronkan elemen kartu
    items.forEach((item, idx) => {
      let card = document.getElementById(`student-card-${item.session_id}`);
      const isSelected = (item.session_id === currentSessionId);

      if (!card) {
        card = document.createElement('div');
        card.id = `student-card-${item.session_id}`;
        card.dataset.sessionId = item.session_id;
        card.className = `student-card p-3 rounded-2xl border transition-all flex items-center gap-3 cursor-pointer ${
          isSelected ? activeClasses.join(' ') : defaultClasses.join(' ') + ' hover:border-brand-300 hover:bg-brand-50/50 dark:hover:bg-gray-800/60'
        }`;
        card.onclick = () => selectStudentSession(card, item.session_id, item.name, item.kelas, item.status);
        card.innerHTML = `
          <div class="h-9 w-9 rounded-xl bg-gradient-to-tr from-[#205A26] to-[#2E7D34] text-white font-bold flex items-center justify-center text-xs shrink-0">
            ${escapeHtml(item.initial)}
          </div>
          <div class="truncate flex-1">
            <h4 class="font-bold text-xs text-gray-900 dark:text-white truncate">${escapeHtml(item.name)}</h4>
            <p class="text-[11px] text-gray-400 font-medium">${escapeHtml(item.kelas)}</p>
          </div>
          <span class="h-2 w-2 rounded-full bg-emerald-500 shrink-0"></span>
        `;
        container.appendChild(card);
      }
    });

    // Jika sedang dalam sesi aktif, ambil pesan terbaru
    if (currentSessionId && currentSessionStatus === 'active') {
      fetchSessionMessages(currentSessionId, activeStudentName);
    }
  }

  function escapeHtml(text) {
    if (!text) return '';
    const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
    return text.replace(/[&<>"']/g, m => map[m]);
  }

  // Jalankan polling antrean setiap 4 detik
  setInterval(pollQueue, 4000);

  // Scroll otomatis ke bawah saat pertama dimuat
  const chatBox = document.getElementById('chat-messages-container');
  if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
</script>
@endsection
