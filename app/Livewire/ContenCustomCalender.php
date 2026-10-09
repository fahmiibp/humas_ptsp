<?php

namespace App\Livewire;

use App\Models\KontenMedsos;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class ContenCustomCalender extends Widget
{
    // Hilangkan keyword 'static' di sini
    protected string $view = 'livewire.conten-custom-calender';

    // Membuat widget berukuran penuh (full width)
    protected int|string|array $columnSpan = 'full';

    public int $currentMonth;
    public int $currentYear;

    public function mount(): void
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
    }

    public static function canView(): bool
    {
        return true;
    }

    public function nextMonth(): void
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function previousMonth(): void
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function today(): void
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
    }

    protected function getViewData(): array
    {
        $startOfMonth = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->startOfMonth();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        $startDate = $startOfMonth->copy()->startOfWeek(Carbon::MONDAY);
        $endDate = $endOfMonth->copy()->endOfWeek(Carbon::SUNDAY);

        $posts = KontenMedsos::whereBetween('tanggal', [$startDate->format('Y-m-d 00:00:00'), $endDate->format('Y-m-d 23:59:59')])
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->tanggal)->format('Y-m-d');
            });

        $days = [];
        $day = $startDate->copy();

        while ($day <= $endDate) {
            $dateKey = $day->format('Y-m-d');
            $days[] = [
                'date' => $day->copy(),
                'isCurrentMonth' => $day->month === $this->currentMonth,
                'isToday' => $day->isToday(),
                'posts' => $posts->get($dateKey, collect([])),
            ];
            $day->addDay();
        }

        return [
            'days' => $days,
            'monthName' => Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->translatedFormat('F Y'),
        ];
    }
}