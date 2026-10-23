<?php

namespace App\Filament\Resources\Timelines\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use App\Ai\Agents\PenulisKegiatan;
use App\Support\AiHelper;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Facades\Gate;

class TimelineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kegiatan')
                    ->description('Isi data utama kegiatan yang akan dijadwalkan.')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('event_name')
                            ->label('Nama Kegiatan')
                            ->placeholder('Contoh: CJIBF 2026 - Pembukaan & Pitching Session')
                            ->helperText(
                                'Gunakan nama resmi kegiatan. Tambahkan lokasi singkat jika relevan dan tersedia.'
                            )
                            ->hintAction(
                                Action::make('rapikanNama')
                                    ->label('Rapikan dengan AI')
                                    ->icon(Heroicon::OutlinedSparkles)
                                    ->action(function (Get $get, Set $set) {
                                        $namaKegiatan = trim((string) $get('event_name'));

                                        if (blank($namaKegiatan)) {
                                            Notification::make()
                                                ->title('Ketik nama kegiatan terlebih dahulu.')
                                                ->warning()
                                                ->send();

                                            return;
                                        }

                                        try {
                                            $hasil = AiHelper::tanya(
                                                PenulisKegiatan::class,
                                                "Rapikan nama kegiatan berikut sesuai format baku "
                                                    . "penamaan arsip dokumentasi instansi pemerintah.\n\n"
                                                    . "Nama kegiatan: {$namaKegiatan}\n\n"
                                                    . "Pertahankan nama acara, sesi, dan tahun yang tersedia. "
                                                    . "Cantumkan lokasi singkat hanya jika disebutkan. "
                                                    . "Jangan menambahkan informasi baru. "
                                                    . "Keluarkan hanya nama kegiatan yang sudah dirapikan."
                                            );

                                            if (blank($hasil)) {
                                                Notification::make()
                                                    ->title('Nama kegiatan gagal dirapikan.')
                                                    ->warning()
                                                    ->send();

                                                return;
                                            }

                                            $set('event_name', trim($hasil));

                                            Notification::make()
                                                ->title('Nama kegiatan berhasil dirapikan.')
                                                ->success()
                                                ->send();
                                        } catch (\Throwable $e) {
                                            report($e);

                                            Notification::make()
                                                ->title('Gagal menghubungi AI. Silakan coba lagi.')
                                                ->danger()
                                                ->send();
                                        }
                                    })
                            )
                            ->maxLength(255)
                            ->required()
                            ->columnSpanFull(),

                        TextInput::make('location')
                            ->label('Lokasi')
                            ->placeholder('Contoh: Aula Kantor Lantai 2')
                            ->helperText('Tempat kegiatan berlangsung (atau tautan jika dilakukan online).')
                            ->prefixIcon('heroicon-o-map-pin')
                            ->maxLength(255)
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('Jadwal & Status')
                    ->description('Tentukan waktu pelaksanaan dan kondisi kegiatan saat ini.')
                    ->icon('heroicon-o-calendar-days')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        DatePicker::make('start_date')
                            ->label('Tanggal Mulai')
                            ->placeholder('Pilih tanggal mulai')
                            ->helperText('Hari pertama kegiatan dilaksanakan.')
                            ->native(false)
                            ->displayFormat('d F Y')
                            ->prefixIcon('heroicon-o-calendar')
                            ->live()
                            ->required(),

                        DatePicker::make('end_date')
                            ->label('Tanggal Selesai')
                            ->placeholder('Pilih tanggal selesai')
                            ->helperText('Tidak boleh lebih awal dari tanggal mulai.')
                            ->native(false)
                            ->displayFormat('d F Y')
                            ->prefixIcon('heroicon-o-calendar')
                            ->minDate(fn(callable $get) => $get('start_date'))
                            ->afterOrEqual('start_date')
                            ->required(),

                        Select::make('status')
                            ->label('Status')
                            ->placeholder('Pilih status kegiatan')
                            ->helperText('Perbarui status sesuai perkembangan kegiatan.')
                            ->options([
                                'Belum Mulai'        => 'Belum Mulai',
                                'Sedang Berlangsung' => 'Sedang Berlangsung',
                                'Selesai'            => 'Selesai',
                                'Batal'              => 'Batal',
                            ])
                            ->native(false)
                            ->default('Belum Mulai')
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
