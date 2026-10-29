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

            <time datetime="{{ $article->jadwal_tayang?->toIso8601String() }}" class="text-sm text-gray-500">
                {{ $article->jadwal_tayang
                    ? $article->jadwal_tayang->timezone(config('app.timezone', 'Asia/Jakarta'))->locale('id')->translatedFormat('l, d F Y')
                    : 'Tanggal tidak tersedia' }}
            </time>
        </div>

        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight tracking-tight mb-6">
            {{ $article->judul_siaran_pers }}
            <p class="text-teal-700 text-xl font-medium">PTSP Jawa Tengah</p>
        </h1>

        <div class="mb-5 flex flex-wrap items-center gap-3">
            <span class="text-sm font-semibold text-gray-700">Bagikan:</span>

            {{-- WhatsApp --}}
            <a href="https://wa.me/?text={{ urlencode($article->judul_siaran_pers . ' ' . url()->current()) }}"
                target="_blank" rel="noopener noreferrer" aria-label="Bagikan ke WhatsApp" title="WhatsApp"
                class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-green-50 text-green-600 transition hover:bg-green-600 hover:text-white">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path
                        d="M20.5 3.5A11.8 11.8 0 0 0 12.1 0C5.6 0 .3 5.3.3 11.8c0 2.1.6 4.2 1.6 6L.2 24l6.3-1.7a11.8 11.8 0 0 0 5.6 1.4h.1c6.5 0 11.8-5.3 11.8-11.8 0-3.2-1.2-6.1-3.5-8.4ZM12.1 21.7c-1.8 0-3.5-.5-5-1.4l-.4-.2-3.7 1 1-3.6-.2-.4a9.8 9.8 0 1 1 8.3 4.6Zm5.4-7.3c-.3-.2-1.8-.9-2.1-1s-.5-.2-.7.2-.8 1-.9 1.1-.3.2-.6.1a8 8 0 0 1-2.4-1.5 9 9 0 0 1-1.7-2.1c-.2-.3 0-.5.1-.6l.5-.6.3-.5c.1-.2 0-.4 0-.6l-1-2.3c-.3-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4s-1.2 1.2-1.2 2.8 1.2 3.2 1.4 3.4a13 13 0 0 0 4.9 4.3c.7.3 1.2.5 1.6.6.7.2 1.3.2 1.8.1.6-.1 1.8-.7 2-1.4s.3-1.3.2-1.4-.2-.3-.5-.5Z" />
                </svg>
            </a>

            {{-- Facebook --}}
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"
                rel="noopener noreferrer" aria-label="Bagikan ke Facebook" title="Facebook"
                class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-blue-50 text-blue-600 transition hover:bg-blue-600 hover:text-white">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path
                        d="M24 12a12 12 0 1 0-13.9 11.9v-8.4H7.1V12h3V9.3c0-3 1.8-4.7 4.5-4.7 1.3 0 2.7.2 2.7.2v3h-1.5c-1.5 0-2 .9-2 1.9V12h3.4l-.5 3.5h-2.9v8.4A12 12 0 0 0 24 12Z" />
                </svg>
            </a>

            {{-- X --}}
            <a href="https://x.com/intent/post?text={{ urlencode($article->judul_siaran_pers) }}&url={{ urlencode(url()->current()) }}"
                target="_blank" rel="noopener noreferrer" aria-label="Bagikan ke X" title="X"
                class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-800 transition hover:bg-black hover:text-white">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path
                        d="M18.9 2H22l-6.8 7.8L23.2 22h-6.3L12 14.6 5.5 22H2.3l7.3-8.4L1.8 2h6.5l4.5 6.8L18.9 2Zm-1.1 18h1.7L7.3 3.9H5.5L17.8 20Z" />
                </svg>
            </a>

            {{-- Salin Link --}}
            <button type="button"
                onclick="
        navigator.clipboard.writeText(window.location.href)
            .then(() => {
                const toast = document.getElementById('copy-link-toast');
                toast.classList.remove('opacity-0', 'translate-y-2', 'pointer-events-none');
                toast.classList.add('opacity-100', 'translate-y-0');

                clearTimeout(window.copyLinkToastTimer);
                window.copyLinkToastTimer = setTimeout(() => {
                    toast.classList.add('opacity-0', 'translate-y-2', 'pointer-events-none');
                    toast.classList.remove('opacity-100', 'translate-y-0');
                }, 2500);
            })
            .catch(() => {
                alert('Gagal menyalin link. Silakan salin URL dari browser.');
            });
    "
                aria-label="Salin link" title="Salin link"
                class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-600 transition hover:bg-teal-600 hover:text-white">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    aria-hidden="true">
                    <rect x="8" y="8" width="13" height="13" rx="2" />
                    <path d="M16 8V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h3" />
                </svg>
            </button>

            {{-- Notifikasi --}}
            <div id="copy-link-toast" role="status" aria-live="polite"
                class="pointer-events-none fixed bottom-6 left-1/2 z-50 flex -translate-x-1/2 translate-y-2 items-center gap-2 rounded-xl bg-gray-900 px-5 py-3 text-sm font-medium text-white opacity-0 shadow-xl transition-all duration-300">
                <svg class="h-5 w-5 text-green-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                </svg>
                Link berhasil disalin!
            </div>
        </div>

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
