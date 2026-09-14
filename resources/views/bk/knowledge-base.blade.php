@extends('layouts.tailadmin')

@section('title', 'Knowledge Base RAG — SAPA BK')

@section('content')
<div class="space-y-6">

  <!-- Header with RAG Pipeline Info (TailAdmin Theme) -->
  <div class="rounded-3xl bg-gradient-to-r from-[#1C2B18] via-brand-950 to-[#205A26] p-6 sm:p-8 text-white border border-[#B4DAB7]/20 shadow-xl space-y-3">
    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-brand-300 text-xs font-semibold backdrop-blur-md">
      <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
      <span>Retrieval-Augmented Generation (RAG) Architecture — SRS Bab 9</span>
    </div>
    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Basis Pengetahuan Resmi BK SMAN 4 Jember</h1>
    <p class="text-xs sm:text-sm text-gray-300 max-w-3xl leading-relaxed">
      Dokumen pedoman resmi BK, aturan pemilihan mapel Kurikulum Merdeka, serta pedoman SNPMB yang diunggah di sini diproses menjadi vektor embedding (ChromaDB) untuk memastikan respons Chatbot AI SAPA BK 100% akurat, kontekstual, dan berlandaskan sumber resmi sekolah.
    </p>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    
    <!-- Upload Knowledge Document (5 cols) -->
    <div class="lg:col-span-5 rounded-3xl bg-white dark:bg-gray-900 p-6 sm:p-8 border border-gray-100 dark:border-gray-800 shadow-xs space-y-5 self-start">
      <div>
        <h2 class="text-base font-bold text-gray-900 dark:text-white">Unggah Dokumen Pedoman Baru</h2>
        <p class="text-xs text-gray-400">Format yang didukung: PDF, DOCX, TXT (Maks. 10MB)</p>
      </div>

      <form method="POST" action="{{ route('bk.knowledge.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Judul Dokumen / Pedoman *</label>
          <input
            type="text"
            name="title"
            required
            placeholder="Contoh: Pedoman SNPMB 2026 Kemdikbud"
            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
          />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">File Berkas *</label>
          <input
            type="file"
            name="file"
            accept=".pdf,.docx,.txt"
            required
            class="w-full px-3 py-2 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden"
          />
        </div>

        <div class="p-4 rounded-2xl bg-brand-50 dark:bg-brand-950/40 border border-brand-100 dark:border-brand-800/60 text-xs text-brand-900 dark:text-brand-300 space-y-1 leading-relaxed">
          <strong class="block">Alur Pipeline RAG (SRS Bab 9.1):</strong>
          <p>Setelah diunggah, dokumen akan diparsing ke dalam chunk teks (512 token) dan diindeks ke ChromaDB untuk di-retrieve otomatis saat siswa bertanya.</p>
        </div>

        <button
          type="submit"
          class="w-full py-3 px-4 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-md shadow-brand-500/20 transition-all"
        >
          Unggah & Jadwalkan Sinkronisasi RAG
        </button>
      </form>
    </div>

    <!-- Knowledge Documents List (7 cols) -->
    <div class="lg:col-span-7 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs overflow-hidden">
      <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
        <h2 class="text-base font-bold text-gray-900 dark:text-white">Dokumen Terindeks dalam Basis AI</h2>
        <span class="text-xs text-gray-400 font-semibold">Total: {{ $documents->total() }} Dokumen</span>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="border-b border-gray-100 dark:border-gray-800 text-[11px] font-bold text-gray-400 dark:text-gray-400 uppercase tracking-wider bg-gray-50/50 dark:bg-gray-800/30">
              <th class="py-3.5 px-6">Nama Dokumen</th>
              <th class="py-3.5 px-6">Status Indeks</th>
              <th class="py-3.5 px-6">Diunggah Oleh</th>
              <th class="py-3.5 px-6 text-right">Berkas</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-xs text-gray-600 dark:text-gray-300">
            @forelse($documents as $doc)
              <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
                <td class="py-4 px-6 font-bold text-gray-900 dark:text-white max-w-xs truncate">
                  <div class="flex items-center gap-3">
                    <div class="h-8 w-8 rounded-xl bg-[#FEFBF0] text-[#7A5200] dark:bg-amber-950/60 dark:text-amber-300 border border-[#FBE9AE]/60 dark:border-amber-800/40 flex items-center justify-center font-bold text-[11px] shrink-0">
                      RAG
                    </div>
                    <span class="truncate">{{ $doc->title }}</span>
                  </div>
                </td>
                <td class="py-4 px-6">
                  @if($doc->status === 'indexed')
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                      <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Terindeks
                    </span>
                  @elseif($doc->status === 'pending')
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                      <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Menunggu RAG
                    </span>
                  @else
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300 border border-rose-200 dark:border-rose-800">
                      Gagal
                    </span>
                  @endif
                </td>
                <td class="py-4 px-6 text-gray-400">
                  {{ $doc->uploader?->name ?? 'Guru BK' }}
                </td>
                <td class="py-4 px-6 text-right">
                  <a
                    href="{{ asset('storage/' . $doc->file_path) }}"
                    target="_blank"
                    class="px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold text-xs transition-colors"
                  >
                    Unduh
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="py-8 text-center text-gray-400 text-xs">Belum ada dokumen knowledge base yang diunggah.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($documents->hasPages())
        <div class="p-6 border-t border-gray-100 dark:border-gray-800">
          {{ $documents->links() }}
        </div>
      @endif
    </div>

  </div>

</div>
@endsection
