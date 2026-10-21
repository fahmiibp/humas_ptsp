<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Arsip extends Model
{
    protected $table = 'arsip';

    protected $fillable = [
        'id_timeline',
        'title',
        'drive_url',
        'event_date',
        'photograper_name',
        'notes',
        'sample_photos',
    ];

    protected function casts(): array
    {
        return [
            'sample_photos' => 'array',
            'event_date' => 'date',
        ];
    }

    public function photograper()
    {
        return $this->belongsTo(User::class, 'photograper_name');
    }
}
