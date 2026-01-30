<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingStoreRequest;
use App\Models\Booking;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\BookingStatusUpdateRequest;
use App\Http\Resources\BookingResource;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['media', 'customer'])
            ->orderBy('starts_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('media_id')) {
            $query->where('media_id', $request->media_id);
        }
        $bookings = $query->paginate(10); //Paginacion de 10 por página
        return BookingResource::collection($bookings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookingStoreRequest $request): JsonResponse
    {
        //Forma de obtener el medio publicitario asociado
        $media = Media::findOrFail($request->media_id);

        //Calculo de la duracion en días
        $start = Carbon::parse($request->starts_at);
        $end = Carbon::parse($request->ends_at);

        //Calculo del precio total utilizando el precio por día del medio
        $totalPrice = Booking::calculatePriceFromDates(
            $start,
            $end,
            $media->price_per_day
        );

        //Creacion de la reserva
        $booking = Booking::create([
            'media_id' => $request->media_id,
            'customer_id' => $request->customer_id,
            'starts_at' => $start,
            'ends_at' => $end,
            'total_price' => $totalPrice,
            'status' => $request->status ?? 'pending',
        ]);

        return (new BookingResource(
            $booking->load(['media', 'customer'])
        ))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking): BookingResource
    {
        return new BookingResource($booking->load(['media', 'customer']));
    }

    public function updateStatus(
        BookingStatusUpdateRequest $request,
        Booking $booking
    ): BookingResource {
        $booking->update(['status' => $request->status]);
        return new BookingResource($booking->load(['media', 'customer']));
    }
}
