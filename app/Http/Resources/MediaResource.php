<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'location' => $this->location,
            'dimensions' => $this->dimensions,
            'price_per_day' => (float) $this->price_per_day,
            'status' => $this->status,

            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),

            //Solo en caso de cargar relaciones
            'bookings' => BookingResource::collection($this->whenLoaded('bookings')),
        ];
    }
}
