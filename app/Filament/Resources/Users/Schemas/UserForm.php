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
                    ->label('Avatar')
                    ->image()
                    ->avatar()
                    ->disk('public')
                    ->directory('Foto_profile')
                    ->circleCropper()
                    ->imageEditor()
                    ->maxSize(2040)
                    ->alignCenter(),
                TextInput::make('name')
                    ->label('Nama')
                    ->required(),
                TextInput::make('email')
                    ->label('Alamat Email')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at')
                    ->label('Waktu Verifikasi Email'),
                TextInput::make('password')
                    ->label('Kata Sandi')
                    ->password()
                    ->revealable()
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->dehydrated(fn(?string $state): bool => filled($state))
                    ->maxLength(255)
                    ->helperText(
                        fn(string $operation): string =>
                            $operation === 'edit' ? 'Kosongkan jika tidak ingin mengubah kata sandi.' : ''
                    ),
                Select::make('roles')
                    ->label('Peran')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->required(),
            ]);
    }
}