<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Panel Admin — SAPA BK SMA Negeri 4 Jember">
    <title>@yield('title', 'Dashboard') — SAPA BK Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Prevent dark mode flash --}}
    <script>
        (function(){
            if(localStorage.getItem('sapabk-theme')==='dark'){
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <style>
        /* Admin sidebar stays dark always */
        #admin-sidebar {
            background-color: var(--sidebar-bg, #0F172A);
        }
    </style>
</head>
<body class="font-sans antialiased" style="background-color: var(--bg-page); color: var(--text-body);">

<div class="flex h-screen overflow-hidden">

    <!-- ===== SIDEBAR ADMIN/GURU BK ===== -->
    <aside id="admin-sidebar"
           class="w-64 shrink-0 flex flex-col
                  fixed inset-y-0 left-0 z-40 transform -translate-x-full
                  lg:relative lg:translate-x-0 transition-transform duration-300">

        <!-- Logo -->
        <div class="flex items-center gap-3 px-5 py-5 border-b border-white/10">
            <div class="w-9 h-9 rounded-xl overflow-hidden bg-white flex items-center justify-center shrink-0 p-0.5">
                <img src="/logo-sman4.png" alt="Logo SMAN 4 Jember" class="w-full h-full object-contain">
            </div>
            <div>
                <p class="font-bold text-white text-sm leading-tight">SAPA BK</p>
                <p class="text-[10px] text-slate-400">
                    @if(auth()->user()->role === 'admin') Panel Admin @else Panel Guru BK @endif
                </p>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            @if(auth()->user()->role === 'admin')
                {{-- ADMIN MENU --}}
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('admin.dashboard') ? 'bg-[#059669] text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.users') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('admin.users*') ? 'bg-[#059669] text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Manajemen User
                </a>
                <a href="{{ route('admin.konfigurasi') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('admin.konfigurasi') ? 'bg-[#059669] text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Konfigurasi Sistem
                </a>
                <a href="{{ route('admin.log') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('admin.log') ? 'bg-[#059669] text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    System Log
                </a>
                <a href="{{ route('admin.laporan') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('admin.laporan') ? 'bg-[#059669] text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Laporan & Statistik
                </a>

                <div class="pt-3 mt-3 border-t border-white/10">
                    <p class="px-3 py-1 text-[10px] uppercase tracking-wider text-slate-500 font-semibold mb-1">Konten</p>
            @endif

            {{-- GURU BK MENU (also visible to Admin) --}}
            @if(auth()->user()->role === 'guru_bk' || auth()->user()->role === 'admin')
                @if(auth()->user()->role === 'guru_bk')
                <a href="{{ route('counselor.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('counselor.dashboard') ? 'bg-[#059669] text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg>
                    Dashboard
                </a>
                @endif
                <a href="{{ route('counselor.siswa') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('counselor.siswa') ? 'bg-[#059669] text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Data Siswa
                </a>
                <a href="{{ route('counselor.percakapan') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('counselor.percakapan*') ? 'bg-[#059669] text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    Percakapan
                </a>
                <a href="{{ route('counselor.ebook') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('counselor.ebook*') ? 'bg-[#059669] text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    E-book
                </a>
                <a href="{{ route('counselor.artikel') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('counselor.artikel*') ? 'bg-[#059669] text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    Artikel
                </a>
                <a href="{{ route('counselor.knowledge-base') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('counselor.knowledge-base*') ? 'bg-[#059669] text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/></svg>
                    Knowledge Base
                </a>
                <a href="{{ route('counselor.tes') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('counselor.tes*') ? 'bg-[#059669] text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Manajemen Tes
                </a>
                <a href="{{ route('counselor.evaluasi') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('counselor.evaluasi*') ? 'bg-[#059669] text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    Evaluasi Chatbot
                </a>
                <a href="{{ route('counselor.faq') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('counselor.faq*') ? 'bg-[#059669] text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    FAQ
                </a>
            @endif

            @if(auth()->user()->role === 'admin')
                </div><!-- end admin extra section -->
            @endif

            <!-- Logout -->
            <div class="pt-3 mt-3 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-300
                                   hover:bg-red-900/40 hover:text-red-400 transition-all w-full text-left">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- Overlay Mobile -->
    <div id="admin-sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden"></div>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="flex-1 flex flex-col overflow-hidden min-w-0">

        <!-- TOPBAR -->
        <header class="px-4 sm:px-6 h-16 flex items-center justify-between shrink-0"
                style="background: var(--bg-card); border-bottom: 1px solid var(--border-color);">
            <button id="admin-sidebar-toggle"
                    class="lg:hidden p-2 rounded-lg transition-colors mr-2"
                    style="color: var(--text-body);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <h1 class="text-sm sm:text-base font-semibold flex-1 truncate" style="color: var(--text-primary);">
                @yield('page-title', 'Dashboard')
            </h1>

            <div class="flex items-center gap-2 sm:gap-3">
                <!-- Dark Mode Toggle -->
                <button id="dark-toggle-btn" class="dark-toggle" aria-label="Toggle Dark Mode" title="Mode Malam">
                    <svg id="icon-moon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    <svg id="icon-sun" class="w-4 h-4 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </button>

                <div class="hidden sm:block text-right">
                    <p class="text-sm font-semibold leading-tight" style="color: var(--text-primary);">{{ auth()->user()->name }}</p>
                    <p class="text-xs" style="color: var(--text-body);">
                        {{ auth()->user()->role === 'admin' ? 'Administrator' : 'Guru BK' }}
                    </p>
                </div>
                <div class="w-9 h-9 rounded-full bg-[#0F172A] flex items-center justify-center text-white font-bold text-sm shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mx-4 sm:mx-6 mt-4 flex items-center gap-3 p-4 rounded-xl border text-sm font-medium"
                 style="background: rgba(5,150,105,0.1); border-color: rgba(110,231,183,0.4); color: #047857;">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mx-4 sm:mx-6 mt-4 p-4 rounded-xl border text-sm"
                 style="background: rgba(220,38,38,0.08); border-color: rgba(220,38,38,0.25); color: #DC2626;">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- CONTENT -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6">
            @yield('content')
        </main>
    </div>
</div>

<script>
    // ===== DARK MODE TOGGLE =====
    const htmlEl    = document.documentElement;
    const toggleBtn = document.getElementById('dark-toggle-btn');
    const iconMoon  = document.getElementById('icon-moon');
    const iconSun   = document.getElementById('icon-sun');

    function applyTheme(isDark) {
        if (isDark) {
            htmlEl.classList.add('dark');
            iconMoon?.classList.add('hidden');
            iconSun?.classList.remove('hidden');
        } else {
            htmlEl.classList.remove('dark');
            iconMoon?.classList.remove('hidden');
            iconSun?.classList.add('hidden');
        }
    }
    applyTheme(localStorage.getItem('sapabk-theme') === 'dark');

    toggleBtn?.addEventListener('click', () => {
        const isDark = htmlEl.classList.toggle('dark');
        localStorage.setItem('sapabk-theme', isDark ? 'dark' : 'light');
        applyTheme(isDark);
    });

    // ===== ADMIN SIDEBAR TOGGLE =====
    const adminToggle  = document.getElementById('admin-sidebar-toggle');
    const adminSidebar = document.getElementById('admin-sidebar');
    const adminOverlay = document.getElementById('admin-sidebar-overlay');

    adminToggle?.addEventListener('click', () => {
        adminSidebar.classList.toggle('-translate-x-full');
        adminOverlay.classList.toggle('hidden');
    });
    adminOverlay?.addEventListener('click', () => {
        adminSidebar.classList.add('-translate-x-full');
        adminOverlay.classList.add('hidden');
    });
</script>

@stack('scripts')
</body>
</html>
