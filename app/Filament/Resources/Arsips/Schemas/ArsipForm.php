<?php

namespace App\Filament\Resources\Arsips\Schemas;

use App\Models\Timeline;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class ArsipForm
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
                    // Panel Kiri / Utama: Detail Kegiatan & Metadata (2 Kolom)
                    Grid::make(1)
                        ->columnSpan(['lg' => 2])
                        ->schema([
                            Section::make('Keterkaitan Agenda & Detail')
                                ->description('Pilih agenda kegiatan yang terkait dan tentukan judul dokumentasi.')
                                ->icon('heroicon-m-calendar-days')
                                ->columns(2)
                                ->schema([
                                    Select::make('id_timeline')
                                        ->label('Agenda Kegiatan Terkait')
                                        ->placeholder('Pilih agenda kegiatan...')
                                        ->options(Timeline::query()->pluck('event_name', 'id'))
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->native(false)
                                        ->prefixIcon('heroicon-m-calendar')
                                        ->columnSpanFull()
                                        ->live()
                                        ->afterStateUpdated(function ($state, Set $set) {
                                            if (! $state) return;
                                            $timeline = Timeline::find($state);
                                            if ($timeline?->start_date) {
                                                $set('event_date', $timeline->start_date);
                                            }
                                        })
                                        ->helperText('Tanggal kegiatan akan terisi otomatis saat agenda dipilih.'),

                                    TextInput::make('title')
                                        ->label('Judul Dokumentasi Arsip')
                                        ->placeholder('Contoh: Peliputan Peresmian Gedung Baru')
                                        ->prefixIcon('heroicon-m-document-text')
                                        ->required()
                                        ->maxLength(255)
                                        ->columnSpanFull(),

                                    DatePicker::make('event_date')
                                        ->label('Tanggal Pelaksanaan')
                                        ->placeholder('Pilih tanggal')
                                        ->native(false)
                                        ->displayFormat('d F Y')
                                        ->prefixIcon('heroicon-m-calendar-days')
                                        ->required(),

                                    Select::make('photograper_name')
                                        ->label('Fotografer / Tim Liputan')
                                        ->placeholder('Pilih fotografer...')
                                        ->options(User::query()->pluck('name', 'id'))
                                        ->searchable()
                                        ->preload()
                                        ->native(false)
                                        ->prefixIcon('heroicon-m-camera')
                                        ->required(),
                                ]),

                            Section::make('Foto Dokumentasi')
                                ->description('Unggah preview atau sampel foto dokumentasi kegiatan (maks. 10 file).')
                                ->icon('heroicon-m-photo')
                                ->schema([
                                    FileUpload::make('sample_photos')
                                        ->hiddenLabel()
                                        ->image()
                                        ->multiple()
                                        ->maxFiles(10)
                                        ->maxSize(10240)
                                        ->acceptedFileTypes([
                                            'image/jpeg',
                                            'image/png',
                                            'image/webp',
                                        ])
                                        ->disk('public')
                                        ->directory('Cover_Foto')
                                        ->visibility('public')
                                        ->panelLayout('grid')
                                        ->imageEditor()
                                        ->reorderable()
                                        ->columnSpanFull()
                                        ->helperText('Format didukung: JPG, PNG, WebP (maks. 10MB per foto). Urutan foto dapat digeser.'),
                                ]),
                        ]),

                    // Panel Kanan / Samping: Tautan Cloud & Catatan Tambahan (1 Kolom)
                    Grid::make(1)
                        ->columnSpan(['lg' => 1])
                        ->schema([
                            Section::make('Penyimpanan Cloud')
                                ->description('Tautan folder Google Drive master arsip.')
                                ->icon('heroicon-m-cloud-arrow-up')
                                ->schema([
                                    TextInput::make('drive_url')
                                        ->label('Link Google Drive')
                                        ->placeholder('https://drive.google.com/drive/folders/...')
                                        ->prefixIcon('heroicon-m-link')
                                        ->url()
                                        ->required()
                                        ->maxLength(2000)
                                        ->suffixAction(
                                            Action::make('open_drive')
                                                ->icon('heroicon-m-arrow-top-right-on-square')
                                                ->tooltip('Buka link di tab baru')
                                                ->url(fn (Get $get): ?string => $get('drive_url'), shouldOpenInNewTab: true)
                                                ->visible(fn (Get $get): bool => filled($get('drive_url')))
                                        )
                                        ->rules([
                                            function () {
                                                return function (string $attribute, $value, \Closure $fail) {
                                                    if (! is_string($value) || trim($value) === '') {
                                                        return;
                                                    }

                                                    $host = parse_url(trim($value), PHP_URL_HOST);
                                                    $allowedHosts = [
                                                        'drive.google.com',
                                                        'docs.google.com',
                                                    ];

                                                    if (
                                                        ! filter_var($value, FILTER_VALIDATE_URL)
                                                        || ! in_array(strtolower((string) $host), $allowedHosts, true)
                                                    ) {
                                                        $fail('Gunakan tautan valid dari Google Drive (https://drive.google.com/...).');
                                                    }
                                                };
                                            },
                                        ])
                                        ->helperText('Pastikan hak akses tautan Drive sudah disetel ke publik/pihak terkait.'),
                                ]),

                            Section::make('Catatan Tambahan')
                                ->icon('heroicon-m-pencil-square')
                                ->schema([
                                    Textarea::make('notes')
                                        ->hiddenLabel()
                                        ->placeholder('Tuliskan ringkasan hasil liputan, daftar tamu penting, atau keterangan khusus (opsional)...')
                                        ->rows(6)
                                        ->dehydrateStateUsing(fn ($state) => $state ?? ''),
                                ]),
                        ]),
                ])->columnSpanFull(),
            ]);
    }
}
