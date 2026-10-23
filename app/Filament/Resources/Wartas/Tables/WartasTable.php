<?php

namespace App\Filament\Resources\Wartas\Tables;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
            ])->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                // 1. Tombol Kirim / Kirim Ulang (Hanya untuk Penulis saat Draft atau Perlu Revisi)
                Action::make('kirim_review')
                    ->label(fn(Model $record) => $record->status_naskah === 'Perlu Revisi' ? 'Kirim Ulang' : 'Kirim ke Koordinator')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Kirim Naskah untuk Direview?')
                    ->modalDescription('Naskah akan dikirim ke koordinator untuk ditinjau kembali.')
                    ->visible(fn(Model $record) => in_array($record->status_naskah, ['Draft Penulis', 'Perlu Revisi']) && Auth::user()->hasRole('super_admin'))
                    ->action(function (Model $record) {
                        $record->update(['status_naskah' => 'Perlu Review Koordinator']);
                        Notification::make()->title('Naskah berhasil dikirim ke koordinator')->success()->send();
                    }),

                // 2. Tombol Setujui (Hanya muncul saat Perlu Review Koordinator)
                Action::make('setujui_warta')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Setujui Warta Ini?')
                    ->modalDescription('Warta akan disetujui dan dilanjutkan ke tahap publikasi.')
                    ->visible(fn(Model $record) => $record->status_naskah === 'Perlu Review Koordinator' && Auth::user()->hasRole('verifikator'))
                    ->action(function (Model $record) {
                        $record->update([
                            'status_naskah' => 'Disetujui',
                            'reviewed_by'   => Auth::id(),
                        ]);
                        Notification::make()->title('Warta Berhasil Disetujui')->success()->send();
                    }),

                // 3. Tombol Tayangkan (Hanya muncul saat status Disetujui)
                Action::make('tayangkan_warta')
                    ->label('Tayangkan')
                    ->icon('heroicon-o-globe-alt')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Tayangkan Warta Ini?')
                    ->modalDescription('Warta akan dipublikasikan secara resmi.')
                    ->visible(fn(Model $record) => $record->status_naskah === 'Disetujui' && Auth::user()->hasRole('super_admin'))
                    ->action(function (Model $record) {
                        $record->update([
                            'status_naskah' => 'Sudah Tayang',
                        ]);
                        Notification::make()->title('Warta Berhasil Ditayangkan')->success()->send();
                    }),

                // 4. Tombol Review / Edit (Muncul di semua status sesuai kebutuhan)
                EditAction::make()
                    ->label(fn(Model $record) => in_array($record->status_naskah, ['Perlu Review Koordinator', 'Disetujui']) ? 'Review' : 'Edit')
                    ->color('warning'),

                ViewAction::make()
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
