<?php

namespace App\Livewire;

use App\Models\Arsip;
use App\Models\Timeline;
use App\Models\Warta;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class PerformanceMonitoringWidget extends Widget
{
    use HasWidgetShield;
    protected string $view = 'livewire.performance-monitoring-widget';

    protected int | string | array $columnSpan = 'full';

    // Urutan tampil di bawah Welcome Banner (-9 agar berada di atas kalender)
    protected static ?int $sort = -9;

    protected function getViewData(): array
    {
        $now = Carbon::now();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $monthName = Carbon::now()->locale('id')->isoFormat('MMMM YYYY');
        $todayDate = Carbon::now()->locale('id')->isoFormat('DD MMMM YYYY');

        // Data Dinamis dari Database
        $agendaCount = Timeline::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $arsipCount = Arsip::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $driveCount = Arsip::whereNotNull('drive_url')->count();

        $wartaPublished = Warta::where('status_naskah', 'Tayang')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $wartaDraft = Warta::where('status_naskah', 'Draft Penulis')->count();

        $totalDaysInMonth = $now->daysInMonth;
        $currentDay = $now->day;
        $remainingDays = $totalDaysInMonth - $currentDay;


        $completionPercentage = $agendaCount > 0
            ? min(round(($arsipCount / $agendaCount) * 100), 100)
            : 100;

        return [
            'monthName'      => $monthName,
            'todayDate'      => $todayDate,
            'agendaCount'    => $agendaCount,
            'arsipCount'     => $arsipCount,
            'driveCount'     => $driveCount,
            'wartaPublished' => $wartaPublished,
            'wartaDraft'     => $wartaDraft,
            'remainingDays'        => $remainingDays,
            'completionPercentage' => $completionPercentage,
        ];
    }
}
