<?php

namespace App\Filament\Resources\Faqs\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FaqsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('urutan', 'asc')
            ->columns([
                TextColumn::make('urutan')
                    ->label('Urutan')
                    ->sortable(),

                TextColumn::make('pertanyaan')
                    ->label('Pertanyaan')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}