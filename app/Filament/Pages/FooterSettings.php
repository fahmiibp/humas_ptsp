<?php

namespace App\Filament\Pages;

use App\Models\FooterSetting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Facades\Storage;
use UnitEnum;

class FooterSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-bars-3-bottom-left';

    protected static ?string $navigationLabel = 'Logo & Informasi Kontak';

    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan Sistem';

    protected static ?int $navigationSort = 20;

    protected string $view = 'filament.pages.footer-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $footer = FooterSetting::query()->first();

        if (! $footer) {
            $footer = FooterSetting::create([
                'copyright' => 'PTSP',
                'dikelola_oleh' => 'Dikelola oleh PTSP',
                'deskripsi_sosial' => 'Dapatkan informasi terbaru melalui media sosial kami.',
                'is_active' => true,
            ]);
        }

        $this->form->fill($footer->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Logo Website')
                    ->description(
                        'Logo yang ditampilkan pada bagian navbar & footer website.'
                    )
                    ->schema([
                        FileUpload::make('logo')
                            ->label('Logo')
                            ->image()
                            ->disk('public')
                            ->directory('footer')
                            ->imagePreviewHeight('120')
                            ->maxSize(2048)
                            ->helperText(
                                'Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB.'
                            )
                            ->columnSpanFull(),
                    ]),

                Section::make('Informasi Alamat')
                    ->description(
                        'Informasi alamat kantor yang ditampilkan pada footer.'
                    )
                    ->schema([
                        Textarea::make('alamat')
                            ->label('Alamat')
                            ->rows(4)
                            ->placeholder(
                                'Masukkan alamat kantor...'
                            )
                            ->columnSpanFull(),
                    ]),

                Section::make('Informasi Kontak')
                    ->description(
                        'Nomor telepon dan email yang ditampilkan pada footer.'
                    )
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('email')
                                    ->label('E-mail')
                                    ->email()
                                    ->placeholder(
                                        'contoh@domain.go.id'
                                    ),

                                TextInput::make('telepon_1')
                                    ->label('Telepon 1')
                                    ->placeholder(
                                        '(024) 0000000'
                                    ),

                                TextInput::make('telepon_2')
                                    ->label('Telepon 2')
                                    ->placeholder(
                                        '(024) 0000000'
                                    ),
                            ]),
                    ]),

                Section::make('Deskripsi Media Sosial')
                    ->description(
                        'Teks yang muncul di bawah informasi media sosial.'
                    )
                    ->schema([
                        Textarea::make('deskripsi_sosial')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->placeholder(
                                'Dapatkan informasi terbaru melalui media sosial kami.'
                            )
                            ->columnSpanFull(),
                    ]),

                Section::make('Copyright')
                    ->description(
                        'Informasi yang ditampilkan pada bagian paling bawah footer.'
                    )
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('copyright')
                                    ->label('Copyright')
                                    ->placeholder('PTSP'),

                                TextInput::make('dikelola_oleh')
                                    ->label('Dikelola Oleh')
                                    ->placeholder(
                                        'Dikelola oleh PTSP'
                                    ),
                            ]),

                        Toggle::make('is_active')
                            ->label('Footer Aktif')
                            ->default(true)
                            ->helperText(
                                'Aktifkan agar pengaturan ini digunakan pada website.'
                            ),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $footer = FooterSetting::query()->first();

        if (! $footer) {
            $footer = new FooterSetting();
        }

        $footer->fill($data);
        $footer->save();

        Notification::make()
            ->title('Pengaturan footer berhasil disimpan')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Perubahan')
                ->submit('save')
                ->icon('heroicon-o-check'),
        ];
    }
}
