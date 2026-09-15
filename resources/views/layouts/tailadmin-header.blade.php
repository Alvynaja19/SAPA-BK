<header class="sticky top-0 z-30 flex w-full border-b border-gray-200/80 bg-white/90 backdrop-blur-md dark:border-gray-800 dark:bg-gray-900/95 transition-colors">
  <div class="flex grow items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
    
    <!-- Left: Hamburger Toggle & Title -->
    <div class="flex items-center gap-3">
      <!-- Desktop Toggle Button -->
      <button
        type="button"
        class="hidden xl:flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200/80 text-gray-700 hover:bg-gray-100/80 hover:text-gray-900 dark:border-gray-800 dark:text-gray-300 dark:hover:bg-gray-800/80 transition-colors"
        @click="$store.sidebar.toggleExpanded()"
        title="Perlebar / Ciutkan Sidebar"
      >
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
        </svg>
      </button>

      <!-- Mobile Menu Toggle Button -->
      <button
        type="button"
        class="flex xl:hidden h-10 w-10 items-center justify-center rounded-xl border border-gray-200/80 text-gray-700 hover:bg-gray-100/80 hover:text-gray-900 dark:border-gray-800 dark:text-gray-300 dark:hover:bg-gray-800/80 transition-colors"
        @click="$store.sidebar.toggleMobileOpen()"
        title="Menu Navigasi"
      >
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
      </button>

      <!-- SMAN 4 Jember Label -->
      <div class="hidden sm:flex items-center gap-2 pl-2">
        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 dark:bg-brand-950/60 dark:text-brand-300 border border-emerald-200 dark:border-brand-800/60">
          <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
          SAPA BK : SMAN 4 Jember
        </span>
      </div>
    </div>

    <!-- Right Controls: Theme Toggle & User Menu -->
    <div class="flex items-center gap-2 sm:gap-3">
      
      <!-- Theme Switcher (Alpine store.theme) -->
      <button
        type="button"
        @click="$store.theme.toggle()"
        class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200/80 text-gray-700 hover:bg-gray-100/80 hover:text-gray-900 dark:border-gray-800 dark:text-gray-300 dark:hover:bg-gray-800/80 transition-colors"
        title="Ganti Mode Gelap/Terang"
      >
        <!-- Sun Icon (Light Mode) -->
        <svg x-show="$store.theme.theme === 'dark'" class="h-5 w-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
        </svg>
        <!-- Moon Icon (Dark Mode) -->
        <svg x-show="$store.theme.theme !== 'dark'" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
        </svg>
      </button>

      <!-- Role Badge -->
      @php
        $user = auth()->user();
        $roleLabel = match($user?->role) {
          'admin' => 'Administrator',
          'guru_bk' => 'Guru BK',
          default => 'Siswa'
        };
        $roleColor = match($user?->role) {
          'admin' => 'bg-amber-50 text-amber-900 border-amber-200 dark:bg-amber-950/50 dark:text-amber-300 dark:border-amber-800',
          'guru_bk' => 'bg-emerald-50 text-emerald-900 border-emerald-200 dark:bg-brand-950/50 dark:text-brand-300 dark:border-brand-800',
          default => 'bg-blue-50 text-blue-900 border-blue-200 dark:bg-blue-950/50 dark:text-blue-300 dark:border-blue-800'
        };
      @endphp
      <span class="hidden md:inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold border {{ $roleColor }}">
        {{ $roleLabel }}
      </span>

      <!-- User Dropdown (Alpine) -->
      <div class="relative" x-data="{ open: false }">
        <button
          type="button"
          @click="open = !open"
          @click.outside="open = false"
          class="flex items-center gap-3 p-1 rounded-xl hover:bg-gray-100/80 dark:hover:bg-gray-800 transition-colors focus:outline-hidden"
        >
          <div class="h-9 w-9 rounded-xl bg-gradient-to-tr from-brand-700 to-brand-600 text-white font-bold flex items-center justify-center shadow-xs text-sm">
            {{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}
          </div>
          <div class="hidden text-left lg:block">
            <span class="block text-xs font-bold text-gray-900 dark:text-white line-clamp-1 max-w-[130px]">{{ $user->name ?? 'User' }}</span>
            <span class="block text-[11px] text-gray-500 dark:text-gray-400 line-clamp-1 max-w-[130px]">{{ $user->email ?? '' }}</span>
          </div>
          <svg class="hidden lg:block h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <!-- Dropdown Menu -->
        <div
          x-show="open"
          x-transition:enter="transition ease-out duration-150"
          x-transition:enter-start="opacity-0 scale-95"
          x-transition:enter-end="opacity-100 scale-100"
          x-transition:leave="transition ease-in duration-100"
          x-transition:leave-start="opacity-100 scale-100"
          x-transition:leave-end="opacity-0 scale-95"
          class="absolute right-0 mt-2 w-56 rounded-2xl bg-white p-2 shadow-xl border border-gray-100 dark:border-gray-800 dark:bg-gray-800 z-50"
          style="display: none;"
        >
          <div class="px-3 py-2 border-b border-gray-100 dark:border-gray-700/60 mb-1">
            <p class="text-xs font-bold text-gray-900 dark:text-white">{{ $user->name }}</p>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 truncate">{{ $user->email }}</p>
          </div>

          <a href="{{ route('profile') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-medium text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700/60 transition-colors">
            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span>Edit Profil & Sandi</span>
          </a>

          <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-medium text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700/60 transition-colors">
            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
            <span>Lihat Portal Publik</span>
          </a>

          <div class="border-t border-gray-100 dark:border-gray-700/60 my-1"></div>

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50 dark:text-rose-400 dark:hover:bg-rose-950/40 transition-colors text-left">
              <svg class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
              </svg>
              <span>Keluar (Logout)</span>
            </button>
          </form>
        </div>
      </div>

    </div>

  </div>
</header>
