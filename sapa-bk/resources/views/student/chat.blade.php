@extends('layouts.student')

@section('title', 'Konsultasi AI BK')
@section('page-title', 'Konsultasi Chat AI')

@section('content')
<div class="flex h-[calc(100vh-6rem)] -m-4 sm:-m-6 overflow-hidden bg-[#F8FAFC]">

    {{-- Sidebar Sesi --}}
    <aside class="w-72 shrink-0 bg-white border-r border-slate-200/80 flex flex-col hidden md:flex">
        <div class="p-4 border-b border-slate-200/70">
            <button id="new-session-btn" class="btn-primary w-full justify-center text-xs py-3 shadow-md shadow-[#059669]/10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                + Mulai Percakapan Baru
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
                <div class="flex items-center gap-2">
                    <span class="text-sm">💬</span>
                    <p class="truncate flex-1 font-sora">{{ $s->title }}</p>
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
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-[#047857] to-[#10B981] flex items-center justify-center text-white shadow-md shadow-[#059669]/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 border-2 border-white rounded-full"></span>
                </div>
                <div>
                    <h2 class="font-sora font-extrabold text-sm text-[#0F172A]">Asisten BK Digital SAPA</h2>
                    <p class="text-[11px] font-medium text-[#059669]">● Aktif 24/7 Pendamping SMAN 4 Jember</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button id="mobile-new-session" onclick="createNewSession()" class="btn-secondary text-xs px-3 py-1.5 md:hidden">
                    + Chat Baru
                </button>
                <span class="hidden sm:inline-flex badge-green text-[10px] font-bold">Privasi 100% Rahasia</span>
            </div>
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
                    Saya Asisten Konsultasi Digital SMAN 4 Jember. Siap membantumu berdiskusi seputar jurusan kuliah, cara mengatasi stres belajar, hingga pilihan karir.
                </p>

                {{-- Interactive Quick Prompts --}}
                <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-3 text-left">
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
            <div class="flex {{ $msg->role === 'user' ? 'justify-end' : 'justify-start' }} gap-3">
                @if($msg->role === 'assistant')
                <div class="w-9 h-9 rounded-2xl bg-[#059669] flex items-center justify-center text-white shrink-0 mt-1 shadow-md shadow-[#059669]/20 font-bold text-sm">
                    🤖
                </div>
                @endif

                <div class="max-w-xs sm:max-w-md lg:max-w-xl px-5 py-3.5 rounded-3xl text-xs sm:text-sm leading-relaxed
                            {{ $msg->role === 'user'
                                ? 'bg-gradient-to-r from-[#047857] to-[#059669] text-white rounded-tr-none shadow-md shadow-[#059669]/20'
                                : 'bg-white text-[#0F172A] rounded-tl-none shadow-xs border border-slate-200/80' }}">
                    {!! nl2br(e($msg->content)) !!}

                    @if($msg->role === 'assistant' && $msg->metadata)
                        @php $meta = json_decode($msg->metadata, true); @endphp
                        @if(!empty($meta['recommended_ebooks']))
                        <div class="mt-3 pt-2.5 border-t border-slate-100 space-y-1">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#059669] block">📚 Rekomendasi E-Book:</span>
                            @foreach($meta['recommended_ebooks'] as $ebookTitle)
                            <a href="{{ route('student.ebook') }}" class="inline-block bg-[#ECFDF5] text-[#059669] font-bold text-[11px] px-2.5 py-1 rounded-lg hover:underline mr-1 mt-1">
                                📖 {{ $ebookTitle }}
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
            @endforeach
            @endif
        </div>

        {{-- Input Form Area --}}
        <div class="bg-white border-t border-slate-200/80 p-4">
            <form id="chat-form" class="flex items-end gap-3 max-w-4xl mx-auto">
                @csrf
                <textarea id="chat-input" rows="1" placeholder="Ketik pertanyaanmu seputar kuliah, stres, atau tugas di sini..."
                        class="form-input flex-1 resize-none max-h-36 py-3.5 px-4 rounded-2xl border-slate-200 focus:border-[#059669] focus:ring-[#059669] text-xs sm:text-sm font-medium"></textarea>
                <button type="submit"
                        class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-[#047857] to-[#10B981] flex items-center justify-center text-white hover:opacity-90 transition-all shrink-0 shadow-md shadow-[#059669]/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </form>
            <p class="text-[10px] text-slate-400 text-center mt-2">
                Asisten AI memberikan saran umum. Untuk kebutuhan mendesak, hubungi Guru BK di sekolah.
            </p>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentSessionId = {{ isset($session) ? $session->id : 'null' }};
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
    });

    function appendBubble(text, role, ebooks = []) {
        const container = document.getElementById('chat-messages');
        const isUser = role === 'user';

        const emptyState = container.querySelector('.flex.flex-col.items-center');
        if (emptyState) emptyState.remove();

        const formattedText = escapeHtml(text).replace(/\n/g, '<br>');

        let ebooksHtml = '';
        if (ebooks && ebooks.length > 0) {
            ebooksHtml = `
                <div class="mt-3 pt-2.5 border-t border-slate-100 space-y-1">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#059669] block">📚 Rekomendasi E-Book:</span>
                    ${ebooks.map(eb => `<a href="/student/ebook" class="inline-block bg-[#ECFDF5] text-[#059669] font-bold text-[11px] px-2.5 py-1 rounded-lg hover:underline mr-1 mt-1">📖 ${escapeHtml(eb)}</a>`).join('')}
                </div>
            `;
        }

        const div = document.createElement('div');
        div.className = `flex ${isUser ? 'justify-end' : 'justify-start'} gap-3`;
        div.innerHTML = `
            ${!isUser ? `<div class="w-9 h-9 rounded-2xl bg-[#059669] flex items-center justify-center text-white shrink-0 mt-1 shadow-md shadow-[#059669]/20 font-bold text-sm">🤖</div>` : ''}
            <div class="max-w-xs sm:max-w-md lg:max-w-xl px-5 py-3.5 rounded-3xl text-xs sm:text-sm leading-relaxed
                        ${isUser ? 'bg-gradient-to-r from-[#047857] to-[#059669] text-white rounded-tr-none shadow-md shadow-[#059669]/20' : 'bg-white text-[#0F172A] rounded-tl-none shadow-xs border border-slate-200/80'}">
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
push
