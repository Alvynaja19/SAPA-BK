<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Ebook;
use App\Models\Faq;
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

    public function articles(): View
    {
        $articles = Article::where('is_published', true)->latest()->paginate(6);

        return view('frontend.articles', compact('articles'));
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
