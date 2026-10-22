<?php

namespace App\Filament\Resources\RencanaKontenMedsos\Schemas;

use App\Models\Timeline;
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
        return $schema->components([
            Section::make('Materi dan Naskah Konten')
                ->description('Isi informasi utama dan materi visual untuk konten yang direncanakan.')
                ->columns(2)
                ->schema([
                    TextInput::make('judul')
                        ->label('Tema / Judul Konten')
                        ->placeholder('Contoh: Hari Kesaktian Pancasila')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    RichEditor::make('caption')
                        ->label('Caption')
                        ->placeholder('Tulis caption atau deskripsi konten di sini...')
                        ->columnSpanFull(),

                    FileUpload::make('gambar')
                        ->label('Gambar Konten')
                        ->helperText('Unggah gambar untuk materi konten. Format gambar saja.')
                        ->image()
                        ->disk('public')
                        ->directory('gambar-konten')
                        ->required()
                        ->columnSpanFull(),
                ]),

            Section::make('Kanal dan Jadwal Publikasi')
                ->description('Tentukan platform, format, dan waktu publikasi.')
                ->columns(2)
                ->schema([
                    Select::make('platform')
                        ->label('Platform')
                        ->placeholder('Pilih platform')
                        ->options([
                            'youtube' => 'YouTube',
                            'instagram' => 'Instagram',
                            'tiktok' => 'TikTok',
                            'facebook' => 'Facebook',
                            'x_twitter' => 'X / Twitter',
                        ])
                        ->searchable()
                        ->required(),

                    Select::make('format')
                        ->label('Format Konten')
                        ->placeholder('Pilih format konten')
                        ->options([
                            'video_upload' => 'Video / Upload',
                            'reels_video_pendek' => 'Reels / Video Pendek',
                            'instagram_story' => 'Instagram Story',
                            'carousel_multi_slide' => 'Carousel / Multi-Slide',
                            'single_post_feed' => 'Single Post / Feed',
                        ])
                        ->searchable()
                        ->required(),

                    DatePicker::make('tanggal')
                        ->label('Tanggal Tayang')
                        ->placeholder('Pilih tanggal publikasi')
                        ->native(false)
                        ->required(),

                    TimePicker::make('jam_tayang')
                        ->label('Jam Tayang')
                        ->placeholder('Pilih jam publikasi')
                        ->seconds(false)
                        ->required(),

                    Select::make('agenda_id')
                        ->label('Agenda Liputan (Opsional)')
                        ->placeholder('Pilih agenda liputan jika ada')
                        ->options(fn (): array => Timeline::query()
                            ->orderByDesc('start_date')
                            ->get()
                            ->mapWithKeys(fn (Timeline $timeline): array => [
                                $timeline->getKey() => sprintf(
                                    '%s — %s',
                                    $timeline->event_name,
                                    $timeline->start_date
                                        ? \Carbon\Carbon::parse($timeline->start_date)->format('d M Y H:i')
                                        : 'Tanggal belum ditentukan'
                                ),
                            ])
                            ->all())
                        ->searchable()
                        ->preload()
                        ->nullable()
                        ->helperText('Opsional. Pilih jika konten ini berkaitan dengan agenda liputan yang sudah terdaftar.')
                        ->columnSpanFull(),

                    TextInput::make('link')
                        ->label('Link Konten')
                        ->placeholder('https://...')
                        ->url()
                        ->maxLength(255)
                        ->helperText('Opsional. Isi jika konten sudah memiliki tautan publikasi.')
                        ->columnSpanFull(),
                ]),

            Section::make('Status dan Publikasi')
                ->description('Atur status rencana konten dan hashtag.')
                ->columns(2)
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
                        ->placeholder('Tambahkan hashtag, lalu tekan Enter')
                        ->helperText('Opsional. Tambahkan hashtag tanpa tanda koma.')
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
