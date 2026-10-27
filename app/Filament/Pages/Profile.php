<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class Profile extends Page
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationLabel = 'Profil';

    protected static ?string $title = 'Pengaturan Profil';

    protected static ?int $navigationSort = 99;

    protected string $view = 'filament.pages.profile';

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user();

        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? null,
            'avatar' => $user->avatar ?? null,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make([
                    'default' => 1,
                    'lg' => 3,
                ])
                ->schema([
                    // Kolom Kiri: Foto Profil & Info Cepat Akun
                    Section::make('Identitas Visual')
                        ->description('Foto profil yang akan ditampilkan di seluruh dashboard sistem.')
                        ->icon('heroicon-m-camera')
                        ->columnSpan(['lg' => 1])
                        ->schema([
                            FileUpload::make('avatar')
                                ->label('Foto Profil')
                                ->image()
                                ->avatar()
                                ->hiddenLabel()
                                ->disk('public')
                                ->directory('Foto_profile')
                                ->circleCropper()
                                ->imageEditor()
                                ->maxSize(2048)
                                ->alignCenter()
                                ->helperText('Format JPG, PNG, atau WebP. Maks 2MB.')
                                ->columnSpanFull(),
                        ]),

                    // Kolom Kanan: Data Personal & Biodata
                    Section::make('Informasi Pribadi')
                        ->description('Perbarui informasi kontak dan data diri Anda.')
                        ->icon('heroicon-m-user')
                        ->columnSpan(['lg' => 2])
                        ->columns(2)
                        ->schema([
                            TextInput::make('name')
                                ->label('Nama Lengkap')
                                ->placeholder('Nama lengkap Anda')
                                ->prefixIcon('heroicon-m-user')
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull(),

                            TextInput::make('email')
                                ->label('Alamat Email')
                                ->placeholder('alamat@email.com')
                                ->prefixIcon('heroicon-m-envelope')
                                ->email()
                                ->required()
                                ->maxLength(255)
                                ->unique(table: 'users', column: 'email', ignorable: Auth::user())
                                ->columnSpan(['default' => 2, 'md' => 1]),

                            TextInput::make('phone')
                                ->label('Nomor WhatsApp / HP')
                                ->placeholder('081234567890')
                                ->prefixIcon('heroicon-m-phone')
                                ->tel()
                                ->maxLength(20)
                                ->columnSpan(['default' => 2, 'md' => 1]),
                        ]),

                    // Panel Bawah: Keamanan Kata Sandi
                    Section::make('Keamanan & Kata Sandi')
                        ->description('Biarkan kosong jika Anda tidak berencana mengganti kata sandi.')
                        ->icon('heroicon-m-shield-check')
                        ->columnSpanFull()
                        ->columns(3)
                        ->schema([
                            TextInput::make('current_password')
                                ->label('Kata Sandi Saat Ini')
                                ->placeholder('••••••••')
                                ->password()
                                ->revealable()
                                ->currentPassword()
                                ->required(fn (Get $get): bool => filled($get('password')))
                                ->autocomplete('current-password'),

                            TextInput::make('password')
                                ->label('Kata Sandi Baru')
                                ->placeholder('Minimal 8 karakter')
                                ->password()
                                ->revealable()
                                ->rule(Password::default()->min(8))
                                ->autocomplete('new-password'),

                            TextInput::make('password_confirmation')
                                ->label('Konfirmasi Kata Sandi')
                                ->placeholder('Ulangi kata sandi baru')
                                ->password()
                                ->revealable()
                                ->same('password')
                                ->required(fn (Get $get): bool => filled($get('password')))
                                ->autocomplete('new-password'),
                        ]),
                ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $data = $this->form->getState();

        // Update data profil dasar
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'avatar' => $data['avatar'] ?? null,
        ]);

        // Update password jika diisi
        if (! empty($data['password'])) {
            $user->update([
                'password' => Hash::make($data['password']),
            ]);
        }

        Notification::make()
            ->title('Profil Berhasil Diperbarui')
            ->body('Data akun Anda telah disimpan. Mengalihkan ke dashboard...')
            ->success()
            ->send();

        // Redirect langsung ke halaman utama Dashboard Filament
        $this->redirect(filament()->getUrl());
    }
}
