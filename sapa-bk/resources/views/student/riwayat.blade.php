@extends('layouts.student')
@section('title', 'Riwayat Konsultasi')
@section('page-title', 'Riwayat Konsultasi')
@section('content')
<div class="card p-6">
    @if($sessions->isEmpty())
        <div class="text-center py-12">
            <p class="text-[#475569] mb-4">Belum ada riwayat konsultasi.</p>
            <a href="{{ route('student.chat') }}" class="btn-primary">Mulai Konsultasi</a>
        </div>
    @else
        <div class="space-y-3">
            @foreach($sessions as $s)
            <div class="flex items-center justify-between p-4 rounded-xl border border-[#E2E8F0] hover:border-[#059669]/40 transition-colors">
                <div>
                    <p class="font-semibold text-[#0F172A] text-sm">{{ $s->title }}</p>
                    <p class="text-xs text-[#475569] mt-0.5">{{ $s->created_at->format('d M Y, H:i') }}</p>
                </div>
                <a href="{{ route('student.chat.session', $s->id) }}" class="btn-secondary text-xs px-4 py-2">Buka</a>
            </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $sessions->links() }}</div>
    @endif
</div>
@endsection
