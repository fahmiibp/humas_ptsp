<?php

namespace App\Filament\Resources\Timelines\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TimelinesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('event_name')
                ->label('Nama Kegiatan'),
                TextColumn::make('start_date')
                ->label('Tanggal Mulai')
                    ->date('d-m-Y'),
                TextColumn::make('end_date')
                ->label('Tanggal Selesai')
                    ->date('d-m-Y'),
                TextColumn::make('location')
                ->label('Lokasi'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Belum Mulai' => 'info',
                        'Sedang Berlangsung' => 'warning', // Warna kuning
                        'Selesai' => 'success',          // Warna hijau
                        'Batal' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
