@extends('layouts.student')
@section('title', 'Tes & Kuesioner')
@section('page-title', 'Tes & Kuesioner')
@section('content')
<div class="card p-6">
    @if($questionnaires->isEmpty())
        <div class="text-center py-12"><p class="text-[#475569]">Belum ada tes tersedia.</p></div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($questionnaires as $q)
            <div class="card-highlight p-5">
                <h3 class="font-bold text-[#0F172A] mb-2">{{ $q->title }}</h3>
                <p class="text-sm text-[#475569] mb-4">{{ Str::limit($q->description, 80) }}</p>
                @if($results->contains($q->id))
                    <a href="{{ route('student.tes.hasil', $q->id) }}" class="btn-secondary text-xs w-full justify-center">Lihat Hasil</a>
                @else
                    <a href="{{ route('student.tes.detail', $q->id) }}" class="btn-primary text-xs w-full justify-center">Kerjakan</a>
                @endif
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
