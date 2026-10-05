<?php
namespace App\Filament\Resources\KontenMedsos\Pages;
use App\Filament\Resources\KontenMedsos\KontenMedsosResource;
use Filament\Resources\Pages\ListRecords;
class ListKontenMedsos extends ListRecords
{
    protected static string $resource = KontenMedsosResource::class;
    public function mount(): void
    {
        redirect(
            \App\Filament\Pages\ContentCalendar::getUrl()
        );
    }
}