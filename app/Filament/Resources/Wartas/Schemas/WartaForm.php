<?php

namespace App\Filament\Resources\Wartas\Schemas;

use App\Models\User;
use App\Models\Warta;
use App\Models\Timeline;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use App\Ai\Agents\PenulisBerita;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;

class WartaForm
{
    public static function configure(Schema $schema): Schema
    {
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
                            ->columnSpanFull(),

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
                            ->columnSpanFull(),

                        Textarea::make('lead_berita')
                            ->label('Lead Berita')
                            ->placeholder('Tuliskan ringkasan atau paragraf pembuka berita...')
                            ->helperText('Ringkasan singkat yang menjelaskan inti berita.')
                            ->required()
                            ->maxLength(500)
                            ->columnSpanFull(),
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

                            ->hintAction(
                                Action::make('generateNewsContent')
                                    ->label('Buat dengan AI')
                                    ->icon('heroicon-o-sparkles')
                                    ->action(function (Get $get, Set $set) {
                                        $judul = $get('judul_siaran_pers');
                                        $lead = $get('lead_berita');

                                        if (blank($judul) || blank($lead)) {
                                            Notification::make()
                                                ->title('Isi judul atau lead berita terlebih dahulu.')
                                                ->warning()
                                                ->send();

                                            return;
                                        }

                                        $prompt = "Buat isi lengkap siaran pers berdasarkan data berikut:\n"
                                            . "Judul berita: " . ($judul ?: '-') . "\n"
                                            . "Lead berita: " . ($lead ?: '-') . "\n"
                                            . "\nKetentuan penulisan:\n"
                                            . "- Gunakan bahasa Indonesia formal dan baku.\n"
                                            . "- Gunakan gaya jurnalistik untuk instansi pemerintah.\n"
                                            . "- Susun isi berita secara runtut dan mudah dipahami.\n"
                                            . "- Pertahankan fakta yang tersedia dalam bahan sumber.\n"
                                            . "- Jangan mengarang nama, jabatan, tanggal, lokasi, angka, "
                                            . "kutipan, pernyataan, atau fakta lain yang tidak diberikan.\n"
                                            . "- Jangan menganggap informasi dalam judul atau lead "
                                            . "sebagai dasar untuk menciptakan fakta tambahan.\n"
                                            . "- Jika informasi tidak cukup untuk menyusun berita lengkap, "
                                            . "hasilkan hanya uraian berdasarkan informasi yang tersedia.\n"
                                            . "- Jangan mengulang judul sebagai isi berita.\n"
                                            . "- Jawab hanya dengan isi berita, tanpa pengantar, "
                                            . "markdown, atau tanda kutip.";

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

                                            $set('badan_berita', nl2br(e($hasil)));

                                            Notification::make()
                                                ->title('Konten berita berhasil dibuat.')
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
                            )

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
                            ->default('Draft Penulis')
                            ->placeholder('Pilih status naskah')
                            ->native(false)
                            ->required(),

                        DatePicker::make('jadwal_tayang')
                            ->label('Jadwal Tayang')
                            ->placeholder('Pilih tanggal tayang')
                            ->native(false)
                            ->displayFormat('d F Y')
                            ->required(),

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
                            ->required(),

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
                    ->columnSpanFull(),

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
                            ->columnSpanFull(),

                        // Textarea::make('catatan_koreksi')
                        //     ->label('Catatan Koreksi')
                        //     ->placeholder('Tuliskan catatan revisi, masukan editor, atau arahan publikasi...')
                        //     ->helperText('Catatan untuk penulis atau koordinator terkait perbaikan naskah.')
                        //     ->rows(4)
                        //     ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->collapsible(),

            ]);
    }
}
