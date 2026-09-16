@extends('layouts.tailadmin')

@section('title', 'Live Chat Konseling Siswa — SAPA BK')

@section('content')
<div class="h-[calc(100vh-160px)] flex flex-col lg:flex-row gap-6">
  
  <!-- Left Column: Antrean Siswa Konseling (SRS F-29 & F-42b) -->
  <div class="w-full lg:w-80 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs flex flex-col shrink-0 overflow-hidden">
    
    <div class="p-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
      <div>
        <h3 class="font-bold text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">Antrean Siswa Konseling</h3>
        <p class="text-[10px] text-emerald-600 dark:text-emerald-400 font-semibold">Jam Operasional: 08:00 - 15:00 WIB</p>
      </div>
      <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
    </div>

    <div class="flex-1 overflow-y-auto custom-scrollbar p-3 space-y-2" id="student-list-container">
      @foreach($siswaList as $idx => $sw)
        <div
          class="student-card p-3 rounded-2xl border border-gray-100 dark:border-gray-800 hover:border-brand-300 hover:bg-brand-50/50 dark:hover:bg-gray-800/60 cursor-pointer transition-all flex items-center gap-3"
          onclick="selectStudent(this, '{{ addslashes($sw->name) }}', '{{ addslashes($sw->kelas ?? 'Kelas Siswa') }}')"
        >
          <div class="h-9 w-9 rounded-xl bg-gradient-to-tr from-[#205A26] to-[#2E7D34] text-white font-bold flex items-center justify-center text-xs shrink-0">
            {{ strtoupper(substr($sw->name, 0, 2)) }}
          </div>
          <div class="truncate flex-1">
            <h4 class="font-bold text-xs text-gray-900 dark:text-white truncate">{{ $sw->name }}</h4>
            <p class="text-[11px] text-gray-400 font-medium">{{ $sw->kelas ?? 'Kelas Siswa' }}</p>
          </div>
          <span class="h-2 w-2 rounded-full bg-emerald-500 shrink-0"></span>
        </div>
      @endforeach
    </div>

    <div class="p-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30 text-[11px] text-gray-400">
      Siswa aktif terhubung langsung dengan ruang konseling digital. Identitas ditampilkan lengkap sesuai SRS F-29.
    </div>

  </div>

  <!-- Right Column: Live Chat Room -->
  <div class="flex-1 rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-xs flex flex-col overflow-hidden">
    
    <!-- Chat Header -->
    <div class="h-16 px-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between bg-white dark:bg-gray-900 shrink-0">
      <div class="flex items-center gap-3">
        <div class="h-9 w-9 rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-950/60 dark:text-brand-400 flex items-center justify-center font-bold">
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
        </div>
        <div>
          <h3 class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white" id="current-student-name">
            {{ $siswaList->first()->name ?? 'Ahmad Fauzi Pratama' }}
          </h3>
          <p class="text-[11px] text-gray-400 font-medium" id="current-student-class">
            {{ $siswaList->first()->kelas ?? 'XII MIPA 1' }} • Status: Terhubung Sesi Konseling
          </p>
        </div>
      </div>

      <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
        Live Counseling Active
      </span>
    </div>

    <!-- Messages Container -->
    <div class="flex-1 p-6 overflow-y-auto space-y-4 bg-gray-50/50 dark:bg-gray-950/50 custom-scrollbar" id="chat-messages-container">
      
      <!-- Student Bubble -->
      <div class="flex items-start gap-3 max-w-xl">
        <div class="h-8 w-8 rounded-xl bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-bold flex items-center justify-center shrink-0">
          S
        </div>
        <div class="space-y-1">
          <div class="p-4 rounded-2xl rounded-tl-none bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 text-xs sm:text-sm shadow-xs border border-gray-100 dark:border-gray-700/60 leading-relaxed">
            Selamat pagi Bapak/Ibu Guru BK, saya ingin berkonsultasi mengenai pilihan program studi SNBP. Nilai biologi dan kimia saya stabil di angka 90, apakah berpeluang jika memilih Farmasi di Universitas Jember?
          </div>
          <span class="text-[10px] text-gray-400 pl-1">08:15 WIB</span>
        </div>
      </div>

      <!-- Counselor Bubble -->
      <div class="flex items-start justify-end gap-3 max-w-xl ml-auto">
        <div class="space-y-1 text-right">
          <div class="p-4 rounded-2xl rounded-tr-none bg-brand-500 text-white text-xs sm:text-sm shadow-md shadow-brand-500/20 text-left leading-relaxed">
            Selamat pagi! Pilihan yang sangat bagus. Nilai Biologi dan Kimia 90 adalah modal kuat pada Kurikulum Merdeka untuk rumpun Saintek/Kesehatan. Nanti siang silakan mampir ke ruang BK setelah istirahat kedua untuk melihat persebaran alumni SMAN 4 Jember di UNEJ ya!
          </div>
          <span class="text-[10px] text-gray-400 pr-1">08:17 WIB • Terbaca</span>
        </div>
        <div class="h-8 w-8 rounded-xl bg-gradient-to-tr from-[#205A26] to-[#2E7D34] text-white text-xs font-bold flex items-center justify-center shrink-0">
          BK
        </div>
      </div>

    </div>

    <!-- Chat Input Box -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 shrink-0">
      <form class="flex items-center gap-2" onsubmit="event.preventDefault(); sendMessageLive();">
        <input
          type="text"
          id="input-pesan-guru"
          placeholder="Tulis pesan bimbingan konseling untuk siswa..."
          class="grow px-4 py-2.5 rounded-xl text-xs border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-hidden focus:border-brand-500"
        />
        <button
          type="submit"
          class="px-5 py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-md shadow-brand-500/20 transition-all flex items-center gap-1.5 shrink-0"
        >
          <span>Kirim</span>
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
        </button>
      </form>
    </div>

  </div>

