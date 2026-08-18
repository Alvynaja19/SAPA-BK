@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Administrator')

@section('content')
<div class="space-y-6">

    <!-- Top Hero Banner -->
    <div class="bg-gradient-to-r from-[#0F172A] via-[#1E293B] to-[#334155] p-6 sm:p-8 rounded-3xl text-white shadow-xl relative overflow-hidden flex flex-col sm:flex-row sm:items-center justify-between gap-6 border border-slate-700">
        <div class="absolute top-0 right-0 w-80 h-80 bg-[#059669]/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-emerald-400 text-[11px] font-bold backdrop-blur-md mb-3 border border-white/10">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Control Center Administrator
            </span>
            <h2 class="font-sora text-2xl sm:text-3xl font-extrabold tracking-tight mb-2">
                Selamat Datang, {{ auth()->user()->name }}! 👋
            </h2>
            <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
                Kelola akun siswa, pantau sesi bimbingan konseling, dan atur hak akses pendidik di portal SAPA BK SMA Negeri 4 Jember.
            </p>
        </div>

        <div class="relative z-10 shrink-0 flex flex-wrap gap-3">
            <a href="{{ route('admin.users', ['role' => 'siswa']) }}" class="btn-primary text-xs px-5 py-3 shadow-lg flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Kelola Akun Siswa ({{ $stats['total_siswa'] }})
            </a>
        </div>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        <!-- Siswa Stat Card -->
        <a href="{{ route('admin.users', ['role' => 'siswa']) }}" class="card p-4 hover:border-[#059669] transition-all group border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <div class="w-10 h-10 rounded-2xl bg-[#ECFDF5] text-[#059669] flex items-center justify-center font-bold group-hover:scale-110 transition-transform">
                    🎓
                </div>
                <span class="text-[10px] font-bold text-[#059669] group-hover:underline">Lihat →</span>
            </div>
            <p class="font-sora text-2xl font-extrabold text-[#0F172A]">{{ $stats['total_siswa'] }}</p>
            <p class="text-xs text-slate-500 font-medium">Akun Siswa</p>
        </a>

        <!-- Guru BK Stat Card -->
        <a href="{{ route('admin.users', ['role' => 'guru_bk']) }}" class="card p-4 hover:border-teal-500 transition-all group border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <div class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center font-bold group-hover:scale-110 transition-transform">
                    👨‍🏫
                </div>
                <span class="text-[10px] font-bold text-teal-600 group-hover:underline">Lihat →</span>
            </div>
            <p class="font-sora text-2xl font-extrabold text-[#0F172A]">{{ $stats['total_guru_bk'] }}</p>
            <p class="text-xs text-slate-500 font-medium">Guru BK</p>
        </a>

        <!-- Admin Stat Card -->
        <a href="{{ route('admin.users', ['role' => 'admin']) }}" class="card p-4 hover:border-indigo-500 transition-all group border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold group-hover:scale-110 transition-transform">
                    🛠️
                </div>
                <span class="text-[10px] font-bold text-indigo-600 group-hover:underline">Lihat →</span>
            </div>
            <p class="font-sora text-2xl font-extrabold text-[#0F172A]">{{ $stats['total_admin'] }}</p>
            <p class="text-xs text-slate-500 font-medium">Admin System</p>
        </a>

        <!-- Percakapan Stat Card -->
        <div class="card p-4 border border-slate-200">
            <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold mb-2">
                💬
            </div>
            <p class="font-sora text-2xl font-extrabold text-[#0F172A]">{{ $stats['total_chat'] }}</p>
            <p class="text-xs text-slate-500 font-medium">Sesi Konsultasi</p>
        </div>

        <!-- E-book Stat Card -->
        <div class="card p-4 border border-slate-200">
            <div class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center font-bold mb-2">
                📚
            </div>
            <p class="font-sora text-2xl font-extrabold text-[#0F172A]">{{ $stats['total_ebook'] }}</p>
            <p class="text-xs text-slate-500 font-medium">Modul E-Book</p>
        </div>

        <!-- Artikel Stat Card -->
        <div class="card p-4 border border-slate-200">
            <div class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold mb-2">
                📰
            </div>
            <p class="font-sora text-2xl font-extrabold text-[#0F172A]">{{ $stats['total_artikel'] }}</p>
            <p class="text-xs text-slate-500 font-medium">Artikel Informasi</p>
        </div>
    </div>

    <!-- Main Section: Data Akun Siswa Terbaru -->
    <div class="card p-6 border border-slate-200/80 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="font-sora font-extrabold text-[#0F172A] text-lg flex items-center gap-2">
                    🎓 Data Akun Siswa Terdaftar
                    <span class="badge-green text-xs font-bold">{{ $stats['total_siswa'] }} Siswa</span>
                </h3>
                <p class="text-xs text-slate-500 mt-1">Daftar pengguna ber-role siswa yang telah mendaftar di sistem SAPA BK</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.users', ['role' => 'siswa']) }}" class="btn-primary text-xs px-4 py-2 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Lihat Semua Data Siswa
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-y border-slate-200 uppercase font-bold text-[10px] text-slate-500 tracking-wider">
                    <tr>
                        <th class="py-3 px-4">Nama Siswa</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Tanggal Registrasi</th>
                        <th class="py-3 px-4">Status Akun</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentStudents as $siswa)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3.5 px-4 font-bold text-[#0F172A] flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 text-[#059669] flex items-center justify-center font-extrabold text-xs shrink-0">
                                {{ strtoupper(substr($siswa->name, 0, 1)) }}
                            </div>
                            <span>{{ $siswa->name }}</span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-500 font-mono">{{ $siswa->email }}</td>
                        <td class="py-3.5 px-4 text-slate-500">{{ $siswa->created_at->format('d M Y, H:i') }}</td>
                        <td class="py-3.5 px-4">
                            @if($siswa->is_active)
                                <span class="badge-green text-[10px]">● Aktif</span>
                            @else
                                <span class="bg-rose-50 text-rose-600 border border-rose-200 px-2 py-0.5 rounded-full text-[10px] font-bold">● Nonaktif</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <a href="{{ route('admin.users.detail', $siswa->id) }}" class="btn-secondary text-[11px] px-3 py-1 font-bold">
                                Detail Akun →
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 text-slate-400">Belum ada akun siswa terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Secondary Split: User Terbaru (Semua Role) & Status Layanan -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Akun Pengguna Terbaru (All Roles) -->
        <div class="card p-5 border border-slate-200/80">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-sora font-bold text-[#0F172A] text-sm">Pendaftaran Pengguna Terakhir</h3>
                <a href="{{ route('admin.users') }}" class="text-xs text-[#059669] font-bold hover:underline">Kelola Semua →</a>
            </div>
            <div class="space-y-3">
                @foreach($recentUsers as $user)
                <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#ECFDF5] flex items-center justify-center text-[#059669] font-bold text-xs shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-sora text-xs font-bold text-[#0F172A] truncate">{{ $user->name }}</p>
                            <p class="text-[11px] text-slate-400 truncate">{{ $user->email }}</p>
                        </div>
                    </div>
                    <span class="badge-{{ $user->role === 'admin' ? 'red' : ($user->role === 'guru_bk' ? 'amber' : 'green') }} shrink-0 text-[10px]">
                        {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Status Layanan -->
        <div class="card p-5 border border-slate-200/80">
            <h3 class="font-sora font-bold text-[#0F172A] text-sm mb-4">Status Infrastruktur System</h3>
            <div class="space-y-2.5">
                @foreach([['Laravel Web Application', 'active'],['Database MySQL / SQLite','active'],['Python BK AI Engine','inactive'],['ChromaDB Vector Store','inactive']] as $service)
                <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100 text-xs">
                    <span class="font-semibold text-[#0F172A]">{{ $service[0] }}</span>
                    @if($service[1] === 'active')
                        <span class="badge-green text-[10px]">● Running</span>
                    @else
                        <span class="bg-slate-100 text-slate-500 px-2.5 py-0.5 rounded-full text-[10px] font-bold">● Standby</span>
                    @endif
                </div>
                @endforeach
            </div>
            <div class="mt-4 pt-3 border-t border-slate-200/80">
                <a href="{{ route('admin.konfigurasi') }}" class="btn-secondary text-xs w-full justify-center py-2.5">
                    ⚙️ Buka Konfigurasi Sistem
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

