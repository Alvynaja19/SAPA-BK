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
<body class="bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100 font-sans antialiased selection:bg-emerald-100 selection:text-emerald-800">

    <!-- ===== NAVBAR PUBLIK ===== -->
    <header id="main-header" class="fixed w-full top-0 z-50 transition-all duration-300 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200/80 dark:border-slate-800 shadow-sm py-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 group shrink-0">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-2xl overflow-hidden bg-white flex items-center justify-center shadow-md p-0.5 shrink-0 border border-slate-100">
                        <img src="/logo-sman4.png" alt="Logo SMAN 4 Jember" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <span id="logo-text" class="font-sora font-extrabold text-base sm:text-lg leading-none tracking-tight block transition-colors text-slate-900 dark:text-white">SAPA BK</span>
                        <span id="logo-subtext" class="text-[10px] sm:text-[11px] font-bold leading-tight block mt-0.5 transition-colors text-[#059669]">SMAN 4 JEMBER</span>
                    </div>
                </a>

                <!-- Nav Links (Desktop Navigation) -->
                <nav class="hidden lg:flex items-center gap-2 mx-auto">
                    <a href="{{ route('home') }}"
                       class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200 nav-link
                              {{ request()->routeIs('home') ? 'bg-[#059669] text-white' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                        Beranda
                    </a>
                    <a href="{{ route('tentang') }}"
                       class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200 nav-link
                              {{ request()->routeIs('tentang') ? 'bg-[#059669] text-white' : 'hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                        Tentang BK
                    </a>
                    <a href="{{ route('ebook.public') }}"
                       class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200 nav-link
                              {{ request()->routeIs('ebook.public') ? 'bg-[#059669] text-white' : 'hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                        E-Book
                    </a>
                    <a href="{{ route('artikel.list') }}"
                       class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200 nav-link
                              {{ request()->routeIs('artikel.*') ? 'bg-[#059669] text-white' : 'hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                        Artikel
                    </a>
                    <a href="{{ route('faq') }}"
                       class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200 nav-link
                              {{ request()->routeIs('faq') ? 'bg-[#059669] text-white' : 'hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                        FAQ
                    </a>
                </nav>

                <!-- Right Actions -->
                <div class="flex items-center gap-2 sm:gap-3">

                    <!-- Dark Mode Toggle -->
                    <button id="dark-toggle-btn" class="p-2 rounded-full transition-colors text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800" aria-label="Toggle Dark Mode" title="Mode Malam">
                        <!-- Moon icon (shown in light mode) -->
                        <svg id="icon-moon" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <!-- Sun icon (shown in dark mode) -->
                        <svg id="icon-sun" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="bg-[#059669] hover:bg-emerald-700 text-white px-5 py-2.5 rounded-2xl font-bold text-sm shadow-md transition-all hidden sm:inline-flex">
                                Panel Admin
                            </a>
                        @elseif(auth()->user()->role === 'guru_bk')
                            <a href="{{ route('counselor.dashboard') }}" class="bg-[#059669] hover:bg-emerald-700 text-white px-5 py-2.5 rounded-2xl font-bold text-sm shadow-md transition-all hidden sm:inline-flex">
                                Panel Guru BK
                            </a>
                        @else
                            <a href="{{ route('student.dashboard') }}" class="bg-[#059669] hover:bg-emerald-700 text-white px-5 py-2.5 rounded-2xl font-bold text-sm shadow-md transition-all hidden sm:inline-flex">
                                Portal Siswa
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="bg-[#059669] hover:bg-emerald-700 text-white px-5 sm:px-6 py-2.5 rounded-2xl font-bold text-sm shadow-md transition-all hidden sm:inline-flex">
                            Masuk Sekarang
                        </a>
                    @endauth

                    <!-- Hamburger Mobile -->
                    <button id="mobile-menu-btn"
                            class="lg:hidden p-2 rounded-xl text-slate-800 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                            aria-label="Menu">
                        <svg id="hamburger-icon" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

            </div>

            <!-- Mobile Drawer Menu -->
            <div id="mobile-menu" class="hidden lg:hidden pb-5 border-t mt-2 pt-4 border-white/20 bg-white dark:bg-slate-900 rounded-2xl p-4 shadow-xl absolute left-4 right-4 top-full">
                <nav class="flex flex-col gap-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 p-3 rounded-xl {{ request()->routeIs('home') ? 'bg-emerald-50 text-[#059669] dark:bg-emerald-900/30' : 'text-slate-700 dark:text-slate-300' }}">
                        <span class="font-sora font-semibold text-sm">Beranda</span>
                    </a>
                    <a href="{{ route('tentang') }}" class="flex items-center gap-3 p-3 rounded-xl {{ request()->routeIs('tentang') ? 'bg-emerald-50 text-[#059669] dark:bg-emerald-900/30' : 'text-slate-700 dark:text-slate-300' }}">
                        <span class="font-sora font-semibold text-sm">Tentang BK</span>
                    </a>
                    <a href="{{ route('ebook.public') }}" class="flex items-center gap-3 p-3 rounded-xl {{ request()->routeIs('ebook.public') ? 'bg-emerald-50 text-[#059669] dark:bg-emerald-900/30' : 'text-slate-700 dark:text-slate-300' }}">
                        <span class="font-sora font-semibold text-sm">E-Book</span>
                    </a>
                    <a href="{{ route('artikel.list') }}" class="flex items-center gap-3 p-3 rounded-xl {{ request()->routeIs('artikel.*') ? 'bg-emerald-50 text-[#059669] dark:bg-emerald-900/30' : 'text-slate-700 dark:text-slate-300' }}">
                        <span class="font-sora font-semibold text-sm">Artikel</span>
                    </a>
                    <a href="{{ route('faq') }}" class="flex items-center gap-3 p-3 rounded-xl {{ request()->routeIs('faq') ? 'bg-emerald-50 text-[#059669] dark:bg-emerald-900/30' : 'text-slate-700 dark:text-slate-300' }}">
                        <span class="font-sora font-semibold text-sm">FAQ</span>
                    </a>
                    @guest
                    <a href="{{ route('login') }}" class="flex items-center gap-3 p-3 rounded-xl {{ request()->routeIs('login') ? 'bg-emerald-50 text-[#059669] dark:bg-emerald-900/30' : 'text-slate-700 dark:text-slate-300' }}">
                        <span class="font-sora font-semibold text-sm">Masuk / Login</span>
                    </a>
                    @endguest
                    @auth
                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800 mt-2">
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 relative z-40">
            <div class="flex items-center gap-3 p-4 rounded-2xl border text-sm font-semibold shadow-sm bg-emerald-50 border-emerald-200 text-emerald-800 dark:bg-emerald-900/30 dark:border-emerald-800 dark:text-emerald-300">
                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- ===== MAIN CONTENT ===== -->
    <main class="{{ request()->routeIs('home') ? '' : 'pt-24' }}">
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

        // ===== HEADER SCROLL LOGIC =====
        const header = document.getElementById('main-header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 10) {
                header.classList.add('shadow-md');
                header.classList.remove('shadow-sm');
            } else {
                header.classList.remove('shadow-md');
                header.classList.add('shadow-sm');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
