<?php

namespace App\Livewire;

use App\Models\Timeline;
use App\Models\User;
use App\Models\Warta;
use Carbon\Carbon;
use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;

class WelcomeBannerWidget extends Widget
{
    // Properti non-static sesuai standar Filament v3 Widget
    protected string $view = 'livewire.welcome-banner-widget';

    // Widget memenuhi 1 baris penuh dashboard
    protected int | string | array $columnSpan = 'full';

    // Urutan widget di halaman dashboard
    protected static ?int $sort = -10;

    public function render(): View
    {
        /** @var User|null $user */
        $user = auth()->user();

        // PERBAIKAN BARIS 32: Gunakan $this->view (bukan static::$view)
        return view($this->view, [
            'userName'    => $user?->name ?? 'Pengguna',
            'todayDate'   => Carbon::now()->locale('id')->isoFormat('dddd, DD MMMM YYYY'),
            'agendaCount' => Timeline::whereDate('created_at', now())->count(),
            'reviewCount' => Warta::where('status_naskah', 'Draft Penulis')->count(),
        ]);
    }
}