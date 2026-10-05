<?php

namespace App\Filament\Resources\Wartas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WartasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul_siaran_pers'),
                TextColumn::make('slug_url'),
                TextColumn::make('lead_berita'),
                TextColumn::make('badan_berita'),
                TextColumn::make('status_naskah'),
                TextColumn::make('jadwal_tayang'),
                TextColumn::make('catatan_koreksi'),
                TextColumn::make('timeline_id'),
                TextColumn::make('users_id'),
                ImageColumn::make('dokumentasi_utama'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
