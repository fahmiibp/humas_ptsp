<?php

namespace App\Filament\Resources\Arsips\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ArsipsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->contentGrid([
                'default' => 1,
                'sm' => 2,
                'lg' => 3,
                '2xl' => 4,
            ])
            ->defaultSort('event_date', 'desc')
            ->columns([
                Stack::make([
                    // 1. Gambar Sampul dengan Aspect Ratio Modern & Fallback
                    ImageColumn::make('sample_photos')
                        ->getStateUsing(function ($record) {
                            $photos = $record->sample_photos;

                            if (is_string($photos)) {
                                $photos = json_decode($photos, true);
                            }

                            if (! is_array($photos) || empty($photos)) {
                                return null;
                            }

                            return array_values($photos)[0] ?? null;
                        })
                        ->disk('public')
                        ->defaultImageUrl('https://placehold.co/600x400/1e293b/94a3b8?text=Tidak+Ada+Foto')
                        ->extraAttributes([
                            // Menghilangkan padding bawaan kartu khusus untuk area gambar
                            'class' => '-mx-4 -mt-4 mb-3 w-[calc(100%+2rem)] max-w-none overflow-hidden rounded-t-xl',
                        ])
                        ->disk('public')
                        ->extraImgAttributes([
                            // Memaksa gambar mengisi penuh 100% dan menentukan tingginya
                            'class' => 'object-cover w-full',
                            'style' => 'width: 100% !important; height: 220px !important; display: block;',
                        ]),

                    // 2. Konten Kartu: Judul, Meta & Ringkasan
                    Stack::make([
                        // Baris Meta: Tanggal & Fotografer
                        Split::make([
                            TextColumn::make('event_date')
                                ->date('d M Y')
                                ->icon(Heroicon::CalendarDays)
                                ->badge()
                                ->color('primary')
                                ->size('xs'),

                            TextColumn::make('photograper.name')
                                ->icon(Heroicon::Camera)
                                ->badge()
                                ->color('gray')
                                ->size('xs')
                                ->alignEnd()
                                ->limit(8) // Membatasi maksimal 15 karakter, sisanya otomatis menjadi '...'
                                ->tooltip(fn($record): ?string => $record->photograper?->name),
                        ]),

                        // Judul Arsip
                        TextColumn::make('title')
                            ->weight(FontWeight::Bold)
                            ->size('lg')
                            ->limit(45)
                            ->tooltip(fn($record): string => $record->title)
                            ->searchable(),

                        // Agenda Terkait (Jika ada)
                        TextColumn::make('timeline.event_name')
                            ->icon(Heroicon::Tag)
                            ->color('gray')
                            ->size('xs')
                            ->limit(35)
                            ->placeholder('Agenda Umum')
                            ->searchable(),

                        // Catatan Singkat
                        TextColumn::make('notes')
                            ->color('gray')
                            ->size('sm')
                            ->lineClamp(2)
                            ->placeholder('Tidak ada catatan tambahan.')
                            ->extraAttributes([
                                'class' => 'text-xs text-slate-500 dark:text-slate-400 leading-relaxed',
                            ]),
                    ])
                        ->space(2)
                        ->extraAttributes([
                            'class' => 'p-4 flex flex-col justify-between flex-grow',
                        ]),
                ])
                    ->extraAttributes([
                        'class' => '
                        h-full
                        flex
                        flex-col
                        overflow-hidden
                        rounded-2xl
                        bg-white
                        dark:bg-slate-900
                        border
                        border-slate-200/80
                        dark:border-white/10
                        shadow-sm
                        hover:shadow-xl
                        hover:-translate-y-1.5
                        transition-all
                        duration-300
                    ',
                    ]),
            ])
            ->filters([
                SelectFilter::make('photograper_name')
                    ->label('Filter Fotografer')
                    ->relationship('photograper', 'name')
                    ->preload()
                    ->searchable(),
            ])
            ->actions([
                // Tombol Buka Drive
                Action::make('buka_drive')
                    ->label('Drive')
                    ->icon(Heroicon::OutlinedCloudArrowUp)
                    ->color('success')
                    ->button()
                    ->size('xs')
                    ->url(fn($record) => $record->drive_url)
                    ->openUrlInNewTab()
                    ->visible(fn($record) => filled($record->drive_url)),

                // Dropdown Aksi (View, Edit, Delete) agar baris aksi ringkas
                ActionGroup::make([
                    Action::make('copy_drive_link')
                        ->label('Salin Link')
                        ->icon(Heroicon::ClipboardDocument)
                        ->color('gray')
                        ->button()
                        ->size('xs')
                        ->extraAttributes(fn($record): array => [
                            'x-on:click.prevent' => "
                            navigator.clipboard.writeText('{$record->drive_url}');
                            \$tooltip('Tersalin!', { timeout: 1500 });
                        ",
                        ])
                        ->action(function (): void {
                            Notification::make()
                                ->title('Link Google Drive Tersalin')
                                ->success()
                                ->send();
                        })
                        ->visible(fn($record) => filled($record->drive_url)),
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
                    ->icon(Heroicon::EllipsisVertical)
                    ->color('gray')
                    ->size('xs')
                    ->button(),
            ])
            ->emptyStateHeading('Belum Ada Arsip Dokumentasi Liputan')
            ->emptyStateDescription('Silakan tambahkan arsip liputan baru untuk memulai pengarsipan.')
            ->emptyStateIcon(Heroicon::Photo)
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}
