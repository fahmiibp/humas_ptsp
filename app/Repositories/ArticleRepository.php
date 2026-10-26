<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class ArticleRepository
{
    public function all(): Collection
    {
        $path = storage_path('app/articles.json');

        if (! File::exists($path)) {
            return collect();
        }

        return collect(json_decode(File::get($path), true))
            ->map(function (array $a) {
                $a['published_at'] = Carbon::parse($a['published_at']);
                return (object) $a;
            })
            ->filter(fn($a) => $a->published_at->lte(now()))
            ->sortByDesc('published_at')
            ->values();
    }

    public function categories(): Collection
    {
        return $this->all()->pluck('category')->unique()->values();
    }

    public function findBySlug(string $slug): ?object
    {
        return $this->all()->firstWhere('slug', $slug);
    }

    public function related(object $article, int $limit = 3): Collection
    {
        return $this->all()
            ->where('category', $article->category)
            ->where('slug', '!=', $article->slug)
            ->take($limit);
    }
}
