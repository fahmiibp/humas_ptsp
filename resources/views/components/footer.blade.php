@inject('repo', 'App\Repositories\ArticleRepository')

@php
    $categories = $repo->categories();
@endphp

<footer class="mt-12 bg-teal-700 text-teal-50">

    <div
        class="mx-auto max-w-6xl 2xl:max-w-[1900px]
                grid max-w-6xl gap-8 px-4 py-10 md:grid-cols-3
                2xl:justify-items-center ">

        {{-- Tentang --}}
        <div class="2xl:flex 2xl:flex-col ">
            <a href="{{ route('home') }}" wire:navigate class="inline-flex items-center gap-2">
                <span class="rounded-lg bg-white">
                    <img src="{{ asset('image/ptsp.png') }}" class="w-18" alt="Logo">
                </span>
                <span class="font-mono text-2xl font-bold text-white">News</span>
            </a>

            <p class="mt-4 max-w-xs text-sm leading-relaxed text-teal-100">
                Portal berita yang menyajikan informasi terbaru, akurat, dan terpercaya
                seputar daerah, olahraga, dan peristiwa terkini.
            </p>
        </div>

        {{-- Kategori --}}
        <div>
            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-white">
                Kategori
            </h3>

            <ul class="space-y-2 text-sm">
                <li>
                    <a href="{{ route('home') }}" wire:navigate class="text-teal-100 transition hover:text-white">
                        Beranda
                    </a>
                </li>

                @foreach ($categories as $cat)
                    <li>
                        <a href="{{ route('home', ['category' => $cat->slug]) }}" wire:navigate
                            class="text-teal-100 transition hover:text-white">
                            {{ $cat->nama_kategori }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Follow Us --}}
        <div class="2xl:flex 2xl:flex-col 2xl:items-center">
            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-white">
                Ikuti Kami
            </h3>

            <x-social-links :label="false" :dark="true" class="gap-4" />

            <p class="mt-4 text-sm text-teal-100">
                Dapatkan kabar terbaru lewat media sosial kami.
            </p>
        </div>

    </div>

    {{-- Hak cipta --}}
    <div class="border-t border-teal-600">
        <div
            class="mx-auto flex max-w-6xl flex-col items-center
                    justify-between gap-2 px-4 py-4 text-xs text-teal-100
                    sm:flex-row 2xl:max-w-[1900px] 2xl:justify-center
                    2xl:gap-8 2xl:text-center">

            <p>&copy; {{ date('Y') }} PTSP. Hak cipta dilindungi.</p>
            <p>Dikelola oleh PTSP</p>

        </div>
    </div>

</footer>
