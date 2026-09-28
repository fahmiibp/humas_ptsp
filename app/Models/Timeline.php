<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    protected $table = 'timeline';
    protected $fillable = [
        'event_name','start_date','end_date','location'
    ];
}
