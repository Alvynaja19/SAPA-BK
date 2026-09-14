<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Dashboard') | SAPA BK — SMAN 4 Jember</title>

  <!-- Favicon -->
  <link rel="icon" href="{{ asset('saasable/images/favicon.ico') }}" type="image/x-icon" />

  <!-- Google Fonts: Outfit & Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Tabler Icons (from Saasable asset) -->
  <link rel="stylesheet" href="{{ asset('saasable/fonts/tabler-icons.min.css') }}" />

  <!-- Vite Styles & Scripts with Graceful Fallback -->
  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @else
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        darkMode: 'class',
        theme: {
          extend: {
            fontFamily: {
              sans: ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
              outfit: ['Outfit', 'Plus Jakarta Sans', 'sans-serif'],
            },
            colors: {
              brand: {
                25: '#f4f8f4',
                50: '#edf5ee',
                100: '#d7ead9',
                200: '#b4dab7',
                300: '#87c48c',
                400: '#53a85b',
                500: '#2e7d34',
                600: '#256b2a',
                700: '#205a26',
                800: '#1a461e',
                900: '#143818',
                950: '#0b210e',
              },
              accent: {
                50: '#fefbf0',
                100: '#fdf4d4',
                200: '#fbe9ae',
                300: '#f8d77a',
                400: '#f5c338',
                500: '#f4b400',
                600: '#d89e00',
                700: '#b28000',
                800: '#7a5200',
                900: '#5c3d00',
              },
              landing: {
                bg: '#FBF8EA',
                'bg-alt': '#F7EDC2',
                surface: '#FFFFFF',
                ink: '#1C2B18',
                'ink-soft': '#4E5E46',
                'ink-faint': '#83927A',
                primary: '#2E7D34',
                'primary-hover': '#205A26',
                accent: '#F4B400',
                'accent-hover': '#D89E00',
                'accent-soft': '#FBE9AE',
                'accent-ink': '#7A5200',
                red: '#D6362E',
                'red-soft': '#FADBD8',
                blue: '#1C6EB4',
                'blue-soft': '#D9E9F6',
                line: '#E6DBA0',
              }
            }
          }
        }
      };
    </script>
  @endif

  <!-- Alpine.js -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

  <!-- Theme & Sidebar Stores Initialization -->
  <script>
    document.addEventListener('alpine:init', () => {
      // 1. Theme Store
      Alpine.store('theme', {
        theme: localStorage.getItem('sapa_bk_theme') || 
               (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'),
        init() {
          this.applyTheme();
        },
        toggle() {
          this.theme = this.theme === 'light' ? 'dark' : 'light';
          localStorage.setItem('sapa_bk_theme', this.theme);
          this.applyTheme();
        },
        applyTheme() {
          const html = document.documentElement;
          if (this.theme === 'dark') {
            html.classList.add('dark');
          } else {
            html.classList.remove('dark');
          }
        }
      });

      // 2. Sidebar Store
      Alpine.store('sidebar', {
        isExpanded: window.innerWidth >= 1280,
        isMobileOpen: false,
        isHovered: false,

        toggleExpanded() {
          this.isExpanded = !this.isExpanded;
          this.isMobileOpen = false;
        },
        toggleMobileOpen() {
          this.isMobileOpen = !this.isMobileOpen;
        },
        setMobileOpen(val) {
          this.isMobileOpen = val;
        },
        setHovered(val) {
          if (window.innerWidth >= 1280 && !this.isExpanded) {
            this.isHovered = val;
          }
        }
      });
    });
  </script>

  <!-- Dark Mode Anti-Flash Script -->
  <script>
    (function() {
      const savedTheme = localStorage.getItem('sapa_bk_theme');
      const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
      const theme = savedTheme || systemTheme;
      if (theme === 'dark') {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }
    })();
  </script>

  <style>
    body {
      font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
    }
    h1, h2, h3, h4, h5, h6, .font-title {
      font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif;
    }
    .custom-scrollbar::-webkit-scrollbar {
      width: 5px;
      height: 5px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
      background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
      background: rgba(156, 163, 175, 0.4);
      border-radius: 9999px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
      background: rgba(156, 163, 175, 0.7);
    }
  </style>

  @stack('styles')
</head>

<body
  class="min-h-screen bg-[#FBF8EA] text-[#1C2B18] antialiased dark:bg-gray-950 dark:text-gray-200 transition-colors"
  x-data
  x-init="
    const checkMobile = () => {
      if (window.innerWidth < 1280) {
        $store.sidebar.setMobileOpen(false);
        $store.sidebar.isExpanded = false;
      } else {
        $store.sidebar.isMobileOpen = false;
        $store.sidebar.isExpanded = true;
      }
    };
    window.addEventListener('resize', checkMobile);
  "
>

  <div class="min-h-screen xl:flex">
    <!-- Backdrop for Mobile -->
    @include('layouts.backdrop')

    <!-- TailAdmin Sidebar -->
    @include('layouts.tailadmin-sidebar')

    <!-- Main Content Container with dynamic left margin matching sidebar state -->
    <div
      class="flex-1 min-w-0 transition-all duration-300 ease-in-out"
      :class="{
        'xl:ml-[280px]': $store.sidebar.isExpanded || $store.sidebar.isHovered,
        'xl:ml-[84px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
        'ml-0': $store.sidebar.isMobileOpen
      }"
    >
      <!-- Top Header -->
      @include('layouts.tailadmin-header')

      <!-- Main Body Content -->
      <main class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-6">
        
        <!-- Flash Message Alerts -->
        @if(session('success'))
          <div
            x-data="{ show: true }"
            x-show="show"
            class="flex items-center justify-between gap-3 p-4 rounded-2xl bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800/60 shadow-xs"
          >
            <div class="flex items-center gap-3">
              <div class="h-8 w-8 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <p class="text-xs sm:text-sm font-semibold">{{ session('success') }}</p>
            </div>
            <button type="button" @click="show = false" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400">
              <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
          </div>
        @endif

        @if(isset($errors) && $errors->any())
          <div
            x-data="{ show: true }"
            x-show="show"
            class="p-4 rounded-2xl bg-rose-50 text-rose-800 border border-rose-200 dark:bg-rose-950/40 dark:text-rose-300 dark:border-rose-800/60 shadow-xs"
          >
            <div class="flex items-start justify-between gap-3">
              <div class="flex items-start gap-3">
                <div class="h-8 w-8 rounded-xl bg-rose-500/10 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0 mt-0.5">
                  <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                  </svg>
                </div>
                <div>
                  <h4 class="text-xs sm:text-sm font-bold">Terjadi Kesalahan:</h4>
                  <ul class="mt-1 list-disc list-inside text-xs space-y-0.5">
                    @foreach($errors->all() as $err)
                      <li>{{ $err }}</li>
                    @endforeach
                  </ul>
                </div>
              </div>
              <button type="button" @click="show = false" class="text-rose-600 hover:text-rose-800 dark:text-rose-400">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
            </div>
          </div>
        @endif

        <!-- Content Injection -->
        @yield('content')

      </main>
    </div>
  </div>

  @stack('scripts')
</body>
</html>
