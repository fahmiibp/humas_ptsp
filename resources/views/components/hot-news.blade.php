@props(['items'])

@if ($items->isNotEmpty())
    @php
        $main = $items->first();
        $others = $items->skip(1)->take(2);

        // Semua foto sebuah berita menjadi array URL
        $imgs = function ($warta) {
            $urls = collect((array) $warta->dokumentasi_utama)
                ->filter()
                ->map(fn($p) => \Illuminate\Support\Facades\Storage::url($p))
                ->values()
                ->all();

            return $urls ?: [asset('images/placeholder-news.png')];
        };
    @endphp

    <section class="mb-10">
        <div class="mb-4 flex items-center gap-3">
            <div class="h-px flex-1 bg-gradient-to-r from-teal-100 to-transparent"></div>
        </div>

        <div class="grid gap-4 md:grid-cols-3">

            {{-- Berita utama --}}
            <div
                class="group relative h-72 overflow-hidden rounded-2xl border border-gray-100 bg-gray-100 transition-all duration-300 hover:border-teal-100 hover:shadow-xl hover:shadow-teal-50 md:h-96 {{ $others->isNotEmpty() ? 'md:col-span-2' : 'md:col-span-3' }}">

                <x-card-slider :images="$imgs($main)" :alt="$main->judul_siaran_pers" />

                <div
                    class="pointer-events-none absolute inset-0 bg-gradient-to-t from-teal-950/85 via-teal-900/20 to-transparent">
                </div>

                <a href="{{ route('articles.show', ['slug' => $main->slug_url]) }}" wire:navigate
                    aria-label="{{ $main->judul_siaran_pers }}" class="absolute inset-0 z-10"></a>

                <span
                    class="pointer-events-none absolute left-4 top-4 z-10 inline-flex items-center gap-1 rounded-md bg-red-500 px-2 py-1 text-xs font-bold text-white">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M13.5 4.938a7 7 0 11-9.006 1.737c.202-.257.59-.218.793.039.278.352.594.672.943.954.332.269.786-.049.773-.476a5.977 5.977 0 01.572-2.759 6.026 6.026 0 012.486-2.665c.247-.14.55-.016.677.238A6.967 6.967 0 0013.5 4.938zM14 12a4 4 0 01-4 4c-1.913 0-3.52-1.398-3.91-3.182-.093-.429.44-.643.814-.413a4.043 4.043 0 001.601.564c.303.038.531-.24.51-.544a5.975 5.975 0 011.315-4.192.447.447 0 01.431-.16A4.001 4.001 0 0114 12z" />
                    </svg>
                    HOT News
                </span>

                <div class="pointer-events-none absolute bottom-0 z-10 p-5 pb-8 text-white">
                    @if ($main->kategori)
                        <span
                            class="inline-flex items-center rounded-md bg-white/20 px-2.5 py-1 text-xs font-semibold text-white backdrop-blur-sm">
                            {{ $main->kategori->nama_kategori }}
                        </span>
                    @endif

                    <h2 class="mt-2 text-xl font-bold leading-snug md:text-2xl">
                        {{ $main->judul_siaran_pers }}
                    </h2>

                    <p class="mt-2 text-xs text-teal-100">
                        {{ $main->jadwal_tayang?->timezone(config('app.timezone', 'Asia/Jakarta'))->locale('id')->diffForHumans() }}
                    </p>
                </div>
            </div>

            {{-- Berita hot lainnya --}}
            @if ($others->isNotEmpty())
                <div class="flex flex-col gap-4">
                    @foreach ($others as $item)
                        <div
                            class="group relative h-44 flex-1 overflow-hidden rounded-2xl border border-gray-100 bg-gray-100 transition-all duration-300 hover:border-teal-100 hover:shadow-xl hover:shadow-teal-50 md:h-auto md:min-h-[11rem]">

                            <x-card-slider :images="$imgs($item)" :alt="$item->judul_siaran_pers" />

                            <div
                                class="pointer-events-none absolute inset-0 bg-gradient-to-t from-teal-950/85 via-teal-900/10 to-transparent">
                            </div>

                            <a href="{{ route('articles.show', ['slug' => $item->slug_url]) }}" wire:navigate
                                aria-label="{{ $item->judul_siaran_pers }}" class="absolute inset-0 z-10"></a>

                            <span
                                class="pointer-events-none absolute left-3 top-3 z-10 h-2 w-2 rounded-full bg-red-400 ring-4 ring-red-100/60"></span>

                            <h3
                                class="pointer-events-none absolute bottom-0 z-10 p-4 pb-6 text-sm font-semibold leading-snug text-white">
                                {{ \Illuminate\Support\Str::limit($item->judul_siaran_pers, 70) }}
                            </h3>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </section>
@endif
