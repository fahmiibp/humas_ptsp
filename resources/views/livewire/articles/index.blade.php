<div class="max-w-7xl 2xl:max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <x-hot-news-ticker :items="$hotTicker" />

    <x-hot-news :items="$hotNews" />

    {{-- <livewire:articles.tanya-berita /> --}}

    {{-- =========================
    PORTAL & LAYANAN TERKAIT
========================== --}}


    {{-- Header & Search --}}
    <div class="mb-8">
        <div class="relative">
            <div wire:loading wire:target="search" class="absolute right-4 top-1/2 -translate-y-1/2">
                <svg class="w-5 h-5 text-teal-500 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                </svg>
            </div>
        </div>

        {{-- Articles Container --}}
        <div class="relative">

            {{-- Loading Overlay --}}
            <div wire:loading.flex wire:target="search,category"
                class="absolute inset-0 bg-white/60 backdrop-blur-sm z-10 items-center justify-center rounded-2xl min-h-[200px]">
                <div class="flex flex-col items-center gap-3">
                    <svg class="w-8 h-8 text-teal-500 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                    </svg>

                    <span class="text-sm text-gray-500">
                        Memuat berita...
                    </span>
                </div>
            </div>

            {{-- Articles --}}
            <div class="flex flex-wrap gap-6">

                @forelse ($articles as $article)
                <article wire:key="article-{{ $article->id }}"
                    class="group w-full sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] bg-white rounded-2xl overflow-hidden border border-gray-100 hover:border-teal-100 hover:shadow-xl hover:shadow-teal-50 transition-all duration-300 flex flex-col">

                    {{-- Thumbnail --}}
                    <a href="{{ route('articles.show', $article->slug_url) }}" wire:navigate
                        class="block overflow-hidden aspect-video bg-gray-100">
                        @php
                        $thumbnail = $article->dokumentasi_utama;

                        if (is_array($thumbnail)) {
                        $thumbnail = $thumbnail[0] ?? null;
                        }
                        @endphp

                        @if ($thumbnail)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($thumbnail) }}"
                            alt="{{ $article->judul_siaran_pers }}" loading="lazy"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        @endif
                    </a>

                    {{-- Article Content --}}
                    <div class="p-5 flex flex-col flex-1">

                        {{-- Category --}}
                        <span
                            class="inline-flex items-center self-start px-2.5 py-1 rounded-md bg-teal-50 text-teal-600 text-xs font-semibold mb-3">
                            {{ $article->kategori->nama_kategori ?? 'Kategori tidak tersedia' }}
                        </span>

                        {{-- Title --}}
                        <a href="{{ route('articles.show', $article->slug_url) }}" wire:navigate>
                            <h2
                                class="text-lg font-bold text-gray-900 line-clamp-2 group-hover:text-teal-600 transition-colors mb-2">
                                {{ $article->judul_siaran_pers }}
                            </h2>
                        </a>

                        {{-- Excerpt / Lead --}}
                        <p class="text-sm text-gray-500 line-clamp-3 mb-4 flex-1">
                            {{ $article->lead_berita }}
                        </p>

                        {{-- Published Date --}}
                        <div class="flex items-center gap-2 text-xs text-gray-400 pt-3 border-t border-gray-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                            @if ($article->jadwal_tayang)
                            <time datetime="{{ $article->jadwal_tayang->toIso8601String() }}"
                                class="text-sm text-gray-500">
                                {{ $article->jadwal_tayang->timezone(config('app.timezone', 'Asia/Jakarta'))->locale('id')->diffForHumans() }}
                            </time>
                            @else
                            <span class="text-sm text-gray-500">
                                Tanggal belum tersedia
                            </span>
                            @endif
                        </div>

                    </div>
                </article>

                @empty

                {{-- Empty State --}}
                <div class="w-full text-center py-16 bg-white rounded-2xl border border-dashed border-gray-200">

                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>

                    <h3 class="text-lg font-semibold text-gray-900 mb-1">
                        Tidak ada berita ditemukan
                    </h3>

                    <p class="text-sm text-gray-500">
                        @if ($search || $category)
                        Coba ubah kata kunci atau filter kategori.
                        @else
                        Belum ada berita yang dipublikasikan.
                        @endif
                    </p>
                </div>
                @endforelse

            </div>
        </div>

        {{-- Pagination --}}
        @if ($articles->hasPages())
        {{-- <div class="mt-10"> --}}
        {{ $articles->links('vendor.pagination.custom') }}
        {{-- {{ $articles->links() }} --}}
        {{-- </div> --}}
        @endif

    </div>

    <hr class="text-gray-200 my-10">

    {{-- Portal & Layanan Terkait --}}


    @if ($portalLinks->isNotEmpty())

    <section class="mb-10">

        {{-- HEADER --}}
        <div class="mb-5 px-2">
            <p
                class="mt-1 text-2xl font-bold text-slate-500"
                style="font-family: 'Dancing Script', cursive;">
                Layanan Terkait
            </p>
        </div>

        {{-- SLIDER WRAPPER --}}
        <div
            x-data="{
            scrollLeft() {
                this.$refs.portalSlider.scrollBy({
                    left: -this.$refs.portalSlider.clientWidth,
                    behavior: 'smooth'
                });
            },
            scrollRight() {
                this.$refs.portalSlider.scrollBy({
                    left: this.$refs.portalSlider.clientWidth,
                    behavior: 'smooth'
                });
            }
        }"
            class="relative">

            {{-- SLIDER --}}
            <div
                x-ref="portalSlider"
                class="
        flex
        gap-5
        overflow-x-auto
        scroll-smooth
        snap-x
        snap-mandatory
        scrollbar-hide
        px-2
        pb-2
    "
                style="
        scrollbar-width: none;
        -ms-overflow-style: none;
    ">

                @foreach ($portalLinks as $portal)

                {{-- PORTAL CARD --}}
                <a
                    href="{{ $portal->url }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="Buka portal {{ $portal->name }}"
                    class="
    group
    relative
    shrink-0
    snap-start

    w-full
    sm:w-[calc(50%-10px)]
    md:w-[calc(33.333%-14px)]
    lg:w-[calc(20%-16px)]

    h-[200px]

    rounded-2xl
    bg-slate-50
    border border-slate-100

    flex flex-col
    items-center
    justify-center
    gap-4

    overflow-hidden
    transition-all duration-300

    hover:bg-white
    hover:border-slate-200
    hover:shadow-lg
    hover:-translate-y-1

    focus:outline-none
    focus:ring-2
    focus:ring-slate-300
