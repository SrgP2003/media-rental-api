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
}
