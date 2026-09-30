<?php

namespace App\Filament\Resources\Arsips;

use App\Filament\Resources\Arsips\Pages\CreateArsip;
use App\Filament\Resources\Arsips\Pages\EditArsip;
use App\Filament\Resources\Arsips\Pages\ListArsips;
use App\Filament\Resources\Arsips\Pages\ViewArsip;
use App\Filament\Resources\Arsips\Schemas\ArsipForm;
use App\Filament\Resources\Arsips\Schemas\ArsipInfolist;
use App\Filament\Resources\Arsips\Tables\ArsipsTable;
use App\Models\Arsip;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ArsipResource extends Resource
{
    protected static string | UnitEnum | null $navigationGroup = 'Produksi Konten';

    protected static ?string $model = Arsip::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBoxArrowDown;

    protected static ?string $navigationLabel = 'Arsip Dokumentasi';

    protected static ?string $pluralModelLabel = 'Arsip Dokumentasi Liputan';

    protected static ?string $recordTitleAttribute = 'nama_kegiatan';


    public static function form(Schema $schema): Schema
    {
        return ArsipForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ArsipInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ArsipsTable::configure($table);
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
            'index' => ListArsips::route('/'),
            'create' => CreateArsip::route('/create'),
            'view' => ViewArsip::route('/{record}'),
            'edit' => EditArsip::route('/{record}/edit'),
        ];
    }
}
