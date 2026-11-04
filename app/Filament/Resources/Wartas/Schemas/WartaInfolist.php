<?php

namespace App\Filament\Resources\Wartas\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;
use Filament\Infolists\Components\ViewEntry;

class WartaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([

                /*
                 * CATATAN KOREKSI
                 */
                Section::make('Catatan Koreksi dari Verifikator')
                    ->description(
                        'Periksa masukan berikut sebelum memperbaiki dan mengirim ulang naskah.'
                    )
                    ->icon(Heroicon::ExclamationTriangle)
                    ->visible(
                        fn ($record): bool =>
                            filled($record?->catatan_koreksi)
                    )
                    ->schema([
                        TextEntry::make('catatan_koreksi')
                            ->hiddenLabel()
                            ->placeholder(
                                'Tidak ada catatan koreksi.'
                            )
                            ->columnSpanFull(),
                    ]),

                /*
                 * RINGKASAN DAN STATUS NASKAH
                 */
                Section::make('Pratinjau Siaran Pers')
                    ->description(
                        'Ringkasan dan identitas utama naskah berita.'
                    )
                    ->icon(Heroicon::Newspaper)
                    ->schema([
                        TextEntry::make('status_naskah')
                            ->label('Status Naskah')
                            ->badge()
                            ->formatStateUsing(
                                fn ($state): string =>
                                    Str::headline((string) $state)
                            )
                            ->color(
                                fn ($state): string => match (
                                    Str::lower(
                                        str_replace(
                                            ' ',
                                            '_',
                                            (string) $state
                                        )
                                    )
                                ) {
                                    'draft',
                                    'draf',
                                    'draft_penulis' => 'gray',

                                    'review',
                                    'menunggu_review',
                                    'dalam_review',
                                    'perlu_review_koordinator' => 'info',

                                    'revisi',
                                    'perlu_revisi' => 'warning',

                                    'ditolak',
                                    'rejected' => 'danger',

                                    'approved',
                                    'disetujui',
                                    'published',
                                    'terbit',
                                    'tayang',
                                    'sudah_tayang' => 'success',

                                    'scheduled',
                                    'dijadwalkan' => 'primary',

                                    default => 'gray',
                                }
                            )
                            ->placeholder('Belum ditentukan'),

                        TextEntry::make('judul_siaran_pers')
                            ->hiddenLabel()
                            ->size(TextSize::Large)
                            ->weight(FontWeight::Bold)
                            ->placeholder('Judul belum tersedia')
                            ->columnSpanFull(),

                        TextEntry::make('lead_berita')
                            ->label('Teras Berita / Lead')
                            ->size(TextSize::Medium)
                            ->color('gray')
                            ->placeholder(
                                'Ringkasan berita belum tersedia.'
                            )
                            ->columnSpanFull(),
                    ]),
                /*
                * GALERI DOKUMENTASI WARTA
                */
                Section::make('Dokumentasi Warta')
                    ->description('Foto dokumentasi yang dilampirkan pada naskah berita.')
                    ->icon(Heroicon::DocumentText)
                    ->visible(function ($record): bool {
                        $images = $record?->dokumentasi_utama;

                        if (is_string($images)) {
                            $decoded = json_decode($images, true);
                            $images = is_array($decoded) ? $decoded : [$images];
                        }

                        return is_array($images)
                            && count(array_filter($images)) > 0;
                    })
                    ->schema([
                        ViewEntry::make('dokumentasi_utama')
                            ->hiddenLabel()
                            ->state(function ($record): array {
                                $images = $record->dokumentasi_utama;

                                if (is_string($images)) {
                                    $decoded = json_decode($images, true);
                                    $images = is_array($decoded) ? $decoded : [$images];
                                }

                                if (! is_array($images)) {
                                    return [];
                                }

                                return array_slice(
                                    array_values(array_filter($images)),
                                    0,
                                    5
                                );
                            })
                            ->view('filament.resources.warta.infolist-dokumentasi')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                /*
                 * ISI BERITA DAN SIDEBAR
                 */
                Grid::make([
                    'default' => 1,
                    'xl' => 3,
                ])
                    ->schema([

                        Section::make('Isi Lengkap Berita')
                            ->description(
                                'Konten utama siaran pers.'
                            )
                            ->icon(Heroicon::DocumentText)
                            ->schema([
                                TextEntry::make('badan_berita')
                                    ->hiddenLabel()
                                    ->html()
                                    ->placeholder(
                                        'Konten berita belum tersedia.'
                                    )
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan([
                                'default' => 1,
                                'xl' => 2,
                            ]),

                        Grid::make(1)
                            ->schema([

                                /*
                                 * INFORMASI PUBLIKASI
                                 */
                                Section::make('Informasi Publikasi')
                                    ->icon(Heroicon::CalendarDays)
                                    ->compact()
                                    ->schema([
                                        TextEntry::make('jadwal_tayang')
                                            ->label('Jadwal Tayang')
                                            ->icon(
                                                Heroicon::CalendarDays
                                            )
                                            ->dateTime(
                                                'd M Y, H:i',
                                                timezone: 'Asia/Jakarta'
                                            )
                                            ->placeholder(
                                                'Belum dijadwalkan'
                                            ),

                                        TextEntry::make('slug_url')
                                            ->label('Slug URL')
                                            ->icon(Heroicon::Link)
                                            ->copyable()
                                            ->copyMessage(
                                                'Slug berhasil disalin'
                                            )
                                            ->color('primary')
                                            ->placeholder('-'),
                                    ]),

                                /*
                                 * RIWAYAT AKTIVITAS
                                 */
                                Section::make('Riwayat Aktivitas')
                                    ->icon(Heroicon::Clock)
                                    ->compact()
                                    ->schema([
                                        TextEntry::make('created_at')
                                            ->label('Dibuat Pada')
                                            ->icon(
                                                Heroicon::CalendarDays
                                            )
                                            ->dateTime(
                                                'd M Y, H:i',
                                                timezone: 'Asia/Jakarta'
                                            )
                                            ->placeholder('-'),

                                        TextEntry::make('updated_at')
                                            ->label('Terakhir Diperbarui')
                                            ->icon(Heroicon::Clock)
                                            ->since()
                                            ->dateTimeTooltip(
                                                'd M Y, H:i'
                                            )
                                            ->placeholder('-'),
                                    ]),

                                /*
                                 * INFORMASI SISTEM
                                 */
                                Section::make('Informasi Sistem')
                                    ->description(
                                        'Referensi internal naskah.'
                                    )
                                    ->icon(
                                        Heroicon::InformationCircle
                                    )
                                    ->compact()
                                    ->collapsed()
                                    ->schema([
                                        TextEntry::make('timeline_id')
                                            ->label('ID Timeline')
                                            ->numeric()
                                            ->placeholder('-'),

                                        TextEntry::make('users_id')
                                            ->label('ID Pengguna')
                                            ->numeric()
                                            ->placeholder('-'),
                                    ]),
                            ])
                            ->columnSpan([
                                'default' => 1,
                                'xl' => 1,
                            ]),
                    ]),
            ]);
    }
}
