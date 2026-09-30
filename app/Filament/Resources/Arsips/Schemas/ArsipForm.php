<?php

namespace App\Filament\Resources\Arsips\Schemas;

use App\Models\Timeline;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ArsipForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('id_timeline')
                 ->options(Timeline::query()->pluck('event_name', 'id'))
                 ->label('Nama Kegiatan')
                 ->required(),
                TextInput::make('title')
                ->required(),
                DatePicker::make('event_date')
                ->required(),
                TextInput::make('drive_url')
                ->required(),
                Select::make('photograper_name')
                ->options(User::query()->pluck('name', 'id'))
                ->required(),
                Textarea::make('notes'),
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
