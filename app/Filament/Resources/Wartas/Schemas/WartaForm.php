<?php

namespace App\Filament\Resources\Wartas\Schemas;

use App\Models\Timeline;
use App\Models\Warta;
use App\Services\GeminiWartaService;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Throwable;

class WartaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Siaran Pers')
                ->description('Masukkan judul dan informasi utama siaran pers.')
                ->icon('heroicon-o-document-text')
                ->schema([
                    TextInput::make('judul_siaran_pers')
                        ->label('Judul Siaran Pers')
                        ->placeholder(
                            'Contoh: DPMPTSP Jateng Catat Realisasi Investasi Kuartal I Lampaui Target'
                        )
                        ->helperText(
                            'Gunakan judul yang jelas, informatif, dan menarik.'
                        )
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(
                            fn (Set $set, ?string $state) =>
                                $set('slug_url', Str::slug($state ?? ''))
                        )
                        ->columnSpanFull(),

                    TextInput::make('slug_url')
                        ->label('Slug URL')
                        ->placeholder('slug-otomatis-dari-judul')
                        ->helperText(
                            'URL akan dibuat otomatis berdasarkan judul.'
                        )
                        ->prefix(url('/warta') . '/')
                        ->required()
                        ->unique(
                            Warta::class,
                            'slug_url',
                            ignoreRecord: true
                        )
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Textarea::make('lead_berita')
                        ->label('Lead Berita')
                        ->placeholder(
                            'Tuliskan ringkasan atau paragraf pembuka berita...'
                        )
                        ->helperText(
                            'Ringkasan singkat yang menjelaskan inti berita.'
                        )
                        ->required()
                        ->maxLength(500)
                        ->columnSpanFull(),

                    Select::make('kategori')
                        ->label('Kategori Berita')
                        ->options([
                            'Investasi' => 'Investasi',
                            'Perizinan' => 'Perizinan',
                            'Pelayanan Publik' => 'Pelayanan Publik',
                            'Kegiatan' => 'Kegiatan',
                            'Pengumuman' => 'Pengumuman',
                            'Infrastruktur' => 'Infrastruktur',
                            'Lainnya' => 'Lainnya',
                        ])
                        ->placeholder('Pilih kategori berita')
                        ->native(false)
                        ->searchable()
                        ->required()
                        ->validationMessages([
                            'required' => 'Kategori berita wajib dipilih.',
                        ]),
                ])
                ->columns(2)
                ->columnSpanFull()
                ->collapsible(),

            Section::make('Konten Berita')
                ->description(
                    'Susun isi lengkap siaran pers menggunakan editor teks.'
                )
                ->icon('heroicon-o-pencil-square')
                ->schema([
                    RichEditor::make('badan_berita')
                        ->label('Isi Berita')
                        ->required()
                        ->columnSpanFull()
                        ->toolbarButtons([
                            'bold',
                            'italic',
                            'underline',
                            'bulletList',
                            'orderedList',
                            'h2',
                            'h3',
                            'undo',
                            'redo',
                        ])
                        ->afterContent(
                            Action::make('generateAiDraft')
                                ->label('Buat Draf dengan AI')
                                ->icon('heroicon-o-sparkles')
                                ->color('info')
                                ->button()
                                ->action(function (
                                    \Filament\Schemas\Components\Utilities\Get $schemaGet,
                                    \Filament\Schemas\Components\Utilities\Set $schemaSet,
                                    GeminiWartaService $gemini
                                ): void {
                                    $judul = trim(
                                        (string) (
                                            $schemaGet('judul_siaran_pers') ?? ''
                                        )
                                    );

                                    $lead = trim(
                                        (string) (
                                            $schemaGet('lead_berita') ?? ''
                                        )
                                    );

                                    $tanggal = $schemaGet('jadwal_tayang');

                                    if ($judul === '') {
                                        Notification::make()
                                            ->title('Judul berita belum diisi')
                                            ->body(
                                                'Isi judul berita sebelum membuat draf dengan AI.'
                                            )
                                            ->warning()
                                            ->send();

                                        return;
                                    }

                                    try {
                                        $draft = $gemini->generateDraft([
                                            'judul' => $judul,
                                            'lead' => $lead,
                                            'tanggal' => $tanggal,
                                        ]);

                                        // Mengisi editor saja; tidak menyimpan record.
                                        $schemaSet('badan_berita', $draft);

                                        Notification::make()
                                            ->title('Draf berita berhasil dibuat')
                                            ->body(
                                                'Periksa dan sunting hasil AI sebelum menyimpan berita.'
                                            )
                                            ->success()
                                            ->send();
                                    } catch (Throwable $exception) {
                                        report($exception);

                                        Notification::make()
                                            ->title('Draf AI gagal dibuat')
                                            ->body(
                                                $exception instanceof \RuntimeException
                                                    ? $exception->getMessage()
                                                    : 'Terjadi kesalahan saat membuat draf. Periksa log Laravel.'
                                            )
                                            ->danger()
                                            ->send();
                                    }
                                })
                        ),
                ])
                ->columnSpanFull(),

            Section::make('Publikasi dan Penjadwalan')
                ->description(
                    'Atur status naskah dan jadwal penayangan.'
                )
                ->icon('heroicon-o-calendar-days')
                ->schema([
                    DatePicker::make('jadwal_tayang')
                        ->label('Jadwal Tayang')
                        ->placeholder('Pilih tanggal tayang')
                        ->native(false)
                        ->displayFormat('d F Y')
                        ->required(),

                    Select::make('timeline_id')
                        ->label('Agenda / Timeline Liputan')
                        ->relationship(
                            name: 'timeline',
                            titleAttribute: 'event_name'
                        )
                        ->getOptionLabelFromRecordUsing(
                            fn (Timeline $record): string => $record->event_name
                        )
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->placeholder('Pilih agenda liputan')
                        ->helperText(
                            'Opsional. Pilih agenda jika siaran pers terkait dengan agenda liputan.'
                        )
                        ->nullable()
                        ->required(false)
                        ->columnSpanFull(),

                    Hidden::make('users_id')
                        ->default(fn () => auth()->id())
                        ->required(),
                ])
                ->columns(2)
                ->columnSpanFull(),

            Section::make('Dokumentasi dan Cover')
                ->description(
                    'Unggah foto utama untuk kebutuhan publikasi berita.'
                )
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
                        ->helperText(
                            'Format gambar mengikuti konfigurasi Laravel. Ukuran maksimal sekitar 2 MB.'
                        )
                        ->required()
                        ->columnSpanFull(),
                ])
                ->columnSpanFull()
                ->collapsible(),
        ]);
    }
}
