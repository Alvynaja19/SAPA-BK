@php
  $user = auth()->user();
  $role = $user?->role ?? 'guru_bk';
@endphp

<aside
  id="tailadmin-sidebar"
  class="fixed top-0 bottom-0 left-0 z-50 flex flex-col border-r border-gray-200/80 bg-white dark:border-gray-800 dark:bg-gray-900 transition-all duration-300 ease-in-out xl:translate-x-0"
  :class="{
    'w-[280px] translate-x-0 shadow-2xl': $store.sidebar.isMobileOpen,
    '-translate-x-full': !$store.sidebar.isMobileOpen,
    'xl:w-[280px]': $store.sidebar.isExpanded || $store.sidebar.isHovered,
    'xl:w-[84px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered
  }"
  @mouseenter="$store.sidebar.setHovered(true)"
  @mouseleave="$store.sidebar.setHovered(false)"
>
  <!-- Sidebar Brand Header -->
  <div class="h-[72px] flex items-center px-4 sm:px-5 border-b border-gray-200/80 dark:border-gray-800 justify-between shrink-0">
    <a href="{{ $role === 'admin' ? route('admin.dashboard') : route('bk.dashboard') }}" class="flex items-center gap-3 overflow-hidden">
      <div class="h-10 w-10 shrink-0 rounded-2xl bg-brand-600 text-white flex items-center justify-center font-extrabold shadow-md shadow-brand-600/25 text-lg">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
      </div>
      <div
        class="transition-opacity duration-200 whitespace-nowrap"
        :class="{
          'opacity-100 block': $store.sidebar.isMobileOpen || $store.sidebar.isExpanded || $store.sidebar.isHovered,
          'opacity-0 hidden xl:block': !$store.sidebar.isMobileOpen && !$store.sidebar.isExpanded && !$store.sidebar.isHovered
        }"
      >
        <span class="block text-base font-extrabold text-[#0F172A] dark:text-white tracking-tight">SAPA <span class="text-brand-600 dark:text-brand-400">BK</span></span>
        <span class="block text-[10px] font-semibold text-gray-500 dark:text-gray-400 tracking-wider uppercase">SMAN 4 JEMBER</span>
      </div>
    </a>

    <!-- Close button for mobile -->
    <button
      type="button"
      @click="$store.sidebar.setMobileOpen(false)"
      class="xl:hidden h-9 w-9 rounded-xl flex items-center justify-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 shrink-0"
      aria-label="Tutup menu sidebar"
    >
      <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
  </div>

  <!-- Navigation Menu List -->
  <div class="flex-1 overflow-y-auto px-3 py-4 space-y-6 custom-scrollbar">
    
    @if($role === 'admin')
      <!-- Group: Superadmin Core -->
      <div>
        <div
          class="px-3 mb-2 text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider transition-opacity duration-200"
          :class="{
            'block': $store.sidebar.isMobileOpen || $store.sidebar.isExpanded || $store.sidebar.isHovered,
            'hidden': !$store.sidebar.isMobileOpen && !$store.sidebar.isExpanded && !$store.sidebar.isHovered
          }"
        >
          Administrator
        </div>

        <nav class="space-y-1">
          <!-- Dashboard Admin -->
          <a
            href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-100/80 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800/80 dark:hover:text-white' }}"
            title="Dashboard Admin"
          >
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
            </svg>
            <span :class="{ 'block': $store.sidebar.isMobileOpen || $store.sidebar.isExpanded || $store.sidebar.isHovered, 'hidden': !$store.sidebar.isMobileOpen && !$store.sidebar.isExpanded && !$store.sidebar.isHovered }">Dashboard</span>
          </a>

          <!-- Manajemen User -->
          <a
            href="{{ route('admin.users') }}"
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.users*') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-100/80 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800/80 dark:hover:text-white' }}"
            title="Manajemen Pengguna"
          >
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
            </svg>
            <span :class="{ 'block': $store.sidebar.isMobileOpen || $store.sidebar.isExpanded || $store.sidebar.isHovered, 'hidden': !$store.sidebar.isMobileOpen && !$store.sidebar.isExpanded && !$store.sidebar.isHovered }">Manajemen User</span>
          </a>

          <!-- Konfigurasi LLM & Vector DB -->
          <a
            href="{{ route('admin.konfigurasi') }}"
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.konfigurasi') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-100/80 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800/80 dark:hover:text-white' }}"
            title="Konfigurasi Sistem & AI"
          >
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span :class="{ 'block': $store.sidebar.isMobileOpen || $store.sidebar.isExpanded || $store.sidebar.isHovered, 'hidden': !$store.sidebar.isMobileOpen && !$store.sidebar.isExpanded && !$store.sidebar.isHovered }">Konfigurasi AI & DB</span>
          </a>

          <!-- System Log -->
          <a
            href="{{ route('admin.log') }}"
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.log') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-100/80 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800/80 dark:hover:text-white' }}"
            title="System Log"
          >
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6.75 7.5l3 3m0 0l-3 3m3-3h7.5M3 18.75h18A2.25 2.25 0 0023.25 16.5v-9A2.25 2.25 0 0021 5.25H3A2.25 2.25 0 00.75 7.5v9A2.25 2.25 0 003 18.75z" />
            </svg>
            <span :class="{ 'block': $store.sidebar.isMobileOpen || $store.sidebar.isExpanded || $store.sidebar.isHovered, 'hidden': !$store.sidebar.isMobileOpen && !$store.sidebar.isExpanded && !$store.sidebar.isHovered }">System Log</span>
          </a>

          <!-- Laporan & Statistik -->
          <a
            href="{{ route('admin.laporan') }}"
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.laporan') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-100/80 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800/80 dark:hover:text-white' }}"
            title="Laporan & Statistik"
          >
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
            </svg>
            <span :class="{ 'block': $store.sidebar.isMobileOpen || $store.sidebar.isExpanded || $store.sidebar.isHovered, 'hidden': !$store.sidebar.isMobileOpen && !$store.sidebar.isExpanded && !$store.sidebar.isHovered }">Laporan & Statistik</span>
          </a>
        </nav>
      </div>
    @endif

    <!-- Group: Modul Bimbingan Konseling (Guru BK + Admin) -->
    <div>
      <div
        class="px-3 mb-2 text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider transition-opacity duration-200"
        :class="{
          'block': $store.sidebar.isMobileOpen || $store.sidebar.isExpanded || $store.sidebar.isHovered,
          'hidden': !$store.sidebar.isMobileOpen && !$store.sidebar.isExpanded && !$store.sidebar.isHovered
        }"
      >
        Layanan BK & Konseling
      </div>

      <nav class="space-y-1">
        @if($role === 'guru_bk')
          <!-- Dashboard Guru BK -->
          <a
            href="{{ route('bk.dashboard') }}"
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('bk.dashboard') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-100/80 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800/80 dark:hover:text-white' }}"
            title="Dashboard Guru BK"
          >
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
            </svg>
            <span :class="{ 'block': $store.sidebar.isMobileOpen || $store.sidebar.isExpanded || $store.sidebar.isHovered, 'hidden': !$store.sidebar.isMobileOpen && !$store.sidebar.isExpanded && !$store.sidebar.isHovered }">Dashboard BK</span>
          </a>
        @endif

        <!-- Data Siswa -->
        <a
          href="{{ route('bk.siswa') }}"
          class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('bk.siswa') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-100/80 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800/80 dark:hover:text-white' }}"
          title="Data Siswa Terdaftar"
        >
          <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
          </svg>
          <span :class="{ 'block': $store.sidebar.isMobileOpen || $store.sidebar.isExpanded || $store.sidebar.isHovered, 'hidden': !$store.sidebar.isMobileOpen && !$store.sidebar.isExpanded && !$store.sidebar.isHovered }">Data Siswa</span>
        </a>

        <!-- Riwayat Percakapan Chatbot -->
        <a
          href="{{ route('bk.percakapan') }}"
          class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('bk.percakapan*') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-100/80 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800/80 dark:hover:text-white' }}"
          title="Riwayat Sesi Chatbot"
        >
          <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 2a1.5 1.5 0 100 3 1.5 1.5 0 000-3zM12 5v3M4 11a3 3 0 013-3h10a3 3 0 013 3v6a3 3 0 01-3 3H7a3 3 0 01-3-3v-6zM2 13v2m20-2v2M9 13v2m6-2v2M10 17h4" />
          </svg>
          <span :class="{ 'block': $store.sidebar.isMobileOpen || $store.sidebar.isExpanded || $store.sidebar.isHovered, 'hidden': !$store.sidebar.isMobileOpen && !$store.sidebar.isExpanded && !$store.sidebar.isHovered }">Riwayat Chat AI</span>
        </a>

        <!-- Live Chat Konseling -->
        <a
          href="{{ route('bk.live-chat') }}"
          class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('bk.live-chat') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-100/80 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800/80 dark:hover:text-white' }}"
          title="Live Chat Siswa (08:00 - 15:00)"
        >
          <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
          </svg>
          <span class="flex items-center justify-between w-full" :class="{ 'block': $store.sidebar.isMobileOpen || $store.sidebar.isExpanded || $store.sidebar.isHovered, 'hidden': !$store.sidebar.isMobileOpen && !$store.sidebar.isExpanded && !$store.sidebar.isHovered }">
            <span>Live Chat Siswa</span>
            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">Live</span>
          </span>
        </a>
      </nav>
    </div>

    <!-- Group: Manajemen Konten & Dokumen -->
    <div>
      <div
        class="px-3 mb-2 text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider transition-opacity duration-200"
        :class="{
          'block': $store.sidebar.isMobileOpen || $store.sidebar.isExpanded || $store.sidebar.isHovered,
          'hidden': !$store.sidebar.isMobileOpen && !$store.sidebar.isExpanded && !$store.sidebar.isHovered
        }"
      >
        Materi & Knowledge
      </div>

      <nav class="space-y-1">
        <!-- E-Book BK -->
        <a
          href="{{ route('bk.ebook') }}"
          class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('bk.ebook') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-100/80 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800/80 dark:hover:text-white' }}"
          title="Manajemen E-Book"
        >
          <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
          </svg>
          <span :class="{ 'block': $store.sidebar.isMobileOpen || $store.sidebar.isExpanded || $store.sidebar.isHovered, 'hidden': !$store.sidebar.isMobileOpen && !$store.sidebar.isExpanded && !$store.sidebar.isHovered }">E-Book BK</span>
        </a>

        <!-- Artikel BK -->
        <a
          href="{{ route('bk.artikel') }}"
          class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('bk.artikel') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-100/80 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800/80 dark:hover:text-white' }}"
          title="Manajemen Artikel"
        >
          <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
          </svg>
          <span :class="{ 'block': $store.sidebar.isMobileOpen || $store.sidebar.isExpanded || $store.sidebar.isHovered, 'hidden': !$store.sidebar.isMobileOpen && !$store.sidebar.isExpanded && !$store.sidebar.isHovered }">Artikel BK</span>
        </a>

        <!-- Knowledge Base (RAG) -->
        <a
          href="{{ route('bk.knowledge') }}"
          class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('bk.knowledge') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-100/80 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800/80 dark:hover:text-white' }}"
          title="Knowledge Base AI (RAG)"
        >
          <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 5.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125m16.5 5.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
          </svg>
          <span :class="{ 'block': $store.sidebar.isMobileOpen || $store.sidebar.isExpanded || $store.sidebar.isHovered, 'hidden': !$store.sidebar.isMobileOpen && !$store.sidebar.isExpanded && !$store.sidebar.isHovered }">Knowledge Base RAG</span>
        </a>

        <!-- Kuesioner & Tes -->
        <a
          href="{{ route('bk.tes') }}"
          class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('bk.tes*') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-100/80 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800/80 dark:hover:text-white' }}"
          title="Kuesioner & Asesmen Minat"
        >
          <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
          </svg>
          <span :class="{ 'block': $store.sidebar.isMobileOpen || $store.sidebar.isExpanded || $store.sidebar.isHovered, 'hidden': !$store.sidebar.isMobileOpen && !$store.sidebar.isExpanded && !$store.sidebar.isHovered }">Kuesioner & Tes</span>
        </a>
      </nav>
    </div>

    <!-- Group: Kontrol Kualitas & Bantuan -->
    <div>
      <div
        class="px-3 mb-2 text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider transition-opacity duration-200"
        :class="{
          'block': $store.sidebar.isMobileOpen || $store.sidebar.isExpanded || $store.sidebar.isHovered,
          'hidden': !$store.sidebar.isMobileOpen && !$store.sidebar.isExpanded && !$store.sidebar.isHovered
        }"
      >
        Evaluasi & Pengaturan
      </div>

      <nav class="space-y-1">
        <!-- Evaluasi Chatbot AI -->
        <a
          href="{{ route('bk.evaluasi') }}"
          class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('bk.evaluasi') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-100/80 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800/80 dark:hover:text-white' }}"
          title="Evaluasi Respons AI"
        >
          <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
          </svg>
          <span :class="{ 'block': $store.sidebar.isMobileOpen || $store.sidebar.isExpanded || $store.sidebar.isHovered, 'hidden': !$store.sidebar.isMobileOpen && !$store.sidebar.isExpanded && !$store.sidebar.isHovered }">Evaluasi Jawaban AI</span>
        </a>

        <!-- FAQ Management -->
        <a
          href="{{ route('bk.faq') }}"
          class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('bk.faq') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-100/80 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800/80 dark:hover:text-white' }}"
          title="Kelola FAQ Publik"
        >
          <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
          </svg>
          <span :class="{ 'block': $store.sidebar.isMobileOpen || $store.sidebar.isExpanded || $store.sidebar.isHovered, 'hidden': !$store.sidebar.isMobileOpen && !$store.sidebar.isExpanded && !$store.sidebar.isHovered }">Kelola FAQ</span>
        </a>
      </nav>
    </div>

  </div>

  <!-- Sidebar Footer User Quick Info -->
  <div class="p-4 border-t border-gray-200/80 dark:border-gray-800 shrink-0">
    <div class="flex items-center gap-3">
      <div class="h-9 w-9 shrink-0 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-bold flex items-center justify-center text-xs">
        {{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}
      </div>
      <div
        class="overflow-hidden transition-opacity duration-200"
        :class="{
          'block': $store.sidebar.isMobileOpen || $store.sidebar.isExpanded || $store.sidebar.isHovered,
          'hidden': !$store.sidebar.isMobileOpen && !$store.sidebar.isExpanded && !$store.sidebar.isHovered
        }"
      >
        <p class="text-xs font-bold text-gray-900 dark:text-white truncate">{{ $user->name ?? 'Pengguna' }}</p>
        <p class="text-[10px] text-gray-500 dark:text-gray-400 capitalize">{{ str_replace('_', ' ', $user->role ?? '') }}</p>
      </div>
    </div>
  </div>

</aside>
