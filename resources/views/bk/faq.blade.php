@extends('layouts.tailadmin')

@section('title', 'Manajemen FAQ — SAPA BK')

@section('content')
<div class="space-y-6">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
        Manajemen FAQ Publik (SRS F-49)
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
        Kelola daftar tanya-jawab populer yang tampil pada landing page portal SAPA BK.
      </p>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    
    <!-- Add FAQ Form (5 cols) -->
    <div class="lg:col-span-5 rounded-3xl bg-white dark:bg-gray-900 p-6 sm:p-8 border border-gray-100 dark:border-gray-800 shadow-xs space-y-5 self-start">
      <div>
        <h2 class="text-base font-bold text-gray-900 dark:text-white">Tambah Pertanyaan FAQ</h2>
        <p class="text-xs text-gray-400">Informasikan solusi cepat seputar layanan bimbingan konseling sekolah.</p>
      </div>

      <form method="POST" action="{{ route('bk.faq.store') }}" class="space-y-4">
        @csrf

        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Pertanyaan Siswa *</label>
          <input
            type="text"
            name="question"
            required
            placeholder="Contoh: Bagaimana prosedur konseling tatap muka?"
            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
          />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Jawaban Konselor BK *</label>
          <textarea
            name="answer"
            rows="5"
            required
            placeholder="Tuliskan jawaban yang ramah, informatif, dan menenangkan bagi siswa..."
            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
          ></textarea>
        </div>

        <button
          type="submit"
          class="w-full py-3 px-4 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-md shadow-brand-500/20 transition-all"
        >
          Simpan FAQ Baru
        </button>
      </form>
    </div>

    <!-- FAQ Table List (7 cols) -->
    <div class="lg:col-span-7 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs overflow-hidden">
      <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
        <h2 class="text-base font-bold text-gray-900 dark:text-white">Daftar FAQ Aktif</h2>
        <span class="text-xs text-gray-400 font-semibold">Total: {{ $faqs->total() }} FAQ</span>
      </div>

      <div class="divide-y divide-gray-100 dark:divide-gray-800">
        @forelse($faqs as $f)
          <div class="p-5 sm:p-6 space-y-2 hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $f->question }}</h3>
            <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed">{{ $f->answer }}</p>
            <div class="flex items-center gap-2 pt-1 text-[11px] text-gray-400">
              <span>Urutan: #{{ $f->order }}</span>
              <span>•</span>
              <span class="text-emerald-600 dark:text-emerald-400 font-semibold">Tampil di Beranda</span>
            </div>
          </div>
        @empty
          <div class="p-12 text-center text-gray-400 text-xs">Belum ada FAQ yang ditambahkan.</div>
        @endforelse
      </div>

      @if($faqs->hasPages())
        <div class="p-6 border-t border-gray-100 dark:border-gray-800">
          {{ $faqs->links() }}
        </div>
      @endif
    </div>

  </div>

</div>
@endsection
