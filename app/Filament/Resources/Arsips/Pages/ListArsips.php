<?php

namespace App\Filament\Resources\Arsips\Pages;

use App\Filament\Resources\Arsips\ArsipResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListArsips extends ListRecords
{
    protected static string $resource = ArsipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
