<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'name',
        'type',
        'location',
        'dimensions',
        'price_per_day',
        'status',
    ];
}
