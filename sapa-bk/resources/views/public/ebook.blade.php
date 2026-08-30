@extends('layouts.public')

@section('title', 'Perpustakaan E-Book')

@section('content')

{{-- ===== HERO SEARCH & HEADER ===== --}}
<section class="bg-gradient-to-b from-[#ECFDF5]/80 via-white to-[#F8FAFC] dark:from-emerald-950/80 dark:via-slate-900 dark:to-slate-950 pt-24 sm:pt-28 pb-14 sm:pb-16 border-b border-slate-200/60 dark:border-slate-800 relative overflow-hidden">
    <div class="absolute top-0 right-1/3 w-96 h-96 hero-glow-1 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <!-- Breadcrumbs -->
        <nav class="flex items-center justify-center gap-2 text-xs font-semibold text-[#059669] dark:text-emerald-400 mb-4">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a>
            <span>/</span>
            <span class="text-slate-400 dark:text-slate-500">E-Book</span>
        </nav>

        <span class="pill-badge mb-4">Pustaka Digital SMAN 4 Jember</span>
        <h1 class="font-sora text-3xl sm:text-5xl font-extrabold text-[#0F172A] dark:text-white tracking-tight leading-tight mb-4">
            Perpustakaan & Literasi Digital BK
        </h1>
        <p class="text-[#475569] dark:text-slate-300 text-base sm:text-lg leading-relaxed max-w-2xl mx-auto mb-8">
            Temukan koleksi e-book psikologi, tips motivasi belajar, panduan memilih jurusan PTN, dan pengembangan diri gratis.
        </p>

        <!-- Search Bar Form -->
        <form action="{{ route('ebook.public') }}" method="GET" class="max-w-xl mx-auto flex items-center gap-2">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text"
                       name="q"
                       value="{{ request('q') }}"
                       placeholder="Cari judul e-book, topik, atau kata kunci..."
                       class="form-input pl-11 pr-4 py-3.5 shadow-sm text-sm rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:border-[#059669]">
            </div>
            <button type="submit" class="btn-primary shrink-0 text-sm px-7 py-3.5">
                Cari
            </button>
        </form>

        <!-- Category Pills (Visual Filter Options) -->
        <div class="flex items-center justify-center flex-wrap gap-2 mt-6">
            <a href="{{ route('ebook.public') }}"
               class="px-4 py-1.5 rounded-full text-xs font-semibold transition-colors
                      {{ !request('q') ? 'bg-[#059669] text-white shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-[#ECFDF5] hover:text-[#059669] dark:hover:bg-emerald-950 dark:hover:text-emerald-400' }}">
                Semua E-Book
            </a>
            <a href="{{ route('ebook.public', ['q' => 'Mental']) }}"
               class="px-4 py-1.5 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-[#ECFDF5] hover:text-[#059669] dark:hover:bg-emerald-950 dark:hover:text-emerald-400 transition-colors">
                Kesehatan Mental
            </a>
            <a href="{{ route('ebook.public', ['q' => 'Karir']) }}"
               class="px-4 py-1.5 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-[#ECFDF5] hover:text-[#059669] dark:hover:bg-emerald-950 dark:hover:text-emerald-400 transition-colors">
                Panduan Karir & PTN
            </a>
            <a href="{{ route('ebook.public', ['q' => 'Motivasi']) }}"
               class="px-4 py-1.5 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-[#ECFDF5] hover:text-[#059669] dark:hover:bg-emerald-950 dark:hover:text-emerald-400 transition-colors">
                Motivasi Belajar
            </a>
            <a href="{{ route('ebook.public', ['q' => 'Pengembangan']) }}"
               class="px-4 py-1.5 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-[#ECFDF5] hover:text-[#059669] dark:hover:bg-emerald-950 dark:hover:text-emerald-400 transition-colors">
                Pengembangan Diri
            </a>
        </div>
    </div>
</section>

{{-- ===== KATALOG E-BOOK ===== --}}
<section class="py-16 bg-white dark:bg-slate-900 min-h-[500px]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(request('q'))
            <div class="mb-8 flex items-center justify-between">
                <p class="text-sm text-slate-600 dark:text-slate-300">
                    Menampilkan hasil pencarian untuk "<strong class="text-[#059669] dark:text-emerald-400">{{ request('q') }}</strong>"
                </p>
                <a href="{{ route('ebook.public') }}" class="text-xs font-bold text-red-500 hover:underline flex items-center gap-1">
                    ✕ Hapus Pencarian
                </a>
            </div>
        @endif

        @if($ebooks->isEmpty())
            <!-- Empty State -->
            <div class="card p-12 text-center max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <h3 class="font-sora font-bold text-lg text-[#0F172A] dark:text-white mb-2">E-Book Tidak Ditemukan</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed mb-6">
                    Maaf, belum ada e-book yang cocok dengan pencarianmu. Coba gunakan kata kunci lain atau jelajahi kategori e-book publik.
                </p>
                <a href="{{ route('ebook.public') }}" class="btn-secondary text-xs">Lihat Semua E-Book</a>
            </div>
        @else
            <!-- Grid E-Book Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-7">
                @foreach($ebooks as $ebook)
                <div class="card-hover overflow-hidden flex flex-col justify-between group">
                    <div>
                        <!-- Realistic Digital Book Cover Container -->
                        <div class="h-52 bg-gradient-to-tr from-[#047857] via-[#059669] to-[#10B981] p-5 flex flex-col justify-between relative overflow-hidden">
                            <div class="absolute -right-8 -bottom-8 w-36 h-36 bg-white/10 rounded-full blur-md"></div>
                            
                            <div class="flex items-center justify-between relative z-10">
                                <span class="badge-green text-[10px] uppercase font-bold backdrop-blur-md">E-Book BK</span>
                                <span class="text-[10px] text-emerald-100 font-semibold flex items-center gap-1">
                                    <span>📄 PDF</span>
                                </span>
                            </div>

                            <div class="text-white relative z-10">
                                <svg class="w-12 h-12 text-white/80 mb-2 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                <span class="text-[11px] font-medium text-emerald-100 block">Eksklusif Siswa</span>
                            </div>
                        </div>

                        <!-- Content Details -->
                        <div class="p-5">
                            <h3 class="font-sora font-bold text-[#0F172A] dark:text-white text-sm mb-2 group-hover:text-[#059669] dark:group-hover:text-emerald-400 transition-colors line-clamp-2 leading-snug">
                                {{ $ebook->title }}
                            </h3>
                            <p class="text-xs text-[#475569] dark:text-slate-300 leading-relaxed line-clamp-3 mb-4">
                                {{ $ebook->description }}
                            </p>
                        </div>
                    </div>

                    <!-- Footer Action -->
                    <div class="px-5 pb-5 pt-3 border-t border-slate-100 dark:border-slate-700/60 flex items-center justify-between">
                        <span class="text-[11px] font-semibold text-[#059669] dark:text-emerald-300 bg-[#ECFDF5] dark:bg-emerald-950/80 px-2.5 py-1 rounded-full">Gratis</span>
                        @auth
                            <a href="{{ route('student.ebook') }}" class="btn-primary text-xs px-4 py-2">
                                Baca E-Book
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-primary text-xs px-4 py-2">
                                Baca E-Book
                            </a>
                        @endauth
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $ebooks->links() }}
            </div>
        @endif

    </div>
</section>

@endsection
