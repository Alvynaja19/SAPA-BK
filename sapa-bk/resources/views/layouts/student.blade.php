<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal Konsultasi Siswa — SAPA BK SMA Negeri 4 Jember">
    <title>@yield('title', 'Dashboard Siswa') — SAPA BK SMAN 4 Jember</title>

    <!-- Google Fonts: Sora & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

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
</head>
<body class="font-sans antialiased" style="background-color: var(--bg-page); color: var(--text-body);">

<div class="flex h-screen overflow-hidden">

    <!-- ===== SIDEBAR SISWA ===== -->
    <aside id="sidebar"
           class="w-64 shrink-0 flex flex-col
                  fixed inset-y-0 left-0 z-40 transform -translate-x-full
                  lg:relative lg:translate-x-0 transition-transform duration-300"
           style="background: var(--bg-card); border-right: 1px solid var(--border-color);">

        <!-- Logo Emblem -->
        <div class="flex items-center gap-3 px-6 py-5" style="border-bottom: 1px solid var(--border-color);">
            <div class="w-10 h-10 rounded-2xl overflow-hidden bg-white flex items-center justify-center shadow-md shadow-[#059669]/20 shrink-0 p-0.5">
                <img src="/logo-sman4.png" alt="Logo SMAN 4 Jember" class="w-full h-full object-contain">
            </div>
            <div>
                <span class="font-sora font-extrabold text-base leading-none block" style="color: var(--text-primary);">SAPA BK</span>
                <span class="text-[10px] font-bold text-[#059669] leading-tight block mt-0.5 uppercase tracking-wide">Portal Siswa</span>
            </div>
        </div>

        <!-- Nav Menu -->
        <nav class="flex-1 overflow-y-auto px-4 py-5 space-y-1.5">
            <a href="{{ route('student.dashboard') }}"
               class="sidebar-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg>
                <span class="font-sora text-xs font-semibold">Dashboard</span>
            </a>
            <a href="{{ route('student.chat') }}"
               class="sidebar-item {{ request()->routeIs('student.chat*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                <span class="font-sora text-xs font-semibold">Konsultasi AI BK</span>
            </a>
            <a href="{{ route('student.riwayat') }}"
               class="sidebar-item {{ request()->routeIs('student.riwayat') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="font-sora text-xs font-semibold">Riwayat Sesi</span>
            </a>
            <a href="{{ route('student.ebook') }}"
               class="sidebar-item {{ request()->routeIs('student.ebook') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                <span class="font-sora text-xs font-semibold">Perpustakaan E-Book</span>
            </a>
            <a href="{{ route('student.tes') }}"
               class="sidebar-item {{ request()->routeIs('student.tes*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                <span class="font-sora text-xs font-semibold">Tes & Kuesioner</span>
            </a>

            <div class="pt-4 mt-4 space-y-1" style="border-top: 1px solid var(--border-color);">
                <a href="{{ route('student.profil') }}"
                   class="sidebar-item {{ request()->routeIs('student.profil') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span class="font-sora text-xs font-semibold">Profil Saya</span>
                </a>
                <a href="{{ route('home') }}" class="sidebar-item">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span class="font-sora text-xs font-semibold">Halaman Utama</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="sidebar-item w-full text-left font-semibold"
                            style="color: #EF4444;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span class="font-sora text-xs">Keluar</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- Overlay Mobile -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden backdrop-blur-sm"></div>

    <!-- ===== MAIN CONTENT AREA ===== -->
    <div class="flex-1 flex flex-col overflow-hidden min-w-0">

        <!-- TOPBAR -->
        <header class="px-4 sm:px-6 h-16 flex items-center justify-between shrink-0"
                style="background: var(--bg-card); border-bottom: 1px solid var(--border-color);">
            <!-- Hamburger -->
            <button id="sidebar-toggle"
                    class="lg:hidden p-2 rounded-xl transition-colors mr-2"
                    style="color: var(--text-body);">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <!-- Page Title -->
            <h1 class="font-sora font-extrabold text-sm sm:text-base flex-1 truncate" style="color: var(--text-primary);">
                @yield('page-title', 'Dashboard Siswa')
            </h1>

            <!-- Right Controls -->
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

                <!-- User Info -->
                <div class="hidden sm:block text-right">
                    <p class="font-sora font-bold text-xs leading-tight" style="color: var(--text-primary);">{{ auth()->user()->name }}</p>
                    <span class="badge-green text-[10px] py-0.5">Siswa SMAN 4 Jember</span>
                </div>
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-2xl bg-gradient-to-tr from-[#047857] to-[#10B981] flex items-center justify-center text-white font-sora font-extrabold text-sm shadow-md shadow-[#059669]/20 shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mx-4 sm:mx-6 mt-4 flex items-center gap-3 p-4 rounded-2xl border text-xs font-semibold shadow-sm"
                 style="background: rgba(5,150,105,0.1); border-color: rgba(110,231,183,0.4); color: #047857;">
                <svg class="w-5 h-5 shrink-0 text-[#059669]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
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

    // ===== SIDEBAR TOGGLE =====
    const sidebarToggle  = document.getElementById('sidebar-toggle');
    const sidebar        = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    sidebarToggle?.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        sidebarOverlay.classList.toggle('hidden');
    });
    sidebarOverlay?.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
    });
</script>

@stack('scripts')
</body>
</html>
