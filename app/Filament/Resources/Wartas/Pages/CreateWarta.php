<?php

namespace App\Filament\Resources\Wartas\Pages;

use App\Filament\Resources\Wartas\WartaResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateWarta extends CreateRecord
{
    protected static string $resource = WartaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['users_id'] = Auth::id();
        $data['status_naskah'] = 'Draft Penulis';
        $data['catatan_koreksi'] = null;

        return $data;
    }
}
