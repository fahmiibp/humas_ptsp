<?php

namespace App\Filament\Resources\RencanaKontenMedsos\Pages;

use App\Filament\Resources\RencanaKontenMedsos\RencanaKontenMedsosResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRencanaKontenMedsos extends EditRecord
{
    protected static string $resource = RencanaKontenMedsosResource::class;

    protected static ?string $title = 'Ubah Konten Medsos';

    protected static ?string $breadcrumb = 'Ubah';

    protected function getSaveFormAction(): \Filament\Actions\Action
    {
        return parent::getSaveFormAction()
            ->label('Simpan Perubahan');
    }

    protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('Batal');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus')
                ->modalHeading('Hapus Konten Medsos')
                ->modalDescription('Apakah Anda yakin ingin menghapus konten ini?')
                ->modalSubmitActionLabel('Ya, Hapus')
                ->modalCancelActionLabel('Batal'),
        ];
    }
}
