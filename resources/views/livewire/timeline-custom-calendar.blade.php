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

                    {{-- Nomor Tanggal --}}
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-semibold rounded-full w-6 h-6 flex items-center justify-center {{ $day['isToday'] ? 'bg-primary-600 text-white font-bold' : '' }}">
                            {{ $day['date']->day }}
                        </span>
                    </div>

                    {{-- Daftar Event pada Tanggal Tersebut --}}
                    <div class="space-y-1">
                        @foreach ($day['events'] as $event)
                        <div
                            class="px-2 py-1 text-xs rounded bg-primary-50 dark:bg-primary-950/60 border-l-2 border-primary-500 text-primary-700 dark:text-primary-300 truncate"
                            title="{{ $event->event_name }} @if($event->location) ({{ $event->location }}) @endif">
                            <div class="font-medium truncate">{{ $event->event_name }}</div>
                            <div class="text-[10px] opacity-75">
                                {{ \Carbon\Carbon::parse($event->start_date)->format('H:i') }}
                                @if($event->location)
                                • {{ $event->location }}
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
                @endforeach
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>