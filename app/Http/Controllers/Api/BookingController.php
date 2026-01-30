<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingStoreRequest;
use App\Models\Booking;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\BookingStatusUpdateRequest;
use Nette\Utils\Json;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Booking::with(['media', 'customer'])
            ->orderBy('starts_at');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->media_id) {
            $query->where('media_id', $request->media_id);
        }

        return response()->json($query->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookingStoreRequest $request): JsonResponse
    {
        //Forma de obtener el medio publicitario asociado
        $media = Media::findOrFail($request->media_id);

        //Calculo de la duracion en días
        $days = $request->starts_at->diffInDays($request->ends_at) + 1;

        //Calculo del precio total
        $totalPrice = $days * $media->price_per_day;

        //Creacion de la reserva
        $booking = Booking::create([
            'media_id' => $request->media_id,
            'customer_id' => $request->customer_id,
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
            'total_price' => $totalPrice,
            'status' => $request->status ?? 'pending',
        ]);

        //Respuesta JSON con la reserva creada
        return response()->json($booking->load(['media', 'customer']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking): JsonResponse
    {
        return response()->json($booking->load(['media', 'customer']));
    }


    /**
     * Update the specified resource in storage.
     */
    /* public function update(Request $request, string $id)
    {
        //
    } */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking): JsonResponse
    {
        $booking->update([
            'status' => 'cancelled',
        ]);
        return response()->json(['message' => 'Reserva cancelada exitosamente.']);
    }

    public function updateStatus(
        BookingStatusUpdateRequest $request,
        Booking $booking
    ): JsonResponse {
        $booking->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Estado actualizado correctamente',
            'booking' => $booking,
        ]);
    }
}
