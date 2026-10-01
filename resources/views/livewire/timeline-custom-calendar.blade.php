<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Header Navigation --}}
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ \Carbon\Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y') }}
            </h2>
            <div class="flex items-center gap-2">
                <x-filament::button wire:click="goToToday" size="sm" color="gray" variant="outlined">
                    Hari Ini
                </x-filament::button>
                <x-filament::button wire:click="previousMonth" size="sm" color="gray">
                    &larr;
                </x-filament::button>
                <x-filament::button wire:click="nextMonth" size="sm" color="gray">
                    &rarr;
                </x-filament::button>
            </div>
        </div>

        {{-- Grid Kalender --}}
        <div class="border border-gray-200 dark:border-gray-800 rounded-lg overflow-hidden">
            {{-- Header Nama Hari --}}
            <div class="grid grid-cols-7 bg-gray-100 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-800 text-center font-semibold text-xs text-gray-600 dark:text-gray-300 uppercase py-2">
                <div>Sen</div>
                <div>Sel</div>
                <div>Rab</div>
                <div>Kam</div>
                <div>Jum</div>
                <div>Sab</div>
                <div>Min</div>
            </div>

            {{-- Body Kotak Tanggal (7 Kolom) --}}
            <div class="grid grid-cols-7 gap-px bg-gray-200 dark:bg-gray-800">
                @foreach ($this->calendarDays as $day)
                <div class="min-h-[110px] p-2 bg-white dark:bg-gray-900 transition-colors {{ ! $day['isCurrentMonth'] ? 'bg-gray-50/50 text-gray-400 dark:bg-gray-950/40 dark:text-gray-600' : '' }}">

                    {{-- Header Tanggal + Badge Total Agenda --}}
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-semibold rounded-full w-6 h-6 flex items-center justify-center {{ $day['isToday'] ? 'bg-primary-600 text-white font-bold ring-2 ring-primary-400' : '' }}">
                            {{ $day['date']->day }}
                        </span>

                        {{-- Badge Jumlah Agenda --}}
                        @if(count($day['events']) > 0)
                            <span class="text-[10px] bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300 px-1.5 py-0.5 rounded-full font-medium">
                                {{ count($day['events']) }} agenda
                            </span>
                        @endif
                    </div>

                    {{-- Daftar Event pada Tanggal Tersebut --}}
                    <div class="space-y-1">
                        @foreach ($day['events'] as $event)
                            @php
                                // Ambil nilai status (aman untuk Enum maupun String)
                                $rawStatus = is_object($event->status) ? $event->status->value : ($event->status ?? 'Belum Mulai');
                                $statusNormalized = strtolower(trim((string) $rawStatus));

                                // Penentuan warna style berdasarkan status
                                $statusStyle = match(true) {
                                    in_array($statusNormalized, ['selesai', 'done', 'completed']) 
                                        => 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-500',

                                    in_array($statusNormalized, ['sedang berlangsung', 'berlangsung', 'ongoing', 'proses']) 
                                        => 'bg-amber-500/10 text-amber-700 dark:text-amber-400 border-amber-500',

                                    in_array($statusNormalized, ['batal', 'canceled', 'cancelled']) 
                                        => 'bg-rose-500/10 text-rose-700 dark:text-rose-400 border-rose-500',

                                    default 
                                        => 'bg-blue-500/10 text-blue-700 dark:text-blue-400 border-blue-500', // Belum Mulai / Default
                                };
                            @endphp

                            <div
                                class="px-2 py-1 text-xs rounded border-l-2 {{ $statusStyle }} truncate"
                                title="{{ $event->event_name }} @if($event->location) ({{ $event->location }}) @endif">
                                
                                {{-- Baris Atas: Jam & Label Status --}}
                                <div class="flex items-center justify-between gap-1 mb-0.5">
                                    <span class="text-[10px] font-semibold opacity-90">
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('H:i') }}
                                    </span>
                                    <span class="text-[9px] px-1 py-0.2 rounded bg-black/10 dark:bg-black/40 font-medium">
                                        {{ $rawStatus }}
                                    </span>
                                </div>

                                {{-- Baris Bawah: Nama Event --}}
                                <div class="font-medium truncate">{{ $event->event_name }}</div>
                            </div>
                        @endforeach
                    </div>

                </div>
                @endforeach
            </div>
        </div>

        {{-- Legenda Status Agenda di Bottom Footer --}}
        <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-800 flex items-center justify-between text-xs text-gray-600 dark:text-gray-400">
            <div class="font-medium text-gray-700 dark:text-gray-300">
                Status Agenda:
            </div>
            <div class="flex items-center gap-4">
                <span class="inline-flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500 inline-block"></span>
                    <span>Belum Mulai</span>
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 inline-block"></span>
                    <span>Sedang Berlangsung</span>
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span>
                    <span>Selesai</span>
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500 inline-block"></span>
                    <span>Batal</span>
                </span>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>