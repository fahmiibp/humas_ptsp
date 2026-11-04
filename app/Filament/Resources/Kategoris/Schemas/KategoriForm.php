<?php

namespace App\Filament\Resources\Kategoris\Schemas;

use App\Ai\Agents\PenulisDeskripsiKategori;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class KategoriForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_kategori')
                    ->label('Nama Kategori')
                    ->placeholder('Contoh: Investasi')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (?string $state, Set $set): void {
                        $set('slug', Str::slug($state ?? ''));
                    })
                    ->validationMessages([
                        'required' => 'Nama kategori wajib diisi.',
                        'max' => 'Nama kategori maksimal 255 karakter.',
                    ]),

                TextInput::make('slug')
                    ->label('Slug')
                    ->placeholder('Contoh: investasi')
                    ->required()
                    ->maxLength(255)
                    ->unique(
                        table: 'kategoris',
                        column: 'slug',
                        ignoreRecord: true
                    )
                    ->validationMessages([
                        'required' => 'Slug kategori wajib diisi.',
                        'unique' => 'Slug kategori sudah digunakan.',
                        'max' => 'Slug maksimal 255 karakter.',
                    ]),

                Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->placeholder('Masukkan deskripsi kategori (opsional)')
                    ->helperText('Tampil di halaman kategori dan sebagai meta description.')
                    ->rows(3)
                    ->maxLength(300)
                    ->columnSpanFull()
                    ->hintAction(
                        Action::make('deskripsi_ai')
                            ->label('Buat dengan AI')
                            ->icon('heroicon-o-sparkles')
                            ->action(function (Get $get, Set $set): void {
                                $nama = trim((string) $get('nama_kategori'));

                                if ($nama === '') {
                                    Notification::make()
                                        ->title('Isi nama kategori dulu')
                                        ->warning()
                                        ->send();

                                    return;
                                }

                                try {
                                    $hasil = (new PenulisDeskripsiKategori)->prompt(
                                        'Buat deskripsi untuk kategori berita bernama: ' . mb_substr($nama, 0, 100)
                                    );

                                    $set('deskripsi', mb_substr(trim((string) $hasil), 0, 300));

                                    Notification::make()
                                        ->title('Deskripsi terisi')
                                        ->body('Periksa dan sesuaikan sebelum disimpan.')
                                        ->success()
                                        ->send();
                                } catch (\Throwable $e) {
                                    report($e);

                                    Notification::make()
                                        ->title('AI sedang tidak tersedia')
                                        ->danger()
                                        ->send();
                                }
                            })
                    ),
            ]);
    }
}
