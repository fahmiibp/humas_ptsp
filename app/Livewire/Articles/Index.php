<?php

namespace App\Livewire\Articles;

use App\Repositories\ArticleRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url] public string $search = '';
    #[Url] public ?string $category = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function render(ArticleRepository $repo)
    {
        $perPage = 6;

        $items = $repo->all()
            ->when($this->search, fn($c) => $c->filter(
                fn($a) => str_contains(strtolower($a->title), strtolower($this->search))
            ))
            ->when($this->category, fn($c) => $c->where('category', $this->category))
            ->values();

        $articles = new LengthAwarePaginator(
            $items->forPage($this->getPage(), $perPage)->values(),
            $items->count(),
            $perPage,
            $this->getPage(),
            ['path' => request()->url()]
        );

        return view('livewire.articles.index', [
            'articles'   => $articles,
            'categories' => $repo->categories(),
        ]);
    }
}
