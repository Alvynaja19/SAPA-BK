@extends('layouts.public')

@section('title', 'Reset Password Baru')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center py-10 sm:py-12 px-4">
    <div class="w-full max-w-md rounded-3xl p-8 sm:p-10 shadow-2xl border"
         style="background: var(--bg-card); border-color: var(--border-color);">
        
        <div class="text-center mb-8">
            <span class="pill-badge mb-3">🔒 Keamanan Akun</span>
            <h1 class="font-sora font-extrabold text-2xl mb-2" style="color: var(--text-primary);">Buat Password Baru</h1>
            <p class="text-xs leading-relaxed" style="color: var(--text-body);">
                Silakan buat kata sandi baru untuk akun <strong>{{ $email }}</strong>
            </p>
        </div>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <!-- Email Display -->
            <div>
                <label class="block text-xs font-bold mb-1.5 uppercase tracking-wide" style="color: var(--text-primary);">Email Akun</label>
                <input type="email" value="{{ $email }}" disabled class="form-input opacity-75 bg-gray-50">
            </div>

            <!-- Password Baru -->
            <div>
                <label for="password" class="block text-xs font-bold mb-1.5 uppercase tracking-wide" style="color: var(--text-primary);">Password Baru</label>
                <input id="password" type="password" name="password" required autofocus
                       class="form-input @error('password') border-red-400 @enderror"
                       placeholder="Minimal 8 karakter">
                @error('password')
                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="block text-xs font-bold mb-1.5 uppercase tracking-wide" style="color: var(--text-primary);">Konfirmasi Password Baru</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       class="form-input"
                       placeholder="Ulangi password baru">
            </div>

            <button type="submit" class="btn-primary w-full justify-center py-3.5 text-sm mt-2">
                Simpan Password Baru
            </button>
        </form>
    </div>
</div>
@endsection
