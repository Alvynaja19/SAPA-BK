@extends('layouts.app')

@section('title', 'Profil Pengguna — SAPA BK')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
  
  <div class="bg-white rounded-3xl p-6 sm:p-8 border border-neutral-200/80 shadow-xs">
    <div class="flex items-center gap-4 pb-6 border-b border-neutral-100">
      <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-primary-600 to-indigo-600 text-white font-bold text-2xl flex items-center justify-center shadow-lg shadow-primary-500/20">
        {{ strtoupper(substr($user->name, 0, 2)) }}
      </div>
      <div>
        <h2 class="text-xl font-bold text-neutral-900">{{ $user->name }}</h2>
        <p class="text-xs text-neutral-500 font-medium mt-0.5">{{ $user->email }} • <span class="uppercase font-semibold text-primary-600">{{ str_replace('_', ' ', $user->role) }}</span></p>
      </div>
    </div>

    <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
          <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-2">Nama Lengkap</label>
          <input type="text" name="name" value="{{ old('name', $user->name) }}" required
            class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 focus:outline-none focus:border-primary-500 text-sm">
        </div>

        <div>
          <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-2">Email (Terkunci)</label>
          <input type="email" value="{{ $user->email }}" disabled
            class="w-full px-4 py-2.5 rounded-xl border border-neutral-200 bg-neutral-100 text-neutral-500 text-sm cursor-not-allowed">
        </div>

        @if($user->isSiswa())
          <div>
            <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-2">NISN</label>
            <input type="text" name="nisn" value="{{ old('nisn', $user->nisn) }}"
              class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 focus:outline-none focus:border-primary-500 text-sm">
          </div>

          <div>
            <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-2">Kelas</label>
            <input type="text" name="kelas" value="{{ old('kelas', $user->kelas) }}"
              class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 focus:outline-none focus:border-primary-500 text-sm">
          </div>
        @endif

        <div>
          <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-2">Nomor Telepon / WhatsApp</label>
          <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
            class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 focus:outline-none focus:border-primary-500 text-sm">
        </div>
      </div>

      <div class="pt-6 border-t border-neutral-100">
        <h3 class="text-sm font-bold text-neutral-800 mb-1">Ubah Kata Sandi (Opsional)</h3>
        <p class="text-xs text-neutral-500 mb-4">Biarkan kosong jika Anda tidak ingin mengganti kata sandi.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
          <div>
            <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-2">Kata Sandi Baru</label>
            <input type="password" name="password"
              class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 focus:outline-none focus:border-primary-500 text-sm" placeholder="Min. 8 karakter">
          </div>
          <div>
            <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-2">Konfirmasi Sandi Baru</label>
            <input type="password" name="password_confirmation"
              class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 focus:outline-none focus:border-primary-500 text-sm" placeholder="Ulangi sandi baru">
          </div>
        </div>
      </div>

      <div class="flex justify-end pt-4">
        <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-semibold text-sm shadow-md shadow-primary-500/20 transition-all">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>

</div>
@endsection
