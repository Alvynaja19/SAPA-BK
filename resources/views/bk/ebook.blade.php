@extends('layouts.tailadmin')

@section('title', 'Manajemen E-Book Bimbingan — SAPA BK')

@section('content')
<div class="space-y-6">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
        Manajemen E-Book & Modul BK
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
        Unggah dan kelola modul bimbingan karir, buku panduan PTN, serta modul kesehatan mental siswa.
      </p>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    
    <!-- Upload Form (4 cols) -->
    <div class="lg:col-span-4 rounded-3xl bg-white dark:bg-gray-900 p-6 sm:p-8 border border-gray-100 dark:border-gray-800 shadow-xs space-y-5 self-start">
      <div>
        <h2 class="text-base font-bold text-gray-900 dark:text-white">Unggah Modul E-Book Baru</h2>
        <p class="text-xs text-gray-400">Format yang didukung: PDF (Maksimal 20MB)</p>
      </div>

      <form method="POST" action="{{ route('bk.ebook.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Judul E-Book *</label>
          <input
            type="text"
            name="title"
            required
            placeholder="Contoh: Panduan Sukses SNBT 2026"
            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
          />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Deskripsi Singkat</label>
          <textarea
            name="description"
            rows="3"
            placeholder="Ringkasan isi e-book bimbingan..."
            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
          ></textarea>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">File PDF Dokumen *</label>
          <input
            type="file"
            name="file"
            accept=".pdf"
            required
            class="w-full px-3 py-2 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden"
          />
        </div>

        <div class="pt-1">
          <label class="flex items-center gap-2 cursor-pointer">
            <input
              type="checkbox"
              name="is_public"
              value="1"
              class="rounded text-brand-600 focus:ring-brand-500"
            />
            <span class="text-xs text-gray-600 dark:text-gray-300 font-medium">Tersedia untuk umum (tamu publik tanpa login)</span>
          </label>
        </div>

        <button
          type="submit"
          class="w-full py-3 px-4 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-md shadow-brand-500/20 transition-all"
        >
          Unggah Modul Sekarang
        </button>
      </form>
    </div>

    <!-- E-Book Table List (8 cols) -->
    <div class="lg:col-span-8 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs overflow-hidden">
      <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
        <h2 class="text-base font-bold text-gray-900 dark:text-white">Daftar E-Book Terunggah</h2>
        <span class="text-xs text-gray-400 font-semibold">Total: {{ $ebooks->total() }} Dokumen</span>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="border-b border-gray-100 dark:border-gray-800 text-[11px] font-bold text-gray-400 dark:text-gray-400 uppercase tracking-wider bg-gray-50/50 dark:bg-gray-800/30">
              <th class="py-3.5 px-6">Judul E-Book</th>
              <th class="py-3.5 px-6">Akses</th>
              <th class="py-3.5 px-6">Diunggah Oleh</th>
              <th class="py-3.5 px-6 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-xs text-gray-600 dark:text-gray-300">
            @forelse($ebooks as $eb)
              <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
                <td class="py-4 px-6 font-bold text-gray-900 dark:text-white max-w-xs truncate">
                  <div class="flex items-center gap-3">
                    <div class="h-8 w-8 rounded-xl bg-rose-50 text-rose-600 dark:bg-rose-950/60 dark:text-rose-400 flex items-center justify-center font-bold text-[11px] shrink-0">
                      PDF
                    </div>
                    <span class="truncate">{{ $eb->title }}</span>
                  </div>
                </td>
                <td class="py-4 px-6">
                  @if($eb->is_public)
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                      Publik
                    </span>
                  @else
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                      Khusus Siswa
                    </span>
                  @endif
                </td>
                <td class="py-4 px-6 text-gray-400">
                  {{ $eb->uploader?->name ?? 'Guru BK' }}
                </td>
                <td class="py-4 px-6 text-right">
                  <div class="flex items-center justify-end gap-2">
                    <a
                      href="{{ asset('storage/' . $eb->file_path) }}"
                      target="_blank"
                      class="px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold text-xs transition-colors"
                    >
                      Buka
                    </a>
                    <form method="POST" action="{{ route('bk.ebook.destroy', $eb->id) }}" onsubmit="return confirm('Hapus e-book ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/50 transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="py-8 text-center text-gray-400 text-xs">Belum ada e-book yang diunggah.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($ebooks->hasPages())
        <div class="p-6 border-t border-gray-100 dark:border-gray-800">
          {{ $ebooks->links() }}
        </div>
      @endif
    </div>

  </div>

</div>
@endsection
