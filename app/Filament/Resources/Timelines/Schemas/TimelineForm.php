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
                ->required(),
                DatePicker::make('start_date')
                ->required(),
                DatePicker::make('end_date')
                ->required(),
                TextInput::make('location')
                ->required(),
                Select::make('status')
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
