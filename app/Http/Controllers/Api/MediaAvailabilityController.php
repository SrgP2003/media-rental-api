<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MediaAvailabilityController extends Controller
{
    //Validacion respecto a las fechas de inicio y fin
    public function check(Request $request, Media $media)
    {
        $request->validate([
            'starts_at' => 'required|date|before:ends_at',
            'ends_at' => 'required|date|after:starts_at',
        ]);
        $start = Carbon::parse($request->starts_at);
        $end = Carbon::parse($request->ends_at);

        //Para verificar la disponibilidad, se buscan reservas que se solapen
        $hasOverlap = $media->bookings()
            ->where('status', '!=', 'cancelled') //Ignorar reservas canceladas
            ->where(function ($query) use ($start, $end) {
                $query->where('starts_at', '<', $end)
                    ->where('ends_at', '>', $start);
            })
            ->exists();

        return response()->json([
            'media_id' => $media->id,
            'available' => !$hasOverlap,
            'starts_at' => $start->toDateString(),
            'ends_at' => $end->toDateString(),
        ]);
    }
}
