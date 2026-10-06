<?php

namespace App\Filament\Resources\Wartas\Schemas;

use App\Models\Timeline;
use App\Models\User;
use App\Models\Warta;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class WartaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('judul_siaran_pers')
                    ->label('Judul Siaran')
                    ->placeholder('Contoh: DPMPTSP Jateng Catat Realisasi Investasi Kuartal I Lampaui Target')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug_url', \Illuminate\Support\Str::slug($state)))
                    ->required(),
                TextInput::make('slug_url')
                    ->label('slug url')
                    ->label('Slug URL')
                    ->placeholder('slug-otomatis-dari-judul')
                    ->required()
                    ->unique(Warta::class, 'slug', ignoreRecord: true)
                    ->maxLength(255)
                    ->prefix(url('/warta') . '/')
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
