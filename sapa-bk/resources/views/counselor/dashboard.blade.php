@extends('layouts.admin')

@section('title', 'Dashboard Guru BK')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Stat Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stat-card">
            <div class="stat-icon">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-[#0F172A]">{{ $totalSiswa }}</p>
                <p class="text-xs text-[#475569] mt-0.5">Total Siswa</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-[#0F172A]">{{ $totalPercakapan }}</p>
                <p class="text-xs text-[#475569] mt-0.5">Total Percakapan</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-[#0F172A]">{{ $totalEbook }}</p>
                <p class="text-xs text-[#475569] mt-0.5">E-book Aktif</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-[#0F172A]">{{ $totalTes }}</p>
                <p class="text-xs text-[#475569] mt-0.5">Tes Aktif</p>
            </div>
        </div>
    </div>

    <!-- Percakapan Terbaru -->
    <div class="card p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-[#0F172A]">Percakapan Terbaru</h3>
            <a href="{{ route('counselor.percakapan') }}" class="text-xs text-[#059669] font-medium hover:underline">Lihat semua</a>
        </div>

        @if($recentSessions->isEmpty())
            <p class="text-sm text-[#475569] text-center py-6">Belum ada percakapan.</p>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-[#E2E8F0] text-xs text-[#475569] font-medium">
                        <th class="text-left pb-3 pr-4">Siswa</th>
                        <th class="text-left pb-3 pr-4">Sesi</th>
                        <th class="text-left pb-3 pr-4">Tanggal</th>
                        <th class="text-left pb-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F1F5F9]">
                    @foreach($recentSessions as $session)
                    <tr class="hover:bg-[#F8FAFC] transition-colors">
                        <td class="py-3 pr-4 font-medium text-[#0F172A]">{{ $session->user->name ?? '—' }}</td>
                        <td class="py-3 pr-4 text-[#475569]">{{ Str::limit($session->title, 35) }}</td>
                        <td class="py-3 pr-4 text-[#475569]">{{ $session->created_at->format('d M Y') }}</td>
                        <td class="py-3">
                            <a href="{{ route('counselor.percakapan.detail', $session->id) }}"
                               class="btn-secondary text-xs px-3 py-1.5">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>
@endsection
