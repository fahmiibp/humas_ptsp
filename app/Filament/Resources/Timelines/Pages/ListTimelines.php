<?php

namespace App\Filament\Resources\Timelines\Pages;

use App\Filament\Resources\Timelines\TimelineResource;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListTimelines extends ListRecords
{
    protected static string $resource = TimelineResource::class;

    public function getSubheading(): ?string
    {
        return 'Pantau seluruh jadwal kegiatan, lokasi pelaksanaan, serta status progres agenda organisasi.';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Buat Agenda Baru')
                ->icon('heroicon-m-calendar-days')
                ->modalHeading('Jadwalkan Agenda Kegiatan')
                ->modalDescription('Lengkapi rincian nama kegiatan, lokasi, rentang waktu, dan status pelaksanaan.')
                ->modalIcon('heroicon-o-calendar-days')
                ->modalWidth('2xl')
                ->modalSubmitActionLabel('Simpan Jadwal')
                ->modalCancelActionLabel('Batal')
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Agenda Berhasil Dijadwalkan')
                        ->body('Jadwal kegiatan baru telah ditambahkan ke dalam daftar agenda.')
                ),
        ];
    }
}
