@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Administrator')

@section('content')
<div class="space-y-6">

    <!-- TailAdmin Top Hero Card -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 p-6 sm:p-8 text-white shadow-theme-md border border-gray-800">
        <div class="absolute -top-24 -right-24 w-72 h-72 bg-brand-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div class="max-w-xl">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-brand-400 text-xs font-semibold backdrop-blur-md mb-3 border border-white/10">
                    <span class="w-2 h-2 rounded-full bg-brand-400 animate-pulse"></span> Control Center Administrator
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight mb-2">
                    Selamat Datang, {{ auth()->user()->name }}! 👋
                </h2>
                <p class="text-gray-300 text-sm leading-relaxed">
                    Kelola akun siswa, pantau sesi bimbingan konseling, dan atur hak akses pendidik di portal SAPA BK SMA Negeri 4 Jember.
                </p>
            </div>

            <div class="shrink-0">
                <a href="{{ route('admin.users', ['role' => 'siswa']) }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-medium text-xs transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Kelola Akun Siswa ({{ $stats['total_siswa'] }})
                </a>
            </div>
        </div>
    </div>

    <!-- TailAdmin Stat Cards Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        <!-- Siswa Stat Card -->
        <a href="{{ route('admin.users', ['role' => 'siswa']) }}" class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-5 shadow-xs hover:border-brand-500 transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-500 dark:bg-brand-500/20 dark:text-brand-400 flex items-center justify-center font-bold text-lg group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                </div>
                <span class="text-xs font-semibold text-brand-500 dark:text-brand-400 group-hover:underline">Lihat →</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_siswa'] }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mt-0.5">Akun Siswa</p>
        </a>

        <!-- Guru BK Stat Card -->
        <a href="{{ route('admin.users', ['role' => 'guru_bk']) }}" class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-5 shadow-xs hover:border-brand-500 transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-blue-light-50 text-blue-light-600 dark:bg-blue-light-500/20 dark:text-blue-light-400 flex items-center justify-center font-bold text-lg group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <span class="text-xs font-semibold text-blue-light-600 dark:text-blue-light-400 group-hover:underline">Lihat →</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_guru_bk'] }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mt-0.5">Guru BK</p>
        </a>

        <!-- Admin Stat Card -->
        <a href="{{ route('admin.users', ['role' => 'admin']) }}" class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-5 shadow-xs hover:border-brand-500 transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-500/20 dark:text-purple-400 flex items-center justify-center font-bold text-lg group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <span class="text-xs font-semibold text-purple-600 dark:text-purple-400 group-hover:underline">Lihat →</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_admin'] }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mt-0.5">Admin System</p>
        </a>

        <!-- Percakapan Stat Card -->
        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-5 shadow-xs">
            <div class="w-10 h-10 rounded-xl bg-success-50 text-success-600 dark:bg-success-500/20 dark:text-success-400 flex items-center justify-center font-bold text-lg mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_chat'] }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mt-0.5">Sesi Konsultasi</p>
        </div>

        <!-- E-book Stat Card -->
        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-5 shadow-xs">
            <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 dark:bg-orange-500/20 dark:text-orange-400 flex items-center justify-center font-bold text-lg mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_ebook'] }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mt-0.5">Modul E-Book</p>
        </div>

        <!-- Artikel Stat Card -->
        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-5 shadow-xs">
            <div class="w-10 h-10 rounded-xl bg-gray-100 text-gray-700 dark:bg-white/5 dark:text-gray-300 flex items-center justify-center font-bold text-lg mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><line x1="10" y1="9" x2="8" y2="9"/></svg>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_artikel'] }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mt-0.5">Artikel Informasi</p>
        </div>
    </div>

    <!-- TailAdmin Table Card: Data Akun Siswa -->
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-6 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="font-bold text-gray-900 dark:text-white text-base flex items-center gap-2">
                    🎓 Data Akun Siswa Terdaftar
                    <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-success-50 text-success-600 dark:bg-success-500/20 dark:text-success-400">
                        {{ $stats['total_siswa'] }} Siswa
                    </span>
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Daftar pengguna ber-role siswa yang telah mendaftar di sistem SAPA BK</p>
            </div>
            <div>
                <a href="{{ route('admin.users', ['role' => 'siswa']) }}" class="btn-primary text-xs">
                    Lihat Semua Data Siswa
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600 dark:text-gray-300">
                <thead class="bg-gray-50 dark:bg-gray-800/50 border-y border-gray-200 dark:border-gray-800 uppercase font-semibold text-[11px] text-gray-500 dark:text-gray-400 tracking-wider">
                    <tr>
                        <th class="py-3 px-4">Nama Siswa</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Tanggal Registrasi</th>
                        <th class="py-3 px-4">Status Akun</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($recentStudents as $siswa)
                    <tr class="hover:bg-gray-50/80 dark:hover:bg-white/5 transition-colors">
                        <td class="py-3.5 px-4 font-semibold text-gray-900 dark:text-white flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-brand-50 text-brand-500 dark:bg-brand-500/20 dark:text-brand-400 flex items-center justify-center font-bold text-xs shrink-0">
                                {{ strtoupper(substr($siswa->name, 0, 1)) }}
                            </div>
                            <span>{{ $siswa->name }}</span>
                        </td>
                        <td class="py-3.5 px-4 text-gray-500 dark:text-gray-400 font-mono">{{ $siswa->email }}</td>
                        <td class="py-3.5 px-4 text-gray-500 dark:text-gray-400">{{ $siswa->created_at->format('d M Y, H:i') }}</td>
                        <td class="py-3.5 px-4">
                            @if($siswa->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-success-50 text-success-600 dark:bg-success-500/20 dark:text-success-400">
                                    ● Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-error-50 text-error-600 dark:bg-error-500/20 dark:text-error-400">
                                    ● Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <a href="{{ route('admin.users.detail', $siswa->id) }}" class="btn-secondary text-[11px] px-3 py-1 font-semibold">
                                Detail Akun →
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 text-gray-400 dark:text-gray-500">Belum ada akun siswa terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Secondary Grid: User Terbaru & Status System -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Akun Pengguna Terbaru -->
        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-6 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-900 dark:text-white text-sm">Pendaftaran Pengguna Terakhir</h3>
                <a href="{{ route('admin.users') }}" class="text-xs text-brand-500 font-semibold hover:underline">Kelola Semua →</a>
            </div>
            <div class="space-y-3">
                @foreach($recentUsers as $user)
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-800">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-brand-50 text-brand-500 dark:bg-brand-500/20 dark:text-brand-400 flex items-center justify-center font-bold text-xs shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-gray-900 dark:text-white truncate">{{ $user->name }}</p>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 truncate">{{ $user->email }}</p>
                        </div>
                    </div>
                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-300 uppercase">
                        {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Status Infrastruktur System -->
        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-6 shadow-xs">
            <h3 class="font-bold text-gray-900 dark:text-white text-sm mb-4">Status Infrastruktur System</h3>
            <div class="space-y-2.5">
                @foreach([['Laravel Web Application', 'active'],['Database MySQL / SQLite','active'],['Python BK AI Engine','inactive'],['ChromaDB Vector Store','inactive']] as $service)
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-800 text-xs">
                    <span class="font-medium text-gray-900 dark:text-white">{{ $service[0] }}</span>
                    @if($service[1] === 'active')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-success-50 text-success-600 dark:bg-success-500/20 dark:text-success-400">● Running</span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">● Standby</span>
                    @endif
                </div>
                @endforeach
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-800">
                <a href="{{ route('admin.konfigurasi') }}" class="btn-secondary text-xs w-full justify-center py-2.5">
                    ⚙️ Buka Konfigurasi Sistem
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
