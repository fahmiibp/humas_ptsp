<div class="max-w-3xl mx-auto px-4 sm:px-6 py-8">

    {{-- Breadcrumb / Back --}}
    <nav class="mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" wire:navigate
            class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors group">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </nav>

    {{-- Article Header --}}
    <header class="mb-8">
        <div class="flex items-center gap-2 mb-4">

            <span
                class="inline-flex items-center px-2.5 py-1 rounded-md bg-teal-50 text-teal-600 text-xs font-semibold">
                {{ $article->kategori }}
            </span>

            <span class="text-gray-300">•</span>

            <time datetime="{{ $article->jadwal_tayang?->toDateString() }}" class="text-sm text-gray-500">
                {{ $article->jadwal_tayang?->translatedFormat('d F Y') ?? 'Tanggal tidak tersedia' }}
            </time>
        </div>

        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight tracking-tight mb-6">
            {{ $article->judul_siaran_pers }}
        </h1>

        {{-- Lead --}}
        @if ($article->lead_berita)
            <p class="text-lg text-gray-600 leading-relaxed">
                {{ $article->lead_berita }}
            </p>
        @endif
    </header>

    {{-- Featured Image --}}
    @php
        $thumbnail = $article->dokumentasi_utama;

        if (is_array($thumbnail)) {
            $thumbnail = $thumbnail[0] ?? null;
        }
    @endphp

    @if ($thumbnail)
        <figure class="mb-8 -mx-4 sm:mx-0">
            <div class="aspect-video overflow-hidden rounded-none sm:rounded-2xl bg-gray-100">
                <img src="{{ \Illuminate\Support\Facades\Storage::url($thumbnail) }}"
                    alt="{{ $article->judul_siaran_pers }}" class="w-full h-full object-cover">
            </div>
        </figure>
    @endif

    {{-- Article Body --}}
    <article
        class="prose prose-lg prose-gray max-w-none
            prose-headings:font-bold prose-headings:text-gray-900
            prose-a:text-indigo-600 prose-a:no-underline hover:prose-a:underline
            prose-img:rounded-xl prose-img:shadow-sm
            prose-blockquote:border-l-indigo-500 prose-blockquote:bg-indigo-50/50
            prose-blockquote:py-1 prose-blockquote:not-italic
            mb-12">
        {!! $article->badan_berita ?? '' !!}
    </article>

    {{-- Divider --}}
    <hr class="border-gray-100 mb-10">

    {{-- Related Articles --}}
    @if ($related->isNotEmpty())
        <section aria-labelledby="related-heading">

            <h2 id="related-heading" class="text-xl font-bold text-gray-900 mb-5 flex items-center gap-2">
                <span class="w-1 h-6 bg-indigo-600 rounded-full"></span>
                Berita Terkait
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                @foreach ($related as $item)
                    <a href="{{ route('articles.show', $item->slug_url) }}" wire:navigate
                        wire:key="related-{{ $item->id }}"
                        class="group flex gap-3 p-3 rounded-xl border border-gray-100 bg-white hover:border-indigo-100 hover:shadow-md hover:shadow-indigo-50 transition-all duration-200">

                        {{-- Related Thumbnail --}}
                        @php
                            $relatedThumbnail = $item->dokumentasi_utama;

                            if (is_array($relatedThumbnail)) {
                                $relatedThumbnail = $relatedThumbnail[0] ?? null;
                            }
                        @endphp

                        @if ($relatedThumbnail)
                            <div class="w-20 h-20 shrink-0 rounded-lg overflow-hidden bg-gray-100">
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($relatedThumbnail) }}"
                                    alt="{{ $item->judul_siaran_pers }}" loading="lazy"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                        @endif

                        <div class="flex flex-col justify-center min-w-0">

                            <h3
                                class="text-sm font-semibold text-gray-900 line-clamp-2 group-hover:text-indigo-600 transition-colors mb-1">
                                {{ $item->judul_siaran_pers }}
                            </h3>

                            <small class="text-xs text-gray-400">
                                {{ $item->jadwal_tayang?->translatedFormat('d F Y') ?? 'Tanggal tidak tersedia' }}
                            </small>

                        </div>
                    </a>
                @endforeach

            </div>
        </section>
    @endif

</div>
