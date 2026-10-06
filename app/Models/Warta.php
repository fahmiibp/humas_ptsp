<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warta extends Model
{
    protected $table = 'warta';

    protected $fillable = [
        'judul_siaran_pers',
        'slug_url',
        'lead_berita',
        'badan_berita',
        'status_naskah',
        'jadwal_tayang',
        'catatan_koreksi',
        'timeline_id',
        'users_id',
        'dokumentasi_utama'
    ];

    protected $casts = [
        'dokumentasi_utama' => 'array',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function timeline()
    {
        return $this->belongsTo(Timeline::class, 'timeline_id');
    }
}
