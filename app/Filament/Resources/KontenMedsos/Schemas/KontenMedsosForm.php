<?php
namespace App\Filament\Resources\KontenMedsos\Schemas;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
class KontenMedsosForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                /*
                |--------------------------------------------------------------------------
                | KOLOM KIRI
                |--------------------------------------------------------------------------
                */
                Section::make('Materi & Naskah Konten')
                    ->description(
                        'Unggah materi visual dan susun takarir (caption) penayangan.'
                    )
                    ->columnSpan(2)
                    ->components([
                        TextInput::make('judul')
                            ->label('Tema / Judul Konten')
                            ->placeholder(
                                'Contoh: Infografis Panduan Pengajuan Izin OSS 2026'
                            )
                            ->required(),
                        FileUpload::make('gambar')
                            ->label('Aset Visual / Video')
                            ->directory('konten')
                            ->image()
                            ->imagePreviewHeight('150')
                            ->panelLayout('compact'),
                        Textarea::make('caption')
                            ->label('Takarir (Caption)')
                            ->placeholder(
                                'Tulis narasi takarir di sini...'
                            )
                            ->rows(8)
                            ->maxLength(2200),
                        TextInput::make('hashtag')
                            ->label('Daftar Tagar (#Hashtag)')
                            ->placeholder(
                                '#JatengGayeng #InvestasiJateng #PTSPPrima'
                            ),
                    ]),
                /*
                |--------------------------------------------------------------------------
                | KOLOM KANAN
                |--------------------------------------------------------------------------
                */
                Grid::make(1)
                    ->columnSpan(1)
                    ->components([
                        Section::make('Kanal & Format')
                            ->components([
                                Select::make('platform')
                                    ->label('Platform Tujuan')
                                    ->options([
                                        'Instagram' => 'Instagram',
                                        'Facebook' => 'Facebook',
                                        'TikTok' => 'TikTok',
                                        'Youtube' => 'Youtube',
                                    ])
                                    ->required(),
                                Select::make('format')
                                    ->label('Format Konten')
                                    ->options([
                                        'Single Post' => 'Single Post',
                                        'Carousel' => 'Carousel',
                                        'Video' => 'Video',
                                        'Reels' => 'Reels',
                                    ])
                                    ->required(),
                                DatePicker::make('tanggal')
                                    ->label('Jadwal Waktu Tayang')
                                    ->default(
                                        request()->get('tanggal')
                                    )
                                    ->displayFormat('d/m/Y')
                                    ->native(false)
                                    ->required(),
                                TimePicker::make('jam_tayang')
                                    ->label('Jam Tayang')
                                    ->seconds(false)
                                    ->format('H:i')
                                    ->displayFormat('H:i')
                                    ->native(false)
                                    ->dehydrated(true)
                                    ->required(),
                            ]),
                        Section::make('Status & Publikasi')
                            ->components([
                                Select::make('status')
                                    ->label('Status Pengerjaan')
                                    ->options([
                                        'Draft' => 'Draft Ide',
                                        'Review' => 'Review',
                                        'Siap Tayang' => 'Siap Tayang',
                                        'Published' => 'Sudah Tayang',
                                    ])
                                    ->default('Draft'),
                                TextInput::make('link')
                                    ->label('Tautan Postingan Publik')
                                    ->placeholder(
                                        'https://instagram.com/p/...'
                                    ),
                                Select::make('agenda_id')
                                    ->label('Keterkaitan Agenda Liputan')
                                    ->options([])
                                    ->searchable()
                                    ->nullable(),
                            ]),
                    ]),
            ]);
    }
}