<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Ebook;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FrontendController extends Controller
{
    public function index(): View
    {
        $articles = Article::where('is_published', true)->latest()->take(3)->get();
        $ebooks = Ebook::where('is_public', true)->latest()->take(4)->get();
        $faqs = Faq::where('is_active', true)->orderBy('order')->take(6)->get();

        return view('frontend.index', compact('articles', 'ebooks', 'faqs'));
    }

    public function about(): View
    {
        return view('frontend.about');
    }

    public function ebooks(): View
    {
        $ebooks = Ebook::where('is_public', true)->latest()->paginate(9);

        return view('frontend.ebooks', compact('ebooks'));
    }

    public function ebookDetail(int $id): View
    {
        $ebook = Ebook::findOrFail($id);

        return view('frontend.ebook-detail', compact('ebook'));
    }

    public function articles(Request $request): View
    {
        $query = Article::where('is_published', true);

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('content', 'like', "%{$q}%");
            });
        }

        $articles = $query->latest()->paginate(6)->withQueryString();

        $categoryCounts = [
            'all' => Article::where('is_published', true)->count(),
            'tips_ptn' => Article::where('is_published', true)->where('category', 'tips_ptn')->count(),
            'kesehatan_mental' => Article::where('is_published', true)->where('category', 'kesehatan_mental')->count(),
            'umum' => Article::where('is_published', true)->where('category', 'umum')->count(),
        ];

        return view('frontend.articles', compact('articles', 'categoryCounts'));
    }

    public function articleDetail(string $slug): View
    {
        $article = Article::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $recentArticles = Article::where('is_published', true)->where('id', '!=', $article->id)->latest()->take(4)->get();

        return view('frontend.article-detail', compact('article', 'recentArticles'));
    }

    public function faqs(): View
    {
        $faqs = Faq::where('is_active', true)->orderBy('order')->get();

        return view('frontend.faq', compact('faqs'));
    }
}
