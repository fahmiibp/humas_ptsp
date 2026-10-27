<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make([
                    'default' => 1,
                    'lg' => 3,
                ])
                ->schema([
                    // Kolom Kiri / Samping: Foto Profil & Hak Akses
                    Section::make('Identitas Visual & Akses')
                        ->description('Foto profil dan penetapan hak akses akun.')
                        ->columnSpan(['lg' => 1])
                        ->schema([
                            FileUpload::make('avatar')
                                ->label('Foto Profil')
                                ->image()
                                ->avatar()
                                ->hiddenLabel()
                                ->disk('public')
                                ->directory('Foto_profile')
                                ->circleCropper()
                                ->imageEditor()
                                ->maxSize(2048)
                                ->alignCenter()
                                ->helperText('Format: JPG/PNG, maks 2MB.'),

                            Select::make('roles')
                                ->label('Peran / Hak Akses')
                                ->relationship('roles', 'name')
                                ->multiple()
                                ->preload()
                                ->searchable()
                                ->required()
                                ->native(false)
                                ->placeholder('Pilih peran pengguna')
                                ->helperText('Tentukan izin dan role yang dimiliki.'),
                        ]),

                    // Kolom Utama: Kredensial & Biodata
                    Section::make('Informasi Akun')
                        ->description('Data dasar dan keamanan login pengguna.')
                        ->columnSpan(['lg' => 2])
                        ->columns(2)
                        ->schema([
                            TextInput::make('name')
                                ->label('Nama Lengkap')
                                ->placeholder('Masukkan nama lengkap')
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull(),

                            TextInput::make('email')
                                ->label('Alamat Email')
                                ->email()
                                ->placeholder('contoh@domain.com')
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true)
                                ->columnSpanFull(),

                            TextInput::make('password')
                                ->label('Kata Sandi')
                                ->password()
                                ->revealable()
                                ->required(fn(string $operation): bool => $operation === 'create')
                                ->dehydrated(fn(?string $state): bool => filled($state))
                                ->maxLength(255)
                                ->autocomplete('new-password')
                                ->helperText(
                                    fn(string $operation): string =>
                                        $operation === 'edit'
                                            ? 'Biarkan kosong jika tidak ingin mengganti kata sandi.'
                                            : 'Gunakan minimal 8 karakter kombinasi huruf dan angka.'
                                )
                                ->columnSpanFull(),
                        ]),
                ])->columnSpanFull(),
            ]);
    }
}
