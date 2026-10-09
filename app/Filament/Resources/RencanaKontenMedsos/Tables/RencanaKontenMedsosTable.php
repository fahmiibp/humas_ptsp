<?php

namespace App\Filament\Resources\RencanaKontenMedsos\Tables;

use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RencanaKontenMedsosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            // Layout Grid Card 3 kolom
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->defaultPaginationPageOption(50)
            ->columns([
                Stack::make([
                    // Baris 1: Platform & Format Konten Badge
                    TextColumn::make('platform')
                        ->formatStateUsing(function ($record) {
                            $platform = ucfirst($record->platform ?? 'Instagram');
                            $format = ucfirst($record->format ?? 'Single Post');

                            return "
                                <div class='flex items-center justify-between w-full mb-3'>
                                    <span class='px-2.5 py-1 text-xs font-semibold rounded-md bg-pink-50 text-pink-600 border border-pink-100 dark:bg-pink-950/40 dark:text-pink-300 dark:border-pink-900'>
                                        {$platform}
                                    </span>
                                    <span class='px-2.5 py-1 text-xs font-medium rounded-md bg-gray-100 text-gray-600 border border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700'>
                                        {$format}
                                    </span>
                                </div>
                            ";
                        })
                        ->html(),

                    // Baris 2: Judul Konten
                    TextColumn::make('judul')
                        ->weight(FontWeight::Bold)
                        ->size('lg')
                        ->extraAttributes(['class' => 'text-gray-900 dark:text-white mb-4 line-clamp-2']),

                    // Baris 3: Status & Jam/Tanggal Tayang
                    TextColumn::make('tanggal')
                        ->formatStateUsing(function ($record) {
                            $status = ucfirst($record->status ?? 'Draft');

                            $tglText = $record->tanggal ? Carbon::parse($record->tanggal)->format('d M Y') : '-';
                            $jamText = $record->jam_tayang ? Carbon::parse($record->jam_tayang)->format('H:i') : '00:00';
                            $fullDateTime = "{$tglText}, {$jamText}";

                            $statusClass = match (strtolower($status)) {
                                'review' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/40 dark:text-amber-300',
                                'publish', 'published' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300',
                                default => 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-800 dark:text-gray-300',
                            };

                            return "
                                <div class='flex items-center justify-between w-full pt-3 border-t border-gray-100 dark:border-gray-800 text-xs'>
                                    <span class='px-2 py-0.5 font-medium rounded-md border {$statusClass}'>
                                        {$status}
                                    </span>
                                    <span class='text-gray-500 font-medium'>
                                        {$fullDateTime}
                                    </span>
                                </div>
                            ";
                        })
                        ->html(),
                ])
                    ->space(1)
                    ->extraAttributes([
                        'class' => 'p-5 bg-white dark:bg-gray-900 rounded-2xl border border-gray-200/80 dark:border-gray-800 shadow-sm hover:shadow-md transition-all',
                    ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
                    ->label('Edit')
                    ->color('primary')
                    ->icon('heroicon-o-pencil-square'),
                ViewAction::make()
                    ->label('View')
                    ->color('gray')
                    ->icon('heroicon-o-eye'),
                DeleteAction::make()
                    ->label('Delete')
                    ->color('danger')
                    ->icon('heroicon-o-trash'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}