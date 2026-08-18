@extends('layouts.student')
@section('title', 'Hasil Tes')
@section('page-title', 'Hasil Tes')
@section('content')
<div class="card p-6 max-w-2xl mx-auto">
    <h2 class="font-bold text-[#0F172A] text-lg mb-2">{{ $result->questionnaire->title }}</h2>
    <p class="text-sm text-[#475569] mb-6">Dikerjakan pada {{ $result->created_at->format('d M Y') }}</p>
    <div class="text-center py-8">
        <p class="text-5xl font-extrabold text-[#059669]">{{ $result->score ?? '—' }}</p>
        <p class="text-sm text-[#475569] mt-2">Skor Anda</p>
    </div>
    <a href="{{ route('student.tes') }}" class="btn-secondary mt-4 inline-flex">← Kembali ke Daftar Tes</a>
</div>
@endsection
