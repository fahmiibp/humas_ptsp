<?php

namespace App\Filament\Resources\Wartas\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
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
                                ->label('Status Verifikasi')
                                ->badge()
                                ->color(fn (?string $state): string => match ($state) {
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
                                fn ($state, $record) => $record->author?->name ?? '-'
                            )
                            ->icon('heroicon-m-user')
                            ->color('gray')
                            ->size('sm'),

                        TextColumn::make('timeline.event_name')
                            ->label('Agenda')
                            ->formatStateUsing(
                                fn ($state, $record) => $record->timeline?->event_name ?? '-'
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
            ->defaultSort('created_at', 'desc')
            ->filters([
                Filter::make('rentang_tanggal')
                    ->label('Rentang Jadwal Tayang')
                    ->schema([
                        DatePicker::make('dari_tanggal')
                            ->label('Dari Tanggal')
                            ->placeholder('Pilih tanggal awal')
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        DatePicker::make('sampai_tanggal')
                            ->label('Sampai Tanggal')
                            ->placeholder('Pilih tanggal akhir')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->afterOrEqual('dari_tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $dariTanggal = $data['dari_tanggal'] ?? null;
                        $sampaiTanggal = $data['sampai_tanggal'] ?? null;

                        return $query
                            ->when(
                                $dariTanggal,
                                fn (Builder $query) => $query->whereDate(
                                    'jadwal_tayang',
                                    '>=',
                                    $dariTanggal
                                )
                            )
                            ->when(
                                $sampaiTanggal,
                                fn (Builder $query) => $query->whereDate(
                                    'jadwal_tayang',
                                    '<=',
                                    $sampaiTanggal
                                )
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if (! empty($data['dari_tanggal'])) {
                            $indicators[] = 'Dari: ' . $data['dari_tanggal'];
                        }

                        if (! empty($data['sampai_tanggal'])) {
                            $indicators[] = 'Sampai: ' . $data['sampai_tanggal'];
                        }

                        return $indicators;
                    }),
            ])
            ->recordActions([
                // Penulis mengirim naskah atau mengirim ulang setelah revisi.
                Action::make('kirim_review')
                    ->label(fn (Model $record): string =>
                        $record->status_naskah === 'Perlu Revisi'
                            ? 'Kirim Ulang'
                            : 'Kirim ke Verifikator'
                    )
                    ->icon('heroicon-o-paper-airplane')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Kirim naskah untuk verifikasi?')
                    ->modalDescription('Naskah akan masuk ke antrean Verifikator.')
                    ->visible(fn (Model $record): bool =>
                        (
                            Auth::user()?->hasAnyRole(['Penulis', 'super_admin']) ?? false
                        )
                        && (int) $record->users_id === (int) Auth::id()
                        && in_array(
                            $record->status_naskah,
                            ['Draft Penulis', 'Perlu Revisi'],
                            true
                        )
                    )
                    ->action(function (Model $record): void {
                        $record->update([
                            'status_naskah' => 'Perlu Review Koordinator',
                            'catatan_koreksi' => null,
                        ]);

                        Notification::make()
                            ->title('Warta dikirim untuk verifikasi')
                            ->success()
                            ->send();
                    }),
                // Verifikator menyetujui naskah.
                Action::make('setujui_warta')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Setujui Warta ini?')
                    ->visible(fn (Model $record): bool => (Auth::user()?->hasAnyRole(['Verifikator', 'Koordinator']) ?? false)
                        && $record->status_naskah === 'Perlu Review Koordinator')
                    ->action(function (Model $record): void {
                        $record->update([
                            'status_naskah' => 'Disetujui',
                            'reviewed_by' => Auth::id(),
                            'catatan_koreksi' => null,
                        ]);

                        Notification::make()->title('Warta disetujui')->success()->send();
                    }),

                // Verifikator menolak dengan catatan wajib.
                Action::make('tolak_warta')
                    ->label('Tolak / Minta Revisi')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('danger')
                    ->form([
                        Textarea::make('catatan_koreksi')
                            ->label('Catatan revisi untuk Penulis')
                            ->placeholder('Jelaskan bagian yang perlu diperbaiki...')
                            ->required()
                            ->minLength(5)
                            ->rows(4),
                    ])
                    ->modalHeading('Kembalikan Warta untuk revisi')
                    ->visible(fn (Model $record): bool => (Auth::user()?->hasAnyRole(['Verifikator', 'Koordinator']) ?? false)
                        && $record->status_naskah === 'Perlu Review Koordinator')
                    ->action(function (Model $record, array $data): void {
                        $record->update([
                            'status_naskah' => 'Perlu Revisi',
                            'catatan_koreksi' => $data['catatan_koreksi'],
                            'reviewed_by' => Auth::id(),
                        ]);

                        Notification::make()->title('Warta dikembalikan kepada Penulis')->warning()->send();
                    }),

                // Hanya admin publikasi dapat menerbitkan warta yang disetujui.
                Action::make('tayangkan_warta')
                    ->label('Publikasikan')
                    ->icon('heroicon-o-globe-alt')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Publikasikan Warta ini?')
                    ->modalDescription('Warta hanya dapat dipublikasikan setelah disetujui Verifikator.')
                    ->visible(fn (Model $record): bool => (Auth::user()?->hasAnyRole(['Admin', 'admin', 'super_admin', 'Super Admin', 'Admin Publikasi']) ?? false)
                        && $record->status_naskah === 'Disetujui')
                    ->action(function (Model $record): void {
                        $record->update(['status_naskah' => 'Sudah Tayang']);

                        Notification::make()->title('Warta berhasil dipublikasikan')->success()->send();
                    }),

                EditAction::make()
                    ->label('Edit')
                    ->visible(fn (Model $record): bool => (Auth::user()?->hasRole('Penulis') ?? false)
                        && (int) $record->users_id === (int) Auth::id()
                        && in_array($record->status_naskah, ['Draft Penulis', 'Perlu Revisi'], true)),

                ViewAction::make()->label('Lihat'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    // Tambahkan bulk action jika diperlukan.
                ]),
            ]);
    }
}
