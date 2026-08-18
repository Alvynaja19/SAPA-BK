@extends('layouts.student')

@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard Siswa')

@section('content')
<div class="space-y-6">

    <!-- Greeting Hero Banner -->
    <div class="bg-gradient-to-r from-[#047857] via-[#059669] to-[#10B981] p-6 sm:p-8 rounded-3xl text-white shadow-xl shadow-[#059669]/20 relative overflow-hidden flex flex-col sm:flex-row sm:items-center justify-between gap-6 border border-emerald-400/30">
        <div class="absolute top-0 right-0 w-80 h-80 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 text-white text-[11px] font-bold backdrop-blur-md mb-3 border border-white/25">
                <span class="w-2 h-2 rounded-full bg-emerald-300 animate-ping"></span> Portal Pendamping Digital Siswa
            </span>
            <h2 class="font-sora text-2xl sm:text-3xl font-extrabold tracking-tight mb-2">
                Halo, {{ auth()->user()->name }}! 👋
            </h2>
            <p class="text-emerald-100 text-xs sm:text-sm leading-relaxed">
                Ada hal seputar jurusan PTN, kebingungan cara belajar, atau kesehatan mental yang ingin kamu diskusikan hari ini? Asisten AI BK siap mendampingimu 24/7.
            </p>
        </div>

        <div class="relative z-10 shrink-0">
            <a href="{{ route('student.chat') }}" class="btn-white text-sm px-6 py-3.5 shadow-lg flex items-center justify-center gap-2">
                <svg class="w-5 h-5 text-[#059669]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                Mulai Konsultasi AI
            </a>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card p-5 flex items-center gap-4 border border-slate-200/80">
            <div class="w-12 h-12 rounded-2xl bg-[#ECFDF5] text-[#059669] flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            </div>
            <div>
                <p class="font-sora text-2xl font-extrabold text-[#0F172A]">{{ $sessions->count() }}</p>
                <p class="text-xs text-slate-500 font-medium">Sesi Konsultasi</p>
            </div>
        </div>

        <div class="card p-5 flex items-center gap-4 border border-slate-200/80">
            <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <div>
                <p class="font-sora text-2xl font-extrabold text-[#0F172A]">{{ $ebooks->count() }}</p>
                <p class="text-xs text-slate-500 font-medium">E-Book Digital</p>
            </div>
        </div>

        <div class="card p-5 flex items-center gap-4 border border-slate-200/80">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div>
                <p class="font-sora text-2xl font-extrabold text-[#0F172A]">{{ $questionnaires->count() }}</p>
                <p class="text-xs text-slate-500 font-medium">Tes Psikologi</p>
            </div>
        </div>

        <div class="card p-5 flex items-center gap-4 border border-slate-200/80">
            <div class="w-12 h-12 rounded-2xl bg-[#ECFDF5] text-[#059669] flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="font-sora text-xs font-bold text-[#0F172A] truncate">
                    {{ $sessions->first() ? $sessions->first()->created_at->diffForHumans() : 'Belum Ada' }}
                </p>
                <p class="text-xs text-slate-500 font-medium">Sesi Terakhir</p>
            </div>
        </div>
    </div>

    <!-- Content Split Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Percakapan Terakhir -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-sora font-bold text-[#0F172A] text-base">Percakapan Terakhir</h3>
                <a href="{{ route('student.riwayat') }}" class="text-xs text-[#059669] font-bold hover:underline">Lihat Semua →</a>
            </div>

            <div class="space-y-3">
                @forelse($sessions as $session)
                <div class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 border border-slate-100 hover:bg-[#ECFDF5]/50 transition-colors">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-xl bg-[#ECFDF5] text-[#059669] flex items-center justify-center shrink-0 font-bold">
                            💬
                        </div>
                        <div class="min-w-0">
                            <p class="font-sora text-xs font-bold text-[#0F172A] truncate">{{ $session->title }}</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">{{ $session->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    <a href="{{ route('student.chat.session', $session->id) }}"
                       class="btn-secondary text-xs px-3.5 py-1.5 shrink-0 ml-2">Buka Chat</a>
                </div>
                @empty
                <div class="text-center py-10">
                    <div class="w-14 h-14 rounded-full bg-[#ECFDF5] text-[#059669] flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <p class="text-xs font-semibold text-[#0F172A] mb-1">Belum Ada Percakapan</p>
                    <p class="text-xs text-slate-500 mb-4">Mulai sesi konsultasi pertamamu sekarang.</p>
                    <a href="{{ route('student.chat') }}" class="btn-primary text-xs px-5 py-2">Mulai Konsultasi</a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- E-book Rekomendasi -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-sora font-bold text-[#0F172A] text-base">E-Book Tersedia</h3>
                <a href="{{ route('student.ebook') }}" class="text-xs text-[#059669] font-bold hover:underline">Lihat Semua →</a>
            </div>

            <div class="space-y-3">
                @forelse($ebooks as $ebook)
                <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-slate-50 border border-slate-100 hover:bg-[#ECFDF5]/50 transition-colors">
                    <div class="w-10 h-12 rounded-xl bg-gradient-to-tr from-[#047857] to-[#10B981] text-white flex items-center justify-center shrink-0 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-sora text-xs font-bold text-[#0F172A] truncate">{{ $ebook->title }}</p>
                        <p class="text-[11px] text-slate-500 truncate mt-0.5">{{ Str::limit($ebook->description, 45) }}</p>
                    </div>
                    <a href="{{ route('student.ebook') }}" class="badge-green shrink-0 text-[10px] font-bold">Baca</a>
                </div>
                @empty
                <div class="text-center py-10 text-xs text-slate-500">Belum ada e-book tersedia.</div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection

