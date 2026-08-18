@extends('layouts.student')
@section('title', $questionnaire->title)
@section('page-title', $questionnaire->title)
@section('content')
<div class="card p-6 max-w-2xl mx-auto">
    <h2 class="font-bold text-[#0F172A] text-lg mb-2">{{ $questionnaire->title }}</h2>
    <p class="text-sm text-[#475569] mb-6">{{ $questionnaire->description }}</p>
    <p class="text-sm text-[#475569]">Kuesioner ini belum memiliki soal. Tunggu Guru BK menambahkan pertanyaan.</p>
    <a href="{{ route('student.tes') }}" class="btn-secondary mt-4 inline-flex">← Kembali</a>
</div>
@endsection
