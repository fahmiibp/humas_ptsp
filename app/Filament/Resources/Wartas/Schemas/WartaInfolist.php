<?php

namespace App\Filament\Resources\Wartas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class WartaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
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
                                fn($state): string =>
                                Str::headline((string) $state)
                            )
                            ->color(fn($state): string => match (Str::lower((string) $state)) {
                                'draft', 'draf' => 'gray',

                                'review',
                                'menunggu_review',
                                'dalam_review' => 'info',

                                'revisi',
                                'perlu_revisi' => 'warning',

                                'ditolak',
                                'rejected' => 'danger',

                                'approved',
                                'disetujui',
                                'published',
                                'terbit',
                                'tayang' => 'success',

                                'scheduled',
                                'dijadwalkan' => 'primary',

                                default => 'gray',
                            })
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

                        /*
                        | RIGHT SIDEBAR
                        */

                        Grid::make(1)
                            ->schema([

                                Section::make(
                                    'Informasi Publikasi'
                                )
                                    ->icon(
                                        Heroicon::CalendarDays
                                    )
                                    ->compact()
                                    ->schema([

                                        TextEntry::make(
                                            'jadwal_tayang'
                                        )
                                            ->label(
                                                'Jadwal Tayang'
                                            )
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

                                        TextEntry::make(
                                            'slug_url'
                                        )
                                            ->label('Slug URL')
                                            ->icon(
                                                Heroicon::Link
                                            )
                                            ->copyable()
                                            ->copyMessage(
                                                'Slug berhasil disalin'
                                            )
                                            ->color('primary')
                                            ->placeholder('-'),

                                    ]),

                                Section::make(
                                    'Catatan Editorial'
                                )
                                    ->description(
                                        'Masukan dan koreksi naskah.'
                                    )
                                    ->icon(
                                        Heroicon::PencilSquare
                                    )
                                    ->compact()
                                    ->schema([

                                        TextEntry::make(
                                            'catatan_koreksi'
                                        )
                                            ->label(
                                                'Catatan Koreksi'
                                            )
                                            ->placeholder(
                                                'Belum ada catatan koreksi.'
                                            )
                                            ->columnSpanFull(),

                                    ]),

                                Section::make(
                                    'Riwayat Aktivitas'
                                )
                                    ->icon(Heroicon::Clock)
                                    ->compact()
                                    ->schema([

                                        TextEntry::make(
                                            'created_at'
                                        )
                                            ->label(
                                                'Dibuat Pada'
                                            )
                                            ->icon(
                                                Heroicon::CalendarDays
                                            )
                                            ->dateTime(
                                                'd M Y, H:i',
                                                timezone: 'Asia/Jakarta'
                                            )
                                            ->placeholder('-'),

                                        TextEntry::make(
                                            'updated_at'
                                        )
                                            ->label(
                                                'Terakhir Diperbarui'
                                            )
                                            ->icon(
                                                Heroicon::Clock
                                            )
                                            ->since()
                                            ->dateTimeTooltip(
                                                'd M Y, H:i'
                                            )
                                            ->placeholder('-'),

                                    ]),

                                Section::make(
                                    'Informasi Sistem'
                                )
                                    ->description(
                                        'Referensi internal naskah.'
                                    )
                                    ->icon(
                                        Heroicon::InformationCircle
                                    )
                                    ->compact()
                                    ->collapsed()
                                    ->schema([

                                        TextEntry::make(
                                            'timeline_id'
                                        )
                                            ->label(
                                                'ID Timeline'
                                            )
                                            ->numeric()
                                            ->placeholder('-'),

                                        TextEntry::make(
                                            'users_id'
                                        )
                                            ->label(
                                                'ID Pengguna'
                                            )
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
