@extends('layouts.admin')

@section('title', 'Manajemen Artikel BK')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Manajemen Artikel Bimbingan Konseling</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Kelola artikel edukasi internal dan eksplorasi rujukan artikel publik dari Crossref & OpenAlex API.
            </p>
        </div>
    </div>

    <!-- Modal Form Tambah Artikel Manual -->
    <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">✍️ Tulis Artikel Baru</h3>
        <form action="{{ route('counselor.artikel.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Judul Artikel</label>
                    <input type="text" name="title" required placeholder="Contoh: Strategi Mengatasi Kecemasan Ujian"
                           class="w-full px-3.5 py-2.5 rounded-xl border text-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Gambar Thumbnail (Opsional)</label>
                    <input type="file" name="thumbnail" accept="image/*"
                           class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Isi Konten Artikel</label>
                <textarea name="content" rows="4" required placeholder="Tuliskan materi bimbingan konseling..."
                          class="w-full px-3.5 py-2.5 rounded-xl border text-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:outline-none"></textarea>
            </div>
            <div class="flex items-center justify-between pt-2">
                <label class="inline-flex items-center gap-2 cursor-pointer text-sm text-slate-700 dark:text-slate-300">
                    <input type="checkbox" name="is_published" value="1" checked class="rounded text-emerald-600 focus:ring-emerald-500">
                    <span>Publikasikan Langsung</span>
                </label>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-5 py-2 rounded-xl text-xs shadow-md transition-all">
                    Simpan & Publikasikan
                </button>
            </div>
        </form>
    </div>

    <!-- Section 1: Daftar Artikel Internal -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden shadow-sm">
        <div class="p-5 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 dark:text-white text-base">📗 Artikel Internal SAPA BK</h3>
            <span class="text-xs text-slate-500">Total: {{ $articles->total() }} artikel</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/50 text-slate-500 dark:text-slate-400 text-xs uppercase font-semibold">
                        <th class="p-4">Judul Artikel</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Tanggal Dibuat</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60">
                    @forelse($articles as $art)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="p-4 font-semibold text-slate-800 dark:text-slate-200">
                            {{ $art->title }}
                        </td>
                        <td class="p-4">
                            @if($art->is_published)
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-400">Dipublikasi</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400">Draft</span>
                            @endif
                        </td>
                        <td class="p-4 text-xs text-slate-500 dark:text-slate-400">
                            {{ $art->created_at ? $art->created_at->format('d M Y H:i') : '-' }}
                        </td>
                        <td class="p-4 text-right">
                            <form action="{{ route('counselor.artikel.destroy', $art->id) }}" method="POST" onsubmit="return confirm('Yakin hapus artikel ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-800 dark:text-rose-400">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-400 text-sm">Belum ada artikel yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100 dark:border-slate-700">
            {{ $articles->links() }}
        </div>
    </div>

    <!-- Section 2: Integrasi Rujukan Artikel Publik API -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-teal-100 text-teal-800 dark:bg-teal-950/80 dark:text-teal-300 mb-1">
                    🌐 LIVE OPEN API (Crossref & OpenAlex)
                </span>
                <h3 class="font-bold text-slate-800 dark:text-white text-lg">Rujukan Artikel Ilmiah BK Terbuka</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Impor referensi artikel ilmiah dari publikasi terbuka untuk disajikan kepada siswa.</p>
            </div>
            <form action="{{ route('counselor.artikel') }}" method="GET" class="flex gap-2">
                <input type="text" name="q" value="{{ $searchQuery }}" placeholder="Cari topik..."
                       class="px-3 py-1.5 rounded-xl border text-xs dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                <button type="submit" class="bg-teal-600 text-white px-3 py-1.5 rounded-xl text-xs font-semibold">Cari API</button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($publicArticles['data'] as $pubItem)
            <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/40 flex flex-col justify-between">
                <div>
                    <span class="text-[10px] font-bold text-teal-600 dark:text-teal-400 uppercase">
                        {{ $pubItem['source'] }} API • {{ $pubItem['year'] ?? 'Terbaru' }}
                    </span>
                    <h4 class="font-bold text-sm text-slate-800 dark:text-white mt-1 line-clamp-2">{{ $pubItem['title'] }}</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">✍️ {{ $pubItem['author'] }}</p>
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 italic mt-2 line-clamp-2">"{{ $pubItem['abstract'] }}"</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-200 dark:border-slate-700/60 flex items-center justify-between">
                    <a href="{{ $pubItem['url'] }}" target="_blank" class="text-xs text-teal-600 dark:text-teal-400 font-semibold hover:underline">Link Asli &rarr;</a>
                    <form action="{{ route('counselor.artikel.import') }}" method="POST">
                        @csrf
                        <input type="hidden" name="title" value="{{ $pubItem['title'] }}">
                        <input type="hidden" name="author" value="{{ $pubItem['author'] }}">
                        <input type="hidden" name="journal" value="{{ $pubItem['journal'] }}">
                        <input type="hidden" name="url" value="{{ $pubItem['url'] }}">
                        <input type="hidden" name="abstract" value="{{ $pubItem['abstract'] }}">
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-semibold px-3 py-1.5 rounded-lg shadow-sm">
                            📥 Impor ke SAPA BK
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
