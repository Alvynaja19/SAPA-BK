@extends('layouts.public')

@section('title', 'FAQ')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 sm:pt-28 pb-12">
    <div class="text-center mb-12">
        <span class="badge-green text-xs mb-3 inline-block">FAQ</span>
        <h1 class="text-3xl font-bold text-[#0F172A] dark:text-white">Pertanyaan Umum</h1>
        <p class="text-[#475569] dark:text-slate-300 mt-3">Temukan jawaban atas pertanyaan yang sering diajukan seputar layanan BK.</p>
    </div>

    @if($faqs->isEmpty())
        <div class="card p-12 text-center">
            <p class="text-[#475569] dark:text-slate-300">Belum ada FAQ tersedia.</p>
        </div>
    @else
    <div class="space-y-3">
        @foreach($faqs as $i => $faq)
        <div class="card overflow-hidden">
            <details {{ $i === 0 ? 'open' : '' }} class="group">
                <summary class="flex items-center justify-between p-5 cursor-pointer hover:bg-[#F8FAFC] dark:hover:bg-slate-700/60 transition-colors list-none">
                    <span class="font-semibold text-[#0F172A] dark:text-white text-sm pr-4">{{ $faq->question }}</span>
                    <svg class="w-5 h-5 text-[#059669] dark:text-emerald-400 shrink-0 transition-transform duration-200 group-open:rotate-180"
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>
                <div class="px-5 pb-5 text-sm text-[#475569] dark:text-slate-300 leading-relaxed border-t border-[#E2E8F0] dark:border-slate-700/60 pt-4">
                    {{ $faq->answer }}
                </div>
            </details>
        </div>
        @endforeach
    </div>
    @endif

    {{-- CTA --}}
    <div class="mt-12 card p-6 text-center bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-950/60 dark:to-teal-950/60 border-emerald-200 dark:border-emerald-800/40">
        <p class="font-semibold text-[#0F172A] dark:text-white mb-2">Tidak menemukan jawaban yang kamu cari?</p>
        <p class="text-sm text-[#475569] dark:text-slate-300 mb-5">Hubungi Guru BK kami langsung atau mulai sesi konsultasi sekarang.</p>
        @auth
            <a href="{{ route('student.chat') }}" class="btn-primary">Mulai Konsultasi</a>
        @else
            <a href="{{ route('login') }}" class="btn-primary">Masuk & Konsultasi</a>
        @endauth
    </div>
</div>
@endsection
