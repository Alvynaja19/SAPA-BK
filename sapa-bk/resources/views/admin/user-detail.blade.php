@extends('layouts.admin')

@section('title', 'Detail Akun Pengguna')
@section('page-title', 'Detail & Pengaturan Akun')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.users') }}" class="inline-flex items-center gap-2 text-xs font-bold text-[#059669] hover:underline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Akun
        </a>
        <span class="badge-{{ $user->role === 'admin' ? 'red' : ($user->role === 'guru_bk' ? 'amber' : 'green') }} text-xs font-bold uppercase">
            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
        </span>
    </div>

    <!-- User Profile Card & Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Left: Profile Summary -->
        <div class="card p-6 border border-slate-200/80 text-center flex flex-col items-center justify-center">
            <div class="w-20 h-20 rounded-3xl {{ $user->role === 'siswa' ? 'bg-emerald-100 text-[#059669]' : ($user->role === 'guru_bk' ? 'bg-teal-100 text-teal-700' : 'bg-slate-200 text-slate-800') }} flex items-center justify-center font-extrabold text-2xl shadow-md mb-4">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <h3 class="font-sora font-extrabold text-base text-[#0F172A] mb-1">{{ $user->name }}</h3>
            <p class="text-xs text-slate-500 font-mono mb-4">{{ $user->email }}</p>

            <div class="w-full pt-4 border-t border-slate-100 space-y-2 text-xs text-left">
                <div class="flex justify-between">
                    <span class="text-slate-400">ID Pengguna:</span>
                    <span class="font-bold text-slate-700">#{{ $user->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Tanggal Daftar:</span>
                    <span class="font-semibold text-slate-700">{{ $user->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Status Akun:</span>
                    @if($user->is_active)
                        <span class="badge-green text-[10px]">Aktif</span>
                    @else
                        <span class="bg-rose-50 text-rose-600 px-2 py-0.5 rounded-full text-[10px] font-bold">Nonaktif</span>
                    @endif
                </div>
                @if($user->role === 'siswa')
                <div class="flex justify-between">
                    <span class="text-slate-400">Total Sesi Chat:</span>
                    <span class="font-bold text-[#059669]">{{ $user->chatSessions()->count() }} Sesi</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Right: Edit Form -->
        <div class="md:col-span-2 card p-6 border border-slate-200/80">
            <h3 class="font-sora font-bold text-base text-[#0F172A] mb-4 pb-3 border-b border-slate-100">
                Perbarui Informasi & Hak Akses Akun
            </h3>

            <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-xs font-bold text-[#0F172A] mb-1 uppercase tracking-wide">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-input text-xs">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-bold text-[#0F172A] mb-1 uppercase tracking-wide">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="form-input text-xs">
                </div>

                <!-- Peran / Role -->
                <div>
                    <label for="role" class="block text-xs font-bold text-[#0F172A] mb-1 uppercase tracking-wide">Peran Sistem (Role)</label>
                    <select id="role" name="role" required class="form-input text-xs">
                        <option value="siswa" {{ $user->role === 'siswa' ? 'selected' : '' }}>🎓 Siswa SMAN 4 Jember</option>
                        <option value="guru_bk" {{ $user->role === 'guru_bk' ? 'selected' : '' }}>👨‍🏫 Guru BK / Pendidik</option>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>🛠️ Administrator System</option>
                    </select>
                </div>

                <!-- Status Aktif -->
                <div>
                    <label for="is_active" class="block text-xs font-bold text-[#0F172A] mb-1 uppercase tracking-wide">Status Aktivasi Akun</label>
                    <select id="is_active" name="is_active" class="form-input text-xs">
                        <option value="1" {{ $user->is_active ? 'selected' : '' }}>Aktif (Dapat Login & Akses Fitur)</option>
                        <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Nonaktif (Akses Diblokir)</option>
                    </select>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini secara permanen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-rose-600 font-bold hover:underline">Hapus Akun Ini</button>
                    </form>

                    <button type="submit" class="btn-primary text-xs px-6 py-2.5 shadow-md shadow-[#059669]/10">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

    </div>

    <!-- Optional: History Sesi Chat jika role Siswa -->
    @if($user->role === 'siswa' && $user->chatSessions()->count() > 0)
    <div class="card p-6 border border-slate-200/80">
        <h3 class="font-sora font-bold text-sm text-[#0F172A] mb-4">
            Riwayat Sesi Konsultasi AI Siswa Ini ({{ $user->chatSessions()->count() }})
        </h3>
        <div class="space-y-2">
            @foreach($user->chatSessions()->latest()->take(5)->get() as $s)
            <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 text-xs">
                <div class="flex items-center gap-2">
                    <span>💬</span>
                    <span class="font-bold text-slate-700">{{ $s->title }}</span>
                </div>
                <span class="text-slate-400 text-[11px]">{{ $s->created_at->format('d M Y, H:i') }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection

