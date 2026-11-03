<?php

namespace App\Livewire\Articles;

use App\Models\Warta;
use App\Models\Kategori;
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
            ->with('kategori')
            ->where('status_naskah', 'Sudah Tayang')
            ->whereNotNull('jadwal_tayang')
            ->whereDate('jadwal_tayang', '<=', now()->toDateString())

            // Pencarian berita
            ->when($this->search, function (Builder $query) {
                $search = $this->search;

                $query->where(function (Builder $query) use ($search) {
                    $query
                        ->where('judul_siaran_pers', 'like', "%{$search}%")
                        ->orWhere('lead_berita', 'like', "%{$search}%")
                        ->orWhereHas('kategori', function (Builder $query) use ($search) {
                            $query->where('nama_kategori', 'like', "%{$search}%");
                        });
                });
            })

            // Filter berdasarkan SLUG kategori
            ->when($this->category, function (Builder $query) {
                $query->whereHas('kategori', function (Builder $query) {
                    $query->where('slug', $this->category);
                });
            })

            ->orderByDesc('jadwal_tayang')
            ->paginate(6);

        $showHot = ! $this->search && ! $this->category;

        $hotNews = $showHot
            ? Warta::query()
            ->with('kategori')
            ->where('status_naskah', 'Sudah Tayang')
            ->whereNotNull('jadwal_tayang')
            ->whereDate('jadwal_tayang', '<=', now()->toDateString())
            ->hotNews()
            ->orderByDesc('jadwal_tayang')
            ->limit(3)
            ->get()
            : collect();

        $hotTicker = $showHot
            ? Warta::query()
            ->where('status_naskah', 'Sudah Tayang')
            ->whereNotNull('jadwal_tayang')
            ->whereDate('jadwal_tayang', '<=', now()->toDateString())
            ->hotNews()
            ->orderByDesc('jadwal_tayang')
            ->limit(5)
            ->get(['id', 'judul_siaran_pers', 'slug_url'])
            : collect();

        // Ambil kategori yang memiliki berita terpublikasi
        $categoryIds = Warta::query()
            ->select('kategori_id')
            ->where('status_naskah', 'Sudah Tayang')
            ->whereNotNull('jadwal_tayang')
            ->whereDate('jadwal_tayang', '<=', now()->toDateString())
            ->whereNotNull('kategori_id')
            ->distinct();

        $categories = Kategori::query()
            ->whereIn('id', $categoryIds)
            ->orderBy('nama_kategori')
            ->get();

        return view('livewire.articles.index', [
            'articles' => $articles,
            'categories' => $categories,
            'hotNews'    => $hotNews,
            'hotTicker'  => $hotTicker,
        ]);
    }
}
