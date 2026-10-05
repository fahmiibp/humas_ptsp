<?php
namespace App\Filament\Resources\KontenMedsos;
use App\Models\KontenMedsos;
use App\Filament\Resources\KontenMedsos\Pages;
use App\Filament\Resources\KontenMedsos\Schemas\KontenMedsosForm;
use App\Filament\Resources\KontenMedsos\Tables\KontenMedsosTable;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use BackedEnum;
use UnitEnum;
use Illuminate\Database\Eloquent\Model;
class KontenMedsosResource extends Resource
{
    /**
     * Resource tidak muncul sebagai menu sidebar.
     * Akses utama melalui Kalender Konten Medsos.
     */
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $model = KontenMedsos::class;
    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-calendar';
    protected static string|UnitEnum|null $navigationGroup =
        'Produksi Konten';
    protected static ?string $navigationLabel =
        'Rencana Konten Medsos';
    public static function form(Schema $schema): Schema
    {
        return KontenMedsosForm::configure($schema);
    }
    public static function table(Table $table): Table
    {
        return KontenMedsosTable::configure($table);
    }
    public static function getRecordTitle(?Model $record): ?string
    {
        return $record?->judul;
    }
    public static function getModelLabel(): string
    {
        return 'Konten Medsos';
    }
    public static function getPluralModelLabel(): string
    {
        return 'Konten Medsos';
    }
    public static function getPages(): array
    {
        return [
            // WAJIB ADA
            'index' =>
                Pages\ListKontenMedsos::route('/'),
            'create' =>
                Pages\CreateKontenMedsos::route('/create'),
            'edit' =>
                Pages\EditKontenMedsos::route('/{record}/edit'),
            'view' =>
                Pages\ViewKontenMedsos::route('/{record}'),
        ];
    }
}