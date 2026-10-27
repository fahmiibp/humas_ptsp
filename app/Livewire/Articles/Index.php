<?php

namespace App\Livewire\Articles;

use App\Models\Warta;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public ?string $category = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCategory(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $articles = Warta::query()
            ->where('status_naskah', 'Sudah Tayang')
            ->whereNotNull('jadwal_tayang')
            ->whereDate('jadwal_tayang', '<=', now()->toDateString())
            ->when($this->search, function (Builder $query) {
                $query->where(function (Builder $query) {
                    $query
                        ->where(
                            'judul_siaran_pers',
                            'like',
                            '%' . $this->search . '%'
                        )
                        ->orWhere(
                            'lead_berita',
                            'like',
                            '%' . $this->search . '%'
                        )
                        ->orWhere(
                            'kategori',
                            'like',
                            '%' . $this->search . '%'
                        );
                });
            })
            ->when(
                $this->category,
                fn(Builder $query) => $query->where(
                    'kategori',
                    $this->category
                )
            )
            ->orderByDesc('jadwal_tayang')
            ->paginate(6);

        $categories = Warta::query()
            ->where('status_naskah', 'Sudah Tayang')
            ->whereNotNull('jadwal_tayang')
            ->whereDate('jadwal_tayang', '<=', now()->toDateString())
            ->whereNotNull('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('livewire.articles.index', [
            'articles' => $articles,
            'categories' => $categories,
        ]);
    }
}
