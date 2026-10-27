<?php

namespace App\Repositories;

use App\Models\Warta;
use Illuminate\Database\Eloquent\Collection;

class ArticleRepository
{
    public function all(): Collection
    {
        return Warta::query()
            ->whereNotNull('jadwal_tayang')
            ->whereDate('jadwal_tayang', '<=', now()->toDateString())
            ->where('status_naskah', 'Sudah Tayang')
            ->orderByDesc('jadwal_tayang')
            ->get();
    }

    public function categories(): \Illuminate\Support\Collection
    {
        return $this->all()
            ->pluck('kategori')
            ->filter()
            ->unique()
            ->values();
    }

    public function findBySlug(string $slug): ?Warta
    {
        return Warta::query()
            ->where('slug_url', $slug)
            ->where('status_naskah', 'Sudah Tayang')
            ->whereNotNull('jadwal_tayang')
            ->whereDate('jadwal_tayang', '<=', now()->toDateString())
            ->first();
    }

    public function related(Warta $article, int $limit = 3): Collection
    {
        return Warta::query()
            ->where('kategori', $article->kategori)
            ->where('slug_url', '!=', $article->slug_url)
            ->where('status_naskah', 'Sudah Tayang')
            ->whereNotNull('jadwal_tayang')
            ->whereDate('jadwal_tayang', '<=', now()->toDateString())
            ->orderByDesc('jadwal_tayang')
            ->limit($limit)
            ->get();
    }
}
