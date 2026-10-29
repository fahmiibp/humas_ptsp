<?php

namespace App\Models;

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
    ];

    protected function casts(): array
    {
        return [
            'dokumentasi_utama' => 'array',
            'jadwal_tayang' => 'date',
        ];
    }

    /**
     * Relasi ke penulis berita.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    /**
     * Relasi ke verifikator yang memeriksa berita.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Relasi ke agenda atau timeline liputan.
     */
    public function timeline(): BelongsTo
    {
        return $this->belongsTo(Timeline::class, 'timeline_id');
    }

    /**
     * Relasi ke kategori berita.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
