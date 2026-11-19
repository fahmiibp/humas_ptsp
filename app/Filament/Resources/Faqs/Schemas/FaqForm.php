<?php

namespace App\Filament\Resources\Faqs\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('pertanyaan')
                    ->label('Pertanyaan')
                    ->placeholder('Masukkan pertanyaan FAQ')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                RichEditor::make('jawaban')
                    ->label('Jawaban')
                    ->placeholder('Masukkan jawaban FAQ')
                    ->required()
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'bulletList',
                        'orderedList',
                        'link',
                        'undo',
                        'redo',
                    ]),

                Toggle::make('is_active')
                    ->label('Tampilkan di Website')
                    ->default(true)
                    ->helperText(
                        'Aktifkan agar FAQ tampil di halaman website.'
                    ),

                TextInput::make('urutan')
                    ->label('Urutan')
                    ->numeric()
                    ->integer()
                    ->default(0)
                    ->minValue(0)
                    ->helperText(
                        'Angka lebih kecil akan ditampilkan lebih dahulu.'
                    ),
            ]);
    }
}