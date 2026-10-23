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
        return parent::getSaveFormAction()->label('Simpan Perubahan');
    }

    protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()->label('Batal');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(fn (): bool => Auth::user()?->hasAnyRole(['Admin', 'admin', 'super_admin', 'Super Admin']) ?? false),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Status, pemilik, dan keputusan verifikasi tidak boleh diubah lewat form edit.
        unset($data['status_naskah'], $data['users_id'], $data['reviewed_by']);

        return $data;
    }
}
