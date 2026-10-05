<?php

namespace App\Filament\Resources\Wartas\Schemas;

use App\Models\Timeline;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WartaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('judul_siaran_pers')
                ->label('Judul Siaran')
                ->required(),
                TextInput::make('slug_url')
                ->label('slug url')
                ->required(),
                TextInput::make('lead_berita')
                ->label('Lead Berita')
                ->required(),
                Textarea::make('badan_berita')
                ->label('Lead Berita')
                ->required(),
                Select::make('status_naskah')
                ->label('status naskah')
                ->options([
                    'Draft Penulis' => 'Draft Penulis',
                    'Perlu Review Koordinator' => 'Perlu Review Koordinator',
                    'Perlu Revisi' => 'Perlu Revisi',
                    'Disetujui' => 'Disetujui',
                    'Sudah Tayang' => 'Sudah Tayang',
                ])
                ->required(),
                DatePicker::make('jadwal_tayang')
                ->label('Jadwal Tayang')
                ->required(),
                Textarea::make('catatan_koreksi')
                ->label('catatan koreksi')
                ->required(),
                Select::make('timeline_id')
                ->options(Timeline::query()->pluck('event_name', 'id'))
                ->required(),
                Select::make('users_id')
                ->options(User::query()->pluck('name', 'id'))
                ->required(),
                 FileUpload::make('dokumentasi_utama')
                ->label('Cover Foto')
                    ->image()
                    ->disk('public')
                    ->directory('Cover_Foto')
                    ->imageEditor()
                    ->maxSize(2040)
                    ->alignCenter()
                ->required(),
                
            ]);
    }
}
