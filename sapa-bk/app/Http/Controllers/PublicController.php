<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ebook;
use App\Models\Article;
use App\Models\Faq;

class PublicController extends Controller
{
    /**
     * Halaman Landing Page — /
     */
    public function index()
    {
        $ebooks   = Ebook::where('is_public', true)->latest()->take(4)->get();
        $articles = Article::where('is_published', true)->latest()->take(3)->get();
        $faqs     = Faq::where('is_active', true)->orderBy('order')->take(5)->get();

        return view('public.index', compact('ebooks', 'articles', 'faqs'));
    }

    /**
     * Halaman Tentang BK — /tentang
     */
    public function tentang()
    {
        return view('public.tentang');
    }

    /**
     * Halaman Daftar E-book — /ebook
     */
    public function ebook(Request $request)
    {
        $query  = Ebook::where('is_public', true);
        if ($request->filled('q')) {
            $query->where('title', 'like', "%{$request->q}%");
        }
        $ebooks = $query->latest()->paginate(12);
        return view('public.ebook', compact('ebooks'));
    }

    /**
     * Halaman Daftar Artikel — /artikel
     */
    public function artikel(Request $request, \App\Services\ArticleApiService $apiService)
    {
        $source = (string) ($request->input('source') ?? 'all');
        $category = (string) ($request->input('category') ?? 'all');
        $searchQuery = (string) ($request->input('q') ?? '');

        // 1. Fetch Internal Articles from Database
        $internalQuery = Article::where('is_published', true);
        if ($searchQuery !== '') {
            $internalQuery->where(function ($q) use ($searchQuery) {
                $q->where('title', 'like', "%{$searchQuery}%")
                  ->orWhere('content', 'like', "%{$searchQuery}%");
            });
        }
        $internalArticles = $internalQuery->latest()->paginate(9)->withQueryString();

        // 2. Fetch Curated & API Articles for SMA Students
        $page = (int) $request->input('page', 1);
        $publicArticles = $apiService->fetchPublicArticles($searchQuery, $category, $page, 9);

        return view('public.artikel', compact('internalArticles', 'publicArticles', 'source', 'category', 'searchQuery'));
    }

    /**
     * Detail Artikel — /artikel/{slug}
     */
    public function artikelDetail(string $slug)
    {
        $article = Article::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $related = Article::where('is_published', true)
                          ->where('id', '!=', $article->id)
                          ->latest()->take(3)->get();
        return view('public.artikel-detail', compact('article', 'related'));
    }

    /**
     * Halaman FAQ — /faq
     */
    public function faq()
    {
        $faqs = Faq::where('is_active', true)->orderBy('order')->get();
        return view('public.faq', compact('faqs'));
    }
}
