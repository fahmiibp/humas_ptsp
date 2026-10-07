<?php

namespace App\Filament\Resources\Wartas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WartasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->columns([
                ImageColumn::make('dokumentasi_utama')
                    ->extraAttributes([
                            'class' => '-mx-4 -mt-4 mb-3 w-[calc(100%+2rem)] max-w-none overflow-hidden rounded-t-xl',
                        ])
                        ->disk('public')
                        ->extraImgAttributes([
                            'class' => 'object-cover w-full',
                            'style' => 'width: 100% !important; height: 220px !important; display: block;',
                        ])
                        ->defaultImageUrl(url('/images/placeholder-news.png')),
                Split::make([
                    Stack::make([
                        TextColumn::make('judul_siaran_pers')
                            ->label('Judul Siaran Pers')
                            ->weight('bold')
                            ->size('lg')
                            ->searchable()
                            ->limit(60)
                            ->wrap(),

                        TextColumn::make('lead_berita')
                            ->label('Ringkasan Berita')
                            ->color('gray')
                            ->limit(100)
                            ->wrap(),

                        Split::make([
                            TextColumn::make('status_naskah')
                                ->label('Status')
                                ->badge()
                                ->color(fn(?string $state): string => match ($state) {
                                    'Draft Penulis' => 'gray',
                                    'Perlu Review Koordinator' => 'warning',
                                    'Perlu Revisi' => 'danger',
                                    'Disetujui' => 'success',
                                    'Sudah Tayang' => 'info',
                                    default => 'gray',
                                }),

                            TextColumn::make('jadwal_tayang')
                                ->label('Jadwal Tayang')
                                ->date('d M Y')
                                ->alignEnd()
                                ->color(fn(?string $state): string => match ($state) {
                                    'Draft Penulis' => 'gray',
                                    'Perlu Review Koordinator' => 'warning',
                                    'Perlu Revisi' => 'danger',
                                    'Disetujui' => 'success',
                                    'Sudah Tayang' => 'info',
                                    default => 'gray',
                                })
                                ->icon('heroicon-m-calendar')
                                ->color('gray'),
                        ])->from('sm'),

                        TextColumn::make('author.name')
                            ->label('Penanggung Jawab')
                            ->formatStateUsing(
                                fn($state, $record) =>
                                $record->author?->name ?? '-'
                            )
                            ->icon('heroicon-m-user')
                            ->color('gray')
                            ->size('sm'),

                        TextColumn::make('timeline.event_name')
                            ->label('Agenda')
                            ->formatStateUsing(
                                fn($state, $record) =>
                                $record->timeline?->event_name ?? '-'
                            )
                            ->icon('heroicon-m-calendar-days')
                            ->color('gray')
                            ->size('sm'),

                        TextColumn::make('slug_url')
                            ->label('Slug URL')
                            ->icon('heroicon-m-link')
                            ->color('primary')
                            ->limit(45)
                            ->copyable()
                            ->size('sm'),
                    ])->space(2),
                ])
                    ->from('md')
                    ->extraAttributes([
                        'class' => 'gap-4 items-start',
                    ]),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
