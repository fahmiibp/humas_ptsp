<?php

namespace App\Filament\Resources\Timelines\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class TimelineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make([
                    'default' => 1,
                    'lg' => 3,
                ])
                ->schema([
                    // Kolom Kiri / Utama: Detail Kegiatan (2 Kolom)
                    Section::make('Informasi Kegiatan')
                        ->description('Rincian nama agenda dan tempat pelaksanaan kegiatan.')
                        ->icon('heroicon-m-calendar-days')
                        ->columnSpan(['lg' => 2])
                        ->schema([
                            TextInput::make('event_name')
                                ->label('Nama Kegiatan')
                                ->placeholder('Contoh: Rapat Koordinasi Wilayah atau Sosialisasi SIPD')
                                ->required()
                                ->maxLength(255)
                                ->prefixIcon('heroicon-m-pencil-square'),

                            TextInput::make('location')
                                ->label('Lokasi Pelaksanaan')
                                ->placeholder('Contoh: Ruang Rapat Lt. 2 atau Hotel Grasia Semarang')
                                ->required()
                                ->maxLength(255)
                                ->prefixIcon('heroicon-m-map-pin')
                                ->helperText('Cantumkan gedung, ruangan, atau link meeting jika daring.'),
                        ]),

                    // Kolom Kanan / Samping: Waktu & Status (1 Kolom)
                    Section::make('Jadwal & Progres')
                        ->description('Periode pelaksanaan serta status tindak lanjut.')
                        ->icon('heroicon-m-clock')
                        ->columnSpan(['lg' => 1])
                        ->schema([
                            DatePicker::make('start_date')
                                ->label('Tanggal Mulai')
                                ->displayFormat('d/m/Y')
                                ->native(false)
                                ->prefixIcon('heroicon-m-calendar')
                                ->required()
                                ->live(),

                            DatePicker::make('end_date')
                                ->label('Tanggal Selesai')
                                ->displayFormat('d/m/Y')
                                ->native(false)
                                ->prefixIcon('heroicon-m-calendar')
                                ->required()
                                ->minDate(fn (Get $get) => $get('start_date'))
                                ->helperText('Tidak boleh lebih awal dari tanggal mulai.')
                                ->validationMessages([
                                    'after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
                                ]),

                            Select::make('status')
                                ->label('Status Agenda')
                                ->options([
                                    'Belum Mulai' => 'Belum Mulai',
                                    'Sedang Berlangsung' => 'Sedang Berlangsung',
                                    'Selesai' => 'Selesai',
                                    'Batal' => 'Batal',
                                ])
                                ->default('Belum Mulai')
                                ->native(false)
                                ->required()
                                ->prefixIcon('heroicon-m-arrow-path'),
                        ]),
                ])->columnSpanFull(),
            ]);
    }
}
