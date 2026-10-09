<?php

namespace App\Filament\Resources\RencanaKontenMedsos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RencanaKontenMedsosForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /*
                |--------------------------------------------------------------------------
                | Materi dan Naskah Konten
                |--------------------------------------------------------------------------
                */

                Section::make('Materi dan Naskah Konten')
                    ->description(
                        'Unggah materi visual dan susun takarir (caption) penayangan.'
                    )
                    ->schema([

                        TextInput::make('judul')
                            ->label('Tema / Judul')
                            ->placeholder('Contoh: Hari Kesaktian Pancasila')
                            ->required()
                            ->maxLength(255),

                        RichEditor::make('caption')
                            ->label('Caption')
                            ->placeholder('Berikan caption atau deskripsi di sini...'),

                        FileUpload::make('gambar')
                            ->label('Gambar Konten')
                            ->disk('public')
                            ->directory('Gambar Konten')
                            ->image()
                            ->required(),
                    ]),

                /*
                |--------------------------------------------------------------------------
                | Kanal dan Format
                |--------------------------------------------------------------------------
                */

                Section::make('Kanal dan Format')
                    ->schema([

                        Select::make('platform')
                            ->label('Platform')
                            ->options([
                                'youtube' => 'YouTube',
                                'instagram' => 'Instagram',
                                'tiktok' => 'TikTok',
                                'facebook' => 'Facebook',
                                'x_twitter' => 'X / Twitter',
                            ])
                            ->searchable()
                            ->required(),

                        DatePicker::make('tanggal')
                            ->label('Tanggal Tayang')
                            ->native(false)
                            ->required(),

                        Select::make('format')
                            ->label('Format Konten')
                            ->options([
                                'video_upload' => 'Video / Upload',
                                'reels_video_pendek' => 'Reels / Video Pendek',
                                'instagram_story' => 'Instagram Story',
                                'carousel_multi_slide' => 'Carousel / Multi-Slide',
                                'single_post_feed' => 'Single Post / Feed',
                            ])
                            ->searchable()
                            ->required(),

                        TextInput::make('link')
                            ->label('Link Konten')
                            ->placeholder('https://...')
                            ->url()
                            ->maxLength(255),

                        TextInput::make('agenda_id')
                            ->label('Agenda')
                            ->placeholder('Masukkan agenda')
                            ->required(),

                        TimePicker::make('jam_tayang')
                            ->label('Jam Tayang')
                            ->seconds(false)
                            ->required(),

                    ]),

                /*
                |--------------------------------------------------------------------------
                | Status dan Publikasi
                |--------------------------------------------------------------------------
                */

                Section::make('Status dan Publikasi')
                    ->schema([

                        Select::make('status')
                            ->label('Status Publikasi')
                            ->options([
                                'draft' => 'Draft Ide',
                                'review' => 'Review',
                                'published' => 'Sudah Tayang',
                            ])
                            ->default('draft')
                            ->required(),

                        TagsInput::make('hastag')
                            ->label('Hashtag')
                            ->placeholder('#dpmptsp'),

                    ]),

            ]);
    }
}