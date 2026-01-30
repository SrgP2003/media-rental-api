<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Booking;

class BookingStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'media_id' => ['required', 'exists:media,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'starts_at' => ['required', 'date', 'after_or_equal:today'],
            'ends_at' => ['required', 'date', 'after_or_equal:starts_at'],
            'status' => ['nullable', 'in:pending,confirmed,cancelled'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {

            if (
                !$this->filled('media_id') ||
                !$this->filled('starts_at') ||
                !$this->filled('ends_at')
            ) {
                return;
            }
            if (!$this->isMediaActive()) { //Verifica si el media esta activo
                $validator->errors()->add(
                    'media_id',
                    'El medio seleccionado no está activo.'
                );
            }

            if ($this->hasOverlap()) {
                $validator->errors()->add(
                    'starts_at',
                    'El medio seleccionado ya está reservado para el rango de fechas proporcionado.'
                );
            }
        });
    }

    private function hasOverlap(): bool
    {
        return Booking::where('media_id', $this->media_id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) {
                $query->where('starts_at', '<=', $this->ends_at)
                    ->where('ends_at', '>=', $this->starts_at);
            })
            ->exists();
    }

    private function isMediaActive(): bool
    {
        $media = \App\Models\Media::find($this->media_id);
        return $media && $media->status === 'active';
    }
}
