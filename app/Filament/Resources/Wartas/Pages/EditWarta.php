<?php

namespace App\Filament\Resources\Wartas\Pages;

use App\Filament\Resources\Wartas\WartaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWarta extends EditRecord
{
    protected static string $resource = WartaResource::class;

    protected static ?string $title = 'Ubah Warta';

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
                ->modalHeading('Hapus Warta')
                ->modalDescription('Apakah Anda yakin ingin menghapus warta ini?')
                ->modalSubmitActionLabel('Ya, Hapus')
                ->modalCancelActionLabel('Batal'),
        ];
    }
}
