@extends('layouts.public')

@section('title', $article->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs text-[#475569] mb-6">
        <a href="{{ route('home') }}" class="hover:text-[#059669]">Beranda</a>
        <span>/</span>
        <a href="{{ route('artikel.list') }}" class="hover:text-[#059669]">Artikel</a>
        <span>/</span>
        <span class="text-[#0F172A] font-medium truncate max-w-xs">{{ $article->title }}</span>
    </nav>

    <span class="badge-green text-xs mb-4 inline-block">Artikel BK</span>
    <h1 class="text-3xl font-extrabold text-[#0F172A] mb-4 leading-tight">{{ $article->title }}</h1>
    <p class="text-sm text-[#475569] mb-8">{{ $article->created_at->format('d M Y') }}</p>

    <div class="h-56 rounded-2xl bg-gradient-to-br from-[#ECFDF5] to-[#D1FAE5] flex items-center justify-center mb-10">
        <svg class="w-16 h-16 text-[#059669]/40" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
    </div>

    <article class="prose prose-slate max-w-none text-[#475569] leading-relaxed text-base">
        {!! nl2br(e($article->content)) !!}
    </article>

    @if($related->isNotEmpty())
    <div class="mt-12 pt-8 border-t border-[#E2E8F0]">
        <h3 class="font-bold text-[#0F172A] mb-6">Artikel Terkait</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            @foreach($related as $rel)
            <a href="{{ route('artikel.detail', $rel->slug) }}" class="card p-4 hover:shadow-md transition-shadow group block">
                <h4 class="font-semibold text-sm text-[#0F172A] group-hover:text-[#059669] transition-colors line-clamp-2 mb-1">{{ $rel->title }}</h4>
                <p class="text-xs text-[#475569]">{{ $rel->created_at->format('d M Y') }}</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
