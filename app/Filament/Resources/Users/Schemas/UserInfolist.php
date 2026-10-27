<?php

namespace App\Filament\Resources\Users\Schemas;


use Filament\Infolists\Components\ImageEntry;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;

class UserInfolist
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
                    // Kartu Profil & Hak Akses (Kolom Kiri)
                    Section::make('Profil Pengguna')
                        ->columnSpan(['lg' => 1])
                        ->schema([
                            ImageEntry::make('avatar')
                                ->hiddenLabel()
                                ->disk('public')
                                ->circular()
                                ->extraImgAttributes(['class' => 'mx-auto shadow-md'])
                                ->defaultImageUrl(fn ($record): string =>
                                    'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name=' . urlencode($record->name)
                                )
                                ->alignCenter(),

                            TextEntry::make('name')
                                ->hiddenLabel()
                                ->weight('bold')
                                ->size(TextSize::Large)
                                ->alignCenter(),

                            TextEntry::make('roles.name')
                                ->hiddenLabel()
                                ->badge()
                                ->color(fn (string $state): string => match (strtolower($state)) {
                                    'super_admin', 'admin' => 'danger',
                                    'editor', 'manager' => 'warning',
                                    'staff' => 'info',
                                    default => 'gray',
                                })
                                ->separator(',')
                                ->alignCenter(),
                        ]),

                    // Data Akun & Riwayat Aktivitas (Kolom Kanan)
                    Grid::make(1)
                        ->columnSpan(['lg' => 2])
                        ->schema([
                            Section::make('Informasi Akun & Keamanan')
                                ->icon('heroicon-m-user-circle')
                                ->columns(2)
                                ->schema([
                                    TextEntry::make('email')
                                        ->label('Alamat Email')
                                        ->icon('heroicon-m-envelope')
                                        ->copyable()
                                        ->copyMessage('Email disalin ke clipboard!'),

                                    TextEntry::make('email_verified_at')
                                        ->label('Status Verifikasi')
                                        ->badge()
                                        ->icon(fn ($state): string => $state ? 'heroicon-m-check-badge' : 'heroicon-m-x-circle')
                                        ->color(fn ($state): string => $state ? 'success' : 'danger')
                                        ->formatStateUsing(fn ($state): string =>
                                            $state ? 'Terverifikasi (' . \Carbon\Carbon::parse($state)->translatedFormat('d M Y') . ')' : 'Belum Diverifikasi'
                                        ),
                                ]),

                            Section::make('Riwayat & Aktivitas Akun')
                                ->icon('heroicon-m-clock')
                                ->columns(2)
                                ->schema([
                                    TextEntry::make('created_at')
                                        ->label('Tanggal Registrasi')
                                        ->dateTime('d F Y, H:i')
                                        ->helperText(fn ($record): string => $record->created_at ? $record->created_at->diffForHumans() : '-'),

                                    TextEntry::make('updated_at')
                                        ->label('Terakhir Diperbarui')
                                        ->dateTime('d F Y, H:i')
                                        ->helperText(fn ($record): string => $record->updated_at ? $record->updated_at->diffForHumans() : '-'),
                                ]),
                        ]),
                ])->columnSpanFull(),
            ]);
    }
}
