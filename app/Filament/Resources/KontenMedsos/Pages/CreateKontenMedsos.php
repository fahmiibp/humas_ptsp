<?php
namespace App\Filament\Resources\KontenMedsos\Pages;
use App\Filament\Resources\KontenMedsos\KontenMedsosResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;
class CreateKontenMedsos extends CreateRecord
{
    protected static string $resource = KontenMedsosResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (request()->has('tanggal')) {
            $data['tanggal'] = request()->get('tanggal');
        }
        return $data;
    }
    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }
    protected function getHeaderHeading(): string
    {
        return 'Create Konten Medsos';
    }
    protected function getRedirectUrl(): string
    {
        return route('filament.admin.pages.content-calendar');
    }
}