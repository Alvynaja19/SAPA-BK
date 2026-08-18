@extends('layouts.student')
@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    {{-- Avatar Card --}}
    <div class="card p-6 flex items-center gap-5">
        <div class="w-16 h-16 rounded-full bg-[#059669] flex items-center justify-center text-white font-extrabold text-2xl shrink-0">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
            <h2 class="font-bold text-[#0F172A] text-lg">{{ $user->name }}</h2>
            <p class="text-sm text-[#475569]">{{ $user->email }}</p>
            <span class="badge-green mt-1 inline-block">Siswa</span>
        </div>
    </div>

    {{-- Form Edit Profil --}}
    <div class="card p-6">
        <h3 class="font-semibold text-[#0F172A] mb-5">Informasi Akun</h3>
        <form method="POST" action="{{ route('student.profil.update') }}" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-[#0F172A] mb-1.5">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input" required>
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-[#0F172A] mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input" required>
                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
