@extends('layouts.student')

@section('title', 'Konsultasi AI & Live Chat BK')
@section('page-title', 'Konsultasi Digital & Live Chat BK')

@section('content')
<div class="flex h-[calc(100vh-6rem)] -m-4 sm:-m-6 overflow-hidden bg-[#F8FAFC]">

    {{-- Sidebar Sesi --}}
    <aside class="w-72 shrink-0 bg-white border-r border-slate-200/80 flex flex-col hidden md:flex">
        <div class="p-4 border-b border-slate-200/70 space-y-2">
            <button id="new-session-btn" class="btn-primary w-full justify-center text-xs py-2.5 shadow-md shadow-[#059669]/10 font-bold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                + Chatbot AI Baru
            </button>
            <button onclick="requestLiveChat()" class="btn-secondary w-full justify-center text-xs py-2.5 bg-amber-50 text-amber-800 border-amber-200 hover:bg-amber-100 font-bold shadow-xs flex items-center gap-1.5">
                <span>👨‍🏫</span> Live Chat Guru BK
            </button>
        </div>
        
        <div class="p-3 border-b border-slate-100 flex items-center justify-between">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Riwayat Percakapan</span>
            <span class="badge-green text-[10px]">{{ $sessions->count() }} Sesi</span>
        </div>

        <div class="flex-1 overflow-y-auto p-3 space-y-1">
            @forelse($sessions as $s)
            <a href="{{ route('student.chat.session', $s->id) }}"
               class="block px-3.5 py-3 rounded-2xl text-xs transition-all border
                      {{ isset($session) && $session->id === $s->id ? 'bg-[#ECFDF5] border-[#6EE7B7] text-[#059669] font-bold shadow-xs' : 'border-transparent text-slate-600 hover:bg-slate-50' }}">
                <div class="flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2 truncate">
                        <span class="text-sm">{{ $s->type === 'human' ? '👨‍🏫' : '💬' }}</span>
                        <p class="truncate font-sora">{{ $s->title }}</p>
                    </div>
                    @if($s->type === 'human')
                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded shrink-0 {{ $s->status === 'active' ? 'bg-emerald-100 text-emerald-700' : ($s->status === 'waiting' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                        Live
                    </span>
                    @endif
                </div>
                <p class="text-[10px] mt-1 opacity-70 pl-6">{{ $s->created_at->format('d M Y, H:i') }}</p>
            </a>
            @empty
            <div class="text-center py-10 px-4">
                <p class="text-xs text-slate-400 font-medium">Belum ada riwayat percakapan</p>
            </div>
            @endforelse
        </div>
    </aside>

    {{-- Area Chat Utama --}}
    <div class="flex-1 flex flex-col overflow-hidden bg-[#F8FAFC]">

        {{-- Header Chat --}}
        <div class="bg-white border-b border-slate-200/80 px-6 py-3.5 flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-[#047857] to-[#10B981] flex items-center justify-center text-white shadow-md shadow-[#059669]/20 font-bold text-lg">
                        {{ isset($session) && $session->type === 'human' ? '👨‍🏫' : '🤖' }}
                    </div>
                    <span id="status-dot" class="absolute -bottom-0.5 -right-0.5 w-3 h-3 {{ isset($session) && $session->type === 'human' && $session->status === 'waiting' ? 'bg-amber-500' : 'bg-emerald-500' }} border-2 border-white rounded-full"></span>
                </div>
                <div>
                    <h2 id="chat-header-title" class="font-sora font-extrabold text-sm text-[#0F172A]">
                        @if(isset($session) && $session->type === 'human')
                            {{ $session->counselor ? 'Guru BK: ' . $session->counselor->name : 'Live Chat Guru BK' }}
                        @else
                            Asisten BK Digital SAPA
                        @endif
                    </h2>
                    <p id="chat-header-subtitle" class="text-[11px] font-medium text-[#059669]">
                        @if(isset($session) && $session->type === 'human')
                            @if($session->status === 'waiting')
                                ⏳ Menunggu respon Guru BK (08:00 - 15:00 WIB)
                            @elseif($session->status === 'active')
                                🟢 Sesi Live Konseling Terhubung
                            @else
                                🔒 Sesi Live Chat Telah Selesai
                            @endif
                        @else
                            ● Aktif 24/7 Pendamping SMAN 4 Jember
                        @endif
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                @if(!isset($session) || $session->type === 'bot')
                <button id="request-live-btn" onclick="requestLiveChat()" class="btn-secondary text-xs px-3.5 py-1.5 bg-amber-50 text-amber-800 border-amber-300 hover:bg-amber-100 flex items-center gap-1.5 font-bold shadow-xs">
                    <span>👨‍🏫</span> Connect Live Guru BK (08:00-15:00)
                </button>
                @endif
                
                <button id="mobile-new-session" onclick="createNewSession()" class="btn-secondary text-xs px-3 py-1.5 md:hidden">
                    + Chat Baru
                </button>
                <span class="hidden sm:inline-flex badge-green text-[10px] font-bold">Privasi Terjaga</span>
            </div>
        </div>

        {{-- Status Notification Banner --}}
        <div id="live-chat-banner" class="{{ isset($session) && $session->type === 'human' ? 'block' : 'hidden' }} px-6 py-2.5 bg-amber-50 border-b border-amber-200/80 text-xs font-semibold text-amber-800 flex items-center justify-between">
            <span id="banner-text">
                @if(isset($session) && $session->type === 'human')
                    @if($session->status === 'waiting')
                        ⏳ Permintaan Live Chat dikirim. Guru BK SMAN 4 Jember akan segera bergabung. (Jam Operasional: 08:00 – 15:00 WIB). Identitas siswa ditampilkan untuk rekam konseling.
                    @elseif($session->status === 'active')
                        💬 Anda terhubung langsung dengan Guru BK {{ $session->counselor->name ?? '' }}. Silakan sampaikan kendalamu.
                    @else
                        🔒 Sesi Live Chat ini telah ditutup oleh Guru BK.
                    @endif
                @endif
            </span>
        </div>

        {{-- Scrollable Messages Area --}}
        <div id="chat-messages" class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-4">
            @if(!isset($session) || $session->messages->isEmpty())
            {{-- Empty State Hero --}}
            <div class="flex flex-col items-center justify-center min-h-[80%] text-center px-4 max-w-xl mx-auto py-8">
                <div class="w-20 h-20 rounded-3xl bg-gradient-to-tr from-[#ECFDF5] to-emerald-100 border border-emerald-200/60 flex items-center justify-center mb-5 shadow-lg shadow-[#059669]/10">
                    <span class="text-4xl animate-bounce">🤖</span>
                </div>
                <h3 class="font-sora font-extrabold text-xl text-[#0F172A] mb-2">Halo, {{ auth()->user()->name }}! 👋</h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed mb-6">
                    Saya Asisten Konsultasi Digital SMAN 4 Jember. Siap membantumu berdiskusi via Chatbot AI atau menghubungkan langsung ke Guru BK sekolah.
                </p>

                {{-- Interactive Quick Prompts --}}
                <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-3 text-left">
                    <button onclick="requestLiveChat()"
                            class="card-hover p-3.5 bg-amber-50/90 rounded-2xl border border-amber-200 text-xs hover:border-amber-500 transition-all group col-span-1 sm:col-span-2 shadow-xs">
                        <span class="font-bold text-amber-900 block mb-1 flex items-center gap-1.5 group-hover:text-amber-700">
                            <span>👨‍🏫</span> Live Chat dengan Guru BK (Real-Time Human Counselor)
                        </span>
                        <span class="text-[11px] text-amber-700 block">Hubungkan secara langsung dengan Tim Konselor SMAN 4 Jember (08:00 - 15:00 WIB)</span>
                    </button>

                    <button onclick="setPrompt('Bagaimana cara memilih jurusan PTN yang sesuai minat dan bakat saya?')"
                            class="card-hover p-3.5 bg-white rounded-2xl border border-slate-200 text-xs hover:border-[#059669] transition-all group">
                        <span class="font-bold text-[#0F172A] block mb-1 group-hover:text-[#059669]">🎓 Pilihan Jurusan PTN</span>
                        <span class="text-[11px] text-slate-400 block">Tips SNBP & kecocokan minat bakat</span>
                    </button>
                    <button onclick="setPrompt('Saya merasa sangat stres dan overthinking dengan tugas sekolah. Bagaimana menghadapinya?')"
                            class="card-hover p-3.5 bg-white rounded-2xl border border-slate-200 text-xs hover:border-[#059669] transition-all group">
                        <span class="font-bold text-[#0F172A] block mb-1 group-hover:text-[#059669]">💚 Kelola Stres & Cemas</span>
                        <span class="text-[11px] text-slate-400 block">Teknik relaksasi & kesehatan mental</span>
                    </button>
                    <button onclick="setPrompt('Bisa berikan tips strategi belajar fokus dan mudah paham tanpa malas?')"
                            class="card-hover p-3.5 bg-white rounded-2xl border border-slate-200 text-xs hover:border-[#059669] transition-all group">
                        <span class="font-bold text-[#0F172A] block mb-1 group-hover:text-[#059669]">📚 Strategi Belajar Efektif</span>
                        <span class="text-[11px] text-slate-400 block">Metode Pomodoro & Active Recall</span>
                    </button>
                    <button onclick="setPrompt('Bagaimana prosedur booking konsultasi tatap muka dengan Guru BK sekolah?')"
                            class="card-hover p-3.5 bg-white rounded-2xl border border-slate-200 text-xs hover:border-[#059669] transition-all group">
                        <span class="font-bold text-[#0F172A] block mb-1 group-hover:text-[#059669]">👨‍🏫 Janji Konseling Tatap Muka</span>
                        <span class="text-[11px] text-slate-400 block">Alur bertemu konselor di sekolah</span>
                    </button>
                </div>
            </div>
            @else
            {{-- Message Trajectory --}}
            @foreach($session->messages as $msg)
                @if($msg->role === 'system')
                <div class="flex justify-center my-2">
                    <span class="bg-amber-100/80 text-amber-800 text-[11px] font-semibold px-4 py-1.5 rounded-full border border-amber-200 text-center max-w-lg">
                        ℹ️ {{ $msg->content }}
                    </span>
                </div>
                @else
                <div class="flex {{ $msg->role === 'user' ? 'justify-end' : 'justify-start' }} gap-3">
                    @if($msg->role !== 'user')
                    <div class="w-9 h-9 rounded-2xl {{ $msg->role === 'counselor' ? 'bg-amber-600' : 'bg-[#059669]' }} flex items-center justify-center text-white shrink-0 mt-1 shadow-md font-bold text-sm">
                        {{ $msg->role === 'counselor' ? '👨‍🏫' : '🤖' }}
                    </div>
                    @endif

                    <div class="max-w-xs sm:max-w-md lg:max-w-xl px-5 py-3.5 rounded-3xl text-xs sm:text-sm leading-relaxed
                                {{ $msg->role === 'user'
                                    ? 'bg-gradient-to-r from-[#047857] to-[#059669] text-white rounded-tr-none shadow-md shadow-[#059669]/20'
                                    : ($msg->role === 'counselor'
                                        ? 'bg-amber-50 text-amber-950 rounded-tl-none border border-amber-200 shadow-xs'
                                        : 'bg-white text-[#0F172A] rounded-tl-none shadow-xs border border-slate-200/80') }}">
                        {!! nl2br(e($msg->content)) !!}

                        @if($msg->role === 'assistant' && $msg->metadata)
                            @php $meta = json_decode($msg->metadata, true); @endphp
                            @if(!empty($meta['recommended_ebooks']))
                            <div class="mt-3 pt-2.5 border-t border-slate-100 space-y-1">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-[#059669] block">📚 Rekomendasi E-Book:</span>
                                @foreach($meta['recommended_ebooks'] as $ebookTitle)
                                <a href="{{ route('student.ebook') }}" class="inline-flex items-center gap-1 bg-[#ECFDF5] text-[#059669] font-bold text-[11px] px-2.5 py-1 rounded-lg hover:underline mr-1 mt-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    {{ $ebookTitle }}
                                </a>
                                @endforeach
                            </div>
                            @endif
                        @endif

                        <p class="text-[10px] mt-2 font-medium {{ $msg->role === 'user' ? 'text-emerald-100/80 text-right' : 'text-slate-400' }}">
                            {{ $msg->created_at->format('H:i') }}
                        </p>
                    </div>
                </div>
                @endif
            @endforeach
            @endif
        </div>

        {{-- Input Form Area --}}
        <div class="bg-white border-t border-slate-200/80 p-4">
            <form id="chat-form" class="flex items-end gap-3 max-w-4xl mx-auto">
                @csrf
                <textarea id="chat-input" rows="1" placeholder="Ketik pesanmu di sini..."
                        class="form-input flex-1 resize-none max-h-36 py-3.5 px-4 rounded-2xl border-slate-200 focus:border-[#059669] focus:ring-[#059669] text-xs sm:text-sm font-medium"></textarea>
                <button type="submit" id="send-btn"
                        class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-[#047857] to-[#10B981] flex items-center justify-center text-white hover:opacity-90 transition-all shrink-0 shadow-md shadow-[#059669]/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </form>
            <p class="text-[10px] text-slate-400 text-center mt-2">
                Jam Operasional Live Chat Guru BK: Senin - Jumat (08:00 - 15:00 WIB). Identitas siswa terhubung untuk rekam medis konseling.
            </p>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentSessionId = {{ isset($session) ? $session->id : 'null' }};
    let currentType = "{{ isset($session) ? $session->type : 'bot' }}";
    let currentStatus = "{{ isset($session) ? $session->status : 'active' }}";
    let pollingInterval = null;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function setPrompt(text) {
        document.getElementById('chat-input').value = text;
        document.getElementById('chat-input').focus();
    }

    const chatMessages = document.getElementById('chat-messages');
    if (chatMessages) chatMessages.scrollTop = chatMessages.scrollHeight;

    const chatInput = document.getElementById('chat-input');
    chatInput?.addEventListener('input', () => {
        chatInput.style.height = 'auto';
        chatInput.style.height = Math.min(chatInput.scrollHeight, 140) + 'px';
    });

    chatInput?.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            document.getElementById('chat-form').dispatchEvent(new Event('submit'));
        }
    });

    async function createNewSession() {
        const res = await fetch('/api/chat/session', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }
        });
        const data = await res.json();
        if (data.session_id) window.location.href = `/chat/${data.session_id}`;
    }

    document.getElementById('new-session-btn')?.addEventListener('click', createNewSession);

    // Request Live Chat Guru BK
    async function requestLiveChat() {
        if (!currentSessionId) {
            const sRes = await fetch('/api/chat/session', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            const sData = await sRes.json();
            if (sData.session_id) {
                currentSessionId = sData.session_id;
            } else {
                alert('Gagal membuat sesi percakapan.');
                return;
            }
        }

        try {
            const res = await fetch(`/api/chat/${currentSessionId}/request-live`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            const data = await res.json();

            if (!res.ok) {
                alert(data.message || 'Layanan Live Chat Guru BK hanya aktif 08:00 - 15:00 WIB.');
                window.location.href = `/chat/${currentSessionId}`;
                return;
            }

            alert(data.message);
            window.location.href = `/chat/${currentSessionId}`;
        } catch (err) {
            alert('Terjadi kesalahan jaringan.');
        }
    }

    // Form Submit Chat
    document.getElementById('chat-form')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = chatInput.value.trim();
        if (!message) return;

        if (!currentSessionId) {
            const res = await fetch('/api/chat/session', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            const data = await res.json();
            currentSessionId = data.session_id;
        }

        chatInput.value = '';
        chatInput.style.height = 'auto';

        appendBubble(message, 'user');

        if (currentType === 'bot') {
            const loadingId = 'loading-' + Date.now();
            appendLoading(loadingId);

            try {
                const res = await fetch('/api/chat', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ session_id: currentSessionId, message })
                });
                const data = await res.json();
                document.getElementById(loadingId)?.remove();

                appendBubble(data.answer, 'assistant', data.recommended_ebooks);
                window.history.replaceState({}, '', `/chat/${currentSessionId}`);
            } catch (err) {
                document.getElementById(loadingId)?.remove();
                appendBubble('Terjadi kendala koneksi. Silakan kirim ulang pesanmu.', 'assistant');
            }
        } else {
            // Mode Live Chat Human Counselor
            try {
                await fetch('/api/chat', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ session_id: currentSessionId, message })
                });
                checkStatusAndFetchMessages();
            } catch (err) {
                console.error('Failed sending live chat message', err);
            }
        }
    });

    // Polling Mechanism untuk Live Chat
    function startPolling() {
        if (currentType === 'human' && currentSessionId) {
            pollingInterval = setInterval(checkStatusAndFetchMessages, 3000);
        }
    }

    let lastMessageCount = {{ isset($session) ? $session->messages->count() : 0 }};

    async function checkStatusAndFetchMessages() {
        if (!currentSessionId) return;

        try {
            const res = await fetch(`/api/chat/${currentSessionId}/status`);
            const data = await res.json();

            currentType = data.type;
            currentStatus = data.status;

            if (data.messages && data.messages.length > lastMessageCount) {
                // Re-render new messages
                const newMessages = data.messages.slice(lastMessageCount);
                newMessages.forEach(msg => {
                    if (msg.role !== 'user') {
                        appendBubble(msg.content, msg.role);
                    }
                });
                lastMessageCount = data.messages.length;
            }

            // Update UI elements
            if (data.counselor) {
                document.getElementById('chat-header-title').innerText = 'Guru BK: ' + data.counselor;
            }
        } catch (err) {
            console.error('Polling error', err);
        }
    }

    if (currentType === 'human') {
        startPolling();
    }

    function appendBubble(text, role, ebooks = []) {
        const container = document.getElementById('chat-messages');
        const isUser = role === 'user';
        const isSystem = role === 'system';

        const emptyState = container.querySelector('.flex.flex-col.items-center');
        if (emptyState) emptyState.remove();

        if (isSystem) {
            const div = document.createElement('div');
            div.className = 'flex justify-center my-2';
            div.innerHTML = `<span class="bg-amber-100/80 text-amber-800 text-[11px] font-semibold px-4 py-1.5 rounded-full border border-amber-200 text-center max-w-lg">ℹ️ ${escapeHtml(text)}</span>`;
            container.appendChild(div);
            container.scrollTop = container.scrollHeight;
            return;
        }

        const formattedText = escapeHtml(text).replace(/\n/g, '<br>');

        let ebooksHtml = '';
        if (ebooks && ebooks.length > 0) {
            ebooksHtml = `
                <div class="mt-3 pt-2.5 border-t border-slate-100 space-y-1">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#059669] block">📚 Rekomendasi E-Book:</span>
                    ${ebooks.map(eb => `<a href="/student/ebook" class="inline-flex items-center gap-1 bg-[#ECFDF5] text-[#059669] font-bold text-[11px] px-2.5 py-1 rounded-lg hover:underline mr-1 mt-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>${escapeHtml(eb)}</a>`).join('')}
                </div>
            `;
        }

        const div = document.createElement('div');
        div.className = `flex ${isUser ? 'justify-end' : 'justify-start'} gap-3`;
        div.innerHTML = `
            ${!isUser ? `<div class="w-9 h-9 rounded-2xl ${role === 'counselor' ? 'bg-amber-600' : 'bg-[#059669]'} flex items-center justify-center text-white shrink-0 mt-1 shadow-md font-bold text-sm">${role === 'counselor' ? '👨‍🏫' : '🤖'}</div>` : ''}
            <div class="max-w-xs sm:max-w-md lg:max-w-xl px-5 py-3.5 rounded-3xl text-xs sm:text-sm leading-relaxed
                        ${isUser ? 'bg-gradient-to-r from-[#047857] to-[#059669] text-white rounded-tr-none shadow-md shadow-[#059669]/20' : (role === 'counselor' ? 'bg-amber-50 text-amber-950 rounded-tl-none border border-amber-200 shadow-xs' : 'bg-white text-[#0F172A] rounded-tl-none shadow-xs border border-slate-200/80')}">
                ${formattedText}
                ${ebooksHtml}
                <p class="text-[10px] mt-2 font-medium ${isUser ? 'text-emerald-100/80 text-right' : 'text-slate-400'}">
                    ${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                </p>
            </div>
        `;
        container.appendChild(div);
        container.scrollTop = container.scrollHeight;
    }

    function appendLoading(id) {
        const container = document.getElementById('chat-messages');
        const div = document.createElement('div');
        div.id = id;
        div.className = 'flex justify-start gap-3';
        div.innerHTML = `
            <div class="w-9 h-9 rounded-2xl bg-[#059669] flex items-center justify-center text-white shrink-0 mt-1 shadow-md shadow-[#059669]/20 font-bold text-sm">🤖</div>
            <div class="bg-white border border-slate-200/80 rounded-3xl rounded-tl-none px-5 py-4 flex items-center gap-1.5 shadow-xs">
                <span class="w-2 h-2 bg-[#059669] rounded-full animate-bounce"></span>
                <span class="w-2 h-2 bg-[#059669] rounded-full animate-bounce" style="animation-delay:0.15s"></span>
                <span class="w-2 h-2 bg-[#059669] rounded-full animate-bounce" style="animation-delay:0.3s"></span>
            </div>
        `;
        container.appendChild(div);
        container.scrollTop = container.scrollHeight;
    }

    function escapeHtml(text) {
        return text.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }
</script>
@endpush
