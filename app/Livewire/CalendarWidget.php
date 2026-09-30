<?php

namespace App\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Filament\Resources\EventResource;
use App\Filament\Resources\Timelines\TimelineResource;
use App\Models\Event;
use App\Models\Timeline;
use Ramsey\Uuid\Type\Time;

class CalendarWidget extends FullCalendarWidget
{

    public function fetchEvents(array $fetchInfo): array
    {
        return Timeline::query()
            ->where('starts_at', '>=', $fetchInfo['start'])
            ->where('ends_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn (Timeline $event) => [
                    'title' => $event->id,
                    'start' => $event->starts_at,
                    'end' => $event->ends_at,
                    'url' => TimelineResource::getUrl(name: 'view', parameters: ['record' => $event]),
                    'shouldOpenUrlInNewTab' => true
                ]
            )
            ->toArray();
    }
}
