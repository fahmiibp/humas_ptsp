<?php

namespace App\Filament\Resources\Wartas\Pages;

use App\Filament\Resources\Wartas\WartaResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
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
            // Edit hanya untuk penulis pemilik naskah
            // yang berstatus Draft Penulis atau Perlu Revisi.
            
            Action::make('editWarta')
                ->label('Edit Warta')
                ->icon('heroicon-o-pencil-square')
                ->color('primary')
                ->button()
                ->url(fn (): string => WartaResource::getUrl('edit', [
                    'record' => $this->getRecord(),
                ]))
                ->visible(function (): bool {
                    $record = $this->getRecord();
                    $user = Auth::user();

                    return $user !== null
                        && (int) $record->users_id === (int) $user->id
                        && in_array(
                            $record->status_naskah,
                            ['Draft Penulis', 'Perlu Revisi'],
                            true
                        );
                }),


            // Alur verifikasi tetap dipertahankan.
            Action::make('verifikasi')
                ->label('Verifikasi Naskah')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(function (): bool {
                    $user = Auth::user();
                    $record = $this->getRecord();

                    return (
                        $user?->hasAnyRole([
                            'Verifikator',
                            'Koordinator',
                        ]) ?? false
                    )
                        && $record->status_naskah
                            === 'Perlu Review Koordinator';
                })
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
                        ->placeholder(
                            'Jelaskan bagian yang perlu diperbaiki jika ditolak...'
                        )
                        ->rows(4)
                        ->required(
                            fn ($get): bool =>
                                $get('status_naskah') === 'Perlu Revisi'
                        ),
                ])
                ->action(function (
                    Model $record,
                    array $data
                ): void {
                    $status = $data['status_naskah'];

                    $record->update([
                        'status_naskah' => $status,
                        'catatan_koreksi' =>
                            $status === 'Perlu Revisi'
                                ? ($data['catatan_koreksi'] ?? null)
                                : null,
                        'reviewed_by' => Auth::id(),
                    ]);
                }),
        ];
    }
}
