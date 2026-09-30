<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    protected $table = 'arsip';
    protected $fillable = [
        'title', 'drive_url', 'event_date', 'photograper_name', 'notes', 'sample_photos'
    ];
}
