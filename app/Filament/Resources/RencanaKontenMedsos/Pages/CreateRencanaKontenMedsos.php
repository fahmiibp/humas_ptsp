<?php

namespace App\Filament\Resources\RencanaKontenMedsos\Pages;

use App\Filament\Resources\RencanaKontenMedsos\RencanaKontenMedsosResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRencanaKontenMedsos extends CreateRecord
{
    protected static string $resource = RencanaKontenMedsosResource::class;

    protected static ?string $title = 'Buat Konten Medsos';

    protected static ?string $breadcrumb = 'Buat';
    
    protected function getCreateFormAction(): \Filament\Actions\Action
    {
        return parent::getCreateFormAction()
            ->label('Simpan');
    }

    protected function getCreateAnotherFormAction(): \Filament\Actions\Action
    {
        return parent::getCreateAnotherFormAction()
            ->label('Simpan & Buat Baru');
    }

    protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('Batal');
    }
}
