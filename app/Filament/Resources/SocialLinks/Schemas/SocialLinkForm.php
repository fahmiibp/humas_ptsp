<?php

namespace App\Filament\Resources\SocialLinks\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class SocialLinkForm
{
    /**
     * Key = nama ikon (sama dengan $icons di komponen Blade).
     */
    protected static function platforms(): array
    {
        return [
            'instagram' => ['label' => 'Instagram',   'base' => 'https://instagram.com/',        'hint' => 'Contoh: namaakun'],
            'tiktok'    => ['label' => 'TikTok',      'base' => 'https://tiktok.com/@',          'hint' => 'Contoh: namaakun'],
            'facebook'  => ['label' => 'Facebook',    'base' => 'https://facebook.com/',         'hint' => 'Contoh: namaakun'],
            'youtube'   => ['label' => 'YouTube',     'base' => 'https://youtube.com/@',         'hint' => 'Contoh: namachannel'],
            'x'         => ['label' => 'X (Twitter)', 'base' => 'https://x.com/',                'hint' => 'Contoh: namaakun'],
            'whatsapp'  => ['label' => 'WhatsApp',    'base' => 'https://wa.me/',                'hint' => 'Nomor, contoh: 081234567890'],
            'telegram'  => ['label' => 'Telegram',    'base' => 'https://t.me/',                 'hint' => 'Contoh: namaakun'],
            'linkedin'  => ['label' => 'LinkedIn',    'base' => 'https://linkedin.com/in/',      'hint' => 'Contoh: namaakun'],
            'threads'   => ['label' => 'Threads',     'base' => 'https://threads.net/@',         'hint' => 'Contoh: namaakun'],
            'pinterest' => ['label' => 'Pinterest',   'base' => 'https://pinterest.com/',        'hint' => 'Contoh: namaakun'],
            'reddit'    => ['label' => 'Reddit',      'base' => 'https://reddit.com/user/',      'hint' => 'Contoh: namaakun'],
            'discord'   => ['label' => 'Discord',     'base' => 'https://discord.gg/',           'hint' => 'Kode undangan, contoh: abc123'],
            'github'    => ['label' => 'GitHub',      'base' => 'https://github.com/',           'hint' => 'Contoh: namaakun'],
            'medium'    => ['label' => 'Medium',      'base' => 'https://medium.com/@',          'hint' => 'Contoh: namaakun'],
            'spotify'   => ['label' => 'Spotify',     'base' => 'https://open.spotify.com/user/', 'hint' => 'ID pengguna Spotify'],
            'twitch'    => ['label' => 'Twitch',      'base' => 'https://twitch.tv/',            'hint' => 'Contoh: namaakun'],
            'snapchat'  => ['label' => 'Snapchat',    'base' => 'https://snapchat.com/add/',     'hint' => 'Contoh: namaakun'],
        ];
    }

    protected static function buildUrl(?string $platform, ?string $username): ?string
    {
        $base = static::platforms()[$platform]['base'] ?? null;
        $username = trim((string) $username);

        if (! $base || $username === '') {
            return null;
        }

        // Kalau yang ditempel sudah URL lengkap, pakai apa adanya.
        if (str_starts_with($username, 'http')) {
            return $username;
        }

        if ($platform === 'whatsapp') {
            $number = preg_replace('/\D+/', '', $username);

            return $base . (str_starts_with($number, '0') ? '62' . substr($number, 1) : $number);
        }

        return $base . ltrim($username, '@/ ');
    }

    protected static function syncUrl(Get $get, Set $set): void
    {
        $set('url', static::buildUrl($get('icon'), $get('username')));
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('icon')
                    ->label('Platform')
                    ->options(fn(): array => collect(static::platforms())->map(fn($p) => $p['label'])->all())
                    ->searchable()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, Get $get, Set $set): void {
                        $set('name', static::platforms()[$state]['label'] ?? null);
                        static::syncUrl($get, $set);
                    }),

                Hidden::make('name'),

                TextInput::make('username')
                    ->label('Nama Akun')
                    ->placeholder('Masukkan nama akun saja')
                    ->helperText(fn(Get $get): string => static::platforms()[$get('icon')]['hint'] ?? 'Pilih platform terlebih dahulu.')
                    ->required()
                    ->live(onBlur: true)
                    ->dehydrated(false)
                    ->afterStateUpdated(fn(Get $get, Set $set) => static::syncUrl($get, $set))
                    ->afterStateHydrated(function (TextInput $component, $record): void {
                        // Saat edit: ambil kembali nama akun dari URL tersimpan.
                        if (! $record) {
                            return;
                        }

                        $base = static::platforms()[$record->icon]['base'] ?? null;

                        if ($base && str_starts_with((string) $record->url, $base)) {
                            $component->state(substr($record->url, strlen($base)));
                        }
                    }),

                TextInput::make('url')
                    ->label('URL Media Sosial')
                    ->helperText('Terisi otomatis dari platform dan nama akun.')
                    ->url()
                    ->readOnly()
                    ->required(),

                Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->helperText('Aktifkan agar ikon ditampilkan di website.')
                    ->default(true)
                    ->required(),

                TextInput::make('sort_order')
                    ->label('Urutan Tampilan')
                    ->placeholder('Contoh: 1')
                    ->helperText('Angka llebih kecil ditampilkan lebih dahulu.')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }
}
