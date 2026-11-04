<div x-data="{ show: false }" x-on:scroll.window.throttle.100ms="show = window.scrollY > 500" class="contents">

    <button type="button" x-show="show" x-cloak x-transition:enter="transition duration-200"
        x-transition:enter-start="translate-y-2 opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" x-on:click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        aria-label="Kembali ke atas"
        class="fixed bottom-6 right-6 z-40 rounded-full border border-teal-100 bg-teal-600 p-3 text-white shadow-lg shadow-teal-900/10 transition hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-300">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
        </svg>
    </button>
</div>
