<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">
        {{ $this->form }}

        <div class="flex items-center justify-end gap-x-3 pt-4 border-t border-gray-200 dark:border-white/10">
            <x-filament::button
                type="button"
                color="gray"
                tag="a"
                :href="filament()->getUrl()"
            >
                Batal
            </x-filament::button>

            <x-filament::button
                type="submit"
                icon="heroicon-m-check"
            >
                Simpan Perubahan
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
