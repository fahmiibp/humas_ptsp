<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Header Navigation --}}
        <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
            <h2 class="flex items-center gap-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white lg:text-xl">
                <x-heroicon-m-calendar-days class="h-5 w-5 text-emerald-600 dark:text-emerald-400" />
                Kalender Kegiatan
            </h2>

            <h2 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ \Carbon\Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y') }}
            </h2>

            <div class="flex items-center gap-2">
                <x-filament::button wire:click="goToToday" size="sm" color="gray" outlined>
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
        <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-800">
            {{-- Header Nama Hari --}}
            <div class="grid grid-cols-7 border-b border-gray-200 bg-gray-100 py-2 text-center text-xs font-semibold uppercase text-gray-600 dark:border-gray-800 dark:bg-gray-800 dark:text-gray-300">
                <div>Sen</div>
                <div>Sel</div>
                <div>Rab</div>
                <div>Kam</div>
                <div>Jum</div>
                <div>Sab</div>
                <div>Min</div>
            </div>

            {{-- Body Kalender --}}
            <div class="grid grid-cols-7 gap-px bg-gray-200 dark:bg-gray-800">
                @foreach ($this->calendarDays as $day)
                    <div
                        wire:key="calendar-day-{{ $day['date']->format('Y-m-d') }}"
                        class="min-h-[110px] min-w-0 bg-white p-2 transition-colors dark:bg-gray-900 {{ ! $day['isCurrentMonth'] ? 'bg-gray-50/50 text-gray-400 dark:bg-gray-950/40 dark:text-gray-600' : '' }}">

                        {{-- Tanggal dan Jumlah Agenda --}}
                        <div class="mb-1 flex items-center justify-between gap-1">
                            <span
                                class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full text-xs font-semibold {{ $day['isToday'] ? 'bg-primary-600 font-bold text-white ring-2 ring-primary-400' : '' }}">
                                {{ $day['date']->day }}
                            </span>

                            @if ($day['events']->count() > 0)
                                <span class="rounded-full bg-gray-200 px-1.5 py-0.5 text-[10px] font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                    {{ $day['events']->count() }} agenda
                                </span>
                            @endif
                        </div>

                        {{-- Daftar Kegiatan --}}
                        <div class="space-y-1">
                            @foreach ($day['events'] as $event)
                                @php
                                    $rawStatus = is_object($event->status)
                                        ? $event->status->value
                                        : ($event->status ?? 'Belum Mulai');

                                    $statusNormalized = strtolower(trim((string) $rawStatus));

                                    $statusStyle = match (true) {
                                        in_array($statusNormalized, ['selesai', 'done', 'completed'], true)
                                            => 'border-emerald-500 bg-emerald-500/10 text-emerald-700 dark:text-emerald-400',

                                        in_array($statusNormalized, ['sedang berlangsung', 'berlangsung', 'ongoing', 'proses'], true)
                                            => 'border-amber-500 bg-amber-500/10 text-amber-700 dark:text-amber-400',

                                        in_array($statusNormalized, ['batal', 'canceled', 'cancelled'], true)
                                            => 'border-rose-500 bg-rose-500/10 text-rose-700 dark:text-rose-400',

                                        default
                                            => 'border-blue-500 bg-blue-500/10 text-blue-700 dark:text-blue-400',
                                    };
                                @endphp

                                <button
                                    type="button"
                                    wire:key="calendar-event-{{ $day['date']->format('Y-m-d') }}-{{ $event->id }}"
                                    wire:click="showDetail({{ $event->id }})"
                                    title="Klik untuk melihat detail: {{ $event->event_name }}"
                                    class="block w-full cursor-pointer truncate rounded border-l-2 px-2 py-1 text-left text-xs transition hover:brightness-95 focus:outline-none focus:ring-2 focus:ring-primary-500 {{ $statusStyle }}">

                                    <div class="mb-0.5 flex items-center justify-between gap-1">
                                        <span class="text-[10px] font-semibold opacity-90">
                                            {{ \Carbon\Carbon::parse($event->start_date)->format('H:i') }}
                                        </span>

                                        <span class="rounded bg-black/10 px-1 py-0.5 text-[9px] font-medium dark:bg-black/40">
                                            {{ $rawStatus }}
                                        </span>
                                    </div>

                                    <div class="truncate font-medium">
                                        {{ $event->event_name }}
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Legenda Status --}}
        <div class="mt-4 flex flex-wrap items-center justify-between gap-3 border-t border-gray-200 pt-3 text-xs text-gray-600 dark:border-gray-800 dark:text-gray-400">
            <div class="font-medium text-gray-700 dark:text-gray-300">
                Status Agenda:
            </div>

            <div class="flex flex-wrap items-center gap-4">
                <span class="inline-flex items-center gap-1.5">
                    <span class="inline-block h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                    Belum Mulai
                </span>

                <span class="inline-flex items-center gap-1.5">
                    <span class="inline-block h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                    Sedang Berlangsung
                </span>

                <span class="inline-flex items-center gap-1.5">
                    <span class="inline-block h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                    Selesai
                </span>

                <span class="inline-flex items-center gap-1.5">
                    <span class="inline-block h-2.5 w-2.5 rounded-full bg-rose-500"></span>
                    Batal
                </span>
            </div>
        </div>

        {{-- Modal Detail Kegiatan --}}
        @if ($showDetailModal && $selectedEvent)
            <div
                class="fixed inset-0 z-[9999] flex items-center justify-center overflow-y-auto bg-black/50 p-4"
                wire:click.self="closeDetail"
                wire:keydown.escape.window="closeDetail">

                <div
                    class="my-auto w-full max-w-lg rounded-xl bg-white p-6 shadow-xl dark:bg-gray-900"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="timeline-detail-title">

                    {{-- Header Modal --}}
                    <div class="mb-5 flex items-start justify-between gap-4">
                        <div>
                            <h2
                                id="timeline-detail-title"
                                class="text-xl font-bold text-gray-900 dark:text-white">
                                Detail Kegiatan
                            </h2>

                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Informasi agenda kegiatan
                            </p>
                        </div>

                        <button
                            type="button"
                            wire:click="closeDetail"
                            class="rounded-lg px-3 py-1 text-xl text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800"
                            aria-label="Tutup detail">
                            &times;
                        </button>
                    </div>

                    {{-- Isi Detail --}}
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Nama Kegiatan
                            </p>

                            <p class="break-words font-semibold text-gray-900 dark:text-white">
                                {{ $selectedEvent['event_name'] ?: '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Tanggal dan Waktu Mulai
                            </p>

                            <p class="text-gray-900 dark:text-white">
                                {{ $selectedEvent['start_date']
                                    ? \Carbon\Carbon::parse($selectedEvent['start_date'])->translatedFormat('d F Y, H:i')
                                    : '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Tanggal dan Waktu Selesai
                            </p>

                            <p class="text-gray-900 dark:text-white">
                                {{ $selectedEvent['end_date']
                                    ? \Carbon\Carbon::parse($selectedEvent['end_date'])->translatedFormat('d F Y, H:i')
                                    : '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Lokasi
                            </p>

                            <p class="break-words text-gray-900 dark:text-white">
                                {{ $selectedEvent['location'] ?: '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Status
                            </p>

                            <span class="inline-flex rounded-full bg-primary-50 px-3 py-1 text-sm font-medium text-primary-700 dark:bg-primary-400/10 dark:text-primary-400">
                                {{ $selectedEvent['status'] ?: 'Belum Mulai' }}
                            </span>
                        </div>
                    </div>

                    {{-- Footer Modal --}}

                    <div class="mt-6 flex flex-wrap justify-end gap-2">

                        @if (!empty($selectedEvent['edit_url']))

                            <x-filament::button

                                tag="a"

                                :href="$selectedEvent['edit_url']"

                                icon="heroicon-m-pencil-square">

                                Edit Agenda Liputan

                            </x-filament::button>

                        @endif

                        <x-filament::button
                            type="button"
                            color="gray"
                            wire:click="closeDetail">
                            Tutup
                        </x-filament::button>
                    </div>
                </div>
            </div>

    @endif

    </x-filament::section>
</x-filament-widgets::widget>
