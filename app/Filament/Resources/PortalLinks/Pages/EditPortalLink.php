<?php

namespace App\Filament\Resources\PortalLinks\Pages;

use App\Filament\Resources\PortalLinks\PortalLinkResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPortalLink extends EditRecord
{
    protected static string $resource = PortalLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
