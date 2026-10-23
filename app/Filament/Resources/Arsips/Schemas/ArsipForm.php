<?php

namespace App\Filament\Resources\Arsips\Schemas;

use App\Ai\Agents\PenulisArsip;
use App\Ai\Agents\JudulArsip;
use App\Models\Timeline;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
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
                            ->maxLength(255)
                            ->hintAction(
                                Action::make('generateTitle')
                                    ->label('Saran Judul dengan AI')
                                    ->icon('heroicon-o-sparkles')
                                    ->action(function (Get $get, Set $set) {
                                        $kegiatan = Timeline::find($get('id_timeline'))?->event_name;

                                        if (blank($kegiatan)) {
                                            Notification::make()
                                                ->title('Pilih Nama Kegiatan terlebih dahulu.')
                                                ->warning()
                                                ->send();

                                            return;
                                        }

                                        $tanggal = $get('event_date')
                                            ? Carbon::parse($get('event_date'))
                                            ->locale('id')
                                            ->translatedFormat('d F Y')
                                            : null;

                                        $prompt = "Buat satu judul arsip dokumentasi berdasarkan data berikut:\n"
                                            . "Nama kegiatan: {$kegiatan}\n"
                                            . ($tanggal ? "Tanggal kegiatan: {$tanggal}\n" : '')
                                            . "\nJudul harus mengikuti ketentuan berikut:\n"
                                            . "- Gunakan pola 'Arsip Kegiatan [nama kegiatan]'.\n"
                                            . "- Gunakan bahasa Indonesia formal dan ringkas.\n"
                                            . "- Pertahankan inti nama kegiatan.\n"
                                            . "- Jangan menambahkan fakta yang tidak tersedia.\n"
                                            . "- Maksimal 12 kata jika memungkinkan.\n"
                                            . "- Jawab hanya dengan judul, tanpa penjelasan atau tanda kutip.";

                                        try {
                                            $hasil = trim((string) JudulArsip::make()->prompt($prompt));

                                            if (blank($hasil)) {
                                                Notification::make()
                                                    ->title('AI tidak menghasilkan judul.')
                                                    ->warning()
                                                    ->send();

                                                return;
                                            }

                                            $set('title', mb_substr($hasil, 0, 255));

                                            Notification::make()
                                                ->title('Judul arsip berhasil dibuat.')
                                                ->success()
                                                ->send();
                                        } catch (\Throwable $e) {
                                            report($e);

                                            Notification::make()
                                                ->title('Gagal menghubungi AI. Coba lagi beberapa saat.')
                                                ->danger()
                                                ->send();
                                        }
                                    })
                            )
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
                            ->hintAction(
                                Action::make('generateNotes')
                                    ->label('Buat dengan AI')
                                    ->icon('heroicon-o-sparkles')
                                    ->action(function (Get $get, Set $set) {
                                        $kegiatan = Timeline::find($get('id_timeline'))?->event_name;
                                        $judul = $get('title');

                                        if (! $kegiatan || ! $judul) {
                                            Notification::make()
                                                ->title('Isi Nama Kegiatan dan Judul Arsip terlebih dahulu.')
                                                ->warning()
                                                ->send();

                                            return;
                                        }

                                        $tanggal = $get('event_date')
                                            ? Carbon::parse($get('event_date'))->locale('id')->translatedFormat('d F Y')
                                            : null;

                                        $fotografer = $get('photograper_name')
                                            ? User::find($get('photograper_name'))?->name
                                            : null;

                                        $catatanAwal = $get('notes');

                                        $prompt = "Buat deskripsi arsip dokumentasi dalam bentuk paragraf yang "
                                            . "jelas, informatif, formal, dan mudah dipahami berdasarkan data berikut.\n\n"
                                            . "Kegiatan: {$kegiatan}\n"
                                            . "Judul: {$judul}\n"
                                            . ($tanggal ? "Tanggal: {$tanggal}\n" : '')
                                            . ($fotografer ? "Fotografer: {$fotografer}\n" : '')
                                            . ($catatanAwal ? "Catatan awal staf: {$catatanAwal}\n" : '')
                                            . "\nKetentuan:\n"
                                            . "- Tulis dalam bentuk deskripsi naratif yang mengalir.\n"
                                            . "- Gunakan bahasa Indonesia yang baku dan profesional.\n"
                                            . "- Jelaskan kegiatan dan konteks dokumentasi berdasarkan data yang tersedia.\n"
                                            . "- Gabungkan informasi yang relevan menjadi paragraf yang padu.\n"
                                            . "- Jangan gunakan poin-poin, daftar, atau judul tambahan.\n"
                                            . "- Jangan mengarang informasi yang tidak tersedia dalam data.\n"
                                            . "- Jika informasi terbatas, buat deskripsi singkat yang tetap bermakna.\n"
                                            . "- Keluarkan hanya teks deskripsi tanpa pengantar tambahan.";
                                        try {
                                            $hasil = (string) PenulisArsip::make()->prompt($prompt);

                                            $set('notes', trim($hasil));
                                        } catch (\Throwable $e) {
                                            report($e);

                                            Notification::make()
                                                ->title('Gagal menghubungi AI. Coba lagi beberapa saat.')
                                                ->danger()
                                                ->send();
                                        }
                                    })
                            )
                            ->dehydrateStateUsing(
                                fn($state) => $state ?? ''
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
