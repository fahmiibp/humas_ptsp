@inject('repo', 'App\Repositories\ArticleRepository')

@php
    $categories = $repo->categories();
    $activeCategory = request()->query('category');
    $search = request()->query('search');
@endphp

<header x-data="{ open: false, categoryOpen: false }"
    class="sticky top-0 z-50 bg-white/95 backdrop-blur">

    {{-- Bar Tanggal --}}
    <div class="hidden border-b border-gray-100 bg-gray-50 md:block">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-1.5 text-xs text-gray-500">
            <span class="inline-flex items-center gap-1.5">
                <svg class="h-3.5 w-3.5 text-teal-500" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z" />
                </svg>

                {{ now()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('l, j F Y') }}
            </span>

            <span class="font-medium text-teal-600">
                PTSP Jawa Tengah
            </span>
        </div>
    </div>

    {{-- Header Utama --}}
    <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4">

        {{-- Logo --}}
        <a href="{{ route('home') }}"
            wire:navigate
            class="flex items-center gap-2">

            <img src="{{ asset('image/ptsp.png') }}"
                width="100"
                alt="Logo PTSP Jawa Tengah">

            <h1 class="font-mono text-3xl font-bold text-teal-700">
                News
            </h1>
        </a>

        {{-- Desktop --}}
        <div class="hidden items-center gap-6 md:flex">

            {{-- Social Media --}}
            <x-social-links />

            {{-- Search --}}
            <form action="{{ route('home') }}" method="GET">

                @if ($activeCategory)
                    <input type="hidden"
                        name="category"
                        value="{{ $activeCategory }}">
                @endif

                <input type="search"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari berita..."
                    class="w-64 rounded-full border border-gray-300 px-4 py-1.5 text-sm
                           focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
            </form>

        </div>

        {{-- Hamburger Mobile --}}
        <button
            @click="open = !open"
            type="button"
            class="rounded-lg p-2 text-gray-700 hover:bg-gray-100 md:hidden"
            aria-label="Menu">

            <svg x-show="!open"
                class="h-6 w-6"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24">

                <path stroke-linecap="round"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>

            <svg x-show="open"
                x-cloak
                class="h-6 w-6"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24">

                <path stroke-linecap="round"
                    d="M6 6l12 12M18 6L6 18" />
            </svg>

        </button>

    </div>

    {{-- NAVBAR DESKTOP --}}
    <nav class="hidden bg-teal-600 md:block">

        <div class="mx-auto max-w-6xl px-4">

            <ul class="flex items-center gap-1 text-sm font-medium">

                {{-- Beranda --}}
                <li>
                    <a href="{{ route('home', array_filter(['search' => $search])) }}"
                        wire:navigate
                        class="block whitespace-nowrap px-4 py-3 text-white transition
                        hover:bg-teal-700
                        {{ !$activeCategory ? 'border-b-4 border-red-500 bg-teal-700' : '' }}">

                        Beranda
                    </a>
                </li>

                {{-- Dropdown Kategori --}}
                <li class="relative"
                    @mouseenter="categoryOpen = true"
                    @mouseleave="categoryOpen = false">

                    <button
                        type="button"
                        @click="categoryOpen = !categoryOpen"
                        class="flex items-center gap-1 whitespace-nowrap px-4 py-3 text-white transition hover:bg-teal-700">

                        Kategori

                        <svg class="h-4 w-4 transition-transform"
                            :class="categoryOpen ? 'rotate-180' : ''"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m6 9 6 6 6-6" />
                        </svg>

                    </button>

                    {{-- Dropdown --}}
                    <div
                        x-show="categoryOpen"
                        x-cloak
                        x-transition
                        class="absolute left-0 top-full z-50 w-60 overflow-hidden rounded-b-lg
                               border border-gray-200 bg-white shadow-xl">

                        {{-- Semua Kategori --}}
                        <a href="{{ route('home', array_filter(['search' => $search])) }}"
                            wire:navigate
                            class="block px-4 py-3 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700
                            {{ !$activeCategory ? 'bg-teal-50 font-semibold text-teal-700' : '' }}">

                            Semua Kategori
                        </a>

                        @foreach ($categories as $cat)

                            <a href="{{ route(
                                'home',
                                array_filter([
                                    'category' => $cat->slug,
                                    'search' => $search,
                                ]),
                            ) }}"
                                wire:navigate
                                class="block px-4 py-3 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700
                                {{ $activeCategory === $cat->slug ? 'bg-teal-50 font-semibold text-teal-700' : '' }}">

                                {{ $cat->nama_kategori }}

                            </a>

                        @endforeach

                    </div>

                </li>
                {{-- FAQ --}}
                <li>
                    <a
                        href="{{ route('faq') }}"
                        wire:navigate
                        class="block whitespace-nowrap px-4 py-3 text-white transition hover:bg-teal-700
                        {{ request()->routeIs('faq') ? 'border-b-4 border-red-500 bg-teal-700' : '' }}"
                    >
                        FAQ
                    </a>
                </li>

            </ul>

        </div>

    </nav>

    {{-- MENU MOBILE --}}
    <div x-show="open"
        x-cloak
        x-transition
        class="border-t border-gray-100 bg-white shadow-lg md:hidden">

        {{-- Search Mobile --}}
        <form action="{{ route('home') }}"
            method="GET"
            class="p-4">

            @if ($activeCategory)
                <input type="hidden"
                    name="category"
                    value="{{ $activeCategory }}">
            @endif

            <input type="search"
                name="search"
                value="{{ $search }}"
                placeholder="Cari berita..."
                class="w-full rounded-full border border-gray-300 px-4 py-2 text-sm
                       focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">

        </form>

        <div class="border-t border-gray-100">

            {{-- Beranda --}}
            <a href="{{ route('home', array_filter(['search' => $search])) }}"
                wire:navigate
                @click="open = false"
                class="block px-5 py-3 text-sm
                {{ !$activeCategory ? 'font-semibold text-teal-600 bg-teal-50' : 'text-gray-700' }}">

                Beranda
            </a>

            {{-- Kategori --}}
            <div x-data="{ categoryMobile: false }">

                <button
                    type="button"
                    @click="categoryMobile = !categoryMobile"
                    class="flex w-full items-center justify-between px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50">

                    <span>Kategori</span>

                    <svg class="h-4 w-4 transition-transform"
                        :class="categoryMobile ? 'rotate-180' : ''"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m6 9 6 6 6-6" />

                    </svg>

                </button>

                <div x-show="categoryMobile"
                    x-cloak
                    class="bg-gray-50">

                    {{-- Semua --}}
                    <a href="{{ route('home', array_filter(['search' => $search])) }}"
                        wire:navigate
                        @click="open = false"
                        class="block px-9 py-2.5 text-sm
                        {{ !$activeCategory ? 'font-semibold text-teal-600' : 'text-gray-600' }}">

                        Semua Kategori
                    </a>

                    @foreach ($categories as $cat)

                        <a href="{{ route(
                            'home',
                            array_filter([
                                'category' => $cat->slug,
                                'search' => $search,
                            ]),
                        ) }}"
                            wire:navigate
                            @click="open = false"
                            class="block px-9 py-2.5 text-sm
                            {{ $activeCategory === $cat->slug
                                ? 'font-semibold text-teal-600'
                                : 'text-gray-600' }}">

                            {{ $cat->nama_kategori }}

                        </a>

                    @endforeach

                </div>

            </div>

            {{-- Hot News --}}
            <a href="{{ route('home', ['hot' => 1]) }}"
                wire:navigate
                @click="open = false"
                class="block px-5 py-3 text-sm text-gray-700 hover:bg-gray-50">

                <span class="inline-flex items-center gap-2">

                    <svg class="h-4 w-4 text-red-500"
                        fill="currentColor"
                        viewBox="0 0 24 24">

                        <path d="M13.5 2.5s.5 4.5-2.5 6.5c-1.5-2-1.5-4-1.5-4S5 8 5 13a7 7 0 0 0 14 0c0-3.5-2-6.5-5.5-10.5Z" />

                    </svg>

                    Hot News

                </span>

            </a>

            {{-- FAQ --}}
            <a
                href="{{ route('faq') }}"
                wire:navigate
                @click="open = false"
                class="block px-5 py-3 text-sm
                {{ request()->routeIs('faq')
                    ? 'font-semibold text-teal-600 bg-teal-50'
                    : 'text-gray-700 hover:bg-gray-50' }}"
            >
                FAQ
            </a>

        </div>

    </div>

</header>