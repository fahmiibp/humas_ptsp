<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class KontenMedsos extends Model
{

    protected $table = 'konten_medsos';


    protected $fillable = [

        'tanggal',
        'judul',
        'caption',
        'platform',
        'status',
        'jam_tayang',
        'gambar',
        'hastag',
        'format',
        'link',
        'agenda_id',

    ];
    protected function casts(): array
    {
        return [
            'hastag' => 'array',
            'tanggal' => 'date',
        ];
    }

}