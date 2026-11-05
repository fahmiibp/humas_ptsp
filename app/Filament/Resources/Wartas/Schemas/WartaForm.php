<?php

namespace App\Filament\Resources\Wartas\Schemas;

use App\Ai\Agents\PenulisBerita;
use App\Models\Kategori;
use App\Models\Timeline;
use App\Models\Warta;
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
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class WartaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            /*
            |--------------------------------------------------------------------------
            | INFORMASI WARTA
            |--------------------------------------------------------------------------
            */

            Section::make('Informasi Warta')
                ->description('Lengkapi informasi utama siaran pers.')
                ->icon('heroicon-o-document-text')
                ->schema([

                    TextInput::make('judul_siaran_pers')
                        ->label('Judul Siaran Pers')
                        ->placeholder('Masukkan judul siaran pers')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (
                            ?string $state,
                            Set $set,
                            Get $get
                        ): void {
                            /*
                             * Buat slug otomatis hanya jika slug
                             * masih kosong.
                             */
                            if (blank($get('slug_url'))) {
                                $set(
                                    'slug_url',
                                    Str::slug($state ?? '')
                                );
                            }

                            /*
                             * Jika Meta Title masih kosong,
                             * gunakan judul berita sebagai default SEO.
                             */
                            if (blank($get('meta_title'))) {
                                $set(
                                    'meta_title',
                                    Str::limit(
                                        trim((string) $state),
                                        60,
                                        ''
                                    )
                                );
                            }
                        })
                        ->columnSpanFull(),

                    TextInput::make('slug_url')
                        ->label('Slug URL')
                        ->placeholder('slug-otomatis-dari-judul')
                        ->helperText(
                            'Slug digunakan sebagai bagian URL berita. Pastikan nilainya unik.'
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
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (
                            ?string $state,
                            Set $set,
                            Get $get
                        ): void {
                            /*
                             * Jika Meta Description masih kosong,
                             * gunakan Lead Berita sebagai default.
                             */
                            if (blank($get('meta_description'))) {
                                $set(
                                    'meta_description',
                                    Str::limit(
                                        trim((string) $state),
                                        160,
                                        ''
                                    )
                                );
                            }
                        })
                        ->columnSpanFull(),

                ])
                ->columns(2)
                ->columnSpanFull()
                ->collapsible(),

            /*
            |--------------------------------------------------------------------------
            | SEO
            |--------------------------------------------------------------------------
            */

            Section::make('Optimasi SEO')
                ->description(
                    'Optimalkan informasi berita agar lebih mudah ditemukan melalui mesin pencari.'
                )
                ->icon('heroicon-o-magnifying-glass')
                ->schema([

                    TextInput::make('meta_title')
                        ->label('Meta Title')
                        ->placeholder(
                            'Contoh: DPMPTSP Jateng Catat Realisasi Investasi 2026'
                        )
                        ->maxLength(60)
                        ->live(onBlur: true)
                        ->helperText(
                            'Judul yang digunakan mesin pencari. Disarankan maksimal 60 karakter.'
                        )
                        ->columnSpanFull(),

                    Textarea::make('meta_description')
                        ->label('Meta Description')
                        ->placeholder(
                            'Tuliskan ringkasan singkat dan menarik mengenai isi berita...'
                        )
                        ->rows(4)
                        ->maxLength(160)
                        ->helperText(
                            'Deskripsi singkat untuk mesin pencari. Disarankan maksimal 160 karakter.'
                        )
                        ->columnSpanFull(),

                    TextInput::make('meta_keywords')
                        ->label('Meta Keywords')
                        ->placeholder(
                            'investasi, DPMPTSP, Jawa Tengah, realisasi investasi'
                        )
                        ->maxLength(500)
                        ->helperText(
                            'Masukkan kata kunci yang relevan dan pisahkan dengan koma.'
                        )
                        ->columnSpanFull(),

                ])
                ->columns(2)
                ->columnSpanFull()
                ->collapsible(),

            /*
            |--------------------------------------------------------------------------
            | PUBLIKASI DAN PENJADWALAN
            |--------------------------------------------------------------------------
            */

            Section::make('Publikasi dan Penjadwalan')
                ->description(
                    'Atur kategori, jadwal tayang, agenda liputan, dan penanggung jawab berita.'
                )
                ->icon('heroicon-o-calendar-days')
                ->schema([

                    Select::make('kategori_id')
                        ->label('Kategori Berita')
                        ->options(
                            fn (): array => Kategori::query()
                                ->orderBy('nama_kategori')
                                ->pluck('nama_kategori', 'id')
                                ->all()
                        )
                        ->placeholder('Pilih kategori berita')
                        ->native(false)
                        ->searchable()
                        ->preload()
                        ->required()
                        ->validationMessages([
                            'required' =>
                                'Kategori berita wajib dipilih.',
                        ]),

                    DatePicker::make('jadwal_tayang')
                        ->label('Jadwal Tayang')
                        ->placeholder('Pilih tanggal tayang')
                        ->native(false)
                        ->displayFormat('d F Y')
                        ->required()
                        ->helperText(
                            'Tentukan tanggal publikasi berita.'
                        ),

                    Select::make('timeline_id')
                        ->label('Agenda / Timeline Liputan')
                        ->relationship(
                            name: 'timeline',
                            titleAttribute: 'event_name'
                        )
                        ->getOptionLabelFromRecordUsing(
                            fn (Timeline $record): string =>
                                $record->event_name
                        )
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->placeholder('Pilih agenda liputan')
                        ->helperText(
                            'Opsional. Pilih agenda yang terkait dengan siaran pers ini.'
                        )
                        ->nullable(),

                    Hidden::make('users_id')
                        ->default(fn () => auth()->id()),

                ])
                ->columns(3)
                ->columnSpanFull(),

            /*
            |--------------------------------------------------------------------------
            | KONTEN BERITA
            |--------------------------------------------------------------------------
            */

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
                            [
                                'alignStart',
                                'alignCenter',
                                'alignEnd',
                            ],
                        ])
                        ->hintAction(
                            Action::make('generateNewsContent')
                                ->label('Buat dengan AI')
                                ->icon('heroicon-o-sparkles')
                                ->action(function (
                                    Get $get,
                                    Set $set
                                ): void {
                                    $judul = $get('judul_siaran_pers');
                                    $lead = $get('lead_berita');

                                    if (blank($judul)) {
                                        Notification::make()
                                            ->title(
                                                'Isi judul berita terlebih dahulu.'
                                            )
                                            ->warning()
                                            ->send();

                                        return;
                                    }

                                    if (blank($lead)) {
                                        Notification::make()
                                            ->title(
                                                'Isi lead berita terlebih dahulu.'
                                            )
                                            ->warning()
                                            ->send();

                                        return;
                                    }

                                    $jadwalTayang = filled(
                                        $get('jadwal_tayang')
                                    )
                                        ? Carbon::parse(
                                            $get('jadwal_tayang')
                                        )->translatedFormat('d F Y')
                                        : '-';

                                    $timelineId = $get('timeline_id');

                                    $namaAgenda = filled($timelineId)
                                        ? (
                                            Timeline::find($timelineId)
                                                ?->event_name ?? '-'
                                        )
                                        : '-';

                                    $prompt = <<<PROMPT
Tulis HANYA badan berita, tanpa judul dan tanpa lead, berdasarkan bahan berikut.

Judul: {$judul}

Lead: {$lead}

Jadwal tayang (tanggal publikasi, bukan tanggal kegiatan): {$jadwalTayang}

Agenda liputan (konteks saja): {$namaAgenda}

Gunakan struktur piramida terbalik.

Jangan mengulang judul dan lead secara verbatim.

Jika informasi terbatas, tulis ringkas sesuai fakta.

Pisahkan paragraf dengan satu baris kosong.
PROMPT;

                                    try {
                                        $hasil = trim(
                                            (string) PenulisBerita::make()
                                                ->prompt($prompt)
                                        );

                                        if (blank($hasil)) {
                                            Notification::make()
                                                ->title(
                                                    'AI tidak menghasilkan konten berita.'
                                                )
                                                ->warning()
                                                ->send();

                                            return;
                                        }

                                        $html = collect(
                                            preg_split(
                                                '/\R{2,}/',
                                                $hasil
                                            )
                                        )
                                            ->map(
                                                fn ($p) => trim($p)
                                            )
                                            ->filter()
                                            ->map(
                                                fn ($p) =>
                                                    '<p>'
                                                    . nl2br(e($p))
                                                    . '</p>'
                                            )
                                            ->implode('');

                                        $set(
                                            'badan_berita',
                                            $html
                                        );

                                        /*
                                         * Jika Meta Description kosong,
                                         * otomatis ambil dari Lead.
                                         */
                                        if (
                                            blank(
                                                $get('meta_description')
                                            )
                                        ) {
                                            $set(
                                                'meta_description',
                                                Str::limit(
                                                    strip_tags(
                                                        (string) $lead
                                                    ),
                                                    160,
                                                    ''
                                                )
                                            );
                                        }

                                        Notification::make()
                                            ->title(
                                                'Konten berita berhasil dibuat.'
                                            )
                                            ->body(
                                                'Mohon periksa kembali sebelum dipublikasikan.'
                                            )
                                            ->success()
                                            ->send();
                                    } catch (\Throwable $e) {
                                        report($e);

                                        Notification::make()
                                            ->title(
                                                'Gagal menghasilkan konten berita.'
                                            )
                                            ->body(
                                                'Silakan coba lagi beberapa saat.'
                                            )
                                            ->danger()
                                            ->send();
                                    }
                                })
                        ),

                ])
                ->columnSpanFull(),

            /*
            |--------------------------------------------------------------------------
            | DOKUMENTASI DAN COVER
            |--------------------------------------------------------------------------
            */

            Section::make('Dokumentasi dan Cover')
                ->description(
                    'Unggah satu atau beberapa foto untuk kebutuhan publikasi berita.'
                )
                ->icon('heroicon-o-photo')
                ->schema([

                    FileUpload::make('dokumentasi_utama')
                        ->label('Dokumentasi Gambar')
                        ->image()
                        ->multiple()
                        ->reorderable()
                        ->maxFiles(5)
                        ->acceptedFileTypes([
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                        ])
                        ->disk('public')
                        ->directory('Cover_Foto')
                        ->maxSize(2048)
                        ->alignCenter()
                        ->imagePreviewHeight('180')
                        ->panelLayout('grid')
                        ->helperText(
                            'Pilih maksimal 5 gambar berformat JPG, PNG, atau WebP. Ukuran maksimal 2 MB per gambar.'
                        )
                        ->required()
                        ->columnSpanFull(),

                ])
                ->columnSpanFull()
                ->collapsible(),

        ]);
    }
}