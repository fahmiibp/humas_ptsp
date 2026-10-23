<?php

namespace App\Livewire\Articles;

use App\Repositories\ArticleRepository;
use Livewire\Component;

class Show extends Component
{
    public string $slug;

    public function mount(string $slug, ArticleRepository $repo)
    {
        abort_unless($repo->findBySlug($slug), 404);
        $this->slug = $slug;
    }

    public function render(ArticleRepository $repo)
    {
        $article = $repo->findBySlug($this->slug);

        return view('livewire.articles.show', [
            'article' => $article,
            'related' => $repo->related($article),
        ])->title($article->title);
    }
}
