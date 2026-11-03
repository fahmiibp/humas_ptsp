<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Warta extends Model
{
    protected $table = 'warta';

    protected $fillable = [
        'judul_siaran_pers',
        'slug_url',
        'lead_berita',
        'badan_berita',
        'kategori_id',
        'status_naskah',
        'jadwal_tayang',
        'catatan_koreksi',
        'timeline_id',
        'users_id',
        'reviewed_by',
        'dokumentasi_utama',
        'is_hot_news',
        'hot_news_until',
    ];

    protected function casts(): array
    {
        return [
            'dokumentasi_utama' => 'array',
            'jadwal_tayang' => 'datetime',
            'is_hot_news' => 'boolean',
            'hot_news_until' => 'datetime',
        ];
    }

    /**
     * Scope: hanya berita yang sedang hot news.
     * Hot news dianggap aktif jika flag true dan belum melewati batas waktu (jika ada).
     */
    public function scopeHotNews(Builder $query): Builder
    {
        return $query->where('is_hot_news', true)
            ->where(function (Builder $q) {
                $q->whereNull('hot_news_until')
                    ->orWhere('hot_news_until', '>', now());
            });
    }

    /**
     * Cek apakah berita ini sedang hot news.
     */
    public function isHotNews(): bool
    {
        return $this->is_hot_news
            && ($this->hot_news_until === null || $this->hot_news_until->isFuture());
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function timeline(): BelongsTo
    {
        return $this->belongsTo(Timeline::class, 'timeline_id');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
}
