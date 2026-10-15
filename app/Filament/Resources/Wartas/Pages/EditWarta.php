<?php

namespace App\Filament\Resources\Wartas\Pages;

use App\Filament\Resources\Wartas\WartaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

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
            Actions\DeleteAction::make(),
        ];
    }

    // Otomatis mengubah status dan mencatat reviewer saat form disimpan
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Jika koordinator mengisi catatan koreksi
        if (!empty($data['catatan_koreksi'])) {
            $data['status_naskah'] = 'Perlu Revisi'; // Status otomatis berubah
            $data['reviewed_by']   = Auth::id();     // Mencatat siapa koordinator yang mengoreksi
        }

        return $data;
    }
}