<div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200/80 dark:border-gray-800 p-6 shadow-sm">
    <!-- Header Kalender -->
    <div class="flex flex-wrap items-center justify-between gap-4 pb-6 border-b border-gray-100 dark:border-gray-800">
        <div class="flex items-center gap-3">
            <div class="p-3 bg-pink-50 text-pink-500 rounded-full dark:bg-pink-950/40">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                    Kalender Konten Medsos • {{ $monthName }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Matriks perencanaan tayang kanal media sosial DPMPTSP Jateng
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ \App\Filament\Resources\RencanaKontenMedsos\RencanaKontenMedsosResource::getUrl('create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg shadow-sm transition">
                + Buat Konten
            </a>

            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden ml-2">
                <button wire:click="previousMonth" type="button"
                    class="p-2 hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button wire:click="today" type="button"
                    class="px-3 py-2 text-xs font-semibold hover:bg-gray-50 dark:hover:bg-gray-800 border-x border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200">
                    Bulan Ini
                </button>
                <button wire:click="nextMonth" type="button"
                    class="p-2 hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Nama Hari (Senin - Minggu) -->
    <div class="grid grid-cols-7 gap-2 mt-4 text-center text-xs font-bold uppercase tracking-wider">
        <div class="py-2 text-gray-500">SEN</div>
        <div class="py-2 text-gray-500">SEL</div>
        <div class="py-2 text-gray-500">RAB</div>
        <div class="py-2 text-gray-500">KAM</div>
        <div class="py-2 text-gray-500">JUM</div>
        <div class="py-2 text-amber-500">SAB</div>
        <div class="py-2 text-red-500">MIN</div>
    </div>

    <!-- Grid Tanggal -->
    <div class="grid grid-cols-7 gap-2 mt-2">
        @foreach($days as $dayData)
            @php
                $isCurrent = $dayData['isCurrentMonth'];
                $isToday = $dayData['isToday'];
                $posts = $dayData['posts'];
            @endphp

            <div class="min-h-[120px] p-2.5 rounded-2xl border transition-all relative flex flex-col justify-between
                    {{ $isToday ? 'border-blue-500 ring-2 ring-blue-500/20 bg-white dark:bg-gray-900' : 'border-gray-100 dark:border-gray-800 bg-gray-50/30 dark:bg-gray-900/50' }}
                    {{ !$isCurrent ? 'opacity-30' : '' }}">

                <div class="flex items-center justify-between">
                    <span
                        class="text-sm font-bold {{ $isToday ? 'text-blue-600 dark:text-blue-400' : 'text-gray-800 dark:text-gray-200' }}">
                        {{ $dayData['date']->day }}
                    </span>

                    @if($posts->count() > 0)
                        <span
                            class="text-[10px] font-semibold bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 px-1.5 py-0.5 rounded-md">
                            {{ $posts->count() }} post
                        </span>
                    @endif
                </div>

                <div class="space-y-1 mt-2 flex-1">
                    @foreach($posts as $post)
                        @php
                            $jam = \Carbon\Carbon::parse($post->jam_tayang ?? $post->tanggal)->format('H:i');
                            $platform = strtolower($post->platform ?? 'Instagram');
                        @endphp
                        <a href="{{ \App\Filament\Resources\RencanaKontenMedsos\RencanaKontenMedsosResource::getUrl('edit', ['record' => $post->id]) }}"
                            class="block text-[11px] p-1.5 rounded-lg bg-pink-50 hover:bg-pink-100 dark:bg-pink-950/40 text-pink-600 dark:text-pink-300 font-medium truncate transition">
                            <span class="font-bold">• {{ $jam }}</span> [{{ ucfirst($platform) }}] {{ $post->judul }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>