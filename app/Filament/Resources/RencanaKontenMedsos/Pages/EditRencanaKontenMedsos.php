<?php

namespace App\Filament\Resources\RencanaKontenMedsos\Pages;

use App\Filament\Resources\RencanaKontenMedsos\RencanaKontenMedsosResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRencanaKontenMedsos extends EditRecord
{
    protected static string $resource = RencanaKontenMedsosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
