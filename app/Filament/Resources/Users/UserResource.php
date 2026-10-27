<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Pages\ViewUser;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Schemas\UserInfolist;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\GlobalSearch\Actions\Action;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class UserResource extends Resource
{
    // Pengelompokan & Urutan Navigasi Sidebar
    protected static string | UnitEnum | null $navigationGroup = 'Pengaturan Sistem';

    protected static ?int $navigationSort = 1;

    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::Users;

    protected static ?string $navigationLabel = 'Manajemen Pengguna';

    protected static ?string $modelLabel = 'Pengguna';

    protected static ?string $pluralModelLabel = 'Daftar Pengguna';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            // Bisa diisi ActivitylogRelationManager::class jika menggunakan Spatie Activitylog
        ];
    }

    /**
     * Mencegah N+1 query problem saat menampilkan relasi roles di tabel & infolist
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['roles']);
    }

    /**
     * Badge jumlah pengguna di sidebar navigasi dengan styling warna
     */
    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Total pengguna terdaftar di sistem';
    }

    /**
     * Global Search: Kolom yang diindeks saat user mencari lewat shortcut (Ctrl + K)
     */
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'roles.name'];
    }

    /**
     * Tampilan judul pada hasil Global Search
     */
    public static function getGlobalSearchResultTitle(Model $record): string | Htmlable
    {
        return $record->name;
    }

    /**
     * Detail pelengkap pada hasil pencarian global (Email & Role)
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Email' => $record->email,
            'Peran' => $record->roles->pluck('name')->implode(', ') ?: 'Tanpa Peran',
        ];
    }

    /**
     * Aksi cepat langsung dari jendela Global Search tanpa perlu masuk ke tabel
     */
    public static function getGlobalSearchResultActions(Model $record): array
    {
        return [
            Action::make('edit')
                ->label('Ubah')
                ->icon('heroicon-m-pencil-square')
                ->url(static::getUrl('edit', ['record' => $record])),
            Action::make('view')
                ->label('Detail')
                ->icon('heroicon-m-eye')
                ->url(static::getUrl('view', ['record' => $record])),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
