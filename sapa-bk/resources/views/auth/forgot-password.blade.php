@extends('layouts.public')

@section('title', 'Lupa Password')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center py-10 sm:py-12 px-4">
    <div class="w-full max-w-md rounded-3xl p-8 sm:p-10 shadow-2xl border"
         style="background: var(--bg-card); border-color: var(--border-color);">
        
        <div class="text-center mb-8">
            <span class="pill-badge mb-3">🔑 Pemulihan Akun</span>
            <h1 class="font-sora font-extrabold text-2xl mb-2" style="color: var(--text-primary);">Lupa Password?</h1>
            <p class="text-xs leading-relaxed" style="color: var(--text-body);">
                Masukkan email terdaftar Anda. Kami akan mengirimkan link instruksi untuk membuat kata sandi baru.
            </p>
        </div>

        @if (session('status'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-700 font-medium">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-xs font-bold mb-1.5 uppercase tracking-wide" style="color: var(--text-primary);">Email Terdaftar</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="form-input @error('email') border-red-400 @enderror"
                       placeholder="nama@email.com">
                @error('email')
                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-primary w-full justify-center py-3.5 text-sm">
                Kirim Link Reset Password
            </button>
        </form>

        <p class="text-center mt-8 text-xs" style="color: var(--text-body);">
            Kembali ke
            <a href="{{ route('login') }}" class="text-[#059669] font-bold hover:underline">Halaman Login</a>
        </p>
    </div>
</div>
@endsection
