<?php

namespace App\Filament\Resources\FooterSettings;

use App\Filament\Resources\FooterSettings\Pages\CreateFooterSetting;
use App\Filament\Resources\FooterSettings\Pages\EditFooterSetting;
use App\Filament\Resources\FooterSettings\Pages\ListFooterSettings;
use App\Filament\Resources\FooterSettings\Schemas\FooterSettingForm;
use App\Filament\Resources\FooterSettings\Tables\FooterSettingsTable;
use App\Models\FooterSetting;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FooterSettingResource extends Resource
{
    protected static ?string $model = FooterSetting::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Pengaturan Footer';

    protected static ?string $modelLabel = 'Pengaturan Footer';

    protected static ?string $pluralModelLabel = 'Pengaturan Footer';

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan';

    public static function form(Schema $schema): Schema
    {
        return FooterSettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FooterSettingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFooterSettings::route('/'),
            'create' => CreateFooterSetting::route('/create'),
            'edit' => EditFooterSetting::route('/{record}/edit'),
        ];
    }
}
