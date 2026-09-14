@extends('layouts.tailadmin')

@section('title', 'Evaluasi Respons AI — SAPA BK')

@section('content')
<div class="space-y-6">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
        Evaluasi Respons AI (SRS F-48)
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
        Tinjau dan beri rating akurasi jawaban chatbot bimbingan konseling untuk meningkatkan kualitas RAG Pipeline.
      </p>
    </div>
  </div>

  <!-- Messages & Evaluation Cards -->
  <div class="rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs overflow-hidden">
    <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
      <h2 class="text-base font-bold text-gray-900 dark:text-white">Daftar Respons AI yang Memerlukan Supervisi</h2>
      <span class="text-xs text-gray-400 font-semibold">Total: {{ isset($messages) ? $messages->total() : 0 }} Pesan</span>
    </div>

    <div class="divide-y divide-gray-100 dark:divide-gray-800">
      @forelse($messages as $msg)
        <div class="p-6 space-y-4 hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
          
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div class="flex items-center gap-2.5">
              <div class="h-8 w-8 rounded-xl bg-[#FEFBF0] text-[#7A5200] dark:bg-amber-950/60 dark:text-amber-300 border border-[#FBE9AE]/60 dark:border-amber-800/40 font-bold flex items-center justify-center text-xs">
                AI
              </div>
              <span class="font-bold text-xs text-gray-900 dark:text-white">
                Sesi: {{ $msg->session?->title ?? 'Sesi Percakapan' }}
              </span>
              <span class="text-[11px] text-gray-400">
                ({{ $msg->session?->user?->name ?? 'Tamu Siswa' }})
              </span>
            </div>

            <div class="flex items-center gap-2">
              @if($msg->evaluation)
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold {{ $msg->evaluation->rating === 'good' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800' : 'bg-rose-50 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300 border border-rose-200 dark:border-rose-800' }}">
                  Rating: {{ strtoupper($msg->evaluation->rating) }}
                </span>
              @else
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                  Belum Dinilai
                </span>
              @endif
              <span class="text-[11px] text-gray-400">{{ $msg->created_at->diffForHumans() }}</span>
            </div>
          </div>

          <!-- Pesan AI -->
          <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-800/60 border border-gray-100 dark:border-gray-800 text-xs sm:text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
            <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">
              Jawaban AI (Model: {{ $msg->metadata['model'] ?? 'Gemini 2.0 Flash' }}):
            </span>
            {{ $msg->content }}
          </div>

          <!-- Catatan Sebelumnya jika ada -->
          @if($msg->evaluation && $msg->evaluation->note)
            <div class="p-3 rounded-xl bg-brand-50/60 dark:bg-brand-950/30 border border-brand-100 dark:border-brand-800 text-xs text-brand-900 dark:text-brand-300">
              <strong class="font-semibold">Catatan Evaluasi Konselor:</strong> {{ $msg->evaluation->note }}
            </div>
          @endif

          <!-- Evaluasi Form -->
          <form method="POST" action="{{ route('bk.evaluasi.store', $msg->id) }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 pt-1">
            @csrf
            <input
              type="text"
              name="note"
              placeholder="Berikan catatan koreksi / materi pendukung (opsional)..."
              value="{{ $msg->evaluation->note ?? '' }}"
              class="grow px-3.5 py-2 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
            />
            <div class="flex items-center gap-2">
              <button
                type="submit"
                name="rating"
                value="good"
                class="px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs transition-colors shadow-xs"
              >
                👍 Jawaban Baik
              </button>
              <button
                type="submit"
                name="rating"
                value="bad"
                class="px-4 py-2 rounded-xl bg-rose-500 hover:bg-rose-600 text-white font-bold text-xs transition-colors shadow-xs"
              >
                👎 Perlu Perbaikan
              </button>
            </div>
          </form>

        </div>
      @empty
        <div class="p-12 text-center text-gray-400 text-xs">Belum ada percakapan AI yang dapat dievaluasi.</div>
      @endforelse
    </div>

    @if(isset($messages) && $messages->hasPages())
      <div class="p-6 border-t border-gray-100 dark:border-gray-800">
        {{ $messages->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
