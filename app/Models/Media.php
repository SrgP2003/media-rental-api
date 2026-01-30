<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    protected $casts = [
        'price_per_day' => 'decimal:2',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
