<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SAPA BK — Platform Pendamping Akademik & Kesehatan Mental Siswa SMAN 4 Jember">
    <title>@yield('title', 'SAPA BK') — Platform Digital BK SMAN 4 Jember</title>

    <!-- Google Fonts: Sora & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Apply dark mode before render to avoid flash --}}
    <script>
        (function(){
            if(localStorage.getItem('sapabk-theme')==='dark'){
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>
<body class="font-sans antialiased selection:bg-emerald-100 selection:text-emerald-800"
      style="background-color: var(--bg-page); color: var(--text-body);">

    <!-- ===== NAVBAR PUBLIK ===== -->
    <header class="glass-header sticky top-0 z-50 border-b transition-all duration-300" style="border-color: var(--glass-border);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 group shrink-0">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-2xl overflow-hidden bg-white flex items-center justify-center shadow-md shadow-[#059669]/20 group-hover:scale-105 transition-transform p-0.5 shrink-0">
                        <img src="/logo-sman4.png" alt="Logo SMAN 4 Jember" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <span class="font-sora font-extrabold text-base sm:text-lg leading-none tracking-tight block" style="color: var(--text-primary);">SAPA BK</span>
                        <span class="text-[10px] sm:text-[11px] font-medium text-[#059669] leading-tight block mt-0.5">SMAN 4 JEMBER</span>
                    </div>
                </a>

                <!-- Nav Links (Desktop Navigation) -->
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('home') }}"
                       class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200
                              {{ request()->routeIs('home') ? 'bg-[#059669] text-white shadow-md shadow-[#059669]/30' : 'hover:bg-slate-100' }}"
                       style="{{ !request()->routeIs('home') ? 'color: var(--text-body);' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('tentang') }}"
                       class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200
                              {{ request()->routeIs('tentang') ? 'bg-[#059669] text-white shadow-md shadow-[#059669]/30' : 'hover:bg-slate-100' }}"
                       style="{{ !request()->routeIs('tentang') ? 'color: var(--text-body);' : '' }}">
                        Tentang BK
                    </a>
                    <a href="{{ route('ebook.public') }}"
                       class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200
                              {{ request()->routeIs('ebook.public') ? 'bg-[#059669] text-white shadow-md shadow-[#059669]/30' : 'hover:bg-slate-100' }}"
                       style="{{ !request()->routeIs('ebook.public') ? 'color: var(--text-body);' : '' }}">
                        E-Book
                    </a>
                    <a href="{{ route('artikel.list') }}"
                       class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200
                              {{ request()->routeIs('artikel.*') ? 'bg-[#059669] text-white shadow-md shadow-[#059669]/30' : 'hover:bg-slate-100' }}"
                       style="{{ !request()->routeIs('artikel.*') ? 'color: var(--text-body);' : '' }}">
                        Artikel
                    </a>
                    <a href="{{ route('faq') }}"
                       class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200
                              {{ request()->routeIs('faq') ? 'bg-[#059669] text-white shadow-md shadow-[#059669]/30' : 'hover:bg-slate-100' }}"
                       style="{{ !request()->routeIs('faq') ? 'color: var(--text-body);' : '' }}">
                        FAQ
                    </a>
                    @guest
                    <a href="{{ route('login') }}"
                       class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200
                              {{ request()->routeIs('login') ? 'bg-[#059669] text-white shadow-md shadow-[#059669]/30' : 'hover:bg-slate-100' }}"
                       style="{{ !request()->routeIs('login') ? 'color: var(--text-body);' : '' }}">
                        Masuk / Login
                    </a>
                    @endguest
                </nav>

                <!-- Right Actions -->
                <div class="flex items-center gap-2 sm:gap-3">

                    <!-- Dark Mode Toggle -->
                    <button id="dark-toggle-btn" class="dark-toggle" aria-label="Toggle Dark Mode" title="Mode Malam">
                        <!-- Moon icon (shown in light mode) -->
                        <svg id="icon-moon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <!-- Sun icon (shown in dark mode) -->
                        <svg id="icon-sun" class="w-4 h-4 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn-primary text-xs px-4 py-2.5 hidden sm:inline-flex">
                                🛠️ Panel Admin
                            </a>
                        @elseif(auth()->user()->role === 'guru_bk')
                            <a href="{{ route('counselor.dashboard') }}" class="btn-primary text-xs px-4 py-2.5 hidden sm:inline-flex">
                                👨‍🏫 Panel Guru BK
                            </a>
                        @else
                            <a href="{{ route('student.dashboard') }}" class="btn-primary text-xs px-4 py-2.5 hidden sm:inline-flex">
                                🎓 Portal Siswa
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-primary text-xs px-4 sm:px-6 py-2.5">
                            <span class="hidden sm:inline">Masuk Ke Akun</span>
                            <span class="sm:hidden">Masuk</span>
                        </a>
                    @endauth

                    <!-- Hamburger Mobile -->
                    <button id="mobile-menu-btn"
                            class="lg:hidden p-2.5 rounded-xl transition-colors"
                            style="color: var(--text-body);"
                            aria-label="Menu">
                        <svg id="hamburger-icon" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg id="close-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

            </div>

            <!-- Mobile Drawer Menu -->
            <div id="mobile-menu" class="hidden lg:hidden pb-5 border-t mt-1 pt-4" style="border-color: var(--border-color);">
                <nav class="flex flex-col gap-1">
                    <a href="{{ route('home') }}" class="sidebar-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span class="font-sora font-semibold text-sm">Beranda</span>
                    </a>
                    <a href="{{ route('tentang') }}" class="sidebar-item {{ request()->routeIs('tentang') ? 'active' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="font-sora font-semibold text-sm">Tentang BK</span>
                    </a>
                    <a href="{{ route('ebook.public') }}" class="sidebar-item {{ request()->routeIs('ebook.public') ? 'active' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span class="font-sora font-semibold text-sm">E-Book</span>
                    </a>
                    <a href="{{ route('artikel.list') }}" class="sidebar-item {{ request()->routeIs('artikel.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        <span class="font-sora font-semibold text-sm">Artikel</span>
                    </a>
                    <a href="{{ route('faq') }}" class="sidebar-item {{ request()->routeIs('faq') ? 'active' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="font-sora font-semibold text-sm">FAQ</span>
                    </a>
                    @guest
                    <a href="{{ route('login') }}" class="sidebar-item {{ request()->routeIs('login') ? 'active' : '' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        <span class="font-sora font-semibold text-sm">Masuk / Login</span>
                    </a>
                    @endguest
                    @auth
                    <div class="pt-3 border-t mt-2" style="border-color: var(--border-color);">
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn-primary w-full justify-center text-sm">🛠️ Panel Admin</a>
                        @elseif(auth()->user()->role === 'guru_bk')
                            <a href="{{ route('counselor.dashboard') }}" class="btn-primary w-full justify-center text-sm">👨‍🏫 Panel Guru BK</a>
                        @else
                            <a href="{{ route('student.dashboard') }}" class="btn-primary w-full justify-center text-sm">🎓 Portal Siswa</a>
                        @endif
                    </div>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- ===== FLASH MESSAGES ===== -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
            <div class="flex items-center gap-3 p-4 rounded-2xl border text-sm font-semibold shadow-sm"
                 style="background: rgba(5,150,105,0.1); border-color: rgba(110,231,183,0.5); color: #047857;">
                <svg class="w-5 h-5 shrink-0 text-[#059669]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- ===== MAIN CONTENT ===== -->
    <main>
        @yield('content')
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="bg-[#042F2E] text-white pt-14 pb-10 relative overflow-hidden mt-16 sm:mt-20 border-t border-emerald-900">
        <!-- Floating Backdrop Light -->
        <div class="absolute top-0 right-1/4 w-64 sm:w-96 h-64 sm:h-96 bg-[#059669]/10 rounded-full filter blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-8 sm:gap-10 pb-10 sm:pb-12 border-b border-emerald-800/80">
                <!-- Brand Info -->
                <div class="sm:col-span-2 lg:col-span-5">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 mb-5" style="text-decoration:none;">
                        <div class="w-10 h-10 rounded-2xl overflow-hidden bg-white flex items-center justify-center shadow-lg p-0.5 shrink-0">
                            <img src="/logo-sman4.png" alt="Logo SMAN 4 Jember" class="w-full h-full object-contain">
                        </div>
                        <span class="font-sora font-extrabold text-2xl" style="color:#ffffff;">SAPA BK</span>
                    </a>
                    <p class="text-base leading-relaxed max-w-sm mb-6" style="color:#cbd5e1;">
                        Platform pendamping digital Bimbingan Konseling & pengembangan minat-bakat untuk seluruh siswa SMA Negeri 4 Jember.
                    </p>
                    <div class="flex items-center gap-3">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                        <span class="text-sm font-semibold" style="color:#6ee7b7;">Layanan Aktif & Siap Membantu 24/7</span>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="lg:col-span-3">
                    <h4 class="font-sora font-bold text-base uppercase tracking-wider mb-5" style="color:#ffffff;">Menu Utama</h4>
                    <ul class="space-y-3.5 text-base" style="color:#cbd5e1;">
                        <li><a href="{{ route('home') }}" style="color:#cbd5e1;" onmouseover="this.style.color='#34d399'" onmouseout="this.style.color='#cbd5e1'">Beranda</a></li>
                        <li><a href="{{ route('tentang') }}" style="color:#cbd5e1;" onmouseover="this.style.color='#34d399'" onmouseout="this.style.color='#cbd5e1'">Tentang BK SMAN 4 Jember</a></li>
                        <li><a href="{{ route('ebook.public') }}" style="color:#cbd5e1;" onmouseover="this.style.color='#34d399'" onmouseout="this.style.color='#cbd5e1'">Perpustakaan E-Book</a></li>
                        <li><a href="{{ route('artikel.list') }}" style="color:#cbd5e1;" onmouseover="this.style.color='#34d399'" onmouseout="this.style.color='#cbd5e1'">Artikel & Edukasi</a></li>
                        <li><a href="{{ route('faq') }}" style="color:#cbd5e1;" onmouseover="this.style.color='#34d399'" onmouseout="this.style.color='#cbd5e1'">Pertanyaan Umum (FAQ)</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="lg:col-span-4">
                    <h4 class="font-sora font-bold text-base uppercase tracking-wider mb-5" style="color:#ffffff;">Lokasi & Kontak</h4>
                    <ul class="space-y-4 text-base" style="color:#cbd5e1;">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 shrink-0 mt-1" style="color:#34d399;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span style="color:#cbd5e1;">SMA Negeri 4 Jember<br>Jl. Hayam Wuruk No.9, Jember, Jawa Timur</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0" style="color:#34d399;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span style="color:#cbd5e1;">bk@sman4jember.sch.id</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-sm" style="color:#94a3b8;">
                <p>&copy; {{ date('Y') }} SAPA BK SMAN 4 Jember. Hak cipta dilindungi undang-undang.</p>
                <p class="flex items-center gap-1">
                    Platform Konsultasi &amp; Kesehatan Mental Siswa SMAN 4 Jember
                </p>
            </div>
        </div>
    </footer>

    <!-- ===== CHAT WIDGET (Floating Trigger) ===== -->
    @yield('chat-widget')

    <script>
        // ===== DARK MODE TOGGLE =====
        const htmlEl     = document.documentElement;
        const toggleBtn  = document.getElementById('dark-toggle-btn');
        const iconMoon   = document.getElementById('icon-moon');
        const iconSun    = document.getElementById('icon-sun');

        function applyTheme(isDark) {
            if (isDark) {
                htmlEl.classList.add('dark');
                iconMoon.classList.add('hidden');
                iconSun.classList.remove('hidden');
            } else {
                htmlEl.classList.remove('dark');
                iconMoon.classList.remove('hidden');
                iconSun.classList.add('hidden');
            }
        }

        // Init on load
        applyTheme(localStorage.getItem('sapabk-theme') === 'dark');

        toggleBtn?.addEventListener('click', () => {
            const isDark = htmlEl.classList.toggle('dark');
            localStorage.setItem('sapabk-theme', isDark ? 'dark' : 'light');
            applyTheme(isDark);
        });

        // ===== MOBILE MENU TOGGLE =====
        const mobileMenuBtn   = document.getElementById('mobile-menu-btn');
        const mobileMenu      = document.getElementById('mobile-menu');
        const hamburgerIcon   = document.getElementById('hamburger-icon');
        const closeIcon       = document.getElementById('close-icon');

        mobileMenuBtn?.addEventListener('click', () => {
            const isOpen = mobileMenu.classList.toggle('hidden') === false;
            mobileMenu.classList.toggle('hidden', !isOpen);
            hamburgerIcon.classList.toggle('hidden', isOpen);
            closeIcon.classList.toggle('hidden', !isOpen);
        });
    </script>

    @stack('scripts')
</body>
</html>
