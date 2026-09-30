<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('avatar')
                    ->label('unggah_avatar')
                    ->image()
                    ->avatar()
                    ->disk('public')
                    ->directory('Foto_profile')
                    ->circleCropper()
                    ->imageEditor()
                    ->maxSize(2040)
                    ->alignCenter(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->label('Kata Sandi')
                    ->password()
                    ->revealable()
                    // Password hanya wajib saat buat akun baru, opsional saat diedit
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->dehydrated(fn(?string $state): bool => filled($state))
                    ->maxLength(255)
                    ->helperText(
                        fn(string $operation): string =>
                        $operation === 'edit' ? 'Kosongkan jika tidak ingin mengubah kata sandi.' : ''
                    ),
                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->required(),
            ]);
    }
}
