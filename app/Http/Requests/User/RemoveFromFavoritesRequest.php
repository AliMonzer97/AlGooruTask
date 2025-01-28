<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RemoveFromFavoritesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'ids' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'ids.required' => 'The favorite IDs field is required.',
            'ids.string' => 'The favorite IDs must be a string.',
        ];
    }
}
