<?php

namespace App\Filament\Resources\Arsips\Pages;

use App\Filament\Resources\Arsips\ArsipResource;
use App\Filament\Widgets\ArsipBannerWidget;
use App\Livewire\ArsipBannerWidget as LivewireArsipBannerWidget;
use App\Models\Arsip;
use Filament\Actions\CreateAction;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab as TabsTab;
use Illuminate\Database\Eloquent\Builder;

class ListArsips extends ListRecords
{
    protected static string $resource = ArsipResource::class;

    public function getTitle(): string
    {
        return 'Arsip Dokumentasi Liputan';
    }

    public function getSubheading(): ?string
    {
        return 'Pusat repositori link Google Drive dan sampel foto dokumentasi kegiatan DPMPTSP Jateng.';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Arsipkan Dokumentasi Baru')
                ->icon('heroicon-m-camera'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            LivewireArsipBannerWidget::class,
        ];
    }

    
    public function getTabs(): array
{
    return [

        'semua' => TabsTab::make('Semua Arsip')
            ->icon('heroicon-m-folder')
            ->badge(Arsip::count()),


        'bulan_ini' => TabsTab::make('Bulan Ini')
            ->icon('heroicon-m-calendar')
            ->modifyQueryUsing(
                fn (Builder $query) =>
                    $query->whereMonth('event_date', now()->month)
                        ->whereYear('event_date', now()->year)
            )
            ->badge(
                Arsip::whereMonth('event_date', now()->month)
                    ->whereYear('event_date', now()->year)
                    ->count()
            ),



        'bulan_lalu' => TabsTab::make('Bulan Lalu')
            ->icon('heroicon-m-clock')
            ->modifyQueryUsing(
                fn (Builder $query) =>
                    $query->whereMonth(
                            'event_date',
                            now()->subMonth()->month
                        )
                        ->whereYear(
                            'event_date',
                            now()->subMonth()->year
                        )
            )
            ->badge(
                Arsip::whereMonth(
                        'event_date',
                        now()->subMonth()->month
                    )
                    ->whereYear(
                        'event_date',
                        now()->subMonth()->year
                    )
                    ->count()
            ),



        'tahun_ini' => TabsTab::make('Tahun Ini')
            ->icon('heroicon-m-calendar-days')
            ->modifyQueryUsing(
                fn (Builder $query) =>
                    $query->whereYear('event_date', now()->year)
            )
            ->badge(
                Arsip::whereYear('event_date', now()->year)
                    ->count()
            ),

    ];
}
}