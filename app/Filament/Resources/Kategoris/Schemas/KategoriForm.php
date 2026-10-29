<?php

namespace App\Filament\Resources\Kategoris\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class KategoriForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_kategori')
                    ->label('Nama Kategori')
                    ->placeholder('Contoh: Investasi')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (
                        ?string $state,
                        callable $set
                    ): void {
                        $set('slug', Str::slug($state ?? ''));
                    })
                    ->validationMessages([
                        'required' => 'Nama kategori wajib diisi.',
                        'max' => 'Nama kategori maksimal 255 karakter.',
                    ]),

                TextInput::make('slug')
                    ->label('Slug')
                    ->placeholder('Contoh: investasi')
                    ->required()
                    ->maxLength(255)
                    ->unique(
                        table: 'kategoris',
                        column: 'slug',
                        ignoreRecord: true
                    )
                    ->validationMessages([
                        'required' => 'Slug kategori wajib diisi.',
                        'unique' => 'Slug kategori sudah digunakan.',
                        'max' => 'Slug maksimal 255 karakter.',
                    ]),

                Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->placeholder('Masukkan deskripsi kategori (opsional)')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
