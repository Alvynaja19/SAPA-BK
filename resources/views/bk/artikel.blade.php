@extends('layouts.tailadmin')

@section('title', 'Manajemen Artikel BK — SAPA BK')

@section('content')
<div class="space-y-6">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
        Artikel & Edukasi Bimbingan
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
        Publikasikan panduan belajar, artikel kesehatan mental remaja, dan info kelanjutan studi SMAN 4 Jember.
      </p>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    
    <!-- Write Article Form (5 cols) -->
    <div class="lg:col-span-5 rounded-3xl bg-white dark:bg-gray-900 p-6 sm:p-8 border border-gray-100 dark:border-gray-800 shadow-xs space-y-5 self-start">
      <div>
        <h2 class="text-base font-bold text-gray-900 dark:text-white">Tulis Artikel Baru</h2>
        <p class="text-xs text-gray-400">Tampil otomatis di landing page publik dan beranda siswa.</p>
      </div>

      <form method="POST" action="{{ route('bk.artikel.store') }}" class="space-y-4">
        @csrf

        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Judul Artikel *</label>
          <input
            type="text"
            name="title"
            required
            placeholder="Contoh: 5 Tips Mengatasi Burnout Belajar Menjelang Ujian"
            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
          />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Isi / Konten Artikel *</label>
          <textarea
            name="content"
            rows="6"
            required
            placeholder="Tulis uraian materi edukasi bimbingan konseling di sini..."
            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
          ></textarea>
        </div>

        <div class="pt-1">
          <label class="flex items-center gap-2 cursor-pointer">
            <input
              type="checkbox"
              name="is_published"
              value="1"
              checked
              class="rounded text-brand-600 focus:ring-brand-500"
            />
            <span class="text-xs text-gray-600 dark:text-gray-300 font-medium">Langsung Terbitkan ke Publik</span>
          </label>
        </div>

        <button
          type="submit"
          class="w-full py-3 px-4 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-md shadow-brand-500/20 transition-all"
        >
          Terbitkan Artikel Sekarang
        </button>
      </form>
    </div>

    <!-- Article Table List (7 cols) -->
    <div class="lg:col-span-7 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs overflow-hidden">
      <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
        <h2 class="text-base font-bold text-gray-900 dark:text-white">Daftar Artikel BK</h2>
        <span class="text-xs text-gray-400 font-semibold">Total: {{ $articles->total() }} Artikel</span>
      </div>

      <div class="divide-y divide-gray-100 dark:divide-gray-800">
        @forelse($articles as $art)
          <div class="p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
            <div class="space-y-1 max-w-md">
              <div class="flex items-center gap-2">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white line-clamp-1">{{ $art->title }}</h3>
                <span class="text-[10px] px-2 py-0.5 rounded-full font-bold {{ $art->is_published ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300' : 'bg-gray-100 text-gray-600' }}">
                  {{ $art->is_published ? 'Terbit' : 'Draf' }}
                </span>
              </div>
              <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">
                {{ Str::limit(strip_tags($art->content), 120) }}
              </p>
              <span class="text-[11px] text-gray-400 block pt-1">
                Oleh {{ $art->author?->name ?? 'Guru BK' }} • {{ $art->created_at->format('d M Y') }}
              </span>
            </div>

            <div class="flex items-center gap-2 shrink-0 self-end sm:self-center">
              <a
                href="{{ route('article.detail', $art->slug) }}"
                target="_blank"
                class="px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-semibold transition-colors"
              >
                Lihat
              </a>
              <form method="POST" action="{{ route('bk.artikel.destroy', $art->id) }}" onsubmit="return confirm('Hapus artikel ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/50 transition-colors">
                  <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </button>
              </form>
            </div>
          </div>
        @empty
          <div class="p-12 text-center text-gray-400 text-xs">Belum ada artikel yang ditulis.</div>
        @endforelse
      </div>

      @if($articles->hasPages())
        <div class="p-6 border-t border-gray-100 dark:border-gray-800">
          {{ $articles->links() }}
        </div>
      @endif
    </div>

  </div>

</div>
@endsection
