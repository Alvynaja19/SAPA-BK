@extends('layouts.tailadmin')

@section('title', 'Kuesioner & Asesmen : SAPA BK SMAN 4 Jember')

@section('content')
<div class="space-y-6" x-data="{ modalTambah: false, modalEdit: false, editData: { id: null, title: '', description: '', is_active: true } }">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
        Kuesioner &amp; Asesmen Minat Siswa
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
        Kelola instrumen kuesioner, atur butir soal pemetaan, dan pantau rekapitulasi hasil asesmen siswa (SRS F-46).
      </p>
    </div>

    <!-- Buat Kuesioner Baru Button -->
    <button
      type="button"
      @click="modalTambah = true"
      class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-semibold text-xs shadow-md shadow-brand-500/20 transition-all self-start sm:self-auto cursor-pointer"
    >
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
      <span>Buat Kuesioner Baru</span>
    </button>
  </div>

  @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-semibold flex items-center gap-2">
      <svg class="h-4 w-4 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <!-- Questionnaire List Card -->
  <div class="rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs overflow-hidden">
    <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
      <h2 class="text-base font-bold text-gray-900 dark:text-white">Daftar Kuesioner Asesmen</h2>
      <span class="text-xs text-gray-400 font-semibold">Total: {{ $questionnaires->total() }} Instrumen</span>
    </div>

    <div class="divide-y divide-gray-100 dark:divide-gray-800">
      @forelse($questionnaires as $q)
        <div class="p-6 flex flex-col lg:flex-row lg:items-center justify-between gap-5 hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
          <div class="flex items-start gap-4">
            <div class="h-12 w-12 rounded-2xl bg-[#FEFBF0] text-[#7A5200] dark:bg-amber-950/60 dark:text-amber-300 border border-[#FBE9AE]/60 dark:border-amber-800/40 flex items-center justify-center font-bold text-xl shrink-0">
              <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" /></svg>
            </div>
            <div class="space-y-1.5">
              <div class="flex items-center gap-2.5 flex-wrap">
                <h3 class="text-base font-bold text-gray-900 dark:text-white">{{ $q->title }}</h3>
                @if($q->is_active)
                  <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    Aktif
                  </span>
                @else
                  <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2 py-0.5 rounded-md bg-gray-100 text-gray-600 border border-gray-200">
                    Nonaktif
                  </span>
                @endif
              </div>
              <p class="text-xs text-gray-500 dark:text-gray-400 max-w-2xl leading-relaxed">{{ $q->description }}</p>
              <div class="flex items-center gap-3 text-xs text-gray-400 pt-1 flex-wrap">
                <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $q->results_count }} Siswa Telah Mengerjakan</span>
                <span>&bull;</span>
                <span class="font-semibold text-brand-600 dark:text-brand-400">{{ $q->questions()->count() }} Butir Soal</span>
              </div>
            </div>
          </div>

          <!-- Action Buttons Group -->
          <div class="flex items-center gap-2 shrink-0 flex-wrap">
            <!-- Kelola Soal Button -->
            <a
              href="{{ route('bk.tes.soal', $q->id) }}"
              class="px-3.5 py-2 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-900 border border-amber-200 dark:bg-amber-950/40 dark:border-amber-800 dark:text-amber-200 font-bold text-xs transition-all flex items-center gap-1.5"
              title="Kelola Butir Soal Kuesioner"
            >
              <svg class="h-4 w-4 text-amber-700 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
              <span>Kelola Soal ({{ $q->questions()->count() }})</span>
            </a>

            <!-- Rekap Hasil Siswa Button -->
            <a
              href="{{ route('bk.tes.hasil', $q->id) }}"
              class="px-3.5 py-2 rounded-xl bg-brand-50 hover:bg-brand-100 text-brand-800 border border-brand-200 dark:bg-brand-950/40 dark:border-brand-800 dark:text-brand-200 font-bold text-xs transition-all flex items-center gap-1.5"
              title="Lihat Rekapitulasi Jawaban Siswa"
            >
              <svg class="h-4 w-4 text-brand-600 dark:text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
              <span>Rekap Hasil</span>
            </a>

            <!-- Edit Kuesioner Button -->
            <button
              type="button"
              @click="editData = { id: {{ $q->id }}, title: '{{ addslashes($q->title) }}', description: '{{ addslashes($q->description) }}', is_active: {{ $q->is_active ? 'true' : 'false' }} }; modalEdit = true"
              class="p-2 rounded-xl border border-gray-200 hover:border-brand-300 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:text-brand-600 transition-colors cursor-pointer"
              title="Edit Informasi Kuesioner"
            >
              <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
            </button>

            <!-- Hapus Kuesioner Form -->
            <form
              method="POST"
              action="{{ route('bk.tes.destroy', $q->id) }}"
              data-confirm="Apakah Anda yakin ingin menghapus kuesioner ini beserta seluruh butir soal dan rekap hasil siswa terkait? Tindakan ini tidak dapat dibatalkan."
              data-confirm-title="Hapus Kuesioner?"
              data-confirm-type="danger"
              data-confirm-btn="Ya, Hapus Kuesioner"
              class="inline-block"
            >
              @csrf
              @method('DELETE')
              <button
                type="submit"
                class="p-2 rounded-xl border border-red-100 hover:border-red-300 dark:border-red-900/40 text-red-500 hover:bg-red-50 dark:hover:bg-red-950/30 transition-colors cursor-pointer"
                title="Hapus Kuesioner"
              >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
              </button>
            </form>
          </div>
        </div>
      @empty
        <div class="p-12 text-center text-gray-400 text-xs">Belum ada kuesioner yang dibuat.</div>
      @endforelse
    </div>

    @if($questionnaires->hasPages())
      <div class="p-6 border-t border-gray-100 dark:border-gray-800">
        {{ $questionnaires->links() }}
      </div>
    @endif
  </div>

  <!-- Modal Buat Kuesioner Baru -->
  <div
    x-show="modalTambah"
    x-transition
    class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-xs flex items-center justify-center p-4"
    style="display: none;"
  >
    <div
      @click.outside="modalTambah = false"
      class="w-full max-w-lg rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-2xl p-6 sm:p-8 space-y-5"
    >
      <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
        <div>
          <h3 class="text-lg font-bold text-gray-900 dark:text-white">Buat Kuesioner Asesmen Baru</h3>
          <p class="text-xs text-gray-400">Rancang kuesioner asesmen diagnostik minat/bakat untuk siswa (SRS F-46).</p>
        </div>
        <button type="button" @click="modalTambah = false" class="text-gray-400 hover:text-gray-600 cursor-pointer">
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
      </div>

      <form method="POST" action="{{ route('bk.tes.store') }}" class="space-y-4">
        @csrf

        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Judul Kuesioner / Asesmen *</label>
          <input
            type="text"
            name="title"
            required
            placeholder="Contoh: Kuesioner Minat Karir dan Bidang Keahlian 2026"
            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
          />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Deskripsi &amp; Petunjuk Pengisian *</label>
          <textarea
            name="description"
            rows="4"
            required
            placeholder="Jelaskan tujuan asesmen dan instruksi bagi siswa saat menjawab..."
            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
          ></textarea>
        </div>

        <div class="pt-1">
          <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_active" value="1" checked class="rounded text-brand-600 focus:ring-brand-500">
            <span class="text-xs text-gray-700 dark:text-gray-300 font-semibold">Aktifkan kuesioner ini agar langsung dapat diisi siswa</span>
          </label>
        </div>

        <div class="pt-4 border-t border-gray-100 dark:border-gray-800 flex items-center justify-end gap-3">
          <button
            type="button"
            @click="modalTambah = false"
            class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer"
          >
            Batal
          </button>
          <button
            type="submit"
            class="px-5 py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-md shadow-brand-500/20 cursor-pointer"
          >
            Simpan Kuesioner
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Edit Kuesioner -->
  <div
    x-show="modalEdit"
    x-transition
    class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-xs flex items-center justify-center p-4"
    style="display: none;"
  >
    <div
      @click.outside="modalEdit = false"
      class="w-full max-w-lg rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-2xl p-6 sm:p-8 space-y-5"
    >
      <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
        <div>
          <h3 class="text-lg font-bold text-gray-900 dark:text-white">Edit Informasi Kuesioner</h3>
          <p class="text-xs text-gray-400">Perbarui judul, deskripsi, atau status keaktifan instrumen asesmen.</p>
        </div>
        <button type="button" @click="modalEdit = false" class="text-gray-400 hover:text-gray-600 cursor-pointer">
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
      </div>

      <form method="POST" :action="'/bk/tes/' + editData.id" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Judul Kuesioner / Asesmen *</label>
          <input
            type="text"
            name="title"
            x-model="editData.title"
            required
            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
          />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Deskripsi &amp; Petunjuk Pengisian *</label>
          <textarea
            name="description"
            rows="4"
            x-model="editData.description"
            required
            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
          ></textarea>
        </div>

        <div class="pt-1">
          <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_active" value="1" x-model="editData.is_active" class="rounded text-brand-600 focus:ring-brand-500">
            <span class="text-xs text-gray-700 dark:text-gray-300 font-semibold">Kuesioner ini aktif dan dapat dikerjakan siswa</span>
          </label>
        </div>

        <div class="pt-4 border-t border-gray-100 dark:border-gray-800 flex items-center justify-end gap-3">
          <button
            type="button"
            @click="modalEdit = false"
            class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer"
          >
            Batal
          </button>
          <button
            type="submit"
            class="px-5 py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-md shadow-brand-500/20 cursor-pointer"
          >
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection
