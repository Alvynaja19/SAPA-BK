@extends('layouts.tailadmin')

@section('title', "Transkrip Percakapan — {$session->title}")

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

  <!-- Back Link -->
  <div class="flex items-center justify-between">
    <a href="{{ route('bk.percakapan') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-400 transition-colors">
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
      <span>Kembali ke Daftar Percakapan</span>
    </a>

    <a
      href="{{ route('bk.live-chat') }}"
      class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-semibold text-xs shadow-md shadow-brand-500/20 transition-all"
    >
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
      <span>Buka Live Chat Konseling</span>
    </a>
  </div>

  <!-- Session Header Card -->
  <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs space-y-2">
    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-brand-50 text-brand-700 dark:bg-brand-950/60 dark:text-brand-300 border border-brand-200 dark:border-brand-800 uppercase">
      Transkrip Sesi Konsultasi
    </span>
    <h1 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white">{{ $session->title }}</h1>
    <p class="text-xs text-gray-500 dark:text-gray-400">
      Siswa: <strong class="text-gray-800 dark:text-gray-200">{{ $session->user?->name ?? 'Anonim' }}</strong> 
      @if($session->user?->kelas)
        ({{ $session->user->kelas }})
      @endif
      • Waktu mulai: {{ $session->created_at->format('d F Y, H:i') }}
    </p>
  </div>

  <!-- Messages Stream -->
  <div class="space-y-4">
    @foreach($session->messages as $msg)
      <div class="rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs p-6 space-y-4">
        
        <!-- Message Sender Header -->
        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-3">
          <div class="flex items-center gap-3">
            <div class="h-8 w-8 rounded-xl font-bold flex items-center justify-center text-xs {{ $msg->role === 'user' ? 'bg-brand-50 text-brand-600 dark:bg-brand-950/60 dark:text-brand-400' : 'bg-[#FEFBF0] text-[#7A5200] dark:bg-amber-950/60 dark:text-amber-300 border border-[#FBE9AE]/60 dark:border-amber-800/40' }}">
              {{ $msg->role === 'user' ? 'S' : 'AI' }}
            </div>
            <span class="font-bold text-xs text-gray-900 dark:text-white capitalize">
              {{ $msg->role === 'user' ? ($session->user?->name ?? 'Siswa') : 'Asisten AI SAPA BK' }}
            </span>
          </div>
          <span class="text-[11px] text-gray-400">{{ $msg->created_at->format('H:i:s') }}</span>
        </div>

        <!-- Content -->
        <div class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
          {{ $msg->content }}
        </div>

        <!-- Evaluasi Block for Assistant message -->
        @if($msg->role === 'assistant')
          <div class="pt-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/60 dark:bg-gray-800/40 -mx-6 -mb-6 p-6 rounded-b-3xl space-y-3">
            <div class="flex items-center justify-between">
              <span class="text-xs font-bold text-gray-700 dark:text-gray-300">Evaluasi Guru BK terhadap Jawaban Ini:</span>
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
                <button type="submit" name="rating" value="good" class="px-3 py-1.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs transition-colors">
                  👍 Baik
                </button>
                <button type="submit" name="rating" value="bad" class="px-3 py-1.5 rounded-xl bg-rose-500 hover:bg-rose-600 text-white font-bold text-xs transition-colors">
                  👎 Kurang Tepat
                </button>
              </div>
            </form>
          </div>
        @endif

      </div>
    @endforeach
  </div>

</div>
@endsection
