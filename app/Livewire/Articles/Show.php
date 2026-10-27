<?php

namespace App\Livewire\Articles;

use App\Models\Warta;
use App\Repositories\ArticleRepository;
use Livewire\Component;

class Show extends Component
{
    public string $slug;

    public function mount(string $slug, ArticleRepository $repo): void
    {
        abort_unless($repo->findBySlug($slug), 404);

        $this->slug = $slug;
    }

    public function render(ArticleRepository $repo)
    {
        $article = $repo->findBySlug($this->slug);

        abort_unless($article, 404);

        return view('livewire.articles.show', [
            'article' => $article,
            'related' => $repo->related($article),
        ])->title($article->judul_siaran_pers);
    }
}
