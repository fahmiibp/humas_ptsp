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
    // Sesuaikan dengan nama view Anda
    // protected string $view = 'filament.widgets.rekap-kinerja-widget';

    protected int | string | array $columnSpan = 'full';

    // SESUAIKAN dengan nilai asli di kolom warta.status_naskah
    protected const STATUS_TERBIT = 'Sudah Tayang';
    protected const STATUS_DRAFT  = 'Draft Penulis';

    // Format: 2026-11
    public string $selectedMonth = '';

    public function mount(): void
    {
        $this->selectedMonth = now()->format('Y-m');
    }

    /**
     * Opsi dropdown: 12 bulan terakhir (termasuk bulan ini).
     */
    protected function getMonthOptions(): array
    {
        $options = [];

        for ($i = 0; $i < 12; $i++) {
            $date = now()->startOfMonth()->subMonths($i);
            $options[$date->format('Y-m')] = $date->translatedFormat('F Y');
        }

        return $options;
    }

    /**
     * Kegiatan (tidak dibatalkan) yang rentang tanggalnya beririsan dengan bulan tsb.
     */
    protected function timelineInMonth(Carbon $month)
    {
        $start = $month->copy()->startOfMonth()->toDateString();
        $end   = $month->copy()->endOfMonth()->toDateString();

        return Timeline::query()
            ->whereDate('start_date', '<=', $end)
            ->whereDate('end_date', '>=', $start)
            ->where(function ($q) {
                $q->whereNull('status')
                    ->orWhereRaw('LOWER(TRIM(status)) != ?', ['batal']);
            });
    }

    protected function getViewData(): array
    {
        // Validasi input agar format tidak rusak jika dimanipulasi dari client
        $selected = array_key_exists($this->selectedMonth, $this->getMonthOptions())
            ? $this->selectedMonth
            : now()->format('Y-m');

        $month          = Carbon::createFromFormat('Y-m-d', $selected . '-01')->startOfMonth();
        $prev           = $month->copy()->subMonth();
        $startOfMonth   = $month->copy()->startOfMonth();
        $endOfMonth     = $month->copy()->endOfMonth();
        $isCurrentMonth = $month->isSameMonth(now());

        // --- Agenda Liputan + tren ---
        $agendaCount = $this->timelineInMonth($month)->count();
        $agendaPrev  = $this->timelineInMonth($prev)->count();

        $agendaTrend = $agendaPrev > 0
            ? (int) round((($agendaCount - $agendaPrev) / $agendaPrev) * 100)
            : null;

        // --- Rasio dokumentasi: kegiatan selesai yang sudah punya arsip ---
        $selesai = $this->timelineInMonth($month)
            ->whereDate('end_date', '<', now()->toDateString());

        $totalSelesai  = (clone $selesai)->count();
        $totalTerarsip = (clone $selesai)->whereHas('arsip')->count();

        $rasioDokumentasi = $totalSelesai > 0
            ? (int) round(($totalTerarsip / $totalSelesai) * 100)
            : 0;

        // --- Arsip (berdasarkan tanggal kegiatan) ---
        $arsipCount = Arsip::query()
            ->whereBetween('event_date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
            ->count();

        // --- Folder Drive: arsip yang punya link Drive ---
        $driveCount = Arsip::query()
            ->whereBetween('event_date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
            ->whereNotNull('drive_url')
            ->where('drive_url', '!=', '')
            ->count();

        // --- Warta ---
        $wartaPublished = Warta::query()
            ->where('status_naskah', self::STATUS_TERBIT)
            ->whereBetween('jadwal_tayang', [$startOfMonth, $endOfMonth])
            ->count();

        $wartaDraft = Warta::query()
            ->where('status_naskah', self::STATUS_DRAFT)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        return [
            'monthOptions'         => $this->getMonthOptions(),
            'isCurrentMonth'       => $isCurrentMonth,
            'todayDate'            => now()->translatedFormat('d F Y'),
            'monthName'            => $month->translatedFormat('F Y'),
            'remainingDays'        => $isCurrentMonth ? now()->daysInMonth - now()->day : 0,

            'completionPercentage' => $rasioDokumentasi,
            'rasioDokumentasi'     => $rasioDokumentasi,
            'totalSelesai'         => $totalSelesai,
            'totalTerarsip'        => $totalTerarsip,

            'agendaCount'          => $agendaCount,
            'agendaTrend'          => $agendaTrend,
            'arsipCount'           => $arsipCount,
            'driveCount'           => $driveCount,
            'wartaPublished'       => $wartaPublished,
            'wartaDraft'           => $wartaDraft,
        ];
    }
}
