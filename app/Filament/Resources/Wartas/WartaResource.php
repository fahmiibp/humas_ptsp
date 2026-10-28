<?php

namespace App\Filament\Resources\Wartas;


use App\Filament\Resources\Wartas\Pages\CreateWarta;
use App\Filament\Resources\Wartas\Pages\EditWarta;
use App\Filament\Resources\Wartas\Pages\ListWartas;
use App\Filament\Resources\Wartas\Pages\ViewWarta;
use App\Filament\Resources\Wartas\Schemas\WartaForm;
use App\Filament\Resources\Wartas\Schemas\WartaInfolist;
use App\Filament\Resources\Wartas\Tables\WartasTable;
use App\Models\Warta;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
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

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = Auth::user();

        if (! $user) {
            return $query->whereRaw('1 = 0');
        }

        if ($user->hasAnyRole(['Admin', 'admin', 'super_admin', 'Super Admin', 'Admin Publikasi'])) {
            return $query;
        }

        if ($user->hasAnyRole(['Verifikator', 'Koordinator'])) {
            return $query->where('status_naskah', 'Perlu Review Koordinator');
        }

        if ($user->hasRole('Penulis')) {
            return $query->where('users_id', $user->getKey());
        }

        return $query->whereRaw('1 = 0');
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->hasAnyRole([
            'Penulis',
            'Admin',
            'admin',
            'super_admin',
            'Super Admin',
            'Admin Publikasi',
        ]) ?? false;
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        if (! $user) {
            return false;
        }

        // Penulis hanya boleh mengedit naskah miliknya
        // saat masih berupa draft atau perlu revisi.
        $isOwner = (int) $record->users_id === (int) $user->id;

        $isEditableStatus = in_array(
            $record->status_naskah,
            ['Draft Penulis', 'Perlu Revisi'],
            true
        );

        return $isOwner && $isEditableStatus;
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        $user = Auth::user();

        return (bool) $user
            && $user->hasAnyRole(['Admin', 'admin', 'super_admin', 'Super Admin'])
            && $record->status_naskah !== 'Sudah Tayang';
    }

    public static function infolist(Schema $schema): Schema
    {
        return WartaInfolist::configure($schema);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWartas::route('/'),
            'create' => CreateWarta::route('/create'),
            'view' => ViewWarta::route('/{record}'),
            'edit' => EditWarta::route('/{record}/edit'),
        ];
    }
}
