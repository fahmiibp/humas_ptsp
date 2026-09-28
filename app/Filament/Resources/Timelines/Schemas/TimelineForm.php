<?php

namespace App\Filament\Resources\Timelines\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TimelineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('event_name'),
                DatePicker::make('start_date'),
                DatePicker::make('end_date'),
                TextInput::make('location')
            ]);
    }
}
