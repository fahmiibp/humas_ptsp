<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $table = 'kategoris';

    protected $fillable = [
        'nama_kategori',
        'slug',
        'deskripsi',
    ];

    public function wartas(): HasMany
    {
        return $this->hasMany(Warta::class, 'kategori_id');
    }
}