@extends('layouts.student')
@section('title', 'E-book')
@section('page-title', 'E-book')
@section('content')
<div class="card p-6">
    @if($ebooks->isEmpty())
        <div class="text-center py-12"><p class="text-[#475569]">Belum ada e-book tersedia.</p></div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($ebooks as $ebook)
            <div class="card overflow-hidden hover:shadow-md transition-shadow group">
                <div class="h-36 bg-gradient-to-br from-[#059669] to-[#047857] flex items-center justify-center">
                    <svg class="w-12 h-12 text-white/70" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-sm text-[#0F172A] line-clamp-2 mb-1">{{ $ebook->title }}</h3>
                    <p class="text-xs text-[#475569] line-clamp-2 mb-3">{{ $ebook->description }}</p>
                    <a href="#" class="btn-primary text-xs w-full justify-center">Baca</a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $ebooks->links() }}</div>
    @endif
</div>
@endsection
