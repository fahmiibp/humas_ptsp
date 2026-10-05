<?php

namespace App\Filament\Pages;

use App\Models\KontenMedsos;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Pages\Page;

class ContentCalendar extends Page
{
    protected string $view = 'filament.pages.content-calendar';


    public function getViewData(): array
    {
        return [
            'events' => $this->getEvents(),
            'stats' => $this->getStats(),
            'konten' => $this->getKonten(),
            'statusCount' => $this->getStatusCount(),
        ];
    }


    protected function getStats(): array
    {
        return [
            'total' => KontenMedsos::count(),

            'draft' => KontenMedsos::where(
                'status',
                'Draft'
            )->count(),

            'review' => KontenMedsos::where(
                'status',
                'Review'
            )->count(),

            'siapTayang' => KontenMedsos::where(
                'status',
                'Siap Tayang'
            )->count(),

            'published' => KontenMedsos::whereIn(
                'status',
                [
                    'Published',
                    'Publish'
                ]
            )->count(),
        ];
    }



    protected function getEvents(): array
    {
        return KontenMedsos::query()
            ->whereNotNull('tanggal')
            ->orderBy('tanggal')
            ->get()
            ->map(function ($konten) {


                $color = match ($konten->status) {

                    'Draft'
                    => '#94A3B8',

                    'Review'
                    => '#F59E0B',

                    'Siap Tayang'
                    => '#2563EB',

                    'Published',
                    'Publish'
                    => '#16A34A',

                    'Ditolak'
                    => '#DC2626',

                    default
                    => '#64748B',
                };


                return [

                    'id' => $konten->id,

                    'title' => $konten->judul,

                    'start' => Carbon::parse(
                        $konten->tanggal
                    )->format('Y-m-d'),


                    'backgroundColor' => $color,

                    'borderColor' => $color,

                    'textColor' => '#FFFFFF',


                    'extendedProps' => [

                        'status' => $konten->status,

                        'platform' => $konten->platform,

                        'format' => $konten->format,


                        'tanggal' => Carbon::parse(
                            $konten->tanggal
                        )->translatedFormat(
                                'l, d F Y'
                            ),


                        'jam' => $konten->jam_tayang,


                        'hashtag' => $konten->hashtag,

                    ],

                ];

            })
            ->toArray();
    }



    public function getStatusCount(): array
    {
        return [

            'semua'
            => KontenMedsos::count(),


            'siapTayang'
            => KontenMedsos::where(
                    'status',
                    'Siap Tayang'
                )->count(),


            'review'
            => KontenMedsos::where(
                    'status',
                    'Review'
                )->count(),


            'published'
            => KontenMedsos::whereIn(
                    'status',
                    [
                        'Published',
                        'Publish'
                    ]
                )->count(),

        ];
    }



    public function getKonten()
    {
        return KontenMedsos::query()
            ->orderByDesc('tanggal')
            ->get();
    }



    public function getHeaderActions(): array
    {
        return [];
    }


    public static function getNavigationLabel(): string
    {
        return 'Rencana Konten Medsos';
    }



    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return 'heroicon-o-calendar';
    }



    public static function getNavigationGroup(): string|\UnitEnum|null
    {
        return 'Produksi Konten';
    }



    public static function getNavigationSort(): int
    {
        return 2;
    }

    public function getMaxContentWidth(): string
    {
        return 'full';
    }

    public function getTitle(): string
    {
        return 'Kalender Konten Medsos';
    }
}