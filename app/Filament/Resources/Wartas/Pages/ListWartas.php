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
        return [
            'Semua' => Tab::make()
            ->badge(Warta::query()->where('status_naskah', 'Draft Penulis')->count())
                ->badgeColor('primary'),
            'Draft Penulis' => Tab::make()
                ->badge(Warta::query()->where('status_naskah', 'Draft Penulis')->count())
                ->badgeColor('gray')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status_naskah', 'Draft Penulis'))
                ->icon('heroicon-m-pencil-square')
                ->iconPosition(IconPosition::Before),
            'Perlu Review Koordinator' => Tab::make()
                ->badge(Warta::query()->where('status_naskah', 'Perlu Review Koordinator')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status_naskah', 'Perlu Review Koordinator'))
                ->icon('heroicon-m-exclamation-circle')
                ->iconPosition(IconPosition::Before),
            'Perlu Revisi' => Tab::make()
                ->badge(Warta::query()->where('status_naskah', 'Perlu Revisi')->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status_naskah', 'Perlu Revisi'))
                ->icon('heroicon-m-check-circle')
                ->iconPosition(IconPosition::Before),
            'Disetujui' => Tab::make()
                ->badge(Warta::query()->where('status_naskah', 'Disetujui')->count())
                ->badgeColor('info')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status_naskah', 'Disetujui'))
                ->icon('heroicon-m-document-text')
                ->iconPosition(IconPosition::Before),
            'Sudah Tayang' => Tab::make()
                ->badge(Warta::query()->where('status_naskah', 'Sudah Tayang')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status_naskah', 'Disetujui'))
                ->icon('heroicon-m-document-text')
                ->iconPosition(IconPosition::Before),

        ];
    }
}
