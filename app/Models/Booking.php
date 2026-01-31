<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

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
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'total_price' => 'decimal:2',
    ];

    protected $attributes = [
        'status' => 'pending',
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

    /**
     * @return int //Para el numero de dias de la reserva
     */
    public function getDurationInDays(): int
    {
        return $this->starts_at->diffInDays($this->ends_at) + 1; // +1 para incluir el día de inicio
    }

    /**
     * @return float //Para el precio total de la reserva
     */
    public function calculateTotalPrice(): float
    {
        if (!$this->media) {
            return 0.0;
        }
        return $this->getDurationInDays() * $this->media->price_per_day;
    }

    /**
     * Calcula el precio total desde fechas sin tener una reserva guardada.
     * Método estático para usar antes de crear la reserva.
     *
     * @param Carbon $startDate Fecha de inicio
     * @param Carbon $endDate Fecha de fin
     * @param float $pricePerDay Precio por día del medio
     * @return float Precio total calculado
     */
    public static function calculatePriceFromDates(Carbon $startDate, Carbon $endDate, float $pricePerDay): float
    {
        $days = $startDate->diffInDays($endDate) + 1;
        return $days * $pricePerDay;
    }
}
