<?php

namespace App\Filament\Resources\FooterSettings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FooterSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /*
                |--------------------------------------------------------------------------
                | LOGO
                |--------------------------------------------------------------------------
                */
                Section::make('Logo')
                    ->description('Logo yang ditampilkan pada footer website.')
                    ->schema([
                        FileUpload::make('logo')
                            ->label('Logo Footer')
                            ->image()
                            ->disk('public')
                            ->directory('footer')
                            ->imagePreviewHeight('120')
                            ->maxSize(2048)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                /*
                |--------------------------------------------------------------------------
                | INFORMASI ALAMAT
                |--------------------------------------------------------------------------
                */
                Section::make('Informasi Alamat')
                    ->description('Informasi alamat kantor yang ditampilkan pada footer.')
                    ->schema([
                        Textarea::make('alamat')
                            ->label('Alamat')
                            ->rows(4)
                            ->placeholder('Masukkan alamat kantor...')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                /*
                |--------------------------------------------------------------------------
                | KONTAK
                |--------------------------------------------------------------------------
                */
                Section::make('Kontak')
                    ->description('Informasi kontak yang ditampilkan pada footer.')
                    ->schema([
                        TextInput::make('email')
                            ->label('E-mail')
                            ->email()
                            ->placeholder('contoh@email.go.id'),

                        TextInput::make('telepon_1')
                            ->label('Telepon 1')
                            ->placeholder('(024) 0000000'),

                        TextInput::make('telepon_2')
                            ->label('Telepon 2')
                            ->placeholder('(024) 0000000'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                /*
                |--------------------------------------------------------------------------
                | MEDIA SOSIAL
                |--------------------------------------------------------------------------
                */
                Section::make('Media Sosial')
                    ->description('Masukkan URL media sosial. Kosongkan jika tidak digunakan.')
                    ->schema([
                        TextInput::make('instagram')
                            ->label('Instagram')
                            ->url()
                            ->placeholder('https://instagram.com/...'),

                        TextInput::make('facebook')
                            ->label('Facebook')
                            ->url()
                            ->placeholder('https://facebook.com/...'),

                        TextInput::make('youtube')
                            ->label('YouTube')
                            ->url()
                            ->placeholder('https://youtube.com/...'),

                        TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->placeholder('628xxxxxxxxxx')
                            ->helperText('Masukkan nomor WhatsApp tanpa tanda + atau spasi.'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                /*
                |--------------------------------------------------------------------------
                | DESKRIPSI MEDIA SOSIAL
                |--------------------------------------------------------------------------
                */
                Section::make('Deskripsi Media Sosial')
                    ->schema([
                        Textarea::make('deskripsi_sosial')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->placeholder(
                                'Dapatkan informasi terbaru melalui media sosial kami.'
                            )
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                /*
                |--------------------------------------------------------------------------
                | COPYRIGHT
                |--------------------------------------------------------------------------
                */
                Section::make('Copyright')
                    ->description('Teks yang ditampilkan pada bagian paling bawah footer.')
                    ->schema([
                        TextInput::make('copyright')
                            ->label('Copyright')
                            ->placeholder('PTSP'),

                        TextInput::make('dikelola_oleh')
                            ->label('Dikelola Oleh')
                            ->placeholder('Dikelola oleh PTSP'),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText(
                                'Jika tidak aktif, pengaturan ini tidak digunakan pada frontend.'
                            ),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

            ]);
    }
}