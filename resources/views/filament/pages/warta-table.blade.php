<x-filament-panels::page>
    {{-- Render Tab Filter di atas Tabel --}}
    <x-filament::tabs class="mb-4">
        <x-filament::tabs.item
            :active="$activeTab === 'semua'"
            wire:click="$set('activeTab', 'semua')"
            :badge="\App\Models\Warta::count()"
        >
            Semua
        </x-filament::tabs.item>

        <x-filament::tabs.item
            :active="$activeTab === 'butuh_review'"
            wire:click="$set('activeTab', 'butuh_review')"
            :badge="\App\Models\Warta::where('status_naskah', 'Draft Penulis')->count()"
            badge-color="warning"
            icon="heroicon-m-exclamation-circle"
        >
            Butuh Review
        </x-filament::tabs.item>

        <x-filament::tabs.item
            :active="$activeTab === 'siap_tayang'"
            wire:click="$set('activeTab', 'siap_tayang')"
            :badge="\App\Models\Warta::where('status_naskah', 'Disetujui')->count()"
            badge-color="info"
            icon="heroicon-m-check-circle"
        >
            Siap Tayang
        </x-filament::tabs.item>

        <x-filament::tabs.item
            :active="$activeTab === 'sudah_tayang'"
            wire:click="$set('activeTab', 'sudah_tayang')"
            :badge="\App\Models\Warta::where('status_naskah', 'Tayang')->count()"
            badge-color="success"
            icon="heroicon-m-newspaper"
        >
            Sudah Tayang
        </x-filament::tabs.item>
    </x-filament::tabs>

    {{-- Render Tabel Filament --}}
    {{ $this->table }}
</x-filament-panels::page>