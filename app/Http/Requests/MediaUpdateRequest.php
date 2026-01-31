<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Sin auth por ahora
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|string|max:100',
            'location' => 'sometimes|string|max:255',
            'dimensions' => 'sometimes|string|max:100',
            'price_per_day' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:active,inactive',
        ];
    }
    public function messages()
    {
        return [
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'type.string' => 'El tipo debe ser una cadena de texto.',
            'location.string' => 'La ubicación debe ser una cadena de texto.',
            'dimensions.string' => 'Las dimensiones deben ser una cadena de texto.',
            'price_per_day.numeric' => 'El precio por día debe ser un número.',
            'price_per_day.min' => 'El precio por día no puede ser negativo.',
            'status.in' => 'El estado debe ser "active" o "inactive".',
        ];
    }
}
