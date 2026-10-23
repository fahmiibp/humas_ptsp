<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profil Pengguna')
                    ->description('Kelola foto dan identitas pengguna.')
                    ->icon('heroicon-o-user-circle')
                    ->schema([
                        FileUpload::make('avatar')
                            ->label('Foto Profil')
                            ->image()
                            ->avatar()
                            ->disk('public')
                            ->directory('Foto_profile')
                            ->visibility('public')
                            ->imageEditor()
                            ->circleCropper()
                            ->maxSize(2040)
                            ->alignCenter()
                            ->columnSpanFull()
                            ->helperText('Format gambar JPG, PNG, atau WebP. Maksimal 2 MB.'),

                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->placeholder('Contoh: Budi Santoso')
                            ->required()
                            ->maxLength(255)
                            ->autocomplete('name')
                            ->validationMessages([
                                'required' => 'Nama lengkap wajib diisi.',
                                'max' => 'Nama maksimal 255 karakter.',
                            ]),
                    ])
                    ->columns(2),

                Section::make('Informasi Akun')
                    ->description('Gunakan email aktif untuk identitas login.')
                    ->icon('heroicon-o-envelope')
                    ->schema([
                        TextInput::make('email')
                            ->label('Alamat Email')
                            ->placeholder('nama@email.com')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->autocomplete('email')
                            ->validationMessages([
                                'required' => 'Alamat email wajib diisi.',
                                'email' => 'Masukkan alamat email yang valid.',
                                'unique' => 'Alamat email sudah digunakan.',
                            ]),

                        TextInput::make('password')
                            ->label('Kata Sandi')
                            ->password()
                            ->revealable()
                            ->autocomplete(
                                fn(string $operation): string =>
                                $operation === 'create'
                                    ? 'new-password'
                                    : 'new-password'
                            )
                            ->required(
                                fn(string $operation): bool =>
                                $operation === 'create'
                            )
                            ->dehydrated(
                                fn(?string $state): bool =>
                                filled($state)
                            )
                            ->rule(Password::min(8))
                            ->maxLength(255)
                            ->helperText(
                                fn(string $operation): string =>
                                $operation === 'create'
                                    ? 'Minimal 8 karakter.'
                                    : 'Kosongkan jika tidak ingin mengubah kata sandi.'
                            )
                            ->validationMessages([
                                'required' => 'Kata sandi wajib diisi.',
                                'min' => 'Kata sandi minimal 8 karakter.',
                            ]),
                    ])
                    ->columns(2),

                Section::make('Hak Akses')
                    ->description('Tentukan peran dan hak akses pengguna.')
                    ->icon('heroicon-o-shield-check')
                    ->schema([
                        Select::make('roles')
                            ->label('Peran Pengguna')
                            ->relationship('roles', 'name')
                            // ->multiple()
                            ->preload()
                            ->searchable()
                            ->required()
                            ->placeholder('Pilih satu atau beberapa peran')
                            ->helperText(
                                'Peran menentukan fitur dan akses yang dimiliki pengguna.'
                            )
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
