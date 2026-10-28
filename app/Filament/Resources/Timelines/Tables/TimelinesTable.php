<?php

namespace App\Filament\Resources\Timelines\Tables;

use Carbon\Carbon;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TimelinesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('start_date', 'asc')
            ->columns([
                // Kolom 1: Nama Agenda & Lokasi (Disatukan secara vertikal)
                TextColumn::make('event_name')
                    ->label('Kegiatan & Lokasi')
                    ->searchable(['event_name', 'location'])
                    ->weight('bold')
                    ->description(fn ($record): string => $record->location ? '📍 ' . $record->location : '📍 Lokasi belum ditentukan')
                    ->wrap(),

                // Kolom 2: Periode Tanggal & Durasi Pelaksanaan
                TextColumn::make('start_date')
                    ->label('Periode Pelaksanaan')
                    ->sortable()
                    ->formatStateUsing(function ($record): string {
                        $start = Carbon::parse($record->start_date);
                        $end = Carbon::parse($record->end_date);

                        if ($start->isSameDay($end)) {
                            return $start->translatedFormat('d M Y');
                        }

                        if ($start->isSameMonth($end)) {
                            return $start->translatedFormat('d') . ' - ' . $end->translatedFormat('d M Y');
                        }

                        return $start->translatedFormat('d M Y') . ' s/d ' . $end->translatedFormat('d M Y');
                    })
                    ->description(function ($record): string {
                        $start = Carbon::parse($record->start_date)->startOfDay();
                        $end = Carbon::parse($record->end_date)->startOfDay();
                        $days = $start->diffInDays($end) + 1;

                        return $days . ' Hari Kegiatan';
                    }),

                // Kolom 3: Status Agenda dengan Badge & Ikon Visual
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        'Belum Mulai' => 'info',
                        'Sedang Berlangsung' => 'warning',
                        'Selesai' => 'success',
                        'Batal' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'Belum Mulai' => 'heroicon-m-clock',
                        'Sedang Berlangsung' => 'heroicon-m-arrow-path',
                        'Selesai' => 'heroicon-m-check-badge',
                        'Batal' => 'heroicon-m-x-circle',
                        default => 'heroicon-m-question-mark-circle',
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'Belum Mulai' => 'Belum Mulai',
                        'Sedang Berlangsung' => 'Sedang Berlangsung',
                        'Selesai' => 'Selesai',
                        'Batal' => 'Batal',
                    ])
                    ->native(false),

                Filter::make('upcoming')
                    ->label('Agenda Mendatang & Aktif')
                    ->query(fn (Builder $query): Builder => $query->where('end_date', '>=', now()->toDateString())),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
                ->tooltip('Menu Opsi')
                ->icon('heroicon-m-ellipsis-vertical')
                ->size('sm'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Agenda Kegiatan')
            ->emptyStateDescription('Semua jadwal pelaksanaan agenda akan tampil di sini.')
            ->emptyStateIcon('heroicon-o-calendar-days');
    }
}
