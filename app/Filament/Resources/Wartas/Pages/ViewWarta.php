<?php

namespace App\Filament\Resources\Wartas\Pages;

use App\Filament\Resources\Wartas\WartaResource;
use App\Models\Warta;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;

class ViewWarta extends ViewRecord
{
    protected static string $resource = WartaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // EditAction::make(),

            Action::make('verifikasi')
                ->label('Verifikasi Naskah')
                ->icon('heroicon-m-check')
                ->color('success')
                ->visible(
                    fn(): bool =>
                    Filament::auth()->user()?->hasRole('Verifikator') ?? false
                )
                ->form([
                    Select::make('status_naskah')
                        ->label('Status Naskah')
                        ->options([
                            'Perlu Revisi' => 'Perlu Revisi',
                            'Disetujui' => 'Disetujui',
                        ])
                        ->placeholder('Pilih status naskah')
                        ->native(false)
                        ->required(),

                    Textarea::make('catatan_koreksi')
                        ->label('Catatan Verifikator')
                        ->rows(4)
                        ->required(),
                ])

        ];
    }
}
