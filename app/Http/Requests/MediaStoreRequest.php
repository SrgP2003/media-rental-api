<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'location' => 'required|string|max:255',
            'dimensions' => 'required|string|max:100',
            'price_per_day' => 'required|numeric|min:0',
            'status' => 'nullable|in:active,inactive',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'type.required' => 'El tipo es obligatorio.',
            'location.required' => 'La ubicación es obligatoria.',
            'dimensions.required' => 'Las dimensiones son obligatorias.',
            'price_per_day.required' => 'El precio por día es obligatorio.',
            'price_per_day.numeric' => 'El precio por día debe ser un número.',
            'price_per_day.min' => 'El precio por día no puede ser negativo.',
            'status.in' => 'El estado debe ser "active" o "inactive".',
        ];
    }
}
