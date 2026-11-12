<?php

namespace App\Filament\Resources\PortalLinks\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PortalLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Portal')
                    ->placeholder('Contoh: Portal Pemerintah Kota Semarang')
                    ->helperText('Masukkan nama website atau sistem yang akan ditampilkan.')
                    ->required()
                    ->maxLength(150)
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->placeholder('Contoh: Portal layanan informasi dan administrasi pemerintah.')
                    ->helperText('Berikan penjelasan singkat mengenai portal atau website ini.')
                    ->rows(3)
                    ->maxLength(500)
                    ->columnSpanFull(),

                TextInput::make('url')
                    ->label('URL Website')
                    ->placeholder('https://contoh.go.id')
                    ->helperText('Masukkan alamat lengkap website, termasuk https://.')
                    ->url()
                    ->required()
                    ->maxLength(500)
                    ->prefixIcon('heroicon-o-globe-alt')
                    ->columnSpanFull(),

                FileUpload::make('icon')
                    ->label('Ikon Portal')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('portal-icons')
                    ->visibility('public')
                    ->maxSize(2048)
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'image/webp',
                        'image/svg+xml',
                    ])
                    ->helperText('Upload logo atau ikon portal. Format: JPG, PNG, WEBP, atau SVG. Maksimal 2 MB.')
                    ->imagePreviewHeight('120')
                    ->columnSpanFull(),

                TextInput::make('sort_order')
                    ->label('Urutan Tampilan')
                    ->placeholder('Contoh: 1')
                    ->helperText('Angka yang lebih kecil akan tampil lebih dahulu.')
                    ->numeric()
                    ->integer()
                    ->minValue(0)
                    ->default(0)
                    ->required()
                    ->prefixIcon('heroicon-o-bars-3'),

                Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->helperText('Aktifkan jika portal ingin ditampilkan di website.')
                    ->default(true)
                    ->onColor('success')
                    ->offColor('danger')
                    ->inline(false),
            ])
            ->columns(2);
    }
}