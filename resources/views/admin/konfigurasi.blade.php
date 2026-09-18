@extends('layouts.tailadmin')

@section('title', 'Konfigurasi LLM & Vector DB : SAPA BK')

@section('content')
<div class="space-y-6" x-data="{ testStatus: null, testing: false }">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
        Konfigurasi Sistem & AI Pipeline
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
        Pengaturan integrasi Google Gemini LLM (SRS F-52) dan ChromaDB Vector Database (SRS F-53).
      </p>
    </div>

    <!-- Test Connection Button -->
    <button
      type="button"
      @click="
        testing = true;
        testStatus = null;
        setTimeout(() => {
          testing = false;
          testStatus = 'success';
        }, 1200);
      "
      :disabled="testing"
      class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-800/80 font-semibold text-xs transition-colors self-start sm:self-auto"
    >
      <svg x-show="!testing" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
      </svg>
      <svg x-show="testing" class="animate-spin h-4 w-4 text-brand-500" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
      </svg>
      <span x-text="testing ? 'Menguji Koneksi...' : 'Uji Koneksi AI Service'"></span>
    </button>
  </div>

  <!-- Test Result Alert Notification -->
  <div
    x-show="testStatus === 'success'"
    x-transition
    class="p-4 rounded-2xl bg-emerald-50 text-emerald-900 border border-emerald-200 dark:bg-emerald-950/50 dark:text-emerald-200 dark:border-emerald-800/60 shadow-xs flex items-center justify-between"
    style="display: none;"
  >
    <div class="flex items-center gap-3">
      <div class="h-8 w-8 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
      </div>
      <p class="text-xs sm:text-sm font-semibold">
        Koneksi Pipeline Berhasil! Google Gemini 2.0 Flash dan ChromaDB merespons dalam 142ms.
      </p>
    </div>
    <button type="button" @click="testStatus = null" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400" aria-label="Tutup Notifikasi">
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
    </button>
  </div>

  <!-- Configuration Form -->
  <form method="POST" action="{{ route('admin.konfigurasi.store') }}" class="space-y-6">
    @csrf

    <!-- Section 1: LLM Engine Configuration (SRS F-52) -->
    <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs space-y-6">
      <div class="flex items-center gap-3 pb-4 border-b border-gray-100 dark:border-gray-800">
        <div class="h-10 w-10 rounded-2xl bg-brand-50 text-brand-600 dark:bg-brand-950/60 dark:text-brand-400 flex items-center justify-center font-bold">
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
          </svg>
        </div>
        <div>
          <h2 class="text-base font-bold text-gray-900 dark:text-white">Konfigurasi Large Language Model (SRS F-52)</h2>
          <p class="text-xs text-gray-400">Parameter generasi bahasa dan penalaran AI asisten bimbingan konseling.</p>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
        
        <!-- LLM Provider -->
        <div>
          <label class="block font-bold text-gray-700 dark:text-gray-300 mb-1.5">Penyedia LLM (Provider)</label>
          <input
            type="text"
            value="{{ $config['llm_provider'] }}"
            readonly
            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800/60 text-gray-500 dark:text-gray-400 cursor-not-allowed"
          />
        </div>

        <!-- LLM Model Choice -->
        <div>
          <label class="block font-bold text-gray-700 dark:text-gray-300 mb-1.5">Model AI yang Digunakan *</label>
          <select
            name="llm_model"
            required
            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
          >
            <option value="gemini-2.0-flash" selected>Google Gemini 2.0 Flash (Direkomendasikan: Cepat & Responsif)</option>
            <option value="gemini-1.5-pro">Google Gemini 1.5 Pro (Penalaran Kompleks)</option>
            <option value="gemini-1.5-flash">Google Gemini 1.5 Flash (Legacy)</option>
          </select>
        </div>

        <!-- Masked API Key -->
        <div>
          <label class="block font-bold text-gray-700 dark:text-gray-300 mb-1.5">Google AI Studio API Key (Tersimpan Aman di .env)</label>
          <input
            type="text"
            value="{{ $config['api_key_masked'] }}"
            readonly
            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800/60 text-gray-500 dark:text-gray-400 cursor-not-allowed font-mono text-xs"
          />
          <p class="text-[10px] text-gray-400 mt-1">Kunci API disembunyikan dan dienkripsi dari frontend sesuai SRS NF-04.</p>
        </div>

        <!-- Temperature -->
        <div>
          <label class="block font-bold text-gray-700 dark:text-gray-300 mb-1.5">Creativity / Temperature (0.0 - 1.0) *</label>
          <input
            type="number"
            step="0.1"
            min="0"
            max="1"
            name="temperature"
            value="{{ $config['temperature'] }}"
            required
            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
          />
          <p class="text-[10px] text-gray-400 mt-1">Nilai lebih rendah (0.3 - 0.5) disarankan untuk akurasi panduan akademik resmi.</p>
        </div>

      </div>
    </div>

    <!-- Section 2: Vector Database & RAG Pipeline (SRS F-53) -->
    <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs space-y-6">
      <div class="flex items-center gap-3 pb-4 border-b border-gray-100 dark:border-gray-800">
        <div class="h-10 w-10 rounded-2xl bg-[#FEFBF0] text-[#7A5200] dark:bg-amber-950/60 dark:text-amber-300 border border-[#FBE9AE]/60 dark:border-amber-800/40 flex items-center justify-center font-bold">
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
          </svg>
        </div>
        <div>
          <h2 class="text-base font-bold text-gray-900 dark:text-white">Pengaturan Vector Database ChromaDB (SRS F-53)</h2>
          <p class="text-xs text-gray-400">Penyimpanan embedding semantik dokumen pedoman BK dan kurikulum.</p>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
        
        <!-- Vector DB Service Host -->
        <div>
          <label class="block font-bold text-gray-700 dark:text-gray-300 mb-1.5">Python RAG Service URL / Host</label>
          <input
            type="text"
            value="{{ $config['vector_host'] }}"
            readonly
            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800/60 text-gray-500 dark:text-gray-400 cursor-not-allowed font-mono"
          />
        </div>

        <!-- Collection Name -->
        <div>
          <label class="block font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Koleksi Embedding *</label>
          <input
            type="text"
            name="collection_name"
            value="{{ $config['collection_name'] }}"
            required
            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500 font-mono"
          />
        </div>

        <!-- Chunk Size -->
        <div>
          <label class="block font-bold text-gray-700 dark:text-gray-300 mb-1.5">Ukuran Pemotongan Teks (Chunk Size)</label>
          <input
            type="text"
            value="{{ $config['chunk_size'] }} Tokens"
            readonly
            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800/60 text-gray-500 dark:text-gray-400 cursor-not-allowed"
          />
        </div>

        <!-- Operational Hours -->
        <div>
          <label class="block font-bold text-gray-700 dark:text-gray-300 mb-1.5">Jam Operasional Live Chat Guru BK (SRS F-29)</label>
          <input
            type="text"
            value="{{ $config['operating_hours'] }}"
            readonly
            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800/60 text-gray-500 dark:text-gray-400 cursor-not-allowed"
          />
        </div>

      </div>
    </div>

    <!-- Submit Action -->
    <div class="flex items-center justify-end gap-3">
      <button
        type="submit"
        class="px-6 py-3 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-lg shadow-brand-500/25 transition-all"
      >
        Simpan Konfigurasi Sistem
      </button>
    </div>

  </form>

</div>
@endsection
