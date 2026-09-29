@extends('layouts.tailadmin')

@section('title', 'Rekapitulasi Hasil Kuesioner : SAPA BK')

@section('content')
<div class="space-y-6">

  <!-- Breadcrumb Back -->
  <div class="flex items-center justify-between">
    <a href="{{ route('bk.tes') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-400 transition-colors">
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
      <span>Kembali ke Daftar Kuesioner</span>
    </a>

    <button
      type="button"
      onclick="window.print()"
      class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200 text-xs font-semibold hover:bg-gray-50 transition-colors"
    >
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
      <span>Cetak Rekap Nilai</span>
    </button>
  </div>

  <!-- Header Card -->
  <div class="rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs p-6 sm:p-8 space-y-2">
    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-brand-50 text-brand-700 dark:bg-brand-950/60 dark:text-brand-300 border border-brand-200 dark:border-brand-800 uppercase">
      Rekapitulasi Asesmen Siswa (SRS F-47)
    </span>
    <h1 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white">{{ $questionnaire->title }}</h1>
    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $questionnaire->description }}</p>
  </div>

  <!-- Results Table (TailAdmin Layout) -->
  <div class="rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs overflow-hidden">
    <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
      <h2 class="text-base font-bold text-gray-900 dark:text-white">Daftar Pengerjaan Peserta Didik</h2>
      <span class="text-xs text-gray-400 font-semibold">Total: {{ $results->total() }} Responden</span>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="border-b border-gray-100 dark:border-gray-800 text-[11px] font-bold text-gray-400 dark:text-gray-400 uppercase tracking-wider bg-gray-50/50 dark:bg-gray-800/30">
            <th class="py-4 px-6">Nama Siswa</th>
            <th class="py-4 px-6">NISN / Kelas</th>
            <th class="py-4 px-6">Waktu Pengerjaan</th>
            <th class="py-4 px-6">Skor Asesmen</th>
            <th class="py-4 px-6">Rekomendasi Profil</th>
            <th class="py-4 px-6 text-right">Tindakan Konselor</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-xs text-gray-600 dark:text-gray-300">
          @forelse($results as $r)
            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors" id="row-result-{{ $r->id }}">
              <td class="py-4 px-6 font-bold text-gray-900 dark:text-white">
                <div class="flex items-center gap-3">
                  <div class="h-8 w-8 rounded-xl bg-gradient-to-tr from-[#205A26] to-[#2E7D34] text-white font-bold flex items-center justify-center text-xs shrink-0">
                    {{ strtoupper(substr($r->user?->name ?? 'S', 0, 2)) }}
                  </div>
                  <span>{{ $r->user?->name ?? 'Siswa' }}</span>
                </div>
              </td>
              <td class="py-4 px-6">
                {{ $r->user?->nisn ?? '-' }} ({{ $r->user?->kelas ?? 'Siswa' }})
              </td>
              <td class="py-4 px-6 text-gray-400">
                {{ $r->created_at->format('d M Y, H:i') }}
              </td>
              <td class="py-4 px-6">
                <span class="font-black text-brand-600 dark:text-brand-400 text-sm">
                  {{ $r->score ?? 0 }}
                </span>
                <span class="text-[10px] text-gray-400">/ {{ $questionnaire->questions->count() * 10 > 0 ? $questionnaire->questions->count() * 10 : 30 }}</span>
              </td>
              <td class="py-4 px-6">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-[#FEFBF0] text-[#7A5200] dark:bg-amber-950/60 dark:text-amber-300 border border-[#FBE9AE]/60 dark:border-amber-800/40">
                  Visual - Auditori
                </span>
              </td>
              <td class="py-4 px-6 text-right">
                <div class="inline-flex items-center gap-2 justify-end">
                  <span id="badge-status-{{ $r->id }}" class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 {{ $r->tindak_lanjut ? '' : 'hidden' }}" title="Catatan tindak lanjut telah disimpan">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                    <span>Ditindaklanjuti</span>
                  </span>

                  <button
                    type="button"
                    onclick="bukaModalTindakLanjut({{ $r->id }})"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-brand-50 hover:bg-brand-100 text-brand-700 dark:bg-brand-950/60 dark:text-brand-300 font-semibold text-xs transition-colors"
                    title="Buka rincian jawaban siswa dan tulis catatan tindak lanjut"
                  >
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    <span>Tindak Lanjut</span>
                  </button>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="py-12 text-center text-gray-400 text-xs">Belum ada siswa yang mengisi kuesioner ini.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($results->hasPages())
      <div class="p-6 border-t border-gray-100 dark:border-gray-800">
        {{ $results->links() }}
      </div>
    @endif
  </div>

</div>

<!-- Modal Tindak Lanjut & Rincian Jawaban Siswa -->
<div
  id="modal-tindak-lanjut-backdrop"
  class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-3 sm:p-5 opacity-0 pointer-events-none transition-opacity duration-200"
  onclick="handleBackdropClick(event)"
>
  <div
    id="modal-tindak-lanjut-box"
    class="w-full max-w-2xl bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-2xl flex flex-col max-h-[92vh] overflow-hidden transform scale-95 transition-transform duration-200"
  >
    <!-- Modal Header -->
    <div class="p-5 sm:p-6 border-b border-gray-100 dark:border-gray-800 flex items-start justify-between bg-white dark:bg-gray-900 shrink-0">
      <div>
        <div class="flex items-center gap-2 mb-1">
          <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-brand-50 text-brand-700 dark:bg-brand-950/60 dark:text-brand-300 border border-brand-200 dark:border-brand-800 uppercase">
            Tindak Lanjut Konselor
          </span>
          <span id="modal-score-badge" class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-extrabold bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300">
            Skor: -
          </span>
        </div>
        <h3 id="modal-student-name" class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
          Memuat data siswa...
        </h3>
        <p id="modal-student-meta" class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
          NISN: - • Kelas: - • Tanggal: -
        </p>
      </div>

      <button
        type="button"
        onclick="tutupModalTindakLanjut()"
        class="h-9 w-9 rounded-xl flex items-center justify-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 shrink-0 transition-colors"
        aria-label="Tutup jendela rincian"
      >
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
      </button>
    </div>

    <!-- Modal Tab Bar -->
    <div class="px-6 border-b border-gray-100 dark:border-gray-800 flex items-center gap-6 bg-gray-50/50 dark:bg-gray-900/50 shrink-0 text-xs font-semibold">
      <button
        type="button"
        id="tab-btn-rekomendasi"
        onclick="gantiTabModal('rekomendasi')"
        class="py-3 border-b-2 border-brand-600 text-brand-600 dark:text-brand-400 transition-colors"
      >
        Form Catatan &amp; Arahan Konselor
      </button>
      <button
        type="button"
        id="tab-btn-jawaban"
        onclick="gantiTabModal('jawaban')"
        class="py-3 border-b-2 border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors flex items-center gap-1.5"
      >
        <span>Jawaban Soal Siswa</span>
        <span id="modal-soal-count" class="px-1.5 py-0.2 rounded-full text-[10px] bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300">0</span>
      </button>
    </div>

    <!-- Modal Body -->
    <div class="p-6 overflow-y-auto custom-scrollbar flex-1 space-y-4">
      
      <!-- Loading State -->
      <div id="modal-loading-state" class="py-12 flex flex-col items-center justify-center gap-3 text-gray-400 text-xs">
        <svg class="animate-spin h-6 w-6 text-brand-600" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        <span>Mengambil rincian asesmen siswa...</span>
      </div>

      <!-- Tab Content 1: Rekomendasi / Tindak Lanjut -->
      <div id="tab-content-rekomendasi" class="space-y-4 hidden">
        <div id="modal-counselor-info" class="p-3.5 rounded-2xl bg-brand-50/60 dark:bg-brand-950/40 border border-brand-200/80 dark:border-brand-900/60 text-xs text-brand-900 dark:text-brand-200 hidden">
          <div class="flex items-center gap-2 font-bold mb-1">
            <svg class="h-4 w-4 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span id="modal-last-counselor">Telah ditindaklanjuti</span>
          </div>
          <p id="modal-last-time" class="text-[11px] text-gray-500 dark:text-gray-400 pl-6"></p>
        </div>

        <div>
          <label for="modal-input-tindak-lanjut" class="block text-xs font-bold text-gray-800 dark:text-gray-200 mb-1.5">
            Catatan Rekomendasi / Tindak Lanjut Konseling:
          </label>
          <p class="text-[11px] text-gray-500 dark:text-gray-400 mb-2">
            Tuliskan saran bimbingan belajar, arahan modalitas, atau kesimpulan konseling. Catatan ini akan ditampilkan secara langsung di dashboard dan lembar hasil siswa.
          </p>
          <textarea
            id="modal-input-tindak-lanjut"
            rows="5"
            placeholder="Contoh: Siswa dominan pada gaya belajar Visual-Auditori. Direkomendasikan membuat mind-mapping dan berdiskusi rutin saat belajar kelompok. Apabila membutuhkan pendampingan lanjutan terkait pemilihan jurusan kuliah, silakan jadwalkan konseling tatap muka atau hubungi via chat..."
            class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-3 text-xs sm:text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all leading-relaxed"
          ></textarea>
        </div>

        <!-- Quick Action Shortcuts -->
        <div class="pt-2 border-t border-gray-100 dark:border-gray-800 space-y-2">
          <span class="block text-[11px] font-bold uppercase tracking-wider text-gray-400">
            Jalan Pintas Komunikasi Siswa:
          </span>
          <div class="flex flex-wrap items-center gap-2">
            <a
              id="modal-btn-wa"
              href="#"
              target="_blank"
              rel="noopener noreferrer"
              class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold bg-emerald-500 hover:bg-emerald-600 text-white shadow-xs transition-colors hidden"
              title="Hubungi langsung via WhatsApp"
            >
              <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
              <span>Hubungi Siswa via WhatsApp</span>
            </a>

            <a
              href="{{ route('bk.live-chat') }}"
              class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold bg-brand-50 hover:bg-brand-100 text-brand-700 dark:bg-brand-950/60 dark:text-brand-300 border border-brand-200 dark:border-brand-800 transition-colors"
              title="Ajak konsultasi di Live Chat Konseling SAPA BK"
            >
              <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
              <span>Ruang Live Chat Siswa</span>
            </a>
          </div>
        </div>
      </div>

      <!-- Tab Content 2: Rincian Butir Jawaban Siswa -->
      <div id="tab-content-jawaban" class="space-y-3 hidden">
        <div id="modal-questions-list" class="space-y-3">
          <!-- Diisi via JavaScript -->
        </div>
      </div>

    </div>

    <!-- Modal Footer -->
    <div class="p-4 sm:p-5 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between bg-gray-50/50 dark:bg-gray-900/50 shrink-0">
      <button
        type="button"
        onclick="tutupModalTindakLanjut()"
        class="px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 transition-colors"
      >
        Tutup
      </button>

      <button
        type="button"
        id="btn-simpan-tindak-lanjut"
        onclick="simpanCatatanTindakLanjut()"
        class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold shadow-md shadow-brand-600/20 transition-all disabled:opacity-50"
      >
        <svg id="spinner-simpan" class="animate-spin h-3.5 w-3.5 hidden" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        <span>Simpan Catatan</span>
      </button>
    </div>

  </div>
</div>

<script>
  let activeResultId = null;
  let activeTabData = 'rekomendasi';

  async function bukaModalTindakLanjut(resultId) {
    activeResultId = resultId;
    const backdrop = document.getElementById('modal-tindak-lanjut-backdrop');
    const box = document.getElementById('modal-tindak-lanjut-box');
    const loadingState = document.getElementById('modal-loading-state');
    const contentRekomendasi = document.getElementById('tab-content-rekomendasi');
    const contentJawaban = document.getElementById('tab-content-jawaban');

    // Tampilkan modal backdrop
    backdrop.classList.remove('opacity-0', 'pointer-events-none');
    backdrop.classList.add('opacity-100');
    box.classList.remove('scale-95');
    box.classList.add('scale-100');

    // Reset tampilan awal ke loading
    loadingState.classList.remove('hidden');
    contentRekomendasi.classList.add('hidden');
    contentJawaban.classList.add('hidden');
    gantiTabModal('rekomendasi');

    try {
      const response = await fetch(`/bk/tes/hasil/${resultId}/detail`, {
        headers: { 'Accept': 'application/json' }
      });
      const res = await response.json();

      if (res.success && res.data) {
        renderModalData(res.data);
      } else {
        window.showToast?.(res.message || 'Gagal memuat detail asesmen.', 'error');
        tutupModalTindakLanjut();
      }
    } catch (err) {
      console.error(err);
      window.showToast?.('Terjadi kendala jaringan saat memuat data.', 'error');
      tutupModalTindakLanjut();
    }
  }

  function renderModalData(d) {
    document.getElementById('modal-student-name').innerText = d.student_name;
    document.getElementById('modal-student-meta').innerText = `NISN: ${d.student_nisn} • Kelas: ${d.student_kelas} • Selesai: ${d.completed_at}`;
    document.getElementById('modal-score-badge').innerText = `Skor: ${d.score ?? 0} Poin`;
    document.getElementById('modal-input-tindak-lanjut').value = d.tindak_lanjut || '';

    // Riwayat konselor jika sudah pernah disimpan
    const counselorBox = document.getElementById('modal-counselor-info');
    if (d.tindak_lanjut && d.counselor_name) {
      counselorBox.classList.remove('hidden');
      document.getElementById('modal-last-counselor').innerText = `Telah ditindaklanjuti oleh: ${d.counselor_name}`;
      document.getElementById('modal-last-time').innerText = `Waktu penyimpanan: ${d.tindak_lanjut_at || '-'}`;
    } else {
      counselorBox.classList.add('hidden');
    }

    // Tombol WhatsApp
    const btnWa = document.getElementById('modal-btn-wa');
    if (d.wa_url) {
      btnWa.href = d.wa_url;
      btnWa.classList.remove('hidden');
    } else {
      btnWa.classList.add('hidden');
    }

    // Render daftar soal dan jawaban
    const countBadge = document.getElementById('modal-soal-count');
    const questionsContainer = document.getElementById('modal-questions-list');
    countBadge.innerText = (d.questions || []).length;
    questionsContainer.innerHTML = '';

    if (!d.questions || d.questions.length === 0) {
      questionsContainer.innerHTML = `
        <div class="py-8 text-center text-xs text-gray-400">
          Tidak ada butir soal yang tercatat pada kuesioner ini.
        </div>
      `;
    } else {
      d.questions.forEach((q, idx) => {
        const item = document.createElement('div');
        item.className = 'p-3.5 rounded-2xl bg-gray-50/70 dark:bg-gray-800/40 border border-gray-100 dark:border-gray-800 space-y-2 text-xs';
        item.innerHTML = `
          <div class="flex items-start gap-2.5">
            <span class="h-5 w-5 rounded-lg bg-brand-100 dark:bg-brand-950 text-brand-700 dark:text-brand-300 font-bold flex items-center justify-center text-[10px] shrink-0 mt-0.5">
              ${idx + 1}
            </span>
            <p class="font-semibold text-gray-900 dark:text-white leading-relaxed">
              ${escapeHtml(q.question_text)}
            </p>
          </div>
          <div class="pl-7">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-white dark:bg-gray-800 border border-brand-200 dark:border-brand-800/60 text-brand-800 dark:text-brand-300 font-bold text-[11px]">
              <svg class="h-3 w-3 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
              <span>Jawaban Siswa: ${escapeHtml(q.answer_label)}</span>
            </span>
          </div>
        `;
        questionsContainer.appendChild(item);
      });
    }

    // Sembunyikan loading, tampilkan tab aktif
    document.getElementById('modal-loading-state').classList.add('hidden');
    gantiTabModal(activeTabData);
  }

  function gantiTabModal(tab) {
    activeTabData = tab;
    const btnRekomendasi = document.getElementById('tab-btn-rekomendasi');
    const btnJawaban = document.getElementById('tab-btn-jawaban');
    const contentRekomendasi = document.getElementById('tab-content-rekomendasi');
    const contentJawaban = document.getElementById('tab-content-jawaban');
    const loadingState = document.getElementById('modal-loading-state');

    if (!loadingState.classList.contains('hidden')) return;

    if (tab === 'rekomendasi') {
      btnRekomendasi.className = 'py-3 border-b-2 border-brand-600 text-brand-600 dark:text-brand-400 font-bold transition-colors';
      btnJawaban.className = 'py-3 border-b-2 border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors flex items-center gap-1.5';
      contentRekomendasi.classList.remove('hidden');
      contentJawaban.classList.add('hidden');
    } else {
      btnJawaban.className = 'py-3 border-b-2 border-brand-600 text-brand-600 dark:text-brand-400 font-bold transition-colors flex items-center gap-1.5';
      btnRekomendasi.className = 'py-3 border-b-2 border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors';
      contentJawaban.classList.remove('hidden');
      contentRekomendasi.classList.add('hidden');
    }
  }

  async function simpanCatatanTindakLanjut() {
    if (!activeResultId) return;

    const textarea = document.getElementById('modal-input-tindak-lanjut');
    const catatan = textarea.value.trim();
    if (!catatan) {
      window.showToast?.('Silakan tuliskan catatan tindak lanjut terlebih dahulu.', 'error');
      textarea.focus();
      return;
    }

    const btnSimpan = document.getElementById('btn-simpan-tindak-lanjut');
    const spinner = document.getElementById('spinner-simpan');

    btnSimpan.disabled = true;
    spinner.classList.remove('hidden');

    try {
      const response = await fetch(`/bk/tes/hasil/${activeResultId}/tindak-lanjut`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ tindak_lanjut: catatan })
      });

      const res = await response.json();

      if (res.success) {
        window.showToast?.(res.message || 'Catatan tindak lanjut berhasil disimpan!', 'success');

        // Munculkan badge "Ditindaklanjuti" pada tabel di baris terkait
        const rowBadge = document.getElementById(`badge-status-${activeResultId}`);
        if (rowBadge) {
          rowBadge.classList.remove('hidden');
        }

        tutupModalTindakLanjut();
      } else {
        window.showToast?.(res.message || 'Gagal menyimpan catatan.', 'error');
      }
    } catch (err) {
      console.error(err);
      window.showToast?.('Terjadi kesalahan jaringan saat menyimpan.', 'error');
    } finally {
      btnSimpan.disabled = false;
      spinner.classList.add('hidden');
    }
  }

  function tutupModalTindakLanjut() {
    const backdrop = document.getElementById('modal-tindak-lanjut-backdrop');
    const box = document.getElementById('modal-tindak-lanjut-box');
    backdrop.classList.add('opacity-0', 'pointer-events-none');
    backdrop.classList.remove('opacity-100');
    box.classList.add('scale-95');
    box.classList.remove('scale-100');
    activeResultId = null;
  }

  function handleBackdropClick(e) {
    if (e.target.id === 'modal-tindak-lanjut-backdrop') {
      tutupModalTindakLanjut();
    }
  }

  // Keyboard navigation: Escape key closes modal
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      const backdrop = document.getElementById('modal-tindak-lanjut-backdrop');
      if (backdrop && !backdrop.classList.contains('pointer-events-none')) {
        tutupModalTindakLanjut();
      }
    }
  });

  function escapeHtml(text) {
    if (!text) return '';
    const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
    return String(text).replace(/[&<>"']/g, m => map[m]);
  }
</script>
@endsection
