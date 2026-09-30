<?php

namespace App\Livewire;

use App\Models\Timeline;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Widgets\Widget;

class TimelineCustomCalendar extends Widget
{
    protected string $view = 'livewire.timeline-custom-calendar';

    protected int | string | array $columnSpan = 'full';

    public int $month;
    public int $year;

    public function mount(): void
    {
        $this->month = (int) now()->month;
        $this->year = (int) now()->year;
    }

    public function getCalendarDaysProperty(): array
    {
        $firstDayOfMonth = Carbon::createFromDate($this->year, $this->month, 1);
        $startOfWeek = $firstDayOfMonth->copy()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = $firstDayOfMonth->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        // 1. Ambil semua event yang bersinggungan dengan rentang tampilan kalender
        $events = Timeline::query()
            ->where('start_date', '<=', $endOfWeek->copy()->endOfDay())
            ->where('end_date', '>=', $startOfWeek->copy()->startOfDay())
            ->get();

        $period = CarbonPeriod::create($startOfWeek, $endOfWeek);
        $days = [];

        foreach ($period as $date) {
            $dayStart = $date->copy()->startOfDay();
            $dayEnd = $date->copy()->endOfDay();

            // 2. Filter event yang berlangsung pada tanggal ini ($date)
            $dayEvents = $events->filter(function ($event) use ($dayStart, $dayEnd) {
                $eventStart = Carbon::parse($event->start_date);
                $eventEnd = Carbon::parse($event->end_date);

                // Event masuk di hari ini jika: start_date <= akhir hari DAN end_date >= awal hari
                return $eventStart->lte($dayEnd) && $eventEnd->gte($dayStart);
            });

            $days[] = [
                'date' => $date,
                'isCurrentMonth' => $date->month === $this->month,
                'isToday' => $date->isToday(),
                'events' => $dayEvents,
            ];
        }

        return $days;
    }

    public function nextMonth(): void
    {
        $date = Carbon::createFromDate($this->year, $this->month, 1)->addMonth();
        $this->month = $date->month;
        $this->year = $date->year;
    }

    public function previousMonth(): void
    {
        $date = Carbon::createFromDate($this->year, $this->month, 1)->subMonth();
        $this->month = $date->month;
        $this->year = $date->year;
    }

    public function goToToday(): void
    {
        $this->month = (int) now()->month;
        $this->year = (int) now()->year;
    }
}
