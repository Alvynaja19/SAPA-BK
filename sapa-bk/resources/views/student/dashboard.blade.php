@extends('layouts.student')

@section('title', 'Dashboard Siswa — SAPA BK SMAN 4 Jember')
@section('page-title', 'Ruang Pendampingan Siswa')

@section('content')
<div class="space-y-6">

    {{-- HERO BANNER & MOOD CHECK-IN --}}
    <div class="relative overflow-hidden rounded-2xl p-6 sm:p-8 text-white shadow-theme-md border border-brand-500/20 bg-gradient-to-r from-brand-600 via-brand-500 to-brand-700">
        
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-brand-300/15 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/15 backdrop-blur-md text-white text-xs font-semibold mb-3 border border-white/20">
                <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                <span>Ruang Konsultasi &amp; Pengembangan Diri Digital</span>
            </div>
            
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight mb-2">
                Halo, {{ $user->name }}! ✨
            </h2>
            
            <p class="text-white/90 text-xs sm:text-sm leading-relaxed max-w-2xl">
                Selamat datang di ruang amanmu. Apapun yang sedang kamu hadapi—seputar akademik, rasa cemas, maupun rencana masa depan—kami di SMAN 4 Jember siap menemani.
            </p>

            {{-- Interactive Mood Selector --}}
            <div class="mt-5 pt-4 border-t border-white/15">
                <p class="text-xs font-bold text-white uppercase tracking-wider mb-3 flex items-center gap-1.5">
                    <span>🌱</span> Apa yang kamu rasakan hari ini? (Klik untuk respon kilat)
                </p>
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="selectMood('semangat', 'Wah, keren! Terus pertahankan energimu. Ada target belajar atau mimpi yang ingin kamu eksplorasi hari ini?')"
                            class="mood-btn px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/25 backdrop-blur-xs text-xs font-semibold text-white border border-white/20 transition-all flex items-center gap-1.5 active:scale-95">
                        <span>😊</span> Bersemangat
                    </button>
                    <button type="button" onclick="selectMood('biasa', 'Hari yang santai dan seimbang. Kamu bisa membaca e-book tips motivasi atau sekadar tanya jawab ringan di sini.')"
                            class="mood-btn px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/25 backdrop-blur-xs text-xs font-semibold text-white border border-white/20 transition-all flex items-center gap-1.5 active:scale-95">
                        <span>😐</span> Biasa Saja
                    </button>
                    <button type="button" onclick="selectMood('stres', 'Tarik napas dalam-dalam ya. Kamu tidak sendirian. Mau curhat dengan Asisten AI atau jadwalkan sesi live dengan Guru BK?')"
                            class="mood-btn px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/25 backdrop-blur-xs text-xs font-semibold text-white border border-white/20 transition-all flex items-center gap-1.5 active:scale-95">
                        <span>😰</span> Cemas / Stres
                    </button>
                    <button type="button" onclick="selectMood('lelah', 'Istirahat sejenak bukan tanda menyerah. Coba metode 4-7-8 untuk relaksasi tubuh dan tenangkan pikiranmu.')"
                            class="mood-btn px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/25 backdrop-blur-xs text-xs font-semibold text-white border border-white/20 transition-all flex items-center gap-1.5 active:scale-95">
                        <span>😴</span> Lelah Belajar
                    </button>
                    <button type="button" onclick="selectMood('karir', 'Memilih jurusan butuh riset yang matang. Coba tanyakan tips SNBP atau ikuti tes minat bakat untuk memetakan potensimu!')"
                            class="mood-btn px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/25 backdrop-blur-xs text-xs font-semibold text-white border border-white/20 transition-all flex items-center gap-1.5 active:scale-95">
                        <span>🎓</span> Bingung Karir
                    </button>
                </div>
            </div>

            {{-- Interactive Mood Response Card --}}
            <div id="mood-response-box" class="hidden mt-4 p-4 rounded-xl bg-white/20 backdrop-blur-md border border-white/30 text-xs text-white">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-start gap-2.5">
                        <span class="text-xl">💡</span>
                        <div>
                            <p id="mood-response-text" class="font-medium leading-relaxed"></p>
                            <div class="mt-2.5 flex items-center gap-2">
                                <button id="mood-chat-btn" onclick="startMoodChat()" class="px-3.5 py-1.5 rounded-lg bg-white text-brand-600 font-bold text-xs shadow-xs hover:bg-gray-100 transition-all flex items-center gap-1">
                                    <span>💬</span> Tanya Asisten AI
                                </button>
                            </div>
                        </div>
                    </div>
                    <button onclick="document.getElementById('mood-response-box').classList.add('hidden')" class="text-white/70 hover:text-white text-base">✕</button>
                </div>
            </div>
        </div>
    </div>

    {{-- STAT CARDS (4 Columns) --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        
        {{-- Card 1 --}}
        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-5 shadow-xs flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-brand-50 text-brand-500 dark:bg-brand-500/20 dark:text-brand-400 flex items-center justify-center shrink-0 text-xl font-bold">
                💬
            </div>
            <div class="min-w-0">
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $totalKonsultasiSaya ?? 0 }}</p>
                <p class="text-[11px] text-gray-500 dark:text-gray-400 font-semibold truncate">Konsultasi Saya</p>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-5 shadow-xs flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-500/20 dark:text-purple-400 flex items-center justify-center shrink-0 text-xl font-bold">
                🎯
            </div>
            <div class="min-w-0">
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $totalTesDiselesaikan ?? 0 }} <span class="text-xs text-gray-400 font-normal">/ {{ $totalTesTersedia ?? 0 }}</span></p>
                <p class="text-[11px] text-gray-500 dark:text-gray-400 font-semibold truncate">Tes Diselesaikan</p>
            </div>
        </div>

        {{-- Card 3 --}}
        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-5 shadow-xs flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-blue-light-50 text-blue-light-600 dark:bg-blue-light-500/20 dark:text-blue-light-400 flex items-center justify-center shrink-0 text-xl font-bold">
                📚
            </div>
            <div class="min-w-0">
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $totalEbookTersedia ?? 0 }}</p>
                <p class="text-[11px] text-gray-500 dark:text-gray-400 font-semibold truncate">E-Book Edukasi</p>
            </div>
        </div>

        {{-- Card 4 --}}
        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-5 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Guru BK</span>
                <span class="w-2.5 h-2.5 rounded-full {{ $isWorkingHours ? 'bg-success-500 animate-ping' : 'bg-amber-400' }}"></span>
            </div>
            <div class="mt-1">
                <p class="text-xs font-bold text-gray-900 dark:text-white">
                    {{ $isWorkingHours ? '🟢 Live BK Aktif' : '⏳ Di Luar Jam Kerja' }}
                </p>
                <p class="text-[10px] text-gray-400">08:00 - 15:00 WIB</p>
            </div>
            <button onclick="startDirectLiveChat()" class="mt-2 text-[11px] font-bold text-brand-500 dark:text-brand-400 hover:underline flex items-center gap-1">
                <span>Hubungkan Konselor</span> →
            </button>
        </div>

    </div>

    {{-- QUICK CHAT BOX --}}
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-6 shadow-xs relative">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-4">
            <div>
                <h3 class="font-bold text-base text-gray-900 dark:text-white flex items-center gap-2">
                    <span>🤖</span> Tanya Apapun ke Asisten Digital BK
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    Dapatkan panduan belajar, referensi SNBP/UTBK, materi e-book, atau teknik relaksasi secara instan 24/7.
                </p>
            </div>
            <a href="{{ route('student.chat') }}" class="btn-secondary text-xs px-4 py-2 font-semibold self-start md:self-auto shrink-0">
                Buka Full Chatbot →
            </a>
        </div>

        <form id="dashboard-quick-chat-form" class="flex items-center gap-2.5">
            @csrf
            <div class="relative flex-1">
                <input type="text" id="quick-message-input" placeholder="Tuliskan pertanyaanmu, misal: 'Bagaimana tips memilih jurusan SNBP sesuai nilai rapor?'"
                       class="w-full rounded-xl py-3 pl-4 pr-10 text-xs sm:text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white placeholder:text-gray-400 focus:border-brand-500 focus:outline-hidden">
                <span class="absolute right-3.5 top-3.5 text-gray-400">💡</span>
            </div>
            <button type="submit" class="btn-primary text-xs sm:text-sm px-5 py-3 rounded-xl shrink-0 font-semibold flex items-center gap-1.5">
                <span>Kirim</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </form>

        {{-- Quick Prompts Pills --}}
        <div class="mt-3.5 flex items-center gap-1.5 overflow-x-auto pb-1 text-xs text-gray-500">
            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider shrink-0 mr-1">Topik Cepat:</span>
            <button type="button" onclick="setQuickPrompt('Bagaimana cara mengatasi rasa cemas dan takut gagal saat ujian sekolah?')"
                    class="shrink-0 px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-800 hover:bg-brand-50 dark:hover:bg-brand-500/20 hover:text-brand-500 dark:text-gray-300 text-[11px] font-medium transition-all border border-gray-200 dark:border-gray-700">
                💚 Atasi Cemas Ujian
            </button>
            <button type="button" onclick="setQuickPrompt('Bagaimana strategi memilih jurusan kuliah SNBP dan SNBT yang peluangnya tinggi?')"
                    class="shrink-0 px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-800 hover:bg-brand-50 dark:hover:bg-brand-500/20 hover:text-brand-500 dark:text-gray-300 text-[11px] font-medium transition-all border border-gray-200 dark:border-gray-700">
                🎓 Strategi SNBP PTN
            </button>
            <button type="button" onclick="setQuickPrompt('Bisa jelaskan teknik belajar Pomodoro dan Active Recall?')"
                    class="shrink-0 px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-800 hover:bg-brand-50 dark:hover:bg-brand-500/20 hover:text-brand-500 dark:text-gray-300 text-[11px] font-medium transition-all border border-gray-200 dark:border-gray-700">
                📚 Cara Belajar Efektif
            </button>
        </div>
    </div>

    {{-- MAIN DASHBOARD CONTENT GRID (3 Columns) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Column 1 & 2 --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Kartu Hasil Asesmen --}}
            <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-6 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-500/20 dark:text-purple-400 flex items-center justify-center text-lg font-bold">
                            🧩
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white text-base">Hasil Asesmen &amp; Minat Bakat</h3>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400">Pemetaan kepribadian dan potensi belajarmu</p>
                        </div>
                    </div>
                    <a href="{{ route('student.tes') }}" class="text-xs text-brand-500 font-semibold hover:underline">Semua Tes ({{ $totalTesTersedia }}) →</a>
                </div>

                @if($latestTestResult)
                <div class="p-4 rounded-xl bg-purple-50/50 dark:bg-purple-500/10 border border-purple-100 dark:border-purple-500/20 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-success-50 text-success-600 dark:bg-success-500/20 dark:text-success-400 mb-1">Tes Terakhir Diselesaikan</span>
                        <h4 class="font-bold text-sm text-purple-950 dark:text-purple-300">{{ $latestTestResult->questionnaire->title ?? 'Asesmen Minat Bakat' }}</h4>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Dikerjakan pada {{ $latestTestResult->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="flex items-center gap-3 shrink-0">
                        @if($latestTestResult->score)
                        <div class="text-center px-4 py-2 rounded-xl bg-white dark:bg-gray-800 border border-purple-200 dark:border-purple-500/30 shadow-xs">
                            <span class="text-[10px] text-gray-400 block uppercase font-bold">Skor</span>
                            <span class="font-bold text-lg text-purple-700 dark:text-purple-400">{{ $latestTestResult->score }}</span>
                        </div>
                        @endif
                        <a href="{{ route('student.tes.hasil', $latestTestResult->questionnaire_id) }}" class="btn-primary text-xs px-4 py-2.5">
                            Lihat Rekomendasi
                        </a>
                    </div>
                </div>
                @else
                <div class="p-6 rounded-xl bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-800 text-center">
                    <span class="text-3xl block mb-2">🎯</span>
                    <h4 class="font-bold text-xs text-gray-900 dark:text-white mb-1">Belum Ada Tes yang Diikuti</h4>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-4">
                        Yuk kenali gaya belajarmu, tipe kepribadian, dan kecocokan jurusan lewat tes asesmen psikologi online SAPA BK.
                    </p>
                    <a href="{{ route('student.tes') }}" class="btn-primary text-xs px-5 py-2">
                        Mulai Tes Sekarang
                    </a>
                </div>
                @endif
            </div>

            {{-- Kartu Percakapan --}}
            <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-6 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-brand-50 text-brand-500 dark:bg-brand-500/20 dark:text-brand-400 flex items-center justify-center text-lg font-bold">
                            💬
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white text-base">Percakapan Konsultasi Terakhir</h3>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400">Lanjutkan kembali sesi obrolan yang belum tuntas</p>
                        </div>
                    </div>
                    <a href="{{ route('student.riwayat') }}" class="text-xs text-brand-500 font-semibold hover:underline">Semua Riwayat →</a>
                </div>

                <div class="space-y-2.5">
                    @forelse($recentSessions as $session)
                    <div class="flex items-center justify-between p-3.5 rounded-xl bg-gray-50 dark:bg-gray-800/50 hover:bg-brand-50/50 dark:hover:bg-white/5 border border-gray-100 dark:border-gray-800 transition-all">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-xl {{ $session->type === 'human' ? 'bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-400' : 'bg-brand-50 text-brand-500 dark:bg-brand-500/20 dark:text-brand-400' }} flex items-center justify-center shrink-0 font-bold text-sm">
                                {{ $session->type === 'human' ? '👨‍🏫' : '🤖' }}
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <p class="text-xs font-bold text-gray-900 dark:text-white truncate">{{ $session->title }}</p>
                                    @if($session->type === 'human')
                                    <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded bg-amber-50 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400 shrink-0">Live BK</span>
                                    @endif
                                </div>
                                <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">{{ $session->created_at->format('d M Y, H:i') }} • {{ $session->messages_count ?? $session->messages()->count() }} pesan</p>
                            </div>
                        </div>
                        <a href="{{ route('student.chat.session', $session->id) }}" class="btn-secondary text-xs px-3.5 py-1.5 shrink-0 ml-2 font-semibold">
                            Buka Sesi
                        </a>
                    </div>
                    @empty
                    <div class="text-center py-8 text-xs text-gray-400 dark:text-gray-500">
                        <p class="mb-2">Belum ada percakapan konsultasi yang tercatat.</p>
                        <a href="{{ route('student.chat') }}" class="btn-primary text-xs px-4 py-2 font-semibold">Mulai Konsultasi Pertama</a>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Column 3 --}}
        <div class="space-y-6">

            {{-- E-Book Pilihan --}}
            <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-6 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-gray-900 dark:text-white text-sm flex items-center gap-2">
                        <span>📚</span> E-Book Panduan BK
                    </h3>
                    <a href="{{ route('student.ebook') }}" class="text-xs text-brand-500 font-semibold hover:underline">Lihat Semua →</a>
                </div>

                <div class="space-y-3">
                    @forelse($ebooks as $ebook)
                    <div class="p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-800 hover:border-brand-300 transition-all flex items-start gap-3">
                        <div class="w-10 h-12 rounded-lg bg-brand-500 text-white flex items-center justify-center shrink-0 shadow-xs">
                            <span class="text-base">📖</span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h4 class="font-bold text-xs text-gray-900 dark:text-white truncate">{{ $ebook->title }}</h4>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 line-clamp-1 mt-0.5">{{ $ebook->description }}</p>
                            <a href="{{ route('student.ebook') }}" class="inline-block mt-1 text-[10px] font-semibold text-brand-500 dark:text-brand-400 hover:underline">
                                Baca Sekarang →
                            </a>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-gray-400 dark:text-gray-500 text-center py-4">Belum ada e-book tersedia.</p>
                    @endforelse
                </div>
            </div>

            {{-- Artikel Edukasi --}}
            <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-6 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-gray-900 dark:text-white text-sm flex items-center gap-2">
                        <span>💡</span> Edukasi &amp; Tips Remaja
                    </h3>
                    <a href="{{ route('artikel.list') }}" class="text-xs text-brand-500 font-semibold hover:underline">Jelajahi →</a>
                </div>

                <div class="space-y-3">
                    @forelse($articles as $art)
                    <a href="{{ route('artikel.detail', $art->slug) }}" class="block p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-800 hover:bg-brand-50/50 dark:hover:bg-white/5 transition-all">
                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded-full bg-brand-50 text-brand-500 dark:bg-brand-500/20 dark:text-brand-400 uppercase">Artikel</span>
                        <h4 class="font-bold text-xs text-gray-900 dark:text-white line-clamp-1 mt-1">{{ $art->title }}</h4>
                        <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-1">{{ $art->created_at->diffForHumans() }}</p>
                    </a>
                    @empty
                    <p class="text-xs text-gray-400 dark:text-gray-500 text-center py-4">Belum ada artikel publikasi.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    let selectedMoodPrompt = '';

    function selectMood(type, responseText) {
        const box = document.getElementById('mood-response-box');
        const text = document.getElementById('mood-response-text');
        
        text.innerText = responseText;
        box.classList.remove('hidden');

        if (type === 'stres') {
            selectedMoodPrompt = 'Saya sedang merasa cemas dan stres dengan beban sekolah. Bisakah kamu berikan latihan pernamapasan dan cara mengatasinya?';
        } else if (type === 'lelah') {
            selectedMoodPrompt = 'Saya merasa lelah dan sulit fokus belajar hari ini. Bagaimana cara membagi waktu istirahat yang efektif?';
        } else if (type === 'karir') {
            selectedMoodPrompt = 'Saya masih bingung menentukan jurusan kuliah setelah lulus dari SMAN 4 Jember. Apa langkah awal yang harus saya lakukan?';
        } else if (type === 'semangat') {
            selectedMoodPrompt = 'Saya merasa bersemangat hari ini! Berikan tips menjaga konsistensi motivasi belajar saya.';
        } else {
            selectedMoodPrompt = 'Halo Asisten BK, apa rekomendasi materi pengembangan diri yang cocok untuk siswa SMA hari ini?';
        }
    }

    async function startMoodChat() {
        if (!selectedMoodPrompt) return;
        await submitPromptToChat(selectedMoodPrompt);
    }

    function setQuickPrompt(text) {
        document.getElementById('quick-message-input').value = text;
        document.getElementById('quick-message-input').focus();
    }

    document.getElementById('dashboard-quick-chat-form')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const msg = document.getElementById('quick-message-input').value.trim();
        if (!msg) return;
        await submitPromptToChat(msg);
    });

    async function submitPromptToChat(message) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        try {
            const sRes = await fetch('/api/chat/session', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            const sData = await sRes.json();
            
            if (!sData.session_id) {
                window.location.href = '/chat';
                return;
            }

            await fetch('/api/chat', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ session_id: sData.session_id, message })
            });

            window.location.href = `/chat/${sData.session_id}`;
        } catch (err) {
            window.location.href = '/chat';
        }
    }

    async function startDirectLiveChat() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        try {
            const sRes = await fetch('/api/chat/session', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            const sData = await sRes.json();
            
            if (!sData.session_id) {
                alert('Gagal membuat sesi percakapan.');
                return;
            }

            const reqRes = await fetch(`/api/chat/${sData.session_id}/request-live`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            const reqData = await reqRes.json();

            if (!reqRes.ok) {
                alert(reqData.message || 'Layanan Live Chat Guru BK hanya aktif 08:00 - 15:00 WIB.');
                window.location.href = `/chat/${sData.session_id}`;
                return;
            }

            window.location.href = `/chat/${sData.session_id}`;
        } catch (err) {
            alert('Terjadi kesalahan jaringan saat menghubungkan ke Guru BK.');
        }
    }
</script>
@endpush
