<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use STS\FilamentImpersonate\Actions\Impersonate;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                ImageColumn::make('avatar')
                    ->label('')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(fn ($record): string =>
                        'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name=' . urlencode($record->name)
                    )
                    ->grow(false),

                TextColumn::make('name')
                    ->label('Pengguna')
                    ->searchable(['name', 'email'])
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record): string => $record->email ?? '-')
                    ->copyable()
                    ->copyableState(fn ($record): string => $record->email)
                    ->copyMessage('Alamat email disalin!')
                    ->copyMessageDuration(1500),

                TextColumn::make('roles.name')
                    ->label('Peran / Hak Akses')
                    ->badge()
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'super_admin', 'admin' => 'danger',
                        'editor', 'manager' => 'warning',
                        'staff' => 'info',
                        default => 'gray',
                    })
                    ->separator(',')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('roles')
                    ->label('Filter Peran')
                    ->relationship('roles', 'name')
                    ->preload()
                    ->searchable(),
            ])
            ->actions([
                Impersonate::make()->iconButton(),
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
                ->tooltip('Menu Aksi')
                ->icon('heroicon-m-ellipsis-vertical')
                ->size('sm'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Pengguna')
            ->emptyStateDescription('Pengguna yang terdaftar akan muncul di daftar tabel ini.')
            ->emptyStateIcon('heroicon-o-users');
    }
}
