<?php

namespace App\Repositories;

use App\Models\Warta;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class ArticleRepository
{
    /**
     * Mengambil semua artikel yang sudah dipublikasikan.
     */
    public function all(): Collection
    {
        return Warta::query()
            ->with('kategori')
            ->where('status_naskah', 'Sudah Tayang')
            ->whereNotNull('jadwal_tayang')
            ->whereDate('jadwal_tayang', '<=', now()->toDateString())
            ->orderByDesc('jadwal_tayang')
            ->get();
    }

    /**
     * Mengambil kategori yang memiliki artikel tayang.
     */
    public function categories(): SupportCollection
    {
        $categoryIds = Warta::query()
            ->select('kategori_id')
            ->where('status_naskah', 'Sudah Tayang')
            ->whereNotNull('jadwal_tayang')
            ->whereDate('jadwal_tayang', '<=', now()->toDateString())
            ->whereNotNull('kategori_id')
            ->distinct();

        return Kategori::query()
            ->whereIn('id', $categoryIds)
            ->orderBy('nama_kategori')
            ->get();
    }

    /**
     * Mengambil detail artikel berdasarkan slug.
     */
    public function findBySlug(string $slug): ?Warta
    {
        return Warta::query()
            ->with('kategori')
            ->where('slug_url', $slug)
            ->where('status_naskah', 'Sudah Tayang')
            ->whereNotNull('jadwal_tayang')
            ->whereDate('jadwal_tayang', '<=', now()->toDateString())
            ->first();
    }

    /**
     * Mengambil artikel terkait berdasarkan kategori.
     */
    public function related(
        Warta $article,
        int $limit = 3
    ): Collection {
        return Warta::query()
            ->with('kategori')
            ->where('kategori_id', $article->kategori_id)
            ->where('id', '!=', $article->id)
            ->where('status_naskah', 'Sudah Tayang')
            ->whereNotNull('jadwal_tayang')
            ->whereDate('jadwal_tayang', '<=', now()->toDateString())
            ->orderByDesc('jadwal_tayang')
            ->limit($limit)
            ->get();
    }

    public function hotNews(int $limit = 5): Collection
    {
        return Warta::query()
            ->with('kategori')
            ->hotNews() // scope dari model: is_hot_news = true dan belum lewat hot_news_until
            ->where('status_naskah', 'Sudah Tayang')
            ->whereNotNull('jadwal_tayang')
            ->whereDate('jadwal_tayang', '<=', now()->toDateString())
            ->orderByDesc('jadwal_tayang')
            ->limit($limit)
            ->get();
    }
}
