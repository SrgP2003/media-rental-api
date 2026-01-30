<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'media_id',
        'customer_id',
        'starts_at',
        'ends_at',
        'total_price',
        'status',
    ];

    protected $casts = [
        'starts_at' => 'date',
        'ends_at' => 'date',
        'total_price' => 'decimal:2',
    ];

    //Considerando que la reserva pertenece a un medio publicitario
    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }
    //Considerando que la reserva pertenece a un cliente
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    // Método para calcular la duración de la reserva en días
    public function getDurationInDays(): int
    {
        return $this->starts_at->diffInDays($this->ends_at) + 1; // +1 para incluir el día de inicio
    }
}
