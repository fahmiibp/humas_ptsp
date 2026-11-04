@props(['images' => [], 'alt' => ''])

@php $images = array_values($images); @endphp

<div class="absolute inset-0 overflow-hidden" x-data="{
    i: 0,
    n: {{ count($images) }},
    startX: 0,
    next() { this.i = (this.i + 1) % this.n },
    prev() { this.i = (this.i - 1 + this.n) % this.n }
}"
    x-on:touchstart.passive="startX = $event.touches[0].clientX"
    x-on:touchend="const d = $event.changedTouches[0].clientX - startX; if (Math.abs(d) > 50) { d < 0 ? next() : prev() }">

    <div class="flex h-full transition-transform duration-500 ease-out" :style="`transform: translateX(-${i * 100}%)`">
        @foreach ($images as $idx => $url)
            <img src="{{ $url }}" alt="{{ $alt }}"
                @if ($idx > 0) loading="lazy" @endif class="h-full w-full shrink-0 object-cover">
        @endforeach
    </div>

    @if (count($images) > 1)
        <button type="button" x-on:click="prev()" aria-label="Foto sebelumnya"
            class="absolute left-2 top-1/2 z-20 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-full bg-white/80 text-teal-700 shadow transition hover:bg-white md:opacity-0 md:group-hover:opacity-100">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button type="button" x-on:click="next()" aria-label="Foto berikutnya"
            class="absolute right-2 top-1/2 z-20 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-full bg-white/80 text-teal-700 shadow transition hover:bg-white md:opacity-0 md:group-hover:opacity-100">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </button>

        <div class="absolute inset-x-0 bottom-2 z-20 flex justify-center gap-1.5">
            @foreach ($images as $idx => $url)
                <button type="button" x-on:click="i = {{ $idx }}" aria-label="Foto {{ $idx + 1 }}"
                    class="h-1.5 rounded-full transition-all"
                    :class="i === {{ $idx }} ? 'w-4 bg-white' : 'w-1.5 bg-white/50 hover:bg-white/80'"></button>
            @endforeach
        </div>
    @endif
</div>@props(['images' => [], 'alt' => ''])

@php $images = array_values($images); @endphp

<div class="absolute inset-0 overflow-hidden" x-data="{
    i: 0,
    n: {{ count($images) }},
    startX: 0,
    next() { this.i = (this.i + 1) % this.n },
    prev() { this.i = (this.i - 1 + this.n) % this.n }
}"
    x-on:touchstart.passive="startX = $event.touches[0].clientX"
    x-on:touchend="const d = $event.changedTouches[0].clientX - startX; if (Math.abs(d) > 50) { d < 0 ? next() : prev() }">

    <div class="flex h-full transition-transform duration-500 ease-out" :style="`transform: translateX(-${i * 100}%)`">
        @foreach ($images as $idx => $url)
            <img src="{{ $url }}" alt="{{ $alt }}"
                @if ($idx > 0) loading="lazy" @endif class="h-full w-full shrink-0 object-cover">
        @endforeach
    </div>

    @if (count($images) > 1)
        <button type="button" x-on:click="prev()" aria-label="Foto sebelumnya"
            class="absolute left-2 top-1/2 z-20 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-full bg-white/80 text-teal-700 shadow transition hover:bg-white md:opacity-0 md:group-hover:opacity-100">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button type="button" x-on:click="next()" aria-label="Foto berikutnya"
            class="absolute right-2 top-1/2 z-20 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-full bg-white/80 text-teal-700 shadow transition hover:bg-white md:opacity-0 md:group-hover:opacity-100">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </button>

        <div class="absolute inset-x-0 bottom-2 z-20 flex justify-center gap-1.5">
            @foreach ($images as $idx => $url)
                <button type="button" x-on:click="i = {{ $idx }}" aria-label="Foto {{ $idx + 1 }}"
                    class="h-1.5 rounded-full transition-all"
                    :class="i === {{ $idx }} ? 'w-4 bg-white' : 'w-1.5 bg-white/50 hover:bg-white/80'"></button>
            @endforeach
        </div>
    @endif
</div>
