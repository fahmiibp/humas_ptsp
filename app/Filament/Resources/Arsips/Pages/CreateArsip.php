<?php

namespace App\Filament\Resources\Arsips\Pages;

use App\Filament\Resources\Arsips\ArsipResource;
use Filament\Resources\Pages\CreateRecord;

class CreateArsip extends CreateRecord
{
    protected static string $resource = ArsipResource::class;

    protected static ?string $breadcrumb = 'Buat';

    protected static ?string $title = 'Buat Arsip Dokumentasi';

    protected function getCreateFormAction(): \Filament\Actions\Action
    {
        Return parent::getCreateFormAction()
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

