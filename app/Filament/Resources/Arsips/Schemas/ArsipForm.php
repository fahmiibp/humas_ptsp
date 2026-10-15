<?php

namespace App\Filament\Resources\Arsips\Schemas;

use App\Models\Timeline;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ArsipForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Input Arsip Dokumentasi Liputan')
                    ->description('Masukan Arsip Dokumentasi Liputan')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Select::make('id_timeline')
                            ->options(Timeline::query()->pluck('event_name', 'id'))
                            ->label('Nama Kegiatan')
                            ->placeholder('Masukan Nama Kegiatan')
                            ->helperText('Pilih Nama Kegiatan')
                            ->required(),
                        TextInput::make('title')
                            ->label('Judul')
                            ->placeholder('Contoh : Peresmian Gedung DPMPTSP')
                            ->helperText('Gunakan Kalimat Yang Singkat Saja')
                            ->required(),
                        DatePicker::make('event_date')
                            ->label('Tanggal Kegiatan')
                            ->required(),
                        TextInput::make('drive_url')
                            ->label('Link Google Drive')
                            ->placeholder('Masukan Link Google Drive Disini')
                            ->helperText('Masukan Link Google Drive Disini')
                            ->required(),
                        Select::make('photograper_name')
                            ->label('Nama Fotografer')
                            ->placeholder('Pilih Fotografer')
                            ->options(User::query()->pluck('name', 'id'))
                            ->required(),
                        Textarea::make('notes')
                        ->label('Catatan')
                        ->placeholder('Tambahkan Catatan Jika Diperlukan')
                        ->dehydrateStateUsing(fn ($state) => $state ?? ''),
                        FileUpload::make('sample_photos')
                            ->label('Cover Foto')
                            ->helperText('Pilih atau tarik file gambar ke sini')
                            ->image()
                            ->disk('public')
                            ->directory('Cover_Foto')
                            ->imageEditor()
                            ->maxSize(2040)
                            ->alignCenter(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->collapsible()
            ]);
    }
}
