<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'starts_at' => $this->starts_at->toDateString(),
            'ends_at' => $this->ends_at->toDateString(),
            'duration_days' => $this->getDurationInDays(),
            'total_price' => (float) $this->total_price,
            'status' => $this->status,

            'media' => $this->whenLoaded('media', function () {
                return $this->media ? [
                    'id' => $this->media->id,
                    'name' => $this->media->name,
                    'type' => $this->media->type,
                ] : null;
            }),
            'customer' => $this->whenLoaded('customer', function () {
                return $this->customer ? [
                    'id' => $this->customer->id,
                    'name' => $this->customer->name,
                    'email' => $this->customer->email,
                ] : null;
            }),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
