<?php

namespace App\Filament\Resources\Arsips\Schemas;

use App\Models\Timeline;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ArsipForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Arsip Dokumentasi')
                    ->description('Lengkapi informasi kegiatan dan dokumentasi yang akan diarsipkan.')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Select::make('id_timeline')
                            ->label('Nama Kegiatan')
                            ->placeholder('Pilih kegiatan')
                            ->options(
                                Timeline::query()->pluck('event_name', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull(),

                        TextInput::make('title')
                            ->label('Judul Arsip')
                            ->placeholder('Contoh: Peresmian Gedung DPMPTSP')
                            ->helperText('Gunakan judul yang singkat dan jelas.')
                            ->required()
                            ->maxLength(255),

                        DatePicker::make('event_date')
                            ->label('Tanggal Kegiatan')
                            ->placeholder('Pilih tanggal kegiatan')
                            ->native(false)
                            ->displayFormat('d F Y')
                            ->required(),

                        Select::make('photograper_name')
                            ->label('Nama Fotografer')
                            ->placeholder('Pilih fotografer')
                            ->options(
                                User::query()->pluck('name', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('drive_url')
                            ->label('Link Google Drive')
                            ->placeholder('https://drive.google.com/drive/folders/...')
                            ->helperText('Masukkan tautan folder atau file Google Drive yang dapat dibuka oleh pihak terkait.')
                            ->url()
                            ->required()
                            ->maxLength(2000)
                            ->rules([
                                function () {
                                    return function (
                                        string $attribute,
                                        $value,
                                        \Closure $fail
                                    ) {
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
                                            || ! in_array(
                                                strtolower((string) $host),
                                                $allowedHosts,
                                                true
                                            )
                                        ) {
                                            $fail(
                                                'Tautan tidak valid. Gunakan URL file atau folder Google Drive, misalnya https://drive.google.com/drive/folders/....'
                                            );
                                        }
                                    };
                                },
                            ])
                            ->columnSpanFull(),

                        Textarea::make('notes')
                            ->label('Catatan')
                            ->placeholder('Tambahkan keterangan kegiatan, isi dokumentasi, atau informasi lain (opsional).')
                            ->rows(4)
                            ->columnSpanFull()
                            ->dehydrateStateUsing(
                                fn ($state) => $state ?? ''
                            ),

                        
                        FileUpload::make('sample_photos')
                            ->label('Foto Dokumentasi')
                            ->helperText('Unggah beberapa foto sekaligus. Format JPG, PNG, atau WebP. Maksimal 10 MB per foto.')
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
                            ->formatStateUsing(function ($state) {
                                if (is_string($state)) {
                                    $state = json_decode($state, true);
                                }

                                return is_array($state) ? array_values($state) : [];
                            })
                            ->reorderable()
                            ->columnSpanFull(),

                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->collapsible(),
            ]);
    }
}
