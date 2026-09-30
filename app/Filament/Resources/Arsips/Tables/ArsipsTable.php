<?php

namespace App\Filament\Resources\Arsips\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ArsipsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->contentGrid([
                'default' => 1,
                'md' => 2,
                'xl' => 3,
            ])
            ->columns([
                Stack::make([
                    // Foto Sampel / Thumbnail
                    ImageColumn::make('foto') // sesuaikan dengan nama kolom gambar Anda
                        ->height('200px')
                        ->width('100%')
                        ->extraImgAttributes([
                            'class' => 'object-cover rounded-t-xl w-full h-48',
                        ]),
                    Stack::make([
                        //Select::'id'
                        TextColumn::make('agenda')
                            ->prefix('Agenda: ')
                            ->color('gray')
                            ->size(TextSize::Small)
                            ->limit(40)
                            ->searchable(),
                    ])->space(1)->extraAttributes(['class' => 'p-4']),
                ])->space(0),
                TextColumn::make('title')
                    ->weight('bold')
                    ->size(TextSize::Large)
                    ->searchable(),
                TextColumn::make('event_date')
                    ->date('d-m-Y'),
                ImageColumn::make('sample_photos')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('drive_url'),
                TextColumn::make('photograper_name'),
                TextColumn::make('notes'),


            ])
            ->filters([])
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
