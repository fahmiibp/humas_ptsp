<?php
namespace App\Filament\Resources\KontenMedsos\Pages;
use App\Filament\Resources\KontenMedsos\KontenMedsosResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;
class EditKontenMedsos extends EditRecord
{
    protected static string $resource = KontenMedsosResource::class;
    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }
    protected function getHeaderHeading(): string
    {
        return 'Edit Konten Medsos';
    }
    protected function getRedirectUrl(): string
    {
        return route('filament.admin.pages.content-calendar');
    }
}