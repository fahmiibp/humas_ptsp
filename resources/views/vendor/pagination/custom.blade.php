@if ($paginator->hasPages())
    <div class="mt-10 flex flex-col sm:flex-row items-center justify-between gap-4">

        {{-- Informasi jumlah berita --}}
        <p class="text-sm text-gray-500">
            Menampilkan
            <span class="font-semibold text-gray-700">{{ $paginator->firstItem() }}</span>
            -
            <span class="font-semibold text-gray-700">{{ $paginator->lastItem() }}</span>
            dari
            <span class="font-semibold text-gray-700">{{ $paginator->total() }}</span>
            berita
        </p>

        <nav class="flex items-center gap-1" aria-label="Pagination">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span
                    class="flex items-center justify-center w-9 h-9 rounded-lg border border-gray-200 text-gray-300 cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 18-6-6 6-6" />
                    </svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                    class="flex items-center justify-center w-9 h-9 rounded-lg border border-gray-200 text-gray-600 hover:bg-teal-50 hover:text-teal-600 hover:border-teal-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 18-6-6 6-6" />
                    </svg>
                </a>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-2 text-gray-400">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page"
                                class="flex items-center justify-center w-9 h-9 rounded-lg bg-teal-600 text-white text-sm font-semibold shadow-sm">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                                class="flex items-center justify-center w-9 h-9 rounded-lg border border-gray-200 text-gray-600 text-sm font-medium hover:bg-teal-50 hover:text-teal-600 hover:border-teal-200 transition">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                    class="flex items-center justify-center w-9 h-9 rounded-lg border border-gray-200 text-gray-600 hover:bg-teal-50 hover:text-teal-600 hover:border-teal-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 18 6-6-6-6" />
                    </svg>
                </a>
            @else
                <span
                    class="flex items-center justify-center w-9 h-9 rounded-lg border border-gray-200 text-gray-300 cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 18 6-6-6-6" />
                    </svg>
                </span>
            @endif

        </nav>
    </div>
@endif
