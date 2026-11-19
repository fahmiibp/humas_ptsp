<?php

namespace App\Livewire\Faq;

use App\Models\Faq;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $faqs = Faq::query()
            ->where('is_active', true)
            ->orderBy('urutan')
            ->orderBy('id')
            ->get();

        return view('livewire.faq.index', [
            'faqs' => $faqs,
        ]);
    }
}