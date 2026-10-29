<?php

namespace App\Filament\Resources\Wartas\Pages;

use App\Filament\Resources\Wartas\WartaResource;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ViewWarta extends ViewRecord
{
    protected static string $resource = WartaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('verifikasi')
                ->label('Verifikasi Naskah')
                ->icon('heroicon-m-check')
                ->color('success')
                ->visible(fn(): bool => (Auth::user()?->hasAnyRole(['Verifikator', 'Koordinator']) ?? false)
                    && $this->getRecord()->status_naskah === 'Perlu Review Koordinator')
                ->form([
                    Select::make('status_naskah')
                        ->label('Keputusan')
                        ->options([
                            'Perlu Revisi' => 'Tolak / Minta Revisi',
                            'Disetujui' => 'Setujui',
                        ])
                        ->native(false)
                        ->required()
                        ->live(),
                    Textarea::make('catatan_koreksi')
                        ->label('Catatan untuk Penulis')
                        ->placeholder('Jelaskan bagian yang perlu diperbaiki jika ditolak...')
                        ->rows(4)
                        ->required(fn($get): bool => $get('status_naskah') === 'Perlu Revisi'),
                ])
                ->action(function (Model $record, array $data): void {
                    $status = $data['status_naskah'];

                    $record->update([
                        'status_naskah' => $status,
                        'catatan_koreksi' => $status === 'Perlu Revisi'
                            ? $data['catatan_koreksi']
                            : null,
                        'reviewed_by' => Auth::id(),
                    ]);
                }),
        ];
    }
}