">

                    {{-- LOGO --}}
                    <div class="
                    flex items-center justify-center
                    w-28 h-24
                    transition-transform duration-300
                    group-hover:scale-105
                ">

                        @if ($portal->icon)

                        <img
                            src="{{ \Illuminate\Support\Facades\Storage::url($portal->icon) }}"
                            alt="{{ $portal->name }}"
                            loading="lazy"
                            class="
                                max-w-[90%]
                                max-h-[90%]
                                w-auto h-auto
                                object-contain
                                grayscale opacity-60
                                group-hover:grayscale-0
                                group-hover:opacity-100
                                transition-all duration-300
                            "
                            onerror="
                                this.style.display='none';
                                this.nextElementSibling.style.display='flex';
                            ">

                        {{-- FALLBACK --}}
                        <div class="
                            hidden items-center justify-center
                            w-14 h-14 rounded-full
                            bg-slate-100 text-slate-300
                        ">
                            <svg
                                class="w-8 h-8"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M12 21a9 9 0 100-18
                                    9 9 0 000 18z
                                    M3 12h18
                                    M12 3c2.5 2.5 4 5.5 4 9
                                    s-1.5 6.5-4 9
                                    c-2.5-2.5-4-5.5-4-9
                                    s1.5-6.5 4-9z" />
                            </svg>
                        </div>

                        @else

                        {{-- FALLBACK --}}
                        <div class="
                            flex items-center justify-center
                            w-14 h-14 rounded-full
                            bg-slate-100 text-slate-300
                        ">
                            <svg
                                class="w-8 h-8"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M12 21a9 9 0 100-18
                                    9 9 0 000 18z
                                    M3 12h18
                                    M12 3c2.5 2.5 4 5.5 4 9
                                    s-1.5 6.5-4 9
                                    c-2.5-2.5-4-5.5-4-9
                                    s1.5-6.5 4-9z" />
                            </svg>
                        </div>

                        @endif

                    </div>

                    {{-- NAMA PORTAL --}}
                    <div class="
                    absolute inset-x-0 bottom-0
                    px-3 py-4 text-center
                    bg-gradient-to-t
                    from-white via-white/95 to-transparent
                    opacity-100 translate-y-0
                    sm:opacity-0 sm:translate-y-3
                    sm:group-hover:opacity-100
                    sm:group-hover:translate-y-0
                    sm:group-focus-visible:opacity-100
                    sm:group-focus-visible:translate-y-0
                    transition-all duration-300
                ">
                        <span class="
                        block text-sm font-bold
                        text-slate-700
                        line-clamp-2
                    ">
                            {{ $portal->name }}
                        </span>
                    </div>

                    {{-- LINK INDICATOR --}}
                    <div class="
                    absolute bottom-3 right-3
                    w-7 h-7
                    rounded-full
                    flex items-center justify-center
                    bg-white border border-slate-100
                    opacity-100
                    sm:opacity-0 sm:translate-x-1
                    sm:group-hover:opacity-100
                    sm:group-hover:translate-x-0
                    transition-all duration-300
                ">
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="#07a2a2"
                            stroke-width="2"
                            viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M7 17L17 7M7 7h10v10" />
                        </svg>
                    </div>

                </a>

                @endforeach

            </div>

            {{-- PREVIOUS BUTTON --}}
            @if ($portalLinks->count() > 5)

            <button
                type="button"
                @click="scrollLeft()"
                class="
                    absolute left-[-10px] top-1/2
                    -translate-y-1/2 z-10
                    w-10 h-10 rounded-full
                    bg-white border border-slate-100
                    shadow-lg
                    hidden sm:flex
                    items-center justify-center
                    text-slate-600
                    hover:bg-slate-50
                    hover:scale-105
                    transition-all duration-200
                "
                aria-label="Portal sebelumnya">
                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            {{-- NEXT BUTTON --}}
            <button
                type="button"
                @click="scrollRight()"
                class="
                    absolute right-[-10px] top-1/2
                    -translate-y-1/2 z-10
                    w-10 h-10 rounded-full
                    bg-white border border-slate-100
                    shadow-lg
                    hidden sm:flex
                    items-center justify-center
                    text-slate-600
                    hover:bg-slate-50
                    hover:scale-105
                    transition-all duration-200
                "
                aria-label="Portal berikutnya">
                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 5l7 7-7 7" />
                </svg>
            </button>

            @endif

        </div>

        {{-- MOBILE HINT --}}
        @if ($portalLinks->count() > 1)

        <div class="
            flex sm:hidden
            justify-center items-center
            gap-2 mt-3
        ">
            <svg
                class="w-4 h-4 text-slate-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M7 16l-4-4m0 0l4-4m-4 4h18" />
            </svg>

            <span class="text-xs text-slate-400">
                Geser untuk melihat layanan lainnya
            </span>
        </div>

        @endif

    </section>

    @endif

</div>