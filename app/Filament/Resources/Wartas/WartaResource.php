<?php

namespace App\Filament\Resources\Wartas;

use App\Filament\Resources\Wartas\Pages\CreateWarta;
use App\Filament\Resources\Wartas\Pages\EditWarta;
use App\Filament\Resources\Wartas\Pages\ListWartas;
use App\Filament\Resources\Wartas\Schemas\WartaForm;
use App\Filament\Resources\Wartas\Tables\WartasTable;
use App\Models\Warta;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class WartaResource extends Resource
{
    protected static ?string $model = Warta::class;

    protected static string | UnitEnum | null $navigationGroup = 'Produksi Konten';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedGlobeAlt;

    // Diubah ke nama kolom tabel agar fitur pencarian global berfungsi
    protected static ?string $recordTitleAttribute = 'judul_siaran_pers';

    public static function form(Schema $schema): Schema
    {
        return WartaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WartasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWartas::route('/'),
            'create' => CreateWarta::route('/create'),
            'edit' => EditWarta::route('/{record}/edit'),
        ];
    }
}