<?php

namespace App\Filament\Resources\RencanaKontenMedsos\Pages;

use App\Filament\Resources\RencanaKontenMedsos\RencanaKontenMedsosResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageRencanaKontenMedsos extends ManageRecords
{
    protected static string $resource = RencanaKontenMedsosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
