<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

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
                                {{ $article->kategori }}
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
                                    <time datetime="{{ $article->jadwal_tayang->toDateString() }}">
                                        {{ $article->jadwal_tayang->translatedFormat('d F Y') }}
                                    </time>
                                @else
                                    <span>Tanggal belum tersedia</span>
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
            <div class="mt-10">
                {{ $articles->links() }}
            </div>
        @endif

    </div>
</div>
