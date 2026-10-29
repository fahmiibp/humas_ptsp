<?php

namespace App\Filament\Resources\SocialLinks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SocialLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Media Sosial')
                    ->placeholder('Contoh: Instagram, Facebook, WhatsApp')
                    ->helperText('Masukkan nama platform media sosial.')
                    ->required(),

                TextInput::make('url')
                    ->label('URL Media Sosial')
                    ->placeholder('https://instagram.com/akunanda')
                    ->helperText('Masukkan URL lengkap akun media sosial.')
                    ->url()
                    ->required(),

                TextInput::make('icon')
                    ->label('Nama Ikon')
                    ->placeholder('Contoh: instagram, facebook, whatsapp')
                    ->helperText('Gunakan nama ikon yang sesuai dengan komponen Blade.')
                    ->default(null),

                Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->helperText('Aktifkan agar ikon ditampilkan di website.')
                    ->default(true)
                    ->required(),

                TextInput::make('sort_order')
                    ->label('Urutan Tampilan')
                    ->placeholder('Contoh: 1')
                    ->helperText('Angka lebih kecil ditampilkan lebih dahulu.')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }
}
