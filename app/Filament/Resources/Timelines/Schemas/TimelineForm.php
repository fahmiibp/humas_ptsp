<?php

namespace App\Filament\Resources\Timelines\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Callout;
use Filament\Schemas\Schema;

class TimelineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('event_name')
                    ->label('Nama Kegiatan')
                    ->required(),

                TextInput::make('location')
                    ->label('Lokasi')
                    ->required(),

                DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->required(),
             
                DatePicker::make('end_date')
                    ->label('Tanggal Selesai')
                    ->required(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'Belum Mulai' => 'Belum Mulai',
                        'Sedang Berlangsung' => 'Sedang Berlangsung',
                        'Selesai' => 'Selesai',
                        'Batal' => 'Batal',
                    ])
                    ->default('Belum Mulai')
                    ->required()
            ]);
    }
}