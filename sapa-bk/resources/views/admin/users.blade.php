@extends('layouts.admin')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen Akun System & Siswa')

@section('content')
<div class="space-y-6">

    <!-- Header Actions & Filters -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <h2 class="font-sora font-extrabold text-xl text-[#0F172A] mb-1">Daftar Akun Pengguna</h2>
            <p class="text-xs text-slate-500">Kelola hak akses dan akun siswa, guru BK, serta administrator</p>
        </div>

        <div class="flex items-center gap-3 flex-wrap">
            <button type="button" onclick="openAddUserModal()" class="btn-primary text-xs px-4 py-2.5 shadow-md shadow-[#059669]/10">
                + Tambah Akun Baru
            </button>
        </div>
    </div>

    <!-- Filter Bar & Search -->
    <div class="card p-4 border border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-4">
        <!-- Role Filter Pills -->
        <div class="flex items-center gap-1.5 overflow-x-auto w-full sm:w-auto pb-1 sm:pb-0">
            <a href="{{ route('admin.users') }}"
               class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all {{ !request('role') ? 'bg-[#059669] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua ({{ \App\Models\User::count() }})
            </a>
            <a href="{{ route('admin.users', ['role' => 'siswa', 'q' => request('q')]) }}"
               class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all {{ request('role') === 'siswa' ? 'bg-[#059669] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                🎓 Siswa ({{ \App\Models\User::where('role','siswa')->count() }})
            </a>
            <a href="{{ route('admin.users', ['role' => 'guru_bk', 'q' => request('q')]) }}"
               class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all {{ request('role') === 'guru_bk' ? 'bg-[#059669] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                👨‍🏫 Guru BK ({{ \App\Models\User::where('role','guru_bk')->count() }})
            </a>
            <a href="{{ route('admin.users', ['role' => 'admin', 'q' => request('q')]) }}"
               class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all {{ request('role') === 'admin' ? 'bg-[#059669] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                🛠️ Admin ({{ \App\Models\User::where('role','admin')->count() }})
            </a>
        </div>

        <!-- Search Input -->
        <form method="GET" action="{{ route('admin.users') }}" class="w-full sm:w-72 flex items-center gap-2">
            @if(request('role'))
                <input type="hidden" name="role" value="{{ request('role') }}">
            @endif
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email..."
                   class="form-input text-xs py-2 px-3 rounded-xl border-slate-200 focus:border-[#059669] focus:ring-[#059669]">
            <button type="submit" class="btn-secondary text-xs px-3 py-2 shrink-0">Cari</button>
        </form>
    </div>

    <!-- Users Table -->
    <div class="card p-6 border border-slate-200/80 shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-y border-slate-200 uppercase font-bold text-[10px] text-slate-500 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4">Pengguna</th>
                        <th class="py-3.5 px-4">Email</th>
                        <th class="py-3.5 px-4">Role</th>
                        <th class="py-3.5 px-4">Tanggal Buat</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $u)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3.5 px-4 font-bold text-[#0F172A] flex items-center gap-3">
                            <div class="w-9 h-9 rounded-2xl {{ $u->role === 'siswa' ? 'bg-emerald-100 text-[#059669]' : ($u->role === 'guru_bk' ? 'bg-teal-100 text-teal-700' : 'bg-slate-200 text-slate-800') }} flex items-center justify-center font-extrabold text-xs shrink-0">
                                {{ strtoupper(substr($u->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-sora text-xs font-bold text-[#0F172A]">{{ $u->name }}</p>
                                <p class="text-[10px] text-slate-400 font-normal">ID: #{{ $u->id }}</p>
                            </div>
                        </td>
                        <td class="py-3.5 px-4 font-mono text-slate-600">{{ $u->email }}</td>
                        <td class="py-3.5 px-4">
                            @if($u->role === 'siswa')
                                <span class="badge-green text-[10px] uppercase font-bold">🎓 Siswa</span>
                            @elseif($u->role === 'guru_bk')
                                <span class="bg-teal-50 text-teal-700 border border-teal-200 px-2.5 py-0.5 rounded-full text-[10px] uppercase font-bold">👨‍🏫 Guru BK</span>
                            @else
                                <span class="bg-indigo-50 text-indigo-700 border border-indigo-200 px-2.5 py-0.5 rounded-full text-[10px] uppercase font-bold">🛠️ Admin</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-slate-500">{{ $u->created_at->format('d M Y, H:i') }}</td>
                        <td class="py-3.5 px-4">
                            @if($u->is_active)
                                <span class="badge-green text-[10px]">● Aktif</span>
                            @else
                                <span class="bg-rose-50 text-rose-600 border border-rose-200 px-2 py-0.5 rounded-full text-[10px] font-bold">● Nonaktif</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('admin.users.detail', $u->id) }}" class="btn-secondary text-[11px] px-2.5 py-1 font-bold">
                                    Detail
                                </a>

                                <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $u->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-10 text-slate-400">Tidak ada akun ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah Akun Baru -->
<div id="add-user-modal" class="fixed inset-0 bg-black/50 backdrop-blur-xs z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
            <h3 class="font-sora font-extrabold text-base text-[#0F172A]">Tambah Akun Baru</h3>
            <button onclick="closeAddUserModal()" class="text-slate-400 hover:text-slate-600">✕</button>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-[#0F172A] mb-1 uppercase">Nama Lengkap</label>
                <input type="text" name="name" required class="form-input text-xs" placeholder="Nama pengguna">
            </div>
            <div>
                <label class="block text-xs font-bold text-[#0F172A] mb-1 uppercase">Email</label>
                <input type="email" name="email" required class="form-input text-xs" placeholder="nama@email.com">
            </div>
            <div>
                <label class="block text-xs font-bold text-[#0F172A] mb-1 uppercase">Password</label>
                <input type="password" name="password" required class="form-input text-xs" placeholder="Minimal 8 karakter">
            </div>
            <div>
                <label class="block text-xs font-bold text-[#0F172A] mb-1 uppercase">Peran / Role</label>
                <select name="role" required class="form-input text-xs">
                    <option value="siswa">Siswa</option>
                    <option value="guru_bk">Guru BK</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeAddUserModal()" class="btn-secondary text-xs px-4 py-2">Batal</button>
                <button type="submit" class="btn-primary text-xs px-5 py-2">Simpan Akun</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddUserModal() {
        document.getElementById('add-user-modal').classList.remove('hidden');
    }
    function closeAddUserModal() {
        document.getElementById('add-user-modal').classList.add('hidden');
    }
</script>
@endsection

