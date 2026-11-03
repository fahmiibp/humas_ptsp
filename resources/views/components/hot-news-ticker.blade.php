@props(['items'])

@if ($items->isNotEmpty())
    <div class="mb-6 overflow-hidden rounded-xl bg-gray-900 text-white" x-data="{ i: 0, total: {{ $items->count() }}, timer: null }" x-init="if (total > 1) timer = setInterval(() => i = (i + 1) % total, 4000)"
        x-on:mouseenter="clearInterval(timer)"
        x-on:mouseleave="if (total > 1) timer = setInterval(() => i = (i + 1) % total, 4000)">

        <div class="flex items-center gap-3 px-4 py-2.5 text-sm">
            {{-- <span class="shrink-0 rounded bg-red-600 px-2 py-0.5 text-xs font-bold uppercase">

            </span> --}}

            <div class="relative h-5 flex-1 overflow-hidden">
                @foreach ($items as $index => $item)
                    <a href="{{ route('articles.show', ['slug' => $item->slug_url]) }}" wire:navigate
                        x-show="i === {{ $index }}" x-transition.opacity.duration.300ms
                        @if ($index > 0) x-cloak @endif
                        class="absolute inset-0 truncate hover:underline">
                        {{ $item->judul_siaran_pers }}
                    </a>
                @endforeach
            </div>

            <span class="hidden shrink-0 text-xs text-gray-400 sm:block" x-show="total > 1"
                x-text="(i + 1) + '/' + total"></span>
        </div>
    </div>
@endif
