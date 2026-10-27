<?php

namespace App\Filament\Resources\Wartas\Schemas;

use App\Ai\Agents\PenulisBerita;
use App\Models\Timeline;
use App\Models\Warta;
use Carbon\Carbon;
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
use Illuminate\Support\Str;

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
                        ->helperText('Gunakan judul yang jelas, informatif, dan menarik.')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        // Slug otomatis hanya saat membuat data baru,
                        // agar URL berita yang sudah terbit tidak berubah.
                        ->afterStateUpdated(
                            fn(Set $set, ?string $state, string $operation) =>
                            $operation === 'create'
                                ? $set('slug_url', Str::slug($state ?? ''))
                                : null
                        )
                        ->columnSpanFull(),

                    TextInput::make('slug_url')
                        ->label('Slug URL')
                        ->placeholder('slug-otomatis-dari-judul')
                        ->helperText('URL dibuat otomatis dari judul saat data baru dibuat.')
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
                        ->placeholder('Tuliskan ringkasan atau paragraf pembuka berita...')
                        ->helperText('Ringkasan singkat yang menjelaskan inti berita.')
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

            Section::make('Publikasi dan Penjadwalan')
                ->description('Atur status naskah dan jadwal penayangan.')
                ->icon('heroicon-o-calendar-days')
                ->schema([
                    DatePicker::make('jadwal_tayang')
                        ->label('Jadwal Tayang')
                        ->placeholder('Pilih tanggal tayang')
                        ->native(false)
                        ->displayFormat('d F Y')
                        ->required(),

                    // Opsional. Pastikan kolom timeline_id nullable di migration.
                    Select::make('timeline_id')
                        ->label('Agenda / Timeline Liputan')
                        ->relationship(
                            name: 'timeline',
                            titleAttribute: 'event_name'
                        )
                        ->getOptionLabelFromRecordUsing(
                            fn(Timeline $record): string => $record->event_name
                        )
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->placeholder('Pilih agenda liputan')
                        ->helperText('Pilih agenda yang terkait dengan siaran pers ini.'),

                    // Hanya terisi saat create. Untuk keamanan lebih baik,
                    // set juga di mutateFormDataBeforeCreate() pada CreateWarta.
                    Hidden::make('users_id')
                        ->default(fn() => auth()->id()),
                ])
                ->columns(2)
                ->columnSpanFull(),

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
                        ->hintAction(
                            Action::make('generateNewsContent')
                                ->label('Buat dengan AI')
                                ->icon('heroicon-o-sparkles')
                                ->action(function (Get $get, Set $set) {
                                    $judul = $get('judul_siaran_pers');
                                    $lead = $get('lead_berita');

                                    if (blank($judul) || blank($lead)) {
                                        if (blank($judul)) {
                                            Notification::make()
                                                ->title('Isi judul berita terlebih dahulu.')
                                                ->warning()
                                                ->send();
                                        }

                                        if (blank($lead)) {
                                            Notification::make()
                                                ->title('Isi lead berita terlebih dahulu.')
                                                ->warning()
                                                ->send();
                                        }

                                        return;
                                    }

                                    $jadwalTayang = filled($get('jadwal_tayang'))
                                        ? Carbon::parse($get('jadwal_tayang'))
                                        ->translatedFormat('d F Y')
                                        : '-';

                                    $timelineId = $get('timeline_id');
                                    $namaAgenda = filled($timelineId)
                                        ? (Timeline::find($timelineId)?->event_name ?? '-')
                                        : '-';

                                    $prompt = <<<PROMPT
                                    Tulis HANYA badan berita (tanpa judul dan tanpa lead) berdasarkan bahan berikut.

                                    Judul: {$judul}
                                    Lead: {$lead}
                                    Jadwal tayang (tanggal publikasi, bukan tanggal kegiatan): {$jadwalTayang}
                                    Agenda liputan (konteks saja): {$namaAgenda}

                                    Gunakan struktur piramida terbalik. Jangan mengulang judul dan lead
                                    secara verbatim. Jika informasi terbatas, tulis ringkas sesuai fakta.
                                    Pisahkan paragraf dengan satu baris kosong.
                                    PROMPT;

                                    try {
                                        $hasil = trim(
                                            (string) PenulisBerita::make()->prompt($prompt)
                                        );

                                        if (blank($hasil)) {
                                            Notification::make()
                                                ->title('AI tidak menghasilkan konten berita.')
                                                ->warning()
                                                ->send();

                                            return;
                                        }

                                        $html = collect(preg_split('/\R{2,}/', $hasil))
                                            ->map(fn($p) => trim($p))
                                            ->filter()
                                            ->map(fn($p) => '<p>' . nl2br(e($p)) . '</p>')
                                            ->implode('');

                                        $set('badan_berita', $html);

                                        Notification::make()
                                            ->title('Konten berita berhasil dibuat.')
                                            ->body('Mohon periksa kembali sebelum dipublikasikan.')
                                            ->success()
                                            ->send();
                                    } catch (\Throwable $e) {
                                        report($e);

                                        Notification::make()
                                            ->title('Gagal menghasilkan konten berita.')
                                            ->body('Silakan coba lagi beberapa saat.')
                                            ->danger()
                                            ->send();
                                    }
                                })
                        ),
                ])
                ->columnSpanFull(),

            Section::make('Dokumentasi dan Cover')
                ->description('Unggah foto utama untuk kebutuhan publikasi berita.')
                ->icon('heroicon-o-photo')
                ->schema([
                    FileUpload::make('dokumentasi_utama')
                        ->label('Cover Foto')
                        ->image()
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->disk('public')
                        ->directory('Cover_Foto')
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            '16:9',
                            '4:3',
                            '1:1',
                        ])
                        ->maxSize(2048)
                        ->alignCenter()
                        ->imagePreviewHeight('280')
                        ->panelLayout('integrated')
                        ->helperText('Format JPG, PNG, atau WebP. Ukuran maksimal 2 MB.')
                        ->required()
                        ->columnSpanFull(),
                ])
                ->columnSpanFull()
                ->collapsible(),
        ]);
    }
}