</div>

<script>
  const activeClasses = ['bg-brand-50/70', 'border-brand-200', 'dark:bg-brand-950/40', 'dark:border-brand-800'];
  const defaultClasses = ['border-gray-100', 'dark:border-gray-800'];

  function selectStudent(element, name, kelas) {
    // Kembalikan semua kartu siswa ke tampilan default (tidak berwarna hijau)
    document.querySelectorAll('.student-card').forEach(card => {
      card.classList.remove(...activeClasses);
      card.classList.add(...defaultClasses);
    });

    // Beri warna hijau pada kartu siswa yang dipilih guru BK
    if (element) {
      element.classList.remove(...defaultClasses);
      element.classList.add(...activeClasses);
    }

    const nameEl = document.getElementById('current-student-name');
    if (nameEl) nameEl.innerText = name;

    const classEl = document.getElementById('current-student-class');
    if (classEl) classEl.innerText = (kelas || 'Kelas Siswa') + ' • Status: Terhubung Sesi Konseling';
  }

  function sendMessageLive() {
    const input = document.getElementById('input-pesan-guru');
    const text = input.value.trim();
    if (!text) return;

    const container = document.getElementById('chat-messages-container');
    const bubble = document.createElement('div');
    bubble.className = 'flex items-start justify-end gap-3 max-w-xl ml-auto';
    bubble.innerHTML = `
      <div class="space-y-1 text-right">
        <div class="p-4 rounded-2xl rounded-tr-none bg-brand-500 text-white text-xs sm:text-sm shadow-md shadow-brand-500/20 text-left leading-relaxed">
          ${text}
        </div>
        <span class="text-[10px] text-gray-400 pr-1">Baru saja • Terkirim</span>
      </div>
      <div class="h-8 w-8 rounded-xl bg-gradient-to-tr from-[#205A26] to-[#2E7D34] text-white text-xs font-bold flex items-center justify-center shrink-0">
        BK
      </div>
    `;
    container.appendChild(bubble);
    container.scrollTop = container.scrollHeight;
    input.value = '';
  }
</script>
@endsection
