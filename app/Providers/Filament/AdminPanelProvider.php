<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Profile;
use App\Livewire\PerformanceMonitoringWidget;
use App\Livewire\TimelineCustomCalendar;
use App\Livewire\WelcomeBannerWidget;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\FontProviders\GoogleFontProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Platform;
use Filament\Support\Enums\Width;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->brandName('DPMPTSP Prov. Jateng')
            ->brandLogo(asset('image/logo.png'))
            ->brandLogoHeight('2.5rem')
            ->favicon(asset('image/logo.png'))
            ->viteTheme('resources/css/filament/admin/theme.css')

            // Tipografi & Palet Warna Modern
            ->font('Plus Jakarta Sans', provider: GoogleFontProvider::class)
            ->colors([

                'primary' => Color::Emerald,

            ])

            // Mengaktifkan Topbar dengan Fitur Pencarian Cepat & Navigasi Bersih
            ->topbar(true)
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->globalSearchFieldKeyBindingSuffix()

            // Optimasi Sidebar Navigasi
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('18rem')
            ->collapsedSidebarWidth('4.5rem')
            ->maxContentWidth(Width::Full)
            ->subNavigationPosition(SubNavigationPosition::End)
            ->sidebarFullyCollapsibleOnDesktop()
            ->navigationGroups([
                NavigationGroup::make('Manajemen Agenda')
                    ->icon('heroicon-o-calendar-days')
                    ->collapsed(false),
                NavigationGroup::make('Dokumentasi & Publikasi')
                    ->icon('heroicon-o-photo')
                    ->collapsed(false),
                NavigationGroup::make('Pengaturan Sistem')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->collapsed(true),
            ])

            // Integrasi Menu Profil & Avatar di Pojok Kanan Atas
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label('Profil Saya')
                    ->icon('heroicon-o-user-circle')
                    ->url(fn(): string => Profile::getUrl()),
            ])

            // Keamanan & Akses
            ->login()
            ->passwordReset()

            // Discovery Komponen
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                WelcomeBannerWidget::class,
                PerformanceMonitoringWidget::class,
                TimelineCustomCalendar::class,
            ])

            // Plugin Shield (Hak Akses & Role)
            ->plugin(
                FilamentShieldPlugin::make()
                    ->navigationLabel('Hak Akses & Izin')
                    ->navigationIcon('heroicon-o-shield-check')
                    ->activeNavigationIcon('heroicon-s-shield-check')
                    ->navigationGroup('Pengaturan Sistem')
                    ->navigationSort(10)
            )

            // Middleware
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
