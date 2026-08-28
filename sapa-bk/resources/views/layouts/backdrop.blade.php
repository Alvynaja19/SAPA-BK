<div x-show="$store.sidebar.isMobileOpen"
     @click="$store.sidebar.setMobileOpen(false)"
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-xs xl:hidden"
     style="display: none;">
</div>
