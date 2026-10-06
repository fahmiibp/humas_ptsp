<x-filament-widgets::widget>
    <div class="rounded-2xl border border-gray-800 bg-[#111827] p-6 shadow-lg text-white">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            
            <!-- Sisi Kiri: Badge, Judul & Subtitle -->
            <div class="space-y-3">
                <!-- Baris Badge & Tanggal -->
                <div class="flex items-center gap-3">
                    <!-- Filament v3 Native Badge -->
                    <x-filament::badge color="info" size="sm">
                        Portal WARTA PTSP
                    </x-filament::badge>
                    
                    <span class="text-xs sm:text-sm text-gray-400 font-medium">
                        {{ $todayDate }}
                    </span>
                </div>

                <!-- Judul Utama -->
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-white">
                    Selamat bertugas, {{ $userName }}! 👋
                </h1>

                <!-- Subtitle Informasi -->
                <p class="text-sm text-gray-400 leading-relaxed max-w-2xl">
                    Hari ini terdapat <strong class="text-white font-semibold">{{ $agendaCount }} agenda liputan</strong> terjadwal dan <strong class="text-amber-400 font-semibold">{{ $reviewCount }} naskah rilis warta</strong> yang menunggu peninjauan redaksi.
                </p>
            </div>

            <!-- Sisi Kanan: Tombol Aksi (Filament v3 Native Buttons) -->
            <div class="flex flex-wrap lg:flex-col xl:flex-row items-center gap-2.5 shrink-0">
                <x-filament::button
                    tag="a"
                    href="{{ url('admin/timelines') }}"
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
                    href="{{ url('admin/warta-table') }}"
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