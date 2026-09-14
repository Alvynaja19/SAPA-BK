@extends('layouts.tailadmin')

@section('title', 'Kelola Soal : ' . $questionnaire->title . ' : SAPA BK SMAN 4 Jember')

@section('content')
<div class="space-y-6" x-data="{
  modalTambah: false,
  modalEdit: false,
  editSoal: { id: null, question_text: '', order: 1, options: [] },
  opsiTambah: [
    { label: '', value: 'A' },
    { label: '', value: 'B' },
    { label: '', value: 'C' }
  ],
  tambahOpsiBaru() {
    const letters = ['A', 'B', 'C', 'D', 'E', 'F'];
    const nextVal = letters[this.opsiTambah.length] || ('Opsi ' + (this.opsiTambah.length + 1));
    this.opsiTambah.push({ label: '', value: nextVal });
  },
  hapusOpsi(index) {
    if (this.opsiTambah.length > 2) {
      this.opsiTambah.splice(index, 1);
    } else {
      alert('Minimal harus menyediakan 2 pilihan jawaban.');
    }
  },
  tambahOpsiEdit() {
    const letters = ['A', 'B', 'C', 'D', 'E', 'F'];
    const nextVal = letters[this.editSoal.options.length] || ('Opsi ' + (this.editSoal.options.length + 1));
    this.editSoal.options.push({ label: '', value: nextVal });
  },
  hapusOpsiEdit(index) {
    if (this.editSoal.options.length > 2) {
      this.editSoal.options.splice(index, 1);
    } else {
      alert('Minimal harus menyediakan 2 pilihan jawaban.');
    }
  }
}">

  <!-- Breadcrumb & Page Header -->
  <div>
    <a href="{{ route('bk.tes') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-brand-600 dark:text-gray-400 mb-3 transition-colors">
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
      <span>Kembali ke Daftar Kuesioner</span>
    </a>
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
          Kelola Butir Soal Asesmen
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
          Instrumen: <strong class="text-gray-800 dark:text-gray-200">{{ $questionnaire->title }}</strong>
        </p>
      </div>

      <button
        type="button"
        @click="modalTambah = true"
        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-semibold text-xs shadow-md shadow-brand-500/20 transition-all self-start sm:self-auto cursor-pointer"
      >
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        <span>Tambah Butir Soal Baru</span>
      </button>
    </div>
  </div>

  @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-semibold flex items-center gap-2">
      <svg class="h-4 w-4 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <!-- Questions List Container -->
  <div class="rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs overflow-hidden">
    <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
      <h2 class="text-base font-bold text-gray-900 dark:text-white">Daftar Pertanyaan &amp; Pilihan Jawaban</h2>
      <span class="text-xs text-gray-400 font-semibold">Total: {{ $questionnaire->questions->count() }} Butir Soal</span>
    </div>

    <div class="divide-y divide-gray-100 dark:border-gray-800">
      @forelse($questionnaire->questions as $index => $soal)
        <div class="p-6 flex flex-col md:flex-row md:items-start justify-between gap-5 hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
          <div class="flex items-start gap-4 flex-1">
            <div class="h-9 w-9 rounded-xl bg-brand-50 text-brand-700 dark:bg-brand-950/60 dark:text-brand-300 font-bold text-sm flex items-center justify-center shrink-0 border border-brand-200/60">
              {{ $index + 1 }}
            </div>
            <div class="space-y-3 flex-1">
              <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-white leading-snug">
                {{ $soal->question_text }}
              </h3>

              <!-- Options Preview -->
              <div class="space-y-1.5 pl-1">
                @if(is_array($soal->options))
                  @foreach($soal->options as $optIdx => $opt)
                    @php
                      $optVal = is_array($opt) ? ($opt['value'] ?? $optIdx) : $opt;
                      $optLabel = is_array($opt) ? ($opt['label'] ?? $optVal) : $opt;
                    @endphp
                    <div class="text-xs text-gray-600 dark:text-gray-300 flex items-start gap-2">
                      <span class="font-bold text-gray-400 dark:text-gray-500 uppercase shrink-0">({{ $optVal }}):</span>
                      <span>{{ $optLabel }}</span>
                    </div>
                  @endforeach
                @endif
              </div>
            </div>
          </div>

          <!-- Actions -->
          <div class="flex items-center gap-2 shrink-0 self-end md:self-start">
            <button
              type="button"
              @click="editSoal = {
                id: {{ $soal->id }},
                question_text: '{{ addslashes($soal->question_text) }}',
                order: {{ $soal->order ?? ($index + 1) }},
                options: {{ json_encode($soal->options ?? []) }}
              }; modalEdit = true"
              class="px-3 py-1.5 rounded-xl border border-gray-200 hover:border-brand-300 dark:border-gray-700 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:text-brand-600 flex items-center gap-1.5 transition-colors cursor-pointer"
            >
              <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
              <span>Edit Soal</span>
            </button>

            <form
              method="POST"
              action="{{ route('bk.tes.soal.destroy', [$questionnaire->id, $soal->id]) }}"
              onsubmit="return confirm('Apakah Anda yakin ingin menghapus butir pertanyaan ini?');"
              class="inline-block"
            >
              @csrf
              @method('DELETE')
              <button
                type="submit"
                class="p-1.5 rounded-xl border border-red-100 hover:border-red-300 dark:border-red-900/40 text-red-500 hover:bg-red-50 dark:hover:bg-red-950/30 transition-colors cursor-pointer"
                title="Hapus Butir Pertanyaan"
              >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
              </button>
            </form>
          </div>
        </div>
      @empty
        <div class="p-12 text-center text-gray-400 text-xs">
          Belum ada butir soal untuk instrumen ini. Silakan klik tombol "Tambah Butir Soal Baru" di atas.
        </div>
      @endforelse
    </div>
  </div>

  <!-- Modal Tambah Butir Soal -->
  <div
    x-show="modalTambah"
    x-transition
    class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-xs flex items-center justify-center p-4"
    style="display: none;"
  >
    <div
      @click.outside="modalTambah = false"
      class="w-full max-w-xl rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-2xl p-6 sm:p-8 space-y-5"
    >
      <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
        <div>
          <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tambah Butir Soal Asesmen</h3>
          <p class="text-xs text-gray-400">Tulis teks pertanyaan dan tentukan opsi jawaban yang dapat dipilih siswa.</p>
        </div>
        <button type="button" @click="modalTambah = false" class="text-gray-400 hover:text-gray-600 cursor-pointer">
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
      </div>

      <form method="POST" action="{{ route('bk.tes.soal.store', $questionnaire->id) }}" class="space-y-4">
        @csrf

        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Teks Pertanyaan / Pernyataan *</label>
          <textarea
            name="question_text"
            rows="3"
            required
            placeholder="Contoh: Saat menghafal rumus atau kosakata bahasa baru, cara mana yang paling sering kamu lakukan?"
            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
          ></textarea>
        </div>

        <div>
          <div class="flex items-center justify-between mb-2">
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">Pilihan Jawaban (Minimal 2) *</label>
            <button
              type="button"
              @click="tambahOpsiBaru()"
              class="text-[11px] font-bold text-brand-600 hover:text-brand-700 cursor-pointer flex items-center gap-1"
            >
              <span>+ Tambah Opsi</span>
            </button>
          </div>

          <div class="space-y-2.5">
            <template x-for="(opsi, idx) in opsiTambah" :key="idx">
              <div class="flex items-center gap-2">
                <input
                  type="text"
                  :name="'options[' + idx + '][value]'"
                  x-model="opsi.value"
                  placeholder="Kode (misal: A, visual)"
                  required
                  class="w-24 px-3 py-2 rounded-xl text-xs font-bold border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white uppercase"
                />
                <input
                  type="text"
                  :name="'options[' + idx + '][label]'"
                  x-model="opsi.label"
                  placeholder="Teks pilihan jawaban..."
                  required
                  class="flex-1 px-3.5 py-2 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white"
                />
                <button
                  type="button"
                  @click="hapusOpsi(idx)"
                  class="p-2 text-gray-400 hover:text-red-500 cursor-pointer"
                  title="Hapus opsi"
                >
                  <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </button>
              </div>
            </template>
          </div>
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
            Simpan Butir Soal
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Edit Butir Soal -->
  <div
    x-show="modalEdit"
    x-transition
    class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-xs flex items-center justify-center p-4"
    style="display: none;"
  >
    <div
      @click.outside="modalEdit = false"
      class="w-full max-w-xl rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-2xl p-6 sm:p-8 space-y-5"
    >
      <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
        <div>
          <h3 class="text-lg font-bold text-gray-900 dark:text-white">Edit Butir Soal Asesmen</h3>
          <p class="text-xs text-gray-400">Perbarui kalimat pertanyaan atau sesuaikan opsi pilihan jawaban.</p>
        </div>
        <button type="button" @click="modalEdit = false" class="text-gray-400 hover:text-gray-600 cursor-pointer">
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
      </div>

      <form method="POST" :action="'/bk/tes/{{ $questionnaire->id }}/soal/' + editSoal.id" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
          <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Teks Pertanyaan / Pernyataan *</label>
          <textarea
            name="question_text"
            rows="3"
            x-model="editSoal.question_text"
            required
            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
          ></textarea>
        </div>

        <div>
          <div class="flex items-center justify-between mb-2">
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">Pilihan Jawaban (Minimal 2) *</label>
            <button
              type="button"
              @click="tambahOpsiEdit()"
              class="text-[11px] font-bold text-brand-600 hover:text-brand-700 cursor-pointer flex items-center gap-1"
            >
              <span>+ Tambah Opsi</span>
            </button>
          </div>

          <div class="space-y-2.5">
            <template x-for="(opsi, idx) in editSoal.options" :key="idx">
              <div class="flex items-center gap-2">
                <input
                  type="text"
                  :name="'options[' + idx + '][value]'"
                  x-model="opsi.value"
                  placeholder="Kode"
                  required
                  class="w-24 px-3 py-2 rounded-xl text-xs font-bold border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white uppercase"
                />
                <input
                  type="text"
                  :name="'options[' + idx + '][label]'"
                  x-model="opsi.label"
                  placeholder="Teks pilihan jawaban..."
                  required
                  class="flex-1 px-3.5 py-2 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white"
                />
                <button
                  type="button"
                  @click="hapusOpsiEdit(idx)"
                  class="p-2 text-gray-400 hover:text-red-500 cursor-pointer"
                  title="Hapus opsi"
                >
                  <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </button>
              </div>
            </template>
          </div>
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
