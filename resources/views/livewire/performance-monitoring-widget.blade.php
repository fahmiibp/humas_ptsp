<x-filament-widgets::widget>
    <div
        class="rounded-2xl border border-emerald-200 dark:border-emerald-800/60 bg-gradient-to-r from-white via-emerald-50 to-emerald-100 dark:bg-gradient-to-r dark:from-emerald-950/60 dark:via-gray-900 dark:to-emerald-950/40 p-6 shadow-xl space-y-6 transition-all text-gray-900 dark:text-white">

        <!-- BAGIAN ATAS: Header & Rekapitulasi Kinerja -->
        <div
            class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 border-b border-emerald-200/60 dark:border-emerald-800/60 pb-6">
            <div class="space-y-1.5">
                <div class="flex items-center gap-2">
                    @if ($isCurrentMonth)
                        <span
                            class="inline-flex items-center rounded-full bg-emerald-100 dark:bg-emerald-500/10 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:text-emerald-400 border border-emerald-300 dark:border-emerald-500/20">
                            ● MONITORING AKTIF • BULAN BERJALAN
                        </span>
                    @else
                        <span
                            class="inline-flex items-center rounded-full bg-gray-100 dark:bg-gray-500/10 px-2.5 py-0.5 text-xs font-semibold text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-500/20">
                            ARSIP • {{ strtoupper($monthName) }}
                        </span>
                    @endif
                    <span class="text-xs text-gray-600 dark:text-emerald-300/80">Per {{ $todayDate }}</span>
                </div>
                <h2 class="text-xl lg:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    Rekapitulasi Kinerja: <span
                        class="text-emerald-700 dark:text-emerald-400 font-extrabold">{{ $monthName }}</span>
                </h2>
                <p class="text-xs lg:text-sm text-gray-700 dark:text-emerald-100/80 max-w-2xl">
                    Akumulasi seluruh agenda liputan, pengarsipan berkas Drive, dan warta dinas yang terlaksana
                    sepanjang bulan ini.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">

                <!-- FILTER BULAN -->
                <div class="min-w-[180px]">
                    <label for="filter-bulan"
                        class="block text-[11px] font-semibold text-emerald-800 dark:text-emerald-300 tracking-wider mb-1">
                        FILTER BULAN
                    </label>
                    <select id="filter-bulan" wire:model.live="selectedMonth"
                        class="w-full rounded-lg border border-emerald-300 dark:border-emerald-700 bg-white/90 dark:bg-emerald-900/40 text-sm text-gray-900 dark:text-white px-3 py-2 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        @foreach ($monthOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Badge Kelengkapan Arsip -->
                <div
                    class="flex items-center gap-4 rounded-xl bg-white/90 dark:bg-emerald-900/40 border border-emerald-200 dark:border-emerald-800/60 p-4 min-w-[220px] shadow-sm">
                    <div>
                        <p class="text-[11px] font-semibold text-emerald-800 dark:text-emerald-300 tracking-wider">
                            KELENGKAPAN ARSIP ({{ strtoupper($monthName) }})</p>
                        <p class="text-2xl font-black text-gray-900 dark:text-white">{{ $completionPercentage }}%</p>
                        <p class="text-[10px] text-gray-500 dark:text-emerald-400/80">
                            {{ $isCurrentMonth ? $remainingDays . ' hari tersisa di bulan ini' : 'Bulan telah selesai' }}
                        </p>
                    </div>
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-500/30">
                        <x-heroicon-m-check-badge class="h-6 w-6" />
                    </div>
                </div>
            </div>
        </div>

        <!-- BAGIAN BAWAH: 4 Grid Kartu Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">

            <!-- 1. Agenda Liputan -->
            <div
                class="rounded-xl border border-emerald-200 dark:border-emerald-800/60 bg-white/90 dark:bg-emerald-950/50 p-4 flex flex-col justify-between shadow-sm hover:border-emerald-400 dark:hover:border-emerald-600 transition-all">
                <div class="flex justify-between items-start">
                    <div>
                        <span
                            class="text-xs font-semibold text-gray-600 dark:text-emerald-300 uppercase tracking-wider">Agenda
                            Liputan</span>
                        <span
                            class="inline-block ml-1.5 px-1.5 py-0.5 rounded text-[10px] bg-emerald-100 dark:bg-emerald-500/20 text-emerald-800 dark:text-emerald-300 font-medium">{{ $isCurrentMonth ? 'Bulan Ini' : $monthName }}</span>
                    </div>
                    <div
                        class="rounded-lg bg-emerald-100 dark:bg-emerald-600/20 p-2 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-transparent">
                        <x-heroicon-m-calendar class="h-5 w-5" />
                    </div>
                </div>
                <div class="my-3">
                    <div class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $agendaCount }}</div>
                    <p class="text-xs text-gray-600 dark:text-emerald-200/80 mt-0.5">kegiatan di {{ $monthName }}
                    </p>
                </div>
                <div
                    class="border-t border-emerald-100 dark:border-emerald-800/60 pt-2 flex justify-between items-center text-xs">
                    <span class="text-gray-500 dark:text-emerald-300/70">Tren vs bln lalu:</span>
                    @if (is_null($agendaTrend))
                        <span class="text-gray-500 font-semibold">–</span>
                    @else
                        <span
                            class="{{ $agendaTrend >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }} font-semibold">
                            {{ $agendaTrend > 0 ? '+' : '' }}{{ $agendaTrend }}%
                        </span>
                    @endif
                </div>
            </div>

            <!-- 2. Arsip Foto/Video -->
            <div
                class="rounded-xl border border-emerald-200 dark:border-emerald-800/60 bg-white/90 dark:bg-emerald-950/50 p-4 flex flex-col justify-between shadow-sm hover:border-emerald-400 dark:hover:border-emerald-600 transition-all">
                <div class="flex justify-between items-start">
                    <div>
                        <span
                            class="text-xs font-semibold text-gray-600 dark:text-emerald-300 uppercase tracking-wider">Arsip
                            Foto/Video</span>
                        <span
                            class="inline-block ml-1.5 px-1.5 py-0.5 rounded text-[10px] bg-emerald-100 dark:bg-emerald-500/20 text-emerald-800 dark:text-emerald-300 font-medium">{{ $isCurrentMonth ? 'Bulan Ini' : $monthName }}</span>
                    </div>
                    <div
                        class="rounded-lg bg-emerald-100 dark:bg-emerald-600/20 p-2 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-transparent">
                        <x-heroicon-m-photo class="h-5 w-5" />
                    </div>
                </div>
                <div class="my-3">
                    <div class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $arsipCount }}</div>
                    <p class="text-xs text-gray-600 dark:text-emerald-200/80 mt-0.5">album rilis terarsip</p>
                </div>
                <div
                    class="border-t border-emerald-100 dark:border-emerald-800/60 pt-2 flex justify-between items-center text-xs">
                    <span class="text-gray-500 dark:text-emerald-300/70">Rasio dokumentasi:</span>
                    <span class="text-emerald-700 dark:text-emerald-300 font-semibold">
                        {{ $rasioDokumentasi }}% ({{ $totalTerarsip }}/{{ $totalSelesai }})
                    </span>
                </div>
            </div>

            <!-- 3. Google Drive -->
            <div
                class="rounded-xl border border-emerald-200 dark:border-emerald-800/60 bg-white/90 dark:bg-emerald-950/50 p-4 flex flex-col justify-between shadow-sm hover:border-emerald-400 dark:hover:border-emerald-600 transition-all">
                <div class="flex justify-between items-start">
                    <div>
                        <span
                            class="text-xs font-semibold text-gray-600 dark:text-emerald-300 uppercase tracking-wider">Google
                            Drive</span>
                        <span
                            class="inline-block ml-1.5 px-1.5 py-0.5 rounded text-[10px] bg-emerald-100 dark:bg-emerald-500/20 text-emerald-800 dark:text-emerald-300 font-medium">Terhubung</span>
                    </div>
                    <div
                        class="rounded-lg bg-emerald-100 dark:bg-emerald-600/20 p-2 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-transparent">
                        <x-heroicon-m-cloud class="h-5 w-5" />
                    </div>
                </div>
                <div class="my-3">
                    <div class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $driveCount }}</div>
                    <p class="text-xs text-gray-600 dark:text-emerald-200/80 mt-0.5">folder arsip siap akses</p>
                </div>
                <div
                    class="border-t border-emerald-100 dark:border-emerald-800/60 pt-2 flex justify-between items-center text-xs">
                    <span class="text-gray-500 dark:text-emerald-300/70">Akses publik drive:</span>
                    <span class="text-emerald-700 dark:text-emerald-300 font-semibold">Aktif & Siap Salin</span>
                </div>
            </div>

            <!-- 4. Warta / Berita -->
            <div
                class="rounded-xl border border-emerald-200 dark:border-emerald-800/60 bg-white/90 dark:bg-emerald-950/50 p-4 flex flex-col justify-between shadow-sm hover:border-emerald-400 dark:hover:border-emerald-600 transition-all">
                <div class="flex justify-between items-start">
                    <div>
                        <span
                            class="text-xs font-semibold text-gray-600 dark:text-emerald-300 uppercase tracking-wider">Warta
                            / Berita</span>
                        <span
                            class="inline-block ml-1.5 px-1.5 py-0.5 rounded text-[10px] bg-emerald-100 dark:bg-emerald-500/20 text-emerald-800 dark:text-emerald-300 font-medium">{{ $isCurrentMonth ? 'Bulan Ini' : $monthName }}</span>
                    </div>
                    <div
                        class="rounded-lg bg-emerald-100 dark:bg-emerald-600/20 p-2 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-transparent">
                        <x-heroicon-m-document-text class="h-5 w-5" />
                    </div>
                </div>
                <div class="my-3">
                    <div class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $wartaPublished }}</div>
                    <p class="text-xs text-gray-600 dark:text-emerald-200/80 mt-0.5">rilis terbit di
                        {{ $monthName }}</p>
                </div>
                <div
                    class="border-t border-emerald-100 dark:border-emerald-800/60 pt-2 flex justify-between items-center text-xs">
                    <span class="text-gray-500 dark:text-emerald-300/70">{{ $wartaDraft }} naskah draf</span>
                    <a href="{{ \App\Filament\Resources\Wartas\WartaResource::getUrl() }}"
                        class="text-emerald-700 dark:text-emerald-400 hover:text-emerald-600 dark:hover:text-emerald-300 font-semibold flex items-center gap-0.5">
                        Buka Warta →
                    </a>
                </div>
            </div>

        </div>

    </div>
</x-filament-widgets::widget>
