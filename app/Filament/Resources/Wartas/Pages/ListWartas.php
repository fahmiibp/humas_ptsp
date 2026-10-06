<?php

namespace App\Filament\Resources\Wartas\Pages;

use App\Filament\Resources\Wartas\WartaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWartas extends ListRecords
{
    protected static string $resource = WartaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Tambah Warta')
            ->icon('heroicon-o-plus')
            ->url($this->getResource()::getUrl('create')),
        ];
    }
}
