<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Dashboard') | SAPA BK : SMAN 4 Jember</title>

  <!-- Favicon -->
  <link rel="icon" href="{{ asset('images/logo-sman4.png') }}" type="image/png" />

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
                25: '#f4fbf6',
                50: '#edf9f0',
                100: '#dcfce7',
                200: '#bbf7d0',
                300: '#86efac',
                400: '#4ade80',
                500: '#22c55e',
                600: '#16a34a',
                700: '#15803d',
                800: '#166534',
                900: '#14532d',
                950: '#052e16',
              },
              accent: {
                50: '#fffbeb',
                100: '#fef3c7',
                200: '#fde68a',
                300: '#fcd34d',
                400: '#fbbf24',
                500: '#f59e0b',
                600: '#d97706',
                700: '#b45309',
                800: '#92400e',
                900: '#78350f',
              },
              landing: {
                bg: '#F8FAF8',
                'bg-alt': '#EEF4ED',
                surface: '#FFFFFF',
                ink: '#0F1D13',
                'ink-soft': '#2D4033',
                'ink-faint': '#526658',
                primary: '#15803D',
                'primary-hover': '#166534',
                accent: '#D97706',
                'accent-hover': '#B45309',
                'accent-soft': '#FEF3C7',
                'accent-ink': '#78350F',
                red: '#E11D48',
                'red-soft': '#FFE4E6',
                blue: '#2563EB',
                'blue-soft': '#DBEAFE',
                line: '#E2E8DF',
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

    /* TailAdmin Custom Confirm Modal */
    .tailadmin-confirm-backdrop {
      position: fixed;
      inset: 0;
      background: rgba(15, 23, 42, 0.6);
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
      z-index: 99999;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 16px;
      opacity: 0;
      pointer-events: none;
      transition: opacity .2s ease;
    }
    .tailadmin-confirm-backdrop.is-open {
      opacity: 1;
      pointer-events: auto;
    }
    .tailadmin-confirm-box {
      width: 100%;
      max-width: 440px;
      transform: scale(0.95) translateY(6px);
      transition: transform .2s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .tailadmin-confirm-backdrop.is-open .tailadmin-confirm-box {
      transform: scale(1) translateY(0);
    }
  </style>

  @stack('styles')
</head>

<body
  class="min-h-screen bg-[#F8FAFC] text-[#0F172A] antialiased dark:bg-gray-950 dark:text-gray-100 transition-colors"
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
      class="flex-1 min-w-0 ml-0 transition-all duration-300 ease-in-out"
      :class="{
        'xl:ml-[280px]': $store.sidebar.isExpanded || $store.sidebar.isHovered,
        'xl:ml-[84px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered
      }"
    >
      <!-- Top Header -->
      @include('layouts.tailadmin-header')

      <!-- Main Body Content -->
      <main class="p-3 sm:p-5 lg:p-8 max-w-7xl mx-auto space-y-6">
        
        <!-- Flash Message Alerts -->
        @if(session('success'))
          <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            class="flex items-center justify-between gap-3 p-4 rounded-2xl bg-emerald-50 text-emerald-900 border border-emerald-200 dark:bg-emerald-950/50 dark:text-emerald-200 dark:border-emerald-800/60 shadow-xs"
          >
            <div class="flex items-center gap-3">
              <div class="h-8 w-8 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <p class="text-xs sm:text-sm font-semibold">{{ session('success') }}</p>
            </div>
            <button type="button" @click="show = false" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400" aria-label="Tutup Notifikasi">
              <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
          </div>
        @endif

        @if(session('error'))
          <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            class="flex items-center justify-between gap-3 p-4 rounded-2xl bg-rose-50 text-rose-900 border border-rose-200 dark:bg-rose-950/50 dark:text-rose-200 dark:border-rose-800/60 shadow-xs"
          >
            <div class="flex items-center gap-3">
              <div class="h-8 w-8 rounded-xl bg-rose-500/10 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
              </div>
              <p class="text-xs sm:text-sm font-semibold">{{ session('error') }}</p>
            </div>
            <button type="button" @click="show = false" class="text-rose-600 hover:text-rose-800 dark:text-rose-400" aria-label="Tutup Notifikasi">
              <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
          </div>
        @endif

        @if(session('warning'))
          <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            class="flex items-center justify-between gap-3 p-4 rounded-2xl bg-amber-50 text-amber-900 border border-amber-200 dark:bg-amber-950/50 dark:text-amber-200 dark:border-amber-800/60 shadow-xs"
          >
            <div class="flex items-center gap-3">
              <div class="h-8 w-8 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
              </div>
              <p class="text-xs sm:text-sm font-semibold">{{ session('warning') }}</p>
            </div>
            <button type="button" @click="show = false" class="text-amber-600 hover:text-amber-800 dark:text-amber-400" aria-label="Tutup Notifikasi">
              <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
          </div>
        @endif

        @if(session('info'))
          <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            class="flex items-center justify-between gap-3 p-4 rounded-2xl bg-blue-50 text-blue-900 border border-blue-200 dark:bg-blue-950/50 dark:text-blue-200 dark:border-blue-800/60 shadow-xs"
          >
            <div class="flex items-center gap-3">
              <div class="h-8 w-8 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <p class="text-xs sm:text-sm font-semibold">{{ session('info') }}</p>
            </div>
            <button type="button" @click="show = false" class="text-blue-600 hover:text-blue-800 dark:text-blue-400" aria-label="Tutup Notifikasi">
              <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
          </div>
        @endif

        @if(isset($errors) && $errors->any())
          <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            class="p-4 rounded-2xl bg-rose-50 text-rose-900 border border-rose-200 dark:bg-rose-950/50 dark:text-rose-200 dark:border-rose-800/60 shadow-xs"
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
              <button type="button" @click="show = false" class="text-rose-600 hover:text-rose-800 dark:text-rose-400" aria-label="Tutup Notifikasi Kesalahan">
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

  <!-- TailAdmin Custom Confirm Modal (SAPA BK) -->
  <div
    id="customConfirmModal"
    class="tailadmin-confirm-backdrop"
    role="dialog"
    aria-modal="true"
    aria-labelledby="confirmModalTitle"
    aria-describedby="confirmModalDesc"
  >
    <div class="tailadmin-confirm-box rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-2xl p-6 sm:p-7 text-center">
      <!-- Icon Badge -->
      <div id="confirmModalIconWrap" class="h-14 w-14 rounded-2xl mx-auto mb-4 flex items-center justify-center transition-colors">
        <span id="confirmModalIcon"></span>
      </div>

      <!-- Title & Description -->
      <h3 id="confirmModalTitle" class="text-lg sm:text-xl font-extrabold text-gray-900 dark:text-white tracking-tight font-title">
        Konfirmasi Tindakan
      </h3>
      <p id="confirmModalDesc" class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 leading-relaxed">
        Apakah Anda yakin ingin melanjutkan tindakan ini?
      </p>

      <!-- Action Buttons -->
      <div class="flex items-center justify-center gap-3 mt-6 pt-1">
        <button
          type="button"
          id="confirmModalCancelBtn"
          class="flex-1 min-h-[44px] px-4 py-2.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 font-semibold text-xs sm:text-sm transition-colors focus:outline-hidden focus:ring-2 focus:ring-gray-400 cursor-pointer"
        >
          Batal
        </button>
        <button
          type="button"
          id="confirmModalActionBtn"
          class="flex-1 min-h-[44px] px-4 py-2.5 rounded-xl font-semibold text-xs sm:text-sm text-white shadow-md transition-all focus:outline-hidden focus:ring-2 focus:ring-offset-2 cursor-pointer"
        >
          Lanjutkan
        </button>
      </div>
    </div>
  </div>

  <!-- Global Confirm Modal Script -->
  <script>
    window.showConfirmModal = function(options) {
      const modal = document.getElementById('customConfirmModal');
      if (!modal) {
        if (typeof options.onConfirm === 'function') options.onConfirm();
        return;
      }

      const titleEl = document.getElementById('confirmModalTitle');
      const descEl = document.getElementById('confirmModalDesc');
      const cancelBtn = document.getElementById('confirmModalCancelBtn');
      const actionBtn = document.getElementById('confirmModalActionBtn');
      const iconWrap = document.getElementById('confirmModalIconWrap');
      const iconEl = document.getElementById('confirmModalIcon');

      titleEl.textContent = options.title || 'Konfirmasi Tindakan';
      descEl.textContent = options.message || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
      cancelBtn.textContent = options.cancelText || 'Batal';
      actionBtn.textContent = options.confirmText || 'Lanjutkan';

      const type = options.type || 'warning';

      // Reset classes
      iconWrap.className = 'h-14 w-14 rounded-2xl mx-auto mb-4 flex items-center justify-center transition-colors ';
      actionBtn.className = 'flex-1 min-h-[44px] px-4 py-2.5 rounded-xl font-semibold text-xs sm:text-sm text-white shadow-md transition-all focus:outline-hidden focus:ring-2 focus:ring-offset-2 cursor-pointer ';

      if (type === 'danger') {
        iconWrap.className += 'bg-rose-50 text-rose-600 dark:bg-rose-950/60 dark:text-rose-400 border border-rose-200/60 dark:border-rose-800/40';
        actionBtn.className += 'bg-rose-600 hover:bg-rose-700 shadow-rose-600/25 focus:ring-rose-500';
        iconEl.innerHTML = '<svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>';
      } else if (type === 'success') {
        iconWrap.className += 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-400 border border-emerald-200/60 dark:border-emerald-800/40';
        actionBtn.className += 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-600/25 focus:ring-emerald-500';
        iconEl.innerHTML = '<svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
      } else if (type === 'info') {
        iconWrap.className += 'bg-blue-50 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400 border border-blue-200/60 dark:border-blue-800/40';
        actionBtn.className += 'bg-blue-600 hover:bg-blue-700 shadow-blue-600/25 focus:ring-blue-500';
        iconEl.innerHTML = '<svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
      } else {
        // Default: warning
        iconWrap.className += 'bg-amber-50 text-amber-600 dark:bg-amber-950/60 dark:text-amber-400 border border-amber-200/60 dark:border-amber-800/40';
        actionBtn.className += 'bg-amber-600 hover:bg-amber-700 shadow-amber-600/25 focus:ring-amber-500';
        iconEl.innerHTML = '<svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>';
      }

      modal.classList.add('is-open');
      cancelBtn.focus();

      function closeModal() {
        modal.classList.remove('is-open');
        cleanup();
      }

      function handleAction() {
        closeModal();
        if (typeof options.onConfirm === 'function') {
          options.onConfirm();
        }
      }

      function handleKeydown(e) {
        if (e.key === 'Escape') {
          closeModal();
        }
      }

      function handleBackdropClick(e) {
        if (e.target === modal) {
          closeModal();
        }
      }

      function cleanup() {
        cancelBtn.removeEventListener('click', closeModal);
        actionBtn.removeEventListener('click', handleAction);
        document.removeEventListener('keydown', handleKeydown);
        modal.removeEventListener('click', handleBackdropClick);
      }

      cancelBtn.addEventListener('click', closeModal);
      actionBtn.addEventListener('click', handleAction);
      document.addEventListener('keydown', handleKeydown);
      modal.addEventListener('click', handleBackdropClick);
    };

    // Real-time Session Guard: otomatis logout tanpa refresh halaman jika akun aktif di perangkat lain
    (function() {
      let isTerminated = false;
      function verifySessionStatus() {
        if (isTerminated) return;
        fetch("{{ route('auth.session-status') }}", {
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          cache: 'no-store'
        })
        .then(function(res) {
          if (res.status === 401 || !res.ok) {
            isTerminated = true;
            window.location.href = "{{ route('login') }}?reason=session_terminated";
          }
        })
        .catch(function() {
          // Abaikan kegagalan jaringan sementara
        });
      }

      // Polling setiap 4 detik untuk responsivitas instan
      setInterval(verifySessionStatus, 4000);

      // Cek seketika saat pengguna kembali ke tab ini
      window.addEventListener('focus', verifySessionStatus);
      document.addEventListener('visibilitychange', function() {
        if (document.visibilityState === 'visible') {
          verifySessionStatus();
        }
      });
    })();
  <!-- Pusher & Laravel Echo untuk WebSocket Real-time Reverb -->
  <script src="https://js.pusher.com/8.4.0-rc2/pusher.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>

  @stack('scripts')
</body>
</html>
