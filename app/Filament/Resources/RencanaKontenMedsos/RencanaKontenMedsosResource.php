<?php

namespace App\Filament\Resources\RencanaKontenMedsos;

use App\Filament\Resources\RencanaKontenMedsos\Pages\CreateRencanaKontenMedsos;
use App\Filament\Resources\RencanaKontenMedsos\Pages\EditRencanaKontenMedsos;
use App\Filament\Resources\RencanaKontenMedsos\Pages\ListRencanaKontenMedsos;
use App\Filament\Resources\RencanaKontenMedsos\Schemas\RencanaKontenMedsosForm;
use App\Filament\Resources\RencanaKontenMedsos\Tables\RencanaKontenMedsosTable;
use App\Models\KontenMedsos;
use App\Models\RencanaKontenMedsos;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RencanaKontenMedsosResource extends Resource
{
    protected static string|UnitEnum|null $navigationGroup = 'Produksi Konten';
    protected static ?string $model = KontenMedsos::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $navigationLabel = 'Rencana Konten Medsos';

    public static function form(Schema $schema): Schema
    {
        return RencanaKontenMedsosForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RencanaKontenMedsosTable::configure($table);
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
            'index' => ListRencanaKontenMedsos::route('/'),
            'create' => CreateRencanaKontenMedsos::route('/create'),
            'edit' => EditRencanaKontenMedsos::route('/{record}/edit'),
        ];
    }
    
}
