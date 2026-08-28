@extends('layouts.admin')

@section('title', 'Live Chat Konseling Guru BK')
@section('page-title', 'Portal Live Chat Konseling (PRD 4.2)')

@section('content')
<div class="flex h-[calc(100vh-7rem)] -m-4 sm:-m-6 overflow-hidden bg-[#F8FAFC]">

    {{-- Sidebar Antrean & Sesi Aktif --}}
    <aside class="w-80 shrink-0 bg-white border-r border-slate-200 flex flex-col">
        <div class="p-4 border-b border-slate-200 bg-slate-50/50">
            <h3 class="font-sora font-bold text-sm text-[#0F172A]">Antrean Live Konseling</h3>
            <p class="text-[11px] text-slate-500 mt-0.5">Jam Operasional: 08:00 – 15:00 WIB</p>
        </div>

        {{-- Section 1: Antrean Menunggu --}}
        <div class="p-3 bg-amber-50/60 border-b border-amber-200/80 flex items-center justify-between">
            <span class="text-[11px] font-bold uppercase tracking-wider text-amber-800 flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                Antrean Siswa (Waiting)
            </span>
            <span id="waiting-count" class="px-2 py-0.5 bg-amber-200 text-amber-900 rounded-full font-bold text-[10px]">
                {{ $waitingSessions->count() }}
            </span>
        </div>

        <div id="waiting-list-container" class="max-h-56 overflow-y-auto p-2.5 space-y-2 border-b border-slate-200">
            @forelse($waitingSessions as $ws)
            <div class="p-3 bg-amber-50/40 rounded-xl border border-amber-200/70 hover:border-amber-400 transition-all">
                <div class="flex items-start justify-between">
                    <div>
                        <h4 class="font-bold text-xs text-[#0F172A]">{{ $ws->user->name }}</h4>
                        <p class="text-[11px] text-slate-500">
                            Kelas {{ $ws->user->studentProfile->kelas ?? '-' }} • NISN: {{ $ws->user->studentProfile->nisn ?? '-' }}
                        </p>
                        <p class="text-[10px] text-amber-700 mt-1 font-medium">
                            ⏱️ Menunggu {{ $ws->requested_at ? $ws->requested_at->diffForHumans() : 'baru saja' }}
                        </p>
                    </div>
                    <button onclick="acceptSession({{ $ws->id }})" class="btn-primary text-[11px] px-3 py-1.5 shadow-xs">
                        Terima
                    </button>
                </div>
            </div>
            @empty
            <p class="text-[11px] text-slate-400 text-center py-4 font-medium">Tidak ada antrean menunggu saat ini.</p>
            @endforelse
        </div>

        {{-- Section 2: Sesi Aktif Saya --}}
        <div class="p-3 bg-emerald-50/50 border-b border-emerald-200/70 flex items-center justify-between">
            <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-800 flex items-center gap-1.5">
                🟢 Sesi Saya Aktif
            </span>
            <span id="active-count" class="px-2 py-0.5 bg-emerald-200 text-emerald-900 rounded-full font-bold text-[10px]">
                {{ $activeSessions->count() }}
            </span>
        </div>

        <div id="active-list-container" class="flex-1 overflow-y-auto p-2.5 space-y-2">
            @forelse($activeSessions as $as)
            <div onclick="selectActiveSession({{ json_encode($as) }})"
                 class="session-card-{{ $as->id }} p-3 bg-white rounded-xl border border-slate-200 hover:border-emerald-500 cursor-pointer transition-all">
                <div class="flex items-center justify-between">
                    <h4 class="font-bold text-xs text-[#0F172A]">{{ $as->user->name }}</h4>
                    <span class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">Aktif</span>
                </div>
                <p class="text-[11px] text-slate-500 mt-0.5">Kelas {{ $as->user->studentProfile->kelas ?? '-' }}</p>
            </div>
            @empty
            <p class="text-[11px] text-slate-400 text-center py-6 font-medium">Belum ada sesi aktif yang Anda tangani.</p>
            @endforelse
        </div>
    </aside>

    {{-- Area Chat Utama Guru BK --}}
    <div class="flex-1 flex flex-col bg-[#F8FAFC]">

        {{-- Header Selected Chat --}}
        <div id="chat-header" class="bg-white border-b border-slate-200 px-6 py-3.5 flex items-center justify-between shadow-xs">
            <div id="header-student-info" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
                    🎓
                </div>
                <div>
                    <h3 id="student-name-title" class="font-sora font-extrabold text-sm text-[#0F172A]">Pilih Sesi Konseling</h3>
                    <p id="student-meta-subtitle" class="text-[11px] text-slate-500">Pilih dari daftar antrean atau sesi aktif di sebelah kiri.</p>
                </div>
            </div>

            <div id="header-actions" class="hidden">
                <button onclick="closeCurrentSession()" class="btn-secondary text-xs px-3.5 py-1.5 text-red-600 border-red-200 hover:bg-red-50 font-bold">
                    🔒 Akhiri Sesi Konseling
                </button>
            </div>
        </div>

        {{-- Messages Container --}}
        <div id="bk-messages-container" class="flex-1 overflow-y-auto p-6 space-y-4">
            <div class="flex flex-col items-center justify-center h-full text-center text-slate-400">
                <span class="text-4xl mb-2">💬</span>
                <p class="text-xs font-semibold">Silakan terima antrean siswa untuk memulai Live Chat.</p>
            </div>
        </div>

        {{-- Input Form Area --}}
        <div id="bk-input-area" class="bg-white border-t border-slate-200 p-4 hidden">
            <form id="bk-chat-form" class="flex items-end gap-3 max-w-4xl mx-auto">
                @csrf
                <textarea id="bk-chat-input" rows="1" placeholder="Ketik balasan konseling untuk siswa..."
                          class="form-input flex-1 resize-none max-h-36 py-3.5 px-4 rounded-2xl border-slate-200 focus:border-amber-600 focus:ring-amber-600 text-xs sm:text-sm font-medium"></textarea>
                <button type="submit"
                        class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-600 to-amber-500 flex items-center justify-center text-white hover:opacity-90 transition-all shrink-0 shadow-md shadow-amber-600/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </form>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    let activeSession = null;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Terima Antrean Siswa
    async function acceptSession(sessionId) {
        try {
            const res = await fetch(`/api/bk/live-chat/${sessionId}/accept`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            const data = await res.json();
            if (data.success) {
                fetchQueueData();
                selectActiveSession(data.session);
            } else {
                alert(data.message || 'Gagal menerima sesi.');
            }
        } catch (err) {
            alert('Kesalahan koneksi saat menerima antrean.');
        }
    }

    // Pilih Sesi Aktif
    function selectActiveSession(session) {
        activeSession = session;
        
        document.getElementById('student-name-title').innerText = session.user.name;
        document.getElementById('student-meta-subtitle').innerText = 
            `Kelas: ${session.user.student_profile?.kelas || '-'} | NISN: ${session.user.student_profile?.nisn || '-'} | Email: ${session.user.email}`;
        
        document.getElementById('header-actions').classList.remove('hidden');
        document.getElementById('bk-input-area').classList.remove('hidden');

        renderMessages(session.messages || []);
    }

    function renderMessages(messages) {
        const container = document.getElementById('bk-messages-container');
        container.innerHTML = '';

        if (!messages || messages.length === 0) {
            container.innerHTML = `<p class="text-center text-xs text-slate-400 py-10">Belum ada pesan dalam sesi ini.</p>`;
            return;
        }

        messages.forEach(msg => {
            const isUser = msg.role === 'user';
            const isCounselor = msg.role === 'counselor';
            const isSystem = msg.role === 'system';

            if (isSystem) {
                const div = document.createElement('div');
                div.className = 'flex justify-center my-2';
                div.innerHTML = `<span class="bg-amber-100 text-amber-800 text-[11px] font-semibold px-4 py-1 rounded-full border border-amber-200 text-center">ℹ️ ${escapeHtml(msg.content)}</span>`;
                container.appendChild(div);
            } else {
                const div = document.createElement('div');
                div.className = `flex ${isCounselor ? 'justify-end' : 'justify-start'} gap-3`;
                div.innerHTML = `
                    ${!isCounselor ? `<div class="w-8 h-8 rounded-xl bg-slate-200 flex items-center justify-center shrink-0 text-xs font-bold mt-1">🎓</div>` : ''}
                    <div class="max-w-md px-4 py-3 rounded-2xl text-xs sm:text-sm leading-relaxed
                                ${isCounselor ? 'bg-amber-600 text-white rounded-tr-none shadow-sm' : 'bg-white border border-slate-200 text-slate-800 rounded-tl-none shadow-xs'}">
                        ${escapeHtml(msg.content).replace(/\n/g, '<br>')}
                        <p class="text-[10px] mt-1.5 ${isCounselor ? 'text-amber-100 text-right' : 'text-slate-400'} font-medium">
                            ${new Date(msg.created_at || Date.now()).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                        </p>
                    </div>
                `;
                container.appendChild(div);
            }
        });

        container.scrollTop = container.scrollHeight;
    }

    // Kirim Balasan Guru BK
    document.getElementById('bk-chat-form')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!activeSession) return;

        const input = document.getElementById('bk-chat-input');
        const message = input.value.trim();
        if (!message) return;

        input.value = '';

        try {
            const res = await fetch(`/api/bk/live-chat/${activeSession.id}/send`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ message })
            });
            const data = await res.json();
            if (data.success) {
                fetchQueueData();
            }
        } catch (err) {
            console.error('Error sending counselor reply', err);
        }
    });

    // Akhiri Sesi Konseling
    async function closeCurrentSession() {
        if (!activeSession || !confirm('Apakah Anda yakin ingin mengakhiri sesi konseling live ini?')) return;

        try {
            const res = await fetch(`/api/bk/live-chat/${activeSession.id}/close`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            const data = await res.json();
            if (data.success) {
                alert('Sesi berhasil diakhiri.');
                activeSession = null;
                document.getElementById('header-actions').classList.add('hidden');
                document.getElementById('bk-input-area').classList.add('hidden');
                document.getElementById('student-name-title').innerText = 'Pilih Sesi Konseling';
                document.getElementById('student-meta-subtitle').innerText = 'Sesi telah diakhiri.';
                fetchQueueData();
            }
        } catch (err) {
            alert('Gagal mengakhiri sesi.');
        }
    }

    // Auto-polling queue data untuk Guru BK
    async function fetchQueueData() {
        try {
            const res = await fetch('/api/bk/live-chat/queue');
            const data = await res.json();

            document.getElementById('waiting-count').innerText = data.waiting ? data.waiting.length : 0;
            document.getElementById('active-count').innerText = data.active ? data.active.length : 0;

            // Render list antrean
            const wContainer = document.getElementById('waiting-list-container');
            wContainer.innerHTML = '';
            if (data.waiting && data.waiting.length > 0) {
                data.waiting.forEach(ws => {
                    const div = document.createElement('div');
                    div.className = 'p-3 bg-amber-50/40 rounded-xl border border-amber-200/70 hover:border-amber-400 transition-all';
                    div.innerHTML = `
                        <div class="flex items-start justify-between">
                            <div>
                                <h4 class="font-bold text-xs text-[#0F172A]">${escapeHtml(ws.user.name)}</h4>
                                <p class="text-[11px] text-slate-500">Kelas ${escapeHtml(ws.user.student_profile?.kelas || '-')} • NISN: ${escapeHtml(ws.user.student_profile?.nisn || '-')}</p>
                            </div>
                            <button onclick="acceptSession(${ws.id})" class="btn-primary text-[11px] px-3 py-1.5 shadow-xs">Terima</button>
                        </div>
                    `;
                    wContainer.appendChild(div);
                });
            } else {
                wContainer.innerHTML = `<p class="text-[11px] text-slate-400 text-center py-4 font-medium">Tidak ada antrean menunggu saat ini.</p>`;
            }

            // If active session selected, refresh its messages
            if (activeSession && data.active) {
                const refreshed = data.active.find(s => s.id === activeSession.id);
                if (refreshed) {
                    activeSession = refreshed;
                    renderMessages(refreshed.messages);
                }
            }
        } catch (err) {
            console.error('Error fetching queue data', err);
        }
    }

    setInterval(fetchQueueData, 3000);

    function escapeHtml(text) {
        return text ? text.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;') : '';
    }
</script>
@endpush
