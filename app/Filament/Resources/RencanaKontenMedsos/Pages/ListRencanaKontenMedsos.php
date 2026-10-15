<?php

namespace App\Filament\Resources\RencanaKontenMedsos\Pages;

use App\Filament\Resources\RencanaKontenMedsos\RencanaKontenMedsosResource;
use App\Livewire\ContenCustomCalender;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRencanaKontenMedsos extends ListRecords
{
    protected static string $resource = RencanaKontenMedsosResource::class;

    protected static ?string $breadcrumb = 'Daftar';

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make()
                ->label('Buat Konten Medsos'),
        ];
    }
    
    protected function getHeaderWidgets(): array
    {
        return [
            ContenCustomCalender::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 1;
    }
}
