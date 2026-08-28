<div class="relative" x-data="{
    dropdownOpen: false,
    toggleDropdown() {
        this.dropdownOpen = !this.dropdownOpen;
    },
    closeDropdown() {
        this.dropdownOpen = false;
    }
}" @click.away="closeDropdown()">
    <!-- User Button -->
    <button
        class="flex items-center gap-3 text-gray-700 dark:text-gray-400"
        @click.prevent="toggleDropdown()"
        type="button"
    >
        <span class="flex items-center justify-center font-bold text-white bg-brand-500 rounded-full h-10 w-10 shrink-0">
            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
        </span>

        <span class="hidden md:block text-left">
            <span class="block font-medium text-theme-sm text-gray-800 dark:text-white/90 leading-tight">
                {{ auth()->user()->name ?? 'Pengguna' }}
            </span>
            <span class="block text-xs text-gray-500 dark:text-gray-400 capitalize">
                {{ auth()->user()->role === 'admin' ? 'Administrator' : (auth()->user()->role === 'guru_bk' ? 'Guru BK' : 'Siswa') }}
            </span>
        </span>

        <!-- Chevron Icon -->
        <svg
            class="w-5 h-5 transition-transform duration-200"
            :class="{ 'rotate-180': dropdownOpen }"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <!-- Dropdown Start -->
    <div
        x-show="dropdownOpen"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-3 flex w-[260px] flex-col rounded-2xl border border-gray-200 bg-white p-4 shadow-theme-lg dark:border-gray-800 dark:bg-gray-900 z-50"
        style="display: none;"
    >
        <!-- User Info -->
        <div class="pb-3 border-b border-gray-100 dark:border-gray-800">
            <span class="block font-semibold text-gray-800 text-theme-sm dark:text-white">
                {{ auth()->user()->name }}
            </span>
            <span class="mt-0.5 block text-theme-xs text-gray-500 dark:text-gray-400 truncate">
                {{ auth()->user()->email }}
            </span>
            <span class="mt-1.5 inline-block px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-brand-50 text-brand-500 dark:bg-brand-500/20 dark:text-brand-400 uppercase">
                {{ auth()->user()->role === 'admin' ? 'Administrator' : (auth()->user()->role === 'guru_bk' ? 'Guru BK' : 'Siswa') }}
            </span>
        </div>

        <!-- Menu Links -->
        <ul class="flex flex-col gap-1 py-3 border-b border-gray-100 dark:border-gray-800">
            @if(auth()->user()->role === 'siswa')
            <li>
                <a href="{{ route('student.profil') }}"
                   class="flex items-center gap-3 px-3 py-2 font-medium text-gray-700 rounded-lg group text-theme-sm hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profil Saya
                </a>
            </li>
            @endif
            <li>
                <a href="{{ route('home') }}"
                   class="flex items-center gap-3 px-3 py-2 font-medium text-gray-700 rounded-lg group text-theme-sm hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Halaman Depan
                </a>
            </li>
        </ul>

        <!-- Logout Form -->
        <form method="POST" action="{{ route('logout') }}" class="pt-2">
            @csrf
            <button
                type="submit"
                class="flex items-center w-full gap-3 px-3 py-2 text-red-600 rounded-lg font-medium text-theme-sm hover:bg-red-50 dark:hover:bg-red-500/10 dark:text-red-400 transition-colors"
                @click="closeDropdown()"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Keluar
            </button>
        </form>
    </div>
</div>
