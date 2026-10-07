<?php

namespace App\Filament\Resources\Arsips\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\Layout\Split;
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
                'xl' => 4,
            ])
            ->columns([
                Stack::make([
                    ImageColumn::make('sample_photos')
                        ->disk('public')
                        ->height(340)
                        ->extraAttributes([
                            'class' => '
                            rounded-3xl
                            overflow-hidden
                            shadow-2xl
                            ring-1
                            ring-white/10
                        '
                        ])
                        ->extraImgAttributes([
                            'class' => '
                            object-cover
                            w-full
                            h-[340px]
                            brightness-90
                            hover:brightness-110
                            hover:scale-110
                            transition-all
                            duration-700
                        '
                        ]),
                    Stack::make([
                        TextColumn::make('title')
                            ->icon(Heroicon::Photo)
                            ->weight('bold')
                            ->size('xl')
                            ->limit(60)
                            ->wrap()
                            ->color('white')
                            ->extraAttributes([
                                'class' => '
                                text-white
                                text-xl
                                font-bold
                                drop-shadow-lg
                            '
                            ]),
                        Stack::make([
                            TextColumn::make('photograper.name')
                                ->icon(Heroicon::Camera)
                                ->badge()
                                ->color('info')
                                ->extraAttributes([
                                    'class' => '
                                        inline-flex'
                                ]),
                            TextColumn::make('event_date')
                                ->icon(Heroicon::CalendarDays)
                                ->date('d M Y')
                                ->badge()
                                ->color('warning')
                                ->extraAttributes([
                                    'class' => '
                                         inline-flex
                                         mt-2'
                                ]),
                        ])
                            ->extraAttributes([
                                'class' => 'mt-3'
                            ]),
                        TextColumn::make('notes')
                            ->label('')
                            ->limit(90)
                            ->wrap()
                            ->color('gray')
                            ->extraAttributes([
                                'class' => '
                                text-gray-300
                                text-sm
                                leading-relaxed
                                mt-3
                                '
                            ]),
                    ])
                        ->extraAttributes([
                        'class' => '
                            absolute
                            bottom-0
                            left-0
                            right-0
                            p-5
                            bg-gradient-to-t
                            from-black
                            via-black/80
                            to-transparent
                            rounded-b-3xl
                        '
                        ]),
                ])
                    ->extraAttributes([
                        'class' => '
                            relative
                            overflow-hidden
                            rounded-3xl
                            bg-slate-950
                            shadow-xl
                            hover:-translate-y-2
                            hover:shadow-2xl
                            transition-all
                            duration-500
                        '   
                    ])
                    ->space(0),
            ])
            ->filters([])

            ->recordActions([
                Action::make('buka_drive')
                    ->label('Drive')
                    ->icon(Heroicon::OutlinedCloudArrowUp)
                    ->color('success')
                    ->button()
                    ->url(fn($record) => $record->drive_url)
                    ->openUrlInNewTab()
                    ->visible(fn($record) => filled($record->drive_url)),
                ViewAction::make()
                    ->button()
                    ->color('info'),
                EditAction::make()
                    ->button()
                    ->color('warning'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}
