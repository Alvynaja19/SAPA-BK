@extends('layouts.public')

@section('title', 'Artikel & Edukasi BK')

@section('content')
<div class="relative overflow-hidden py-6 sm:py-16 bg-gradient-to-b from-emerald-900/10 via-transparent to-transparent dark:from-emerald-950/20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- ===== HERO HEADER ===== -->
        <div class="text-center max-w-3xl mx-auto mb-8 sm:mb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[11px] sm:text-xs font-semibold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 mb-3">
                <span>📚 Edukasi & Informasi BK SMAN 4 Jember</span>
            </div>
            <h1 class="font-sora text-2xl sm:text-4xl md:text-5xl font-extrabold tracking-tight mb-3" style="color: var(--text-primary);">
                Artikel Bimbingan & <span class="bg-clip-text text-transparent bg-gradient-to-r from-[#059669] via-emerald-500 to-teal-400">Konseling</span>
            </h1>
            <p class="text-xs sm:text-base leading-relaxed px-2 sm:px-0" style="color: var(--text-muted);">
                Kumpulan panduan praktis, tips belajar, informasi kesehatan mental, dan persiapan karir untuk siswa SMA.
            </p>
        </div>

        <!-- ===== SEARCH BAR & CATEGORY FILTERS ===== -->
        <div class="max-w-4xl mx-auto mb-10 sm:mb-14">
            <!-- Search Form (Mobile Optimized Stack) -->
            <form action="{{ route('artikel.list') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3 mb-6 sm:mb-8">
                <input type="hidden" name="source" value="{{ $source }}">
                <input type="hidden" name="category" value="{{ $category }}">
                
                <div class="relative w-full flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text"
                           id="search-input"
                           name="q"
                           value="{{ $searchQuery }}"
                           placeholder="Cari topik artikel..."
                           onfocus="if(this.value){ this.select(); }"
                           class="w-full pl-10 pr-10 py-3 sm:py-3.5 rounded-xl sm:rounded-2xl border text-xs sm:text-sm transition-all focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-sm"
                           style="background: var(--bg-surface); border-color: var(--border-color); color: var(--text-primary);">
                    
                    @if($searchQuery)
                    <a href="{{ route('artikel.list', ['source' => $source, 'category' => $category]) }}"
                       class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors"
                       title="Hapus pencarian">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                    @endif
                </div>

                <button type="submit" class="w-full sm:w-auto btn-primary text-xs px-6 py-3 sm:py-3.5 rounded-xl sm:rounded-2xl font-bold shrink-0 shadow-md justify-center">
                    Cari Artikel
                </button>
            </form>

            <!-- Topic Category Pills (Mobile Swipe + Desktop Center Wrap) -->
            <div class="pt-1">
                <p class="text-center text-[10px] sm:text-xs font-semibold text-slate-400 dark:text-slate-500 mb-2.5 uppercase tracking-wider">Topik Artikel</p>
                
                <div class="flex items-center sm:justify-center gap-2 sm:gap-3 overflow-x-auto pb-3 sm:pb-0 -mx-4 px-4 sm:mx-0 sm:px-0 sm:flex-wrap scrollbar-none snap-x">
                    <a href="{{ route('artikel.list', ['source' => $source, 'category' => 'all', 'q' => $searchQuery]) }}"
                       class="px-3.5 sm:px-4 py-2 rounded-full text-xs font-bold transition-all border whitespace-nowrap shrink-0 snap-start
                              {{ $category === 'all' ? 'bg-emerald-700 text-white border-transparent shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:bg-slate-200' }}">
                        Semua Topik
                    </a>
                    <a href="{{ route('artikel.list', ['source' => $source, 'category' => 'mental', 'q' => $searchQuery]) }}"
                       class="px-3.5 sm:px-4 py-2 rounded-full text-xs font-bold transition-all border whitespace-nowrap shrink-0 snap-start
                              {{ $category === 'mental' ? 'bg-emerald-700 text-white border-transparent shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:bg-slate-200' }}">
                        Kesehatan Mental
                    </a>
                    <a href="{{ route('artikel.list', ['source' => $source, 'category' => 'karir', 'q' => $searchQuery]) }}"
                       class="px-3.5 sm:px-4 py-2 rounded-full text-xs font-bold transition-all border whitespace-nowrap shrink-0 snap-start
                              {{ $category === 'karir' ? 'bg-emerald-700 text-white border-transparent shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:bg-slate-200' }}">
                        Karir & Perencanaan Kuliah
                    </a>
                    <a href="{{ route('artikel.list', ['source' => $source, 'category' => 'belajar', 'q' => $searchQuery]) }}"
                       class="px-3.5 sm:px-4 py-2 rounded-full text-xs font-bold transition-all border whitespace-nowrap shrink-0 snap-start
                              {{ $category === 'belajar' ? 'bg-emerald-700 text-white border-transparent shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:bg-slate-200' }}">
                        Strategi Belajar
                    </a>
                    <a href="{{ route('artikel.list', ['source' => $source, 'category' => 'pengembangan', 'q' => $searchQuery]) }}"
                       class="px-3.5 sm:px-4 py-2 rounded-full text-xs font-bold transition-all border whitespace-nowrap shrink-0 snap-start
                              {{ $category === 'pengembangan' ? 'bg-emerald-700 text-white border-transparent shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:bg-slate-200' }}">
                        Pengembangan Diri
                    </a>
                </div>
            </div>

            <!-- Source Filter Tabs (Mobile Compact Pills) -->
            <div class="flex items-center justify-center flex-wrap gap-1.5 sm:gap-2 pt-4 sm:pt-6 border-t border-slate-200/60 dark:border-slate-800/60 mt-4 sm:mt-6 text-xs">
                <span class="text-slate-400 font-medium text-[11px] sm:text-xs">Sumber:</span>
                <a href="{{ route('artikel.list', ['source' => 'all', 'category' => $category, 'q' => $searchQuery]) }}"
                   class="px-2.5 sm:px-3 py-1 rounded-lg text-[11px] sm:text-xs font-semibold {{ $source === 'all' ? 'bg-slate-800 text-white dark:bg-slate-200 dark:text-slate-900' : 'text-slate-500 hover:text-slate-800' }}">
                    Semua
                </a>
                <a href="{{ route('artikel.list', ['source' => 'internal', 'category' => $category, 'q' => $searchQuery]) }}"
                   class="px-2.5 sm:px-3 py-1 rounded-lg text-[11px] sm:text-xs font-semibold {{ $source === 'internal' ? 'bg-slate-800 text-white dark:bg-slate-200 dark:text-slate-900' : 'text-slate-500 hover:text-slate-800' }}">
                    Internal BK ({{ $internalArticles->total() }})
                </a>
                <a href="{{ route('artikel.list', ['source' => 'public', 'category' => $category, 'q' => $searchQuery]) }}"
                   class="px-2.5 sm:px-3 py-1 rounded-lg text-[11px] sm:text-xs font-semibold {{ $source === 'public' ? 'bg-slate-800 text-white dark:bg-slate-200 dark:text-slate-900' : 'text-slate-500 hover:text-slate-800' }}">
                    Edukasi Terbuka ({{ $publicArticles['total'] ?? 0 }})
                </a>
            </div>
        </div>

        <!-- ===== SECTION 1: ARTIKEL INTERNAL SAPA BK ===== -->
        @if(($source === 'all' || $source === 'internal') && $internalArticles->isNotEmpty())
            <div class="mb-10 sm:mb-12">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h2 class="font-sora font-extrabold text-lg sm:text-2xl flex items-center gap-2" style="color: var(--text-primary);">
                        <span class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-[#059669]"></span>
                        Artikel SAPA BK SMAN 4 Jember
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    @foreach($internalArticles as $article)
                    <a href="{{ route('artikel.detail', $article->slug) }}" class="card overflow-hidden hover:-translate-y-1 transition-all duration-300 group block flex flex-col justify-between">
                        <div>
                            <div class="h-40 sm:h-44 bg-gradient-to-br from-emerald-500/10 to-teal-500/20 relative flex items-center justify-center overflow-hidden">
                                @if($article->thumbnail)
                                    <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="p-6 text-center">
                                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-emerald-500/20 flex items-center justify-center mx-auto mb-2 text-emerald-600 dark:text-emerald-400">
                                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                        </div>
                                        <span class="text-[11px] sm:text-xs font-semibold text-emerald-600 dark:text-emerald-400">SAPA BK Official</span>
                                    </div>
                                @endif
                                <span class="absolute top-3 left-3 px-2.5 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-[11px] font-bold bg-emerald-600 text-white shadow-sm">
                                    Internal BK
                                </span>
                            </div>
                            <div class="p-4 sm:p-5">
                                <h3 class="font-sora font-bold text-sm sm:text-base mb-1.5 sm:mb-2 group-hover:text-[#059669] transition-colors line-clamp-2" style="color: var(--text-primary);">
                                    {{ $article->title }}
                                </h3>
                                <p class="text-xs sm:text-sm line-clamp-3 mb-3 leading-relaxed" style="color: var(--text-muted);">
                                    {{ Str::limit(strip_tags($article->content), 110) }}
                                </p>
                            </div>
                        </div>
                        <div class="px-4 sm:px-5 pb-4 sm:pb-5 pt-0 flex items-center justify-between border-t border-slate-100 dark:border-slate-800/60 mt-auto pt-3">
                            <span class="text-[10px] sm:text-[11px] font-medium" style="color: var(--text-muted);">
                                📅 {{ $article->created_at ? $article->created_at->format('d M Y') : 'Baru' }}
                            </span>
                            <span class="text-xs font-bold text-[#059669] group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
                                Baca &rarr;
                            </span>
                        </div>
                    </a>
                    @endforeach
                </div>

                @if($source === 'internal')
                    <div class="mt-6 sm:mt-8">{{ $internalArticles->links() }}</div>
                @endif
            </div>
        @endif

        <!-- ===== SECTION 2: ARTIKEL EDUKASI & RUJUKAN BK SMA ===== -->
        @if($source === 'all' || $source === 'public')
            <div>
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <div>
                        <h2 class="font-sora font-extrabold text-lg sm:text-2xl flex items-center gap-2" style="color: var(--text-primary);">
                            <span class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-teal-500"></span>
                            Artikel & Edukasi Bimbingan Konseling
                        </h2>
                        <p class="text-xs sm:text-sm mt-0.5 sm:mt-1" style="color: var(--text-muted);">
                            Artikel ramah siswa dan rujukan terbuka yang mudah dipahami.
                        </p>
                    </div>
                </div>

                @if(empty($publicArticles['data']))
                    <div class="card p-8 sm:p-12 text-center">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-3 text-slate-400">
                            <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <h3 class="font-sora font-bold text-base sm:text-lg mb-1" style="color: var(--text-primary);">Tidak Ada Artikel Ditemukan</h3>
                        <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto">
                            Coba ubah filter topik atau kata kunci pencarian Anda untuk menemukan artikel bimbingan konseling lainnya.
                        </p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                        @foreach($publicArticles['data'] as $pubArticle)
                        <div class="card p-4 sm:p-6 flex flex-col justify-between hover:-translate-y-1 transition-all duration-300 border hover:border-emerald-500/40 shadow-sm hover:shadow-md">
                            <div>
                                <!-- Header Badge -->
                                <div class="flex items-center justify-between gap-2 mb-2.5">
                                    <span class="px-2.5 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-[11px] font-bold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 inline-flex items-center gap-1 truncate max-w-[70%]">
                                        {{ trim($pubArticle['category'] ?? 'Kesehatan Mental') }}
                                    </span>
                                    <span class="text-[10px] sm:text-xs font-semibold px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                                        {{ $pubArticle['year'] ?? 2026 }}
                                    </span>
                                </div>

                                <!-- Article Title -->
                                <h3 class="font-sora font-bold text-sm sm:text-base mb-2 leading-snug hover:text-[#059669] transition-colors line-clamp-2" style="color: var(--text-primary);">
                                    <a href="{{ $pubArticle['url'] }}" target="_blank" rel="noopener noreferrer">
                                        {{ $pubArticle['title'] }}
                                    </a>
                                </h3>

                                <!-- Author & Source -->
                                <div class="mb-2.5 space-y-0.5">
                                    <p class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 truncate">
                                        ✍️ {{ $pubArticle['author'] }}
                                    </p>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate">
                                        📖 {{ $pubArticle['journal'] }} ({{ $pubArticle['source'] }})
                                    </p>
                                </div>

                                <!-- Abstract / Summary -->
                                <p class="text-xs leading-relaxed line-clamp-3 mb-3.5 p-2.5 sm:p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800 text-slate-600 dark:text-slate-300">
                                    {{ $pubArticle['abstract'] }}
                                </p>
                            </div>

                            <!-- Footer Action Button (Mobile Full Width Stack) -->
                            <div class="pt-3 border-t border-slate-100 dark:border-slate-800/60 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-2.5 mt-auto">
                                <span class="text-[10px] sm:text-[11px] font-medium text-emerald-600 dark:text-emerald-400 inline-flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                    Link Terverifikasi
                                </span>
                                <a href="{{ $pubArticle['url'] }}" target="_blank" rel="noopener noreferrer"
                                   class="btn-primary text-xs px-3.5 py-2 rounded-xl inline-flex items-center justify-center gap-1.5 shadow-sm w-full sm:w-auto">
                                    <span>Baca Artikel Full</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination Navigation -->
                    @if($source === 'public' && isset($publicArticles['lastPage']) && $publicArticles['lastPage'] > 1)
                        <div class="mt-6 sm:mt-8 flex items-center justify-center gap-2 text-xs flex-wrap">
                            @if(($publicArticles['page'] ?? 1) > 1)
                                <a href="{{ route('artikel.list', ['source' => 'public', 'category' => $category, 'q' => $searchQuery, 'page' => ($publicArticles['page'] - 1)]) }}"
                                   class="btn-primary text-xs px-3.5 sm:px-4 py-2 rounded-xl">
                                    &larr; Sebelumnya
                                </a>
                            @endif
                            <span class="text-xs px-3 sm:px-4 py-2 font-semibold text-slate-600 dark:text-slate-300">
                                Halaman {{ $publicArticles['page'] ?? 1 }} dari {{ $publicArticles['lastPage'] }}
                            </span>
                            @if(($publicArticles['page'] ?? 1) < $publicArticles['lastPage'])
                                <a href="{{ route('artikel.list', ['source' => 'public', 'category' => $category, 'q' => $searchQuery, 'page' => ($publicArticles['page'] + 1)]) }}"
                                   class="btn-primary text-xs px-3.5 sm:px-4 py-2 rounded-xl">
                                    Berikutnya &rarr;
                                </a>
                            @endif
                        </div>
                    @endif
                @endif
            </div>
        @endif

    </div>
</div>
@endsection
