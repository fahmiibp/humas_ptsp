@inject('repo', 'App\Repositories\ArticleRepository')

@php
    $categories = $repo->categories();
    $activeCategory = request()->query('category');
@endphp

<header x-data="{ open: false }" class="sticky top-0 z-50 bg-white/95 backdrop-blur">
    {{-- Bar atas --}}
    <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4">

        <a href="{{ route('home') }}" wire:navigate class="flex items-center mb-6 mt-6">
            <img src="{{ asset('image/ptsp.png') }}" width="100" alt="Logo">
            <h1 class="text-3xl font-bold text-teal-700 font-mono">News</h1>
        </a>

        {{-- Follow Us + Pencarian (desktop) --}}
        <div class="hidden items-center gap-6 md:flex">
            <x-social-links />

            <form action="{{ route('home') }}" method="GET">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari berita..."
                    class="w-64 rounded-full border border-gray-300 px-4 py-1.5 text-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
            </form>
        </div>

        {{-- Tombol hamburger (mobile) --}}
        <button @click="open = !open" class="md:hidden rounded p-2 text-gray-700 hover:bg-gray-100" aria-label="Menu">
            <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" d="M6 6l12 12M18 6L6 18" />
            </svg>
        </button>
    </div>

    {{-- Menu kategori (desktop) --}}
    <nav class="hidden mx-auto max-w-6xl bg-teal-500 md:block">
        <ul class="mx-auto flex max-w-6xl gap-1 overflow-x-auto px-4 text-sm font-medium">
            <li>
                <a href="{{ route('home') }}" wire:navigate
                    class="block px-3 py-2.5 {{ !$activeCategory ? 'border-b-4 border-red-500 text-white' : 'text-white' }}">
                    Beranda
                </a>
            </li>
            @foreach ($categories as $cat)
                <li>
                    <a href="{{ route('home', ['category' => $cat]) }}" wire:navigate
                        class="block px-3 py-2.5 {{ $activeCategory === $cat ? 'border-b-4 border-red-500 text-white' : 'text-white' }}">
                        {{ $cat }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    {{-- Menu mobile --}}
    <div x-show="open" x-cloak x-transition class="border-t border-gray-100 md:hidden">
        <form action="{{ route('home') }}" method="GET" class="p-4">
            <input type="search" name="search" placeholder="Cari berita..."
                class="w-full rounded-full border border-gray-300 px-4 py-2 text-sm focus:border-teal-500 focus:outline-none">
        </form>

        <ul class="pb-3 text-sm font-medium">
            <li>
                <a href="{{ route('home') }}" wire:navigate @click="open = false"
                    class="block px-4 py-2 {{ !$activeCategory ? 'text-teal-600' : 'text-gray-700' }}">Beranda</a>
            </li>
            @foreach ($categories as $cat)
                <li>
                    <a href="{{ route('home', ['category' => $cat]) }}" wire:navigate @click="open = false"
                        class="block px-4 py-2 {{ $activeCategory === $cat ? 'text-teal-600' : 'text-gray-700' }}">
                        {{ $cat }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</header>
