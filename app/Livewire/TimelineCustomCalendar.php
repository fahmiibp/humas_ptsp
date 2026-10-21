<?php

namespace App\Livewire;

use App\Models\Timeline;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Widgets\Widget;

class TimelineCustomCalendar extends Widget
{
    use HasWidgetShield;

    protected string $view = 'livewire.timeline-custom-calendar';

    protected int | string | array $columnSpan = 'full';

    public int $month;

    public int $year;

    public bool $showDetailModal = false;

    public ?array $selectedEvent = null;

    public function mount(): void
    {
        $this->month = (int) now()->month;
        $this->year = (int) now()->year;
    }

    public function showDetail(int $timelineId): void
    {
        $timeline = Timeline::query()->findOrFail($timelineId);

        $status = $timeline->status;

        if (is_object($status) && isset($status->value)) {
            $status = $status->value;
        }

        $this->selectedEvent = [
            'id' => $timeline->id,
            'event_name' => $timeline->event_name,
            'start_date' => $timeline->start_date,
            'end_date' => $timeline->end_date,
            'location' => $timeline->location,
            'status' => $status ?? 'Belum Mulai',
            'edit_url' => route(
                'filament.admin.resources.timelines.edit',
                ['record' => $timeline->id]
            ),
        ];

        $this->showDetailModal = true;
    }

    public function closeDetail(): void
    {
        $this->showDetailModal = false;
        $this->selectedEvent = null;
    }

    public function getCalendarDaysProperty(): array
    {
        $firstDayOfMonth = Carbon::createFromDate(
            $this->year,
            $this->month,
            1
        );

        $startOfWeek = $firstDayOfMonth
            ->copy()
            ->startOfWeek(Carbon::MONDAY);

        $endOfWeek = $firstDayOfMonth
            ->copy()
            ->endOfMonth()
            ->endOfWeek(Carbon::SUNDAY);

        $events = Timeline::query()
            ->where(
                'start_date',
                '<=',
                $endOfWeek->copy()->endOfDay()
            )
            ->where(
                'end_date',
                '>=',
                $startOfWeek->copy()->startOfDay()
            )
            ->get();

        $period = CarbonPeriod::create(
            $startOfWeek,
            $endOfWeek
        );

        $days = [];

        foreach ($period as $date) {
            $dayStart = $date->copy()->startOfDay();
            $dayEnd = $date->copy()->endOfDay();

            $dayEvents = $events->filter(
                function ($event) use ($dayStart, $dayEnd) {
                    $eventStart = Carbon::parse($event->start_date);
                    $eventEnd = Carbon::parse($event->end_date);

                    return $eventStart->lte($dayEnd)
                        && $eventEnd->gte($dayStart);
                }
            );

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
        $date = Carbon::createFromDate(
            $this->year,
            $this->month,
            1
        )->addMonth();

        $this->month = $date->month;
        $this->year = $date->year;
    }

    public function previousMonth(): void
    {
        $date = Carbon::createFromDate(
            $this->year,
            $this->month,
            1
        )->subMonth();

        $this->month = $date->month;
        $this->year = $date->year;
    }

    public function goToToday(): void
    {
        $this->month = (int) now()->month;
        $this->year = (int) now()->year;
    }
}
