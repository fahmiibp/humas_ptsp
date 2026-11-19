<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    protected $fillable = [
        'logo',
        'alamat',
        'email',
        'telepon_1',
        'telepon_2',
        'instagram',
        'facebook',
        'youtube',
        'whatsapp',
        'deskripsi_sosial',
        'copyright',
        'dikelola_oleh',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}