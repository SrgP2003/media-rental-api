<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Booking;
use Illuminate\Validation\Validator;

class BookingStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; //Mientras, no hay lógica de autorización
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'media_id' => 'required|exists:media,id',
            'customer_id' => 'required|exists:customers,id',
            'starts_at' => 'required|date|after_or_equal:today',
            'ends_at' => 'required|date|after_or_equal:starts_at',
            'total_price' => 'required|numeric|min:0',
            'status' => 'nullable|in:pending,confirmed,cancelled',
        ];
    }
    //Metodo para validar solapamientos de reservas
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            if ($this->hasOverlap()) {
                $validator->errors()->add(
                    'dates',
                    'El medio seleccionado ya está reservado para el rango de fechas proporcionado.'
                );
            }
        });
    }
    //Metodo para detectar solapamientos de reservas
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
}
