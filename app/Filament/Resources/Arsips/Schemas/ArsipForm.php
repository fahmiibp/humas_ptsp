<?php

namespace App\Filament\Resources\Arsips\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ArsipForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('file_name')
                
            ]);
    }
}
