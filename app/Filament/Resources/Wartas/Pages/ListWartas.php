<?php

namespace App\Filament\Resources\Wartas\Pages;

use App\Filament\Resources\Wartas\WartaResource;
use App\Models\Warta;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Enums\IconPosition;
use Illuminate\Database\Eloquent\Builder;

class ListWartas extends ListRecords
{
    protected static string $resource = WartaResource::class;

    protected static ?string $title = 'Daftar Warta';

    protected static ?string $breadcrumb = 'Daftar';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Warta')
                ->icon('heroicon-o-plus')
                ->url($this->getResource()::getUrl('create')),
        ];
    }

    public function getTabs(): array
    {
        // Satu query untuk semua jumlah status
        $counts = Warta::query()
            ->selectRaw('status_naskah, COUNT(*) as total')
            ->groupBy('status_naskah')
            ->pluck('total', 'status_naskah');

        // Konfigurasi tiap tab: label => [status di DB, warna, ikon]
        $statuses = [
            'Draft Penulis' => [
                'status' => 'Draft Penulis',
                'color'  => 'gray',
                'icon'   => 'heroicon-m-pencil-square',
            ],
            'Menunggu Verifikasi' => [
                'status' => 'Perlu Review Koordinator',
                'color'  => 'warning',
                'icon'   => 'heroicon-m-exclamation-circle',
            ],
            'Perlu Revisi' => [
                'status' => 'Perlu Revisi',
                'color'  => 'danger',
                'icon'   => 'heroicon-m-arrow-path',
            ],
            'Disetujui' => [
                'status' => 'Disetujui',
                'color'  => 'info',
                'icon'   => 'heroicon-m-check-circle',
            ],
            'Sudah Tayang' => [
                'status' => 'Sudah Tayang',
                'color'  => 'success',
                'icon'   => 'heroicon-m-megaphone',
            ],
        ];

        $tabs = [
            'Semua' => Tab::make()
                ->badge($counts->sum())
                ->badgeColor('primary'),
        ];

        foreach ($statuses as $label => $config) {
            $tabs[$label] = Tab::make()
                ->badge($counts[$config['status']] ?? 0)
                ->badgeColor($config['color'])
                ->icon($config['icon'])
                ->iconPosition(IconPosition::Before)
                ->modifyQueryUsing(
                    fn(Builder $query): Builder => $query->where('status_naskah', $config['status'])
                );
        }

        return $tabs;
    }
}
