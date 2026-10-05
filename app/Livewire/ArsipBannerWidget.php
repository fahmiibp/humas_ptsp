<?php

namespace App\Livewire;

use Filament\Widgets\Widget;

class ArsipBannerWidget extends Widget
{
    protected string $view = 'livewire.arsip-banner-widget';
    protected int | string | array $columnSpan = 'full';
}
