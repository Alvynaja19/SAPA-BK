@extends('layouts.admin')

@section('title', 'Panel Guru BK — SMAN 4 Jember')
@section('page-title', 'Pusat Kendali Bimbingan Konseling')

@section('content')
<div class="space-y-6">

    {{-- LIVE COUNSELING QUEUE ALERT BANNER --}}
    @if($waitingCount > 0)
    <div class="p-5 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 text-white shadow-theme-md flex flex-col sm:flex-row sm:items-center justify-between gap-4 border border-orange-400">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center text-xl shrink-0">
                ⚠️
            </div>
            <div>
                <h3 class="font-bold text-sm sm:text-base">
                    Ada {{ $waitingCount }} Siswa Menunggu Konseling Live!
                </h3>
                <p class="text-xs text-orange-100 mt-0.5">
                    Siswa mengajukan sesi konsultasi langsung dengan Guru BK SMAN 4 Jember.
                </p>
            </div>
        </div>
        <a href="{{ route('counselor.live-chat') }}" class="px-5 py-2.5 rounded-xl bg-white text-orange-900 font-bold text-xs hover:bg-orange-50 transition-all shadow-xs shrink-0 flex items-center justify-center gap-1.5">
            <span>👨‍🏫</span> Buka Antrean Live Chat →
        </a>
    </div>
    @endif

    {{-- METRICS & COUNSELOR STATS GRID --}}
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        {{-- Antrean Live --}}
        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-5 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl {{ $waitingCount > 0 ? 'bg-amber-50 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400 animate-pulse' : 'bg-gray-100 text-gray-600 dark:bg-white/5 dark:text-gray-400' }} flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $waitingCount }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Antrean Menunggu</p>
            </div>
        </div>

        {{-- Sesi Aktif Live --}}
        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-5 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-success-50 text-success-600 dark:bg-success-500/20 dark:text-success-400 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $activeLiveCount }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Sesi Live Berjalan</p>
            </div>
        </div>

        {{-- Total Siswa --}}
        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-5 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-500 dark:bg-brand-500/20 dark:text-brand-400 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalSiswa }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Siswa Terdaftar</p>
            </div>
        </div>

        {{-- Total Percakapan --}}
        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-5 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-500/20 dark:text-purple-400 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalPercakapan }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Total Konsultasi</p>
            </div>
        </div>

    </div>

    {{-- SPLIT MAIN WORKSPACE --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- Left: Antrean Siswa & Percakapan Siswa Terbaru (8 Cols) --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- Sesi Antrean Menunggu --}}
            @if($waitingSessions->isNotEmpty())
            <div class="rounded-2xl border border-amber-200 dark:border-amber-500/30 bg-amber-50/50 dark:bg-amber-500/10 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-sm text-amber-900 dark:text-amber-400 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-ping"></span>
                        Antrean Siswa Memerlukan Tanggapan
                    </h3>
                    <a href="{{ route('counselor.live-chat') }}" class="text-xs font-bold text-amber-800 dark:text-amber-300 hover:underline">Kelola Live Chat →</a>
                </div>

                <div class="space-y-2.5">
                    @foreach($waitingSessions as $ws)
                    <div class="p-4 rounded-xl bg-white dark:bg-gray-900 border border-amber-200/80 dark:border-gray-800 shadow-xs flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <h4 class="font-bold text-xs text-gray-900 dark:text-white truncate">{{ $ws->user->name }}</h4>
                                <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-success-50 text-success-600 dark:bg-success-500/20 dark:text-success-400">
                                    Kelas {{ $ws->user->studentProfile->kelas ?? '-' }}
                                </span>
                            </div>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 truncate">
                                NISN: {{ $ws->user->studentProfile->nisn ?? '-' }} • Menunggu {{ $ws->requested_at ? $ws->requested_at->diffForHumans() : 'baru saja' }}
                            </p>
                        </div>
                        <a href="{{ route('counselor.live-chat') }}" class="btn-primary text-xs px-4 py-1.5 shadow-xs font-semibold shrink-0">
                            Terima Sesi
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Riwayat Percakapan Siswa Terbaru --}}
            <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-6 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="font-bold text-base text-gray-900 dark:text-white">Log Konsultasi Siswa Terbaru</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Transkrip interaksi siswa dengan Chatbot AI &amp; Konselor BK</p>
                    </div>
                    <a href="{{ route('counselor.percakapan') }}" class="text-xs text-brand-500 font-semibold hover:underline">Semua Log →</a>
                </div>

                @if($recentSessions->isEmpty())
                <div class="text-center py-10 text-xs text-gray-400 dark:text-gray-500">
                    Belum ada riwayat percakapan yang tercatat.
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-gray-600 dark:text-gray-300">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-800 text-gray-400 dark:text-gray-500 font-semibold uppercase tracking-wider text-[10px]">
                                <th class="text-left pb-3 pr-3">Siswa</th>
                                <th class="text-left pb-3 pr-3">Topik / Judul</th>
                                <th class="text-left pb-3 pr-3">Tipe</th>
                                <th class="text-left pb-3 pr-3">Tanggal</th>
                                <th class="text-right pb-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach($recentSessions as $session)
                            <tr class="hover:bg-gray-50/70 dark:hover:bg-white/5 transition-colors">
                                <td class="py-3 pr-3 font-semibold text-gray-900 dark:text-white">
                                    {{ $session->user->name ?? 'Anonim' }}
                                </td>
                                <td class="py-3 pr-3 text-gray-600 dark:text-gray-400 max-w-[200px] truncate">
                                    {{ $session->title }}
                                </td>
                                <td class="py-3 pr-3">
                                    @if($session->type === 'human')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400">Live BK</span>
                                    @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-success-50 text-success-600 dark:bg-success-500/20 dark:text-success-400">Bot AI</span>
                                    @endif
                                </td>
                                <td class="py-3 pr-3 text-gray-500 dark:text-gray-400">
                                    {{ $session->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="py-3 text-right">
                                    <a href="{{ route('counselor.percakapan.detail', $session->id) }}"
                                       class="btn-secondary text-[11px] px-3 py-1 font-semibold">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

        </div>

        {{-- Right: Quick Action Hub & Quality Monitoring (4 Cols) --}}
        <div class="lg:col-span-4 space-y-6">

            {{-- Quick Action Hub --}}
            <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-6 shadow-xs">
                <h3 class="font-bold text-sm text-gray-900 dark:text-white mb-3">Aksi Cepat Guru BK</h3>
                <div class="space-y-2">
                    <a href="{{ route('counselor.live-chat') }}" class="flex items-center justify-between p-3 rounded-xl bg-amber-50/60 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/30 text-xs font-semibold text-amber-900 dark:text-amber-300 transition-all hover:scale-[1.01]">
                        <span class="flex items-center gap-2">
                            <span>👨‍🏫</span> Portal Live Chat Siswa
                        </span>
                        <span>→</span>
                    </a>
                    <a href="{{ route('counselor.knowledge-base') }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50 hover:bg-brand-50 dark:hover:bg-brand-500/10 border border-gray-200 dark:border-gray-800 text-xs font-semibold text-gray-900 dark:text-gray-200 hover:text-brand-500 transition-all">
                        <span class="flex items-center gap-2">
                            <span>📄</span> Upload Dokumen RAG (PDF)
                        </span>
                        <span>→</span>
                    </a>
                    <a href="{{ route('counselor.ebook') }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50 hover:bg-brand-50 dark:hover:bg-brand-500/10 border border-gray-200 dark:border-gray-800 text-xs font-semibold text-gray-900 dark:text-gray-200 hover:text-brand-500 transition-all">
                        <span class="flex items-center gap-2">
                            <span>📚</span> Tambah E-Book Digital ({{ $totalEbook }})
                        </span>
                        <span>→</span>
                    </a>
                    <a href="{{ route('counselor.artikel') }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50 hover:bg-brand-50 dark:hover:bg-brand-500/10 border border-gray-200 dark:border-gray-800 text-xs font-semibold text-gray-900 dark:text-gray-200 hover:text-brand-500 transition-all">
                        <span class="flex items-center gap-2">
                            <span>🌐</span> Impor Artikel Jurnal ({{ $totalArtikel }})
                        </span>
                        <span>→</span>
                    </a>
                    <a href="{{ route('counselor.tes') }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50 hover:bg-brand-50 dark:hover:bg-brand-500/10 border border-gray-200 dark:border-gray-800 text-xs font-semibold text-gray-900 dark:text-gray-200 hover:text-brand-500 transition-all">
                        <span class="flex items-center gap-2">
                            <span>📝</span> Kelola Tes &amp; Kuesioner ({{ $totalTes }})
                        </span>
                        <span>→</span>
                    </a>
                </div>
            </div>

            {{-- Monitoring Evaluasi Chatbot AI --}}
            <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-6 shadow-xs">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-bold text-sm text-gray-900 dark:text-white flex items-center gap-1.5">
                        <span>🔍</span> Evaluasi Respon AI
                    </h3>
                    <a href="{{ route('counselor.evaluasi') }}" class="text-[11px] text-brand-500 font-semibold hover:underline">Semua →</a>
                </div>

                @if($recentBadEvaluations->isEmpty())
                <p class="text-xs text-gray-400 dark:text-gray-500 text-center py-4">
                    Belum ada catatan evaluasi jawaban bot yang dilaporkan.
                </p>
                @else
                <div class="space-y-2.5">
                    @foreach($recentBadEvaluations as $eval)
                    <div class="p-3 rounded-xl bg-error-50/60 dark:bg-error-500/10 border border-error-200 dark:border-error-500/30 text-xs">
                        <div class="flex items-center justify-between text-[10px] text-error-700 dark:text-error-400 font-semibold mb-1">
                            <span>Evaluasi Negatif (Bad)</span>
                            <span>{{ $eval->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 text-[11px] line-clamp-2">"{{ $eval->note ?? 'Perlu perbaikan referensi materi.' }}"</p>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

        </div>

    </div>

</div>
@endsection
