@extends('layouts.tailadmin')

@section('title', ($session->mode === 'guru_bk' ? 'Transkrip Live Chat: ' : 'Transkrip Chatbot AI: ') . $session->title . ' - SAPA BK')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

  <!-- Back Link & Action -->
  <div class="flex items-center justify-between gap-4">
    @if($session->mode === 'guru_bk')
      <a href="{{ route('bk.live-chat.riwayat') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-400 transition-colors">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        <span>Kembali ke Riwayat Live Chat BK</span>
      </a>
    @else
      <a href="{{ route('bk.percakapan') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-400 transition-colors">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        <span>Kembali ke Riwayat Chatbot AI</span>
      </a>
    @endif

    @if($session->mode === 'guru_bk' && $session->status === 'active')
      <a
        href="{{ route('bk.live-chat') }}"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs shadow-md shadow-emerald-600/20 transition-all shrink-0"
      >
        <span class="relative flex h-2 w-2">
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
          <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
        </span>
        <span>Masuk ke Ruang Live Chat Aktif</span>
      </a>
    @endif
  </div>

  <!-- Session Header Card -->
  <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs space-y-3">
    <div class="flex items-center gap-2 flex-wrap">
      @if($session->mode === 'guru_bk')
        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 border border-blue-200 dark:border-blue-800 uppercase">
          Sesi Konseling Live Chat Guru BK
        </span>
        @if($session->status === 'active')
          <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
            Sedang Berlangsung (Aktif)
          </span>
        @else
          <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700">
            Selesai / Terkunci
          </span>
        @endif
      @else
        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 uppercase">
          Transkrip Chatbot AI (Gemini)
        </span>
      @endif
    </div>

    <h1 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white">{{ $session->title ?: 'Sesi Konseling' }}</h1>
    
    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-gray-500 dark:text-gray-400">
      <span>
        Siswa: <strong class="text-gray-800 dark:text-gray-200">{{ $session->user?->name ?? 'Anonim' }}</strong>
        @if($session->user?->kelas)
          ({{ $session->user->kelas }})
        @endif
      </span>

      @if($session->mode === 'guru_bk')
        <span>•</span>
        <span>
          Guru Pembimbing: <strong class="text-gray-800 dark:text-gray-200">{{ $session->teacher?->name ?? 'Guru BK' }}</strong>
        </span>
      @endif

      <span>•</span>
      <span>Mulai: {{ $session->created_at->format('d F Y, H:i') }} WIB</span>

      @if($session->closed_at)
        <span>•</span>
        <span>Selesai: {{ $session->closed_at->format('d F Y, H:i') }} WIB</span>
      @endif
    </div>
  </div>

  <!-- Messages Stream -->
  <div class="space-y-4">
    @forelse($session->messages as $msg)
      <div class="rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs p-6 space-y-4">
        
        <!-- Message Sender Header -->
        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-3">
          <div class="flex items-center gap-3">
            @if($msg->role === 'user')
              <div class="h-8 w-8 rounded-xl font-bold flex items-center justify-center text-xs bg-brand-50 text-brand-600 dark:bg-brand-950/60 dark:text-brand-400 border border-brand-200/50 dark:border-brand-800/40">
                S
              </div>
              <span class="font-bold text-xs text-gray-900 dark:text-white capitalize">
                {{ $session->user?->name ?? 'Siswa' }}
              </span>
            @elseif($msg->role === 'counselor')
              <div class="h-8 w-8 rounded-xl font-bold flex items-center justify-center text-xs bg-blue-50 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400 border border-blue-200/50 dark:border-blue-800/40">
                BK
              </div>
              <span class="font-bold text-xs text-gray-900 dark:text-white">
                {{ $session->teacher?->name ?? 'Guru BK' }}
              </span>
            @else
              <div class="h-8 w-8 rounded-xl font-bold flex items-center justify-center text-xs bg-amber-50 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-200/60 dark:border-amber-800/40">
                AI
              </div>
              <span class="font-bold text-xs text-gray-900 dark:text-white">
                Asisten Cerdas AI (Gemini)
              </span>
            @endif
          </div>
          <span class="text-[11px] text-gray-400">{{ $msg->created_at->format('H:i:s') }} WIB</span>
        </div>

        <!-- Content -->
        <div class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">
          {{ $msg->content }}
        </div>

        <!-- Evaluasi Block for Assistant (AI) message only -->
        @if($msg->role === 'assistant')
          <div class="pt-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/60 dark:bg-gray-800/40 -mx-6 -mb-6 p-6 rounded-b-3xl space-y-3">
            <div class="flex items-center justify-between">
              <span class="text-xs font-bold text-gray-700 dark:text-gray-300">Evaluasi Guru BK terhadap Jawaban AI Ini:</span>
              @if($msg->evaluation)
                <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full {{ $msg->evaluation->rating === 'good' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300' : 'bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-950/60 dark:text-rose-300' }}">
                  Rating: {{ strtoupper($msg->evaluation->rating) }}
                </span>
              @endif
            </div>

            @if($msg->evaluation && $msg->evaluation->note)
              <p class="text-xs text-gray-500 dark:text-gray-400 italic">"{{ $msg->evaluation->note }}"</p>
            @endif

            <form method="POST" action="{{ route('bk.evaluasi.store', $msg->id) }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 pt-1">
              @csrf
              <input
                type="text"
                name="note"
                placeholder="Tambah catatan koreksi Guru BK (opsional)..."
                value="{{ $msg->evaluation->note ?? '' }}"
                class="grow px-3 py-1.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-hidden"
              />
              <div class="flex items-center gap-1.5">
                <button type="submit" name="rating" value="good" class="px-3 py-1.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs transition-colors cursor-pointer">
                  👍 Baik
                </button>
                <button type="submit" name="rating" value="bad" class="px-3 py-1.5 rounded-xl bg-rose-500 hover:bg-rose-600 text-white font-bold text-xs transition-colors cursor-pointer">
                  👎 Kurang Tepat
                </button>
              </div>
            </form>
          </div>
        @endif

      </div>
    @empty
      <div class="p-12 text-center text-gray-400 text-xs rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800">
        Belum ada dialog pesan dalam sesi ini.
      </div>
    @endforelse
  </div>

</div>
@endsection
