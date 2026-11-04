<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use STS\FilamentImpersonate\Actions\Impersonate;

class UsersTable
{
    /**
     * Hanya Super Admin yang boleh mereset password.
     */
    private static function canResetPassword(): bool
    {
        return Auth::user()?->hasAnyRole([
            'super_admin',
            'Super Admin',
        ]) ?? false;
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')

            ->columns([
                ImageColumn::make('avatar')
                    ->label('')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(
                        fn ($record): string =>
                            'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name='
                            . urlencode($record->name)
                    )
                    ->grow(false),

                TextColumn::make('name')
                    ->label('Pengguna')
                    ->searchable(['name', 'email'])
                    ->sortable()
                    ->weight('bold')
                    ->description(
                        fn ($record): string => $record->email ?? '-'
                    )
                    ->copyable()
                    ->copyableState(
                        fn ($record): string => $record->email ?? ''
                    )
                    ->copyMessage('Alamat email disalin!')
                    ->copyMessageDuration(1500),

                TextColumn::make('roles.name')
                    ->label('Peran / Hak Akses')
                    ->badge()
                    ->color(
                        fn (string $state): string => match (
                            strtolower($state)
                        ) {
                            'super_admin', 'admin' => 'danger',
                            'editor', 'manager' => 'warning',
                            'staff' => 'info',
                            default => 'gray',
                        }
                    )
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
                Impersonate::make()
                    ->iconButton(),

                ActionGroup::make([
                    ViewAction::make(),

                    EditAction::make(),

                    /*
                     * RESET PASSWORD
                     */
                    Action::make('resetPassword')
                        ->label('Reset Password')
                        ->icon('heroicon-o-key')
                        ->color('warning')
                        ->visible(
                            fn (): bool => self::canResetPassword()
                        )
                        ->schema([
                            TextInput::make('password')
                                ->label('Password Baru')
                                ->password()
                                ->revealable()
                                ->autocomplete('new-password')
                                ->required()
                                ->rule(
                                    Password::min(8)
                                        ->mixedCase()
                                        ->numbers()
                                        ->symbols()
                                )
                                ->confirmed()
                                ->validationMessages([
                                    'confirmed' =>
                                        'Konfirmasi password tidak cocok.',
                                ])
                                ->helperText(
                                    'Minimal 8 karakter dan wajib mengandung '
                                    . 'huruf kapital, huruf kecil, angka, '
                                    . 'serta simbol.'
                                ),

                            TextInput::make('password_confirmation')
                                ->label('Konfirmasi Password Baru')
                                ->password()
                                ->revealable()
                                ->autocomplete('new-password')
                                ->required(),
                        ])
                        ->modalHeading('Reset Password Pengguna')
                        ->modalDescription(
                            'Masukkan password baru untuk pengguna ini. '
                            . 'Password lama tidak diperlukan.'
                        )
                        ->modalSubmitActionLabel('Simpan Password Baru')
                        ->action(function (
                            array $data,
                            User $record
                        ): void {
                            // Validasi otorisasi di sisi server.
                            abort_unless(
                                self::canResetPassword(),
                                403
                            );

                            // Hash password sebelum disimpan.
                            $record->password = Hash::make(
                                $data['password']
                            );

                            $record->save();

                            Notification::make()
                                ->title('Password berhasil direset')
                                ->body(
                                    'Password pengguna '
                                    . $record->name
                                    . ' berhasil diperbarui.'
                                )
                                ->success()
                                ->send();
                        }),

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
            ->emptyStateDescription(
                'Pengguna yang terdaftar akan muncul di daftar tabel ini.'
            )
            ->emptyStateIcon('heroicon-o-users');
    }
}
