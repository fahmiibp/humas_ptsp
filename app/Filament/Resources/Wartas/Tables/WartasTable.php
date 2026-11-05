<?php

namespace App\Filament\Resources\Wartas\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

use Filament\Notifications\Notification;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;

use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

use Filament\Schemas\Components\Utilities\Get;

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
                    ->label('Cover Foto')
                    ->state(function ($record) {
                        $images = $record->dokumentasi_utama;

                        // Mendukung data baru berupa array dan data lama berupa string.
                        if (is_string($images)) {
                            $decoded = json_decode($images, true);

                            $images = is_array($decoded)
                                ? $decoded
                                : [$images];
                        }

                        if (! is_array($images)) {
                            return null;
                        }

                        // Tampilkan gambar pertama sebagai cover kartu.
                        return array_values(array_filter($images))[0] ?? null;
                    })
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
                                ->grow(false)
                                ->color(fn (?string $state): string => match ($state) {
                                    'Draft Penulis' => 'gray',
                                    'Perlu Review Koordinator' => 'warning',
                                    'Perlu Revisi' => 'danger',
                                    'Disetujui' => 'success',
                                    'Sudah Tayang' => 'info',
                                    default => 'gray',
                                }),

                            TextColumn::make('is_hot_news')
                                ->label('Hot News')
                                ->badge()
                                ->color('danger')
                                ->icon('heroicon-m-fire')
                                ->grow(false)
                                ->state(
                                    fn (Model $record): ?string =>
                                        $record->isHotNews() ? 'HOT' : null
                                ),

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

                // ==========================================
                // FILTER KATEGORI WARTA
                // ==========================================
                SelectFilter::make('kategori_id')
                    ->label('Kategori Warta')
                    ->relationship('kategori', 'nama_kategori')
                    ->searchable()
                    ->preload(),

                // ==========================================
                // FILTER RENTANG JADWAL TAYANG
                // ==========================================
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

                // ==========================================
                // FILTER HOT NEWS
                // ==========================================
                Filter::make('hot_news')
                    ->label('Hanya Hot News')
                    ->toggle()
                    ->query(
                        fn (Builder $query): Builder =>
                            $query->hotNews()
                    ),
            ])

            ->recordActions([

                Action::make('kirim_review')
                    ->label(
                        fn (Model $record): string =>
                            $record->status_naskah === 'Perlu Revisi'
                                ? 'Kirim Ulang'
                                : 'Kirim ke Verifikator'
                    )
                    ->icon('heroicon-o-paper-airplane')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Kirim naskah untuk verifikasi?')
                    ->modalDescription('Naskah akan masuk ke antrean Verifikator.')
                    ->visible(
                        fn (Model $record): bool => (
                            Auth::user()?->hasAnyRole([
                                'penulis',
                                'Penulis',
                                'super_admin',
                            ]) ?? false
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

                Action::make('tayangkan_warta')
                    ->label('Publikasikan')
                    ->icon('heroicon-o-globe-alt')
                    ->color('info')
                    ->modalHeading('Publikasikan Warta ini?')
                    ->modalDescription(
                        'Warta hanya dapat dipublikasikan setelah disetujui Verifikator.'
                    )
                    ->modalSubmitAction(
                        fn (Action $action) => $action->color('primary')
                    )
                    ->form([

                        Toggle::make('is_hot_news')
                            ->label('Jadikan Hot News')
                            ->helperText('Berita akan ditampilkan di bagian Hot News.')
                            ->live()
                            ->default(false),

                        DateTimePicker::make('hot_news_until')
                            ->label('Hot News sampai')
                            ->helperText('Kosongkan jika tidak ada batas waktu.')
                            ->native(false)
                            ->minDate(now())
                            ->visible(
                                fn (Get $get): bool =>
                                    (bool) $get('is_hot_news')
                            ),

                    ])
                    ->visible(
                        fn (Model $record): bool =>
                            (
                                Auth::user()?->hasAnyRole([
                                    'Admin',
                                    'admin',
                                    'super_admin',
                                    'Super Admin',
                                    'Admin Publikasi',
                                ]) ?? false
                            )
                            && $record->status_naskah === 'Disetujui'
                    )
                    ->action(function (Model $record, array $data): void {

                        $isHot = (bool) ($data['is_hot_news'] ?? false);

                        $record->update([
                            'status_naskah' => 'Sudah Tayang',
                            'is_hot_news' => $isHot,
                            'hot_news_until' => $isHot
                                ? ($data['hot_news_until'] ?? null)
                                : null,
                        ]);

                        Notification::make()
                            ->title('Warta berhasil dipublikasikan')
                            ->success()
                            ->send();
                    }),

                Action::make('atur_hot_news')
                    ->label(
                        fn (Model $record): string =>
                            $record->isHotNews()
                                ? 'Atur / Cabut Hot News'
                                : 'Jadikan Hot News'
                    )
                    ->icon('heroicon-o-fire')
                    ->color('warning')
                    ->modalHeading('Atur Hot News')
                    ->modalSubmitAction(
                        fn (Action $action) => $action->color('primary')
                    )
                    ->fillForm(
                        fn (Model $record): array => [
                            'is_hot_news' => $record->is_hot_news,
                            'hot_news_until' => $record->hot_news_until,
                        ]
                    )
                    ->form([

                        Toggle::make('is_hot_news')
                            ->label('Hot News')
                            ->live(),

                        DateTimePicker::make('hot_news_until')
                            ->label('Hot News sampai')
                            ->helperText('Kosongkan jika tidak ada batas waktu.')
                            ->native(false)
                            ->minDate(now())
                            ->visible(
                                fn (Get $get): bool =>
                                    (bool) $get('is_hot_news')
                            ),

                    ])
                    ->visible(
                        fn (Model $record): bool =>
                            (
                                Auth::user()?->hasAnyRole([
                                    'Admin',
                                    'admin',
                                    'super_admin',
                                    'Super Admin',
                                    'Admin Publikasi',
                                ]) ?? false
                            )
                            && $record->status_naskah === 'Sudah Tayang'
                    )
                    ->action(function (Model $record, array $data): void {

                        $isHot = (bool) ($data['is_hot_news'] ?? false);

                        $record->update([
                            'is_hot_news' => $isHot,
                            'hot_news_until' => $isHot
                                ? ($data['hot_news_until'] ?? null)
                                : null,
                        ]);

                        Notification::make()
                            ->title(
                                $isHot
                                    ? 'Hot News diaktifkan'
                                    : 'Hot News dicabut'
                            )
                            ->success()
                            ->send();
                    }),

                EditAction::make('edit')
                    ->label('Edit')
                    ->visible(
                        fn (Model $record): bool =>
                            (
                                Auth::user()?->hasAnyRole([
                                    'penulis',
                                    'Penulis',
                                ]) ?? false
                            )
                            && (int) $record->users_id === (int) Auth::id()
                            && in_array(
                                $record->status_naskah,
                                ['Draft Penulis', 'Perlu Revisi'],
                                true
                            )
                    ),

                ViewAction::make()
                    ->label('Lihat'),

                ViewAction::make('preview')
                    ->label('Buka Berita')
                    ->url(
                        fn (Model $record): string =>
                            route('articles.show', [
                                'slug' => $record->slug_url,
                            ])
                    )
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-globe-alt')
                    ->visible(
                        fn (Model $record): bool =>
                            $record->status_naskah === 'Sudah Tayang'
                    ),

                DeleteAction::make()
                    ->label('Hapus Warta')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Warta yang Sudah Dipublikasikan')
                    ->modalDescription(
                        'Apakah kamu yakin ingin menghapus warta ini? Berita yang dihapus tidak akan tersedia lagi di halaman frontend.'
                    )
                    ->modalSubmitActionLabel('Ya, Hapus Warta')
                    ->visible(
                        fn (Model $record): bool =>
                            $record->status_naskah === 'Sudah Tayang'
                    ),
            ])

            ->bulkActions([
                BulkActionGroup::make([
                    // Tambahkan bulk action jika diperlukan.
                ]),
            ]);
    }
}
