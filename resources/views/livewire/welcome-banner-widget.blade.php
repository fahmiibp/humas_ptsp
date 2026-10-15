<x-filament-widgets::widget>
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-linear-65 from-white-500 to-green-500 dark:bg-[#111827] p-6 shadow-xl space-y-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            
            <!-- Sisi Kiri: Badge, Judul & Subtitle -->
            <div class="space-y-3">
                <!-- Baris Badge & Tanggal -->
                <div class="flex items-center gap-3">
                    <x-filament::badge color="info" size="sm">
                        Portal WARTA PTSP
                    </x-filament::badge>
                    
                    <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 font-medium">
                        {{ $todayDate }}
                    </span>
                </div>

                <!-- Judul Utama -->
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    Selamat bertugas, <span class="text-blue-600 dark:text-blue-400">{{ $userName }}</span>! 👋
                </h1>

                <!-- Subtitle Informasi -->
                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed max-w-2xl">
                    Hari ini terdapat <strong class="text-gray-900 dark:text-white font-semibold">{{ $agendaCount }} agenda liputan</strong> terjadwal dan <strong class="text-amber-600 dark:text-amber-400 font-semibold">{{ $reviewCount }} naskah rilis warta</strong> yang menunggu peninjauan redaksi.
                </p>
            </div>

            <!-- Sisi Kanan: Tombol Aksi (Filament v3 Native Buttons) -->
            <div class="flex flex-wrap lg:flex-col xl:flex-row items-center gap-2.5 shrink-0">
                <x-filament::button
                    tag="a"
                    href="{{ url('admin/timelines/create') }}"
                    icon="heroicon-m-calendar-days"
                    color="primary"
                    size="md"
                >
                    Input Agenda
                </x-filament::button>

                <x-filament::button
                    tag="a"
                    href="{{ url('admin/wartas/create') }}"
                    icon="heroicon-m-pencil-square"
                    color="gray"
                    size="md"
                >
                    Tulis Warta
                </x-filament::button>

                <x-filament::button
                    tag="a"
                    href="{{ url('admin/rencana-konten-medsos/create') }}"
                    icon="heroicon-m-share"
                    color="gray"
                    size="md"
                >
                    Jadwalkan Medsos
                </x-filament::button>
            </div>

        </div>
    </div>
</x-filament-widgets::widget>