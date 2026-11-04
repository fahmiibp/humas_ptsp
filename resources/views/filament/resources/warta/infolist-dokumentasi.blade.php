
@php
    $images = $getState() ?? [];
@endphp

@if (count($images) > 0)
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($images as $image)
            @php
                $url = \Illuminate\Support\Facades\Storage::disk('public')
                    ->url($image);
            @endphp

            <a
                href="{{ $url }}"
                target="_blank"
                rel="noopener noreferrer"
                class="group block overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition hover:shadow-md dark:border-gray-700 dark:bg-gray-900"
            >
                <div class="aspect-video overflow-hidden bg-gray-100 dark:bg-gray-800">
                    <img
                        src="{{ $url }}"
                        alt="Dokumentasi Warta {{ $loop->iteration }}"
                        loading="lazy"
                        class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                    >
                </div>

                <div class="flex items-center justify-between gap-2 px-3 py-3">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-200">
                        Foto {{ $loop->iteration }}
                    </span>

                    <span class="text-xs text-primary-600 dark:text-primary-400">
                        Lihat gambar ↗
                    </span>
                </div>
            </a>
        @endforeach
    </div>
@else
    <p class="text-sm text-gray-500">
        Belum ada foto dokumentasi.
    </p>
@endif
