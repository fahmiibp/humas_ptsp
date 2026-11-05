@inject('repo', 'App\Repositories\ArticleRepository')

@php
    $categories = $repo->categories();
    $activeCategory = request()->query('category');
    $search = request()->query('search');
@endphp

<header x-data="{ open: false }" class="sticky top-0 z-50 bg-white/95 backdrop-blur">

    {{-- Bar Tanggal --}}
    <div class="hidden border-b border-gray-100 bg-gray-50 md:block">
        <div class="mx-auto flex max-w-6xl 2xl:max-w-[1600px] items-center justify-between px-4 py-1.5 text-xs text-gray-500">
            <span class="inline-flex items-center gap-1.5">
                <svg class="h-3.5 w-3.5 text-teal-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z" />
                </svg>
                {{ now()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('l, j F Y') }}
            </span>
            <span class="font-medium text-teal-600">PTSP Jawa Tengah</span>
        </div>
    </div>

    {{-- Bar Atas --}}
    <div class="mx-auto flex h-16 max-w-6xl 2xl:max-w-[1600px] items-center justify-between px-4">

        {{-- Logo --}}
        <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2">

            <img src="{{ asset('image/ptsp.png') }}" width="100" alt="Logo">

            <h1 class="text-3xl font-bold text-teal-700 font-mono">
                News
            </h1>
        </a>

        {{-- Social Media dan Pencarian Desktop --}}
        <div class="hidden items-center gap-6 md:flex">

            <x-social-links />

            <form action="{{ route('home') }}" method="GET">

                {{-- Pertahankan kategori aktif --}}
                @if ($activeCategory)
                    <input type="hidden" name="category" value="{{ $activeCategory }}">
                @endif

                <input type="search" name="search" value="{{ $search }}" placeholder="Cari berita..."
                    class="w-64 rounded-full border border-gray-300 px-4 py-1.5 text-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">

            </form>

        </div>

        {{-- Tombol Hamburger Mobile --}}
        <button @click="open = !open" class="rounded p-2 text-gray-700 hover:bg-gray-100 md:hidden" aria-label="Menu"
            :aria-expanded="open.toString()">

            {{-- Icon Menu --}}
            <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">

                <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16" />

            </svg>

            {{-- Icon Close --}}
            <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">

                <path stroke-linecap="round" d="M6 6l12 12M18 6L6 18" />

            </svg>

        </button>

    </div>

    {{-- Navigasi Kategori Desktop --}}
    <nav class="mx-auto hidden max-w-6xl 2xl:max-w-[1600px] bg-teal-500 md:block">

        <ul class="mx-auto flex max-w-6xl 2xl:max-w-[1600px] gap-1 overflow-x-auto px-4 text-sm font-medium">

            {{-- Beranda --}}
            <li>
                <a href="{{ route('home', array_filter(['search' => $search])) }}" wire:navigate
                    class="block whitespace-nowrap px-3 py-2.5 text-white
                    {{ !$activeCategory ? 'border-b-4 border-red-500' : '' }}">

                    Beranda

                </a>
            </li>

            {{-- Daftar Kategori --}}
            @foreach ($categories as $cat)
                <li>
                    <a href="{{ route(
                        'home',
                        array_filter([
                            'category' => $cat->slug,
                            'search' => $search,
                        ]),
                    ) }}"
                        wire:navigate
                        class="block whitespace-nowrap px-3 py-2.5 text-white
                        {{ $activeCategory === $cat->slug ? 'border-b-4 border-red-500' : '' }}">

                        {{ $cat->nama_kategori }}

                    </a>
                </li>
            @endforeach

        </ul>

    </nav>

    {{-- Menu Mobile --}}
    <div x-show="open" x-cloak x-transition class="border-t border-gray-100 md:hidden">

        {{-- Pencarian Mobile --}}
        <form action="{{ route('home') }}" method="GET" class="p-4">

            {{-- Pertahankan kategori aktif --}}
            @if ($activeCategory)
                <input type="hidden" name="category" value="{{ $activeCategory }}">
            @endif

            <input type="search" name="search" value="{{ $search }}" placeholder="Cari berita..."
                class="w-full rounded-full border border-gray-300 px-4 py-2 text-sm focus:border-teal-500 focus:outline-none">

        </form>

        {{-- Navigasi Mobile --}}
        <ul class="pb-3 text-sm font-medium">

            {{-- Beranda --}}
            <li>
                <a href="{{ route('home', array_filter(['search' => $search])) }}" wire:navigate @click="open = false"
                    class="block px-4 py-2
                    {{ !$activeCategory ? 'font-semibold text-teal-600' : 'text-gray-700' }}">

                    Beranda

                </a>
            </li>

            {{-- Daftar Kategori --}}
            @foreach ($categories as $cat)
                <li>
                    <a href="{{ route(
                        'home',
                        array_filter([
                            'category' => $cat->slug,
                            'search' => $search,
                        ]),
                    ) }}"
                        wire:navigate @click="open = false"
                        class="block px-4 py-2
                        {{ $activeCategory === $cat->slug ? 'font-semibold text-teal-600' : 'text-gray-700' }}">

                        {{ $cat->nama_kategori }}

                    </a>
                </li>
            @endforeach

        </ul>

    </div>

</header>
