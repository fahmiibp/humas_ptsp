<?php

namespace App\Filament\Resources\Wartas\Schemas;

use App\Models\Timeline;
use App\Models\User;
use App\Models\Warta;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WartaForm
{
    public static function configure(Schema $schema): Schema
    {

    $isReviewing = fn (?Model $record) => $record && $record->status_naskah === 'Perlu Review Koordinator';

        return $schema
            ->components([
                Section::make('Informasi Siaran Pers')
                    ->description('Masukkan judul dan informasi utama siaran pers.')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        TextInput::make('judul_siaran_pers')
                            ->label('Judul Siaran Pers')
                            ->placeholder(
                                'Contoh: DPMPTSP Jateng Catat Realisasi Investasi Kuartal I Lampaui Target'
                            )
                            ->helperText('Gunakan judul yang jelas, informatif, dan menarik.')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn(Set $set, ?string $state) =>
                                $set('slug_url', Str::slug($state ?? ''))
                            )
                            ->columnSpanFull()
                            ->disabled($isReviewing)
                            ->disabled(fn (?Model $record) => $record && !in_array($record->status_naskah, ['Draft Penulis', 'Perlu Revisi'])),

                        TextInput::make('slug_url')
                            ->label('Slug URL')
                            ->placeholder('slug-otomatis-dari-judul')
                            ->helperText('URL akan dibuat otomatis berdasarkan judul.')
                            ->prefix(url('/warta') . '/')
                            ->required()
                            ->unique(
                                Warta::class,
                                'slug_url',
                                ignoreRecord: true
                            )
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->disabled($isReviewing),

                        Textarea::make('lead_berita')
                            ->label('Lead Berita')
                            ->placeholder('Tuliskan ringkasan atau paragraf pembuka berita...')
                            ->helperText('Ringkasan singkat yang menjelaskan inti berita.')
                            ->required()
                            ->maxLength(500)
                            ->columnSpanFull()
                            ->disabled($isReviewing),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->collapsible(),


                Section::make('Konten Berita')
                    ->description('Susun isi lengkap siaran pers menggunakan editor teks.')
                    ->icon('heroicon-o-pencil-square')
                    ->schema([
                        RichEditor::make('badan_berita')
                            ->label('Badan Berita Lengkap')
                            ->placeholder('Mulai tuliskan naskah lengkap siaran pers di sini...')
                            ->toolbarButtons([
                                'blockquote',
                                'bold',
                                'bulletList',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->required()
                            ->columnSpanFull()
                            ->disabled($isReviewing),
                    ])
                    ->columnSpanFull(),
                Section::make('Publikasi dan Penjadwalan')
                    ->description('Atur status naskah dan jadwal penayangan.')
                    ->icon('heroicon-o-calendar-days')
                    ->schema([
                        Select::make('status_naskah')
                            ->label('Status Naskah')
                            ->options([
                                'Draft Penulis' => 'Draft Penulis',
                                'Perlu Review Koordinator' => 'Perlu Review Koordinator',
                                'Perlu Revisi' => 'Perlu Revisi',
                                'Disetujui' => 'Disetujui',
                                'Sudah Tayang' => 'Sudah Tayang',
                            ])
                            ->required()
                            ->default('Draft Penulis')
                            ->disabled($isReviewing),
                        DatePicker::make('jadwal_tayang')
                            ->label('Jadwal Tayang')
                            ->placeholder('Pilih tanggal tayang')
                            ->native(false)
                            ->displayFormat('d F Y')
                            ->required()
                            ->disabled($isReviewing),

                        Select::make('timeline_id')
                            ->label('Agenda / Timeline')
                            ->options(
                                Timeline::query()
                                    ->orderBy('event_name')
                                    ->pluck('event_name', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->placeholder('Pilih agenda terkait')
                            ->required()
                            ->disabled($isReviewing),

                        Select::make('users_id')
                            ->label('Penanggung Jawab')
                            ->options(
                                User::query()
                                    ->orderBy('name')
                                    ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->placeholder('Pilih penanggung jawab')
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->disabled($isReviewing),

                Section::make('Dokumentasi dan Cover')
                    ->description('Unggah foto utama untuk kebutuhan publikasi berita.')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        FileUpload::make('dokumentasi_utama')
                            ->label('Cover Foto')
                            ->image()
                            ->disk('public')
                            ->directory('Cover_Foto')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(2040)
                            ->alignCenter()
                            ->imagePreviewHeight('280')
                            ->panelLayout('integrated')
                            ->helperText('Format gambar yang didukung mengikuti konfigurasi Laravel. Ukuran maksimal 2 MB.')
                            ->required()
                            ->columnSpanFull()
                            ->disabled($isReviewing),

                        Textarea::make('catatan_koreksi')
                            ->label('Catatan Koreksi / Revisi dari Koordinator')
                            ->helperText('Isi catatan ini jika naskah memerlukan perbaikan dari penulis.')
                            ->rows(4)
                            ->placeholder('Tuliskan poin-poin koreksi atau revisi di sini...')
                            // Muncul otomatis jika status bukan 'Draft Penulis'
                            ->visible(fn(?Model $record): bool => $record && $record->status_naskah !== 'Draft Penulis')
                            ->disabled(true)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->collapsible(),

            ]);
    }
}
