<?php

namespace App\Filament\Resources\Timelines\Pages;

use App\Filament\Resources\Timelines\TimelineResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTimeline extends ViewRecord
{
    protected static string $resource = TimelineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
