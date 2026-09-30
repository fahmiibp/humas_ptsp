<?php

namespace App\Filament\Resources\Arsips\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ArsipForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title'),
                DatePicker::make('event_date'),
                TextInput::make('drive_url'),
                TextInput::make('photograper_name'),
                TextInput::make('notes'),
                FileUpload::make('sample_photos')
                ->label('Cover Foto')
                    ->image()
                    ->disk('public')
                    ->directory('Cover_Foto')
                    ->imageEditor()
                    ->maxSize(2040)
                    ->alignCenter(),
            ]);
    }
}
