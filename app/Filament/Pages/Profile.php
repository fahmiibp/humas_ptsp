<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Profile extends Page
{

    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'Profil';
    protected static ?string $title = 'Profil Saya';
    protected string $view = 'filament.pages.profile';

    public ?array $data = [];

    public function mount(): void
    {

        $user = Auth::user();

        $this->form->fill([

            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'avatar' => $user->avatar,

        ]);

    }

    public function form(Schema $schema): Schema
    {

        return $schema

            ->components([

                Grid::make(3)

                    ->schema([

                        Section::make('Foto Profil')

                            ->description('Upload foto profil Anda')

                            ->schema([

                                FileUpload::make('avatar')

                                    ->label('Foto Profil')
                                    ->image()
                                    ->avatar()
                                    ->directory('avatars')
                                    ->disk('public')
                                    ->directory('avatar'),

                            ])

                            ->columnSpan(1),

                        Section::make('Informasi Akun')

                            ->schema([

                                TextInput::make('name')

                                    ->label('Nama Lengkap')
                                    ->required(),

                                TextInput::make('email')

                                    ->label('Email')
                                    ->email()
                                    ->required(),

                                TextInput::make('phone')

                                    ->label('Nomor WhatsApp / HP'),

                            ])
                            ->columnSpan(2),

                        Section::make('Ganti Password')

                            ->description('Kosongkan jika tidak ingin mengganti password')
                            ->schema([

                                TextInput::make('current_password')

                                    ->label('Password Lama')
                                    ->password()
                                    ->revealable(),

                                TextInput::make('password')

                                    ->label('Password Baru')
                                    ->password()
                                    ->revealable(),

                                TextInput::make('password_confirmation')

                                    ->label('Konfirmasi Password Baru')
                                    ->password()
                                    ->revealable(),

                            ])

                            ->columnSpanFull(),

                    ])

            ])

            ->statePath('data');

    }

    public function save(): void
    {

        $user = Auth::user();

        $data = $this->form->getState();

        $user->update([

            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'avatar' => $data['avatar'] ?? null,

        ]);

        if (!empty($data['password'])) {

            if (

                !empty($data['current_password'])

                &&

                Hash::check(
                    $data['current_password'],
                    $user->password
                )

            ) {

                $user->update([

                    'password' => Hash::make(
                        $data['password']
                    ),

                ]);

            }

        }

        Notification::make()

            ->title('Profil berhasil diperbarui')
            ->success()
            ->send();

    }

}