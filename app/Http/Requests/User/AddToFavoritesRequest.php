<?php

namespace App\Http\Requests\User;

use App\Enums\FavoriteTypes;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddToFavoritesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'favorites' => 'required|array',
            'favorites.*.type' => ['required','string',Rule::in(FavoriteTypes::keys())],
            'favorites.*.value' => ['required','string'],
        ];
    }

    public function messages(): array
    {
        return [
            'favorites.required' => 'The favorites field is required.',
            'favorites.array' => 'The favorites field must be an array.',
            'favorites.*.type.required' => 'The type field is required for each favorite.',
            'favorites.*.type.string' => 'The type field must be a string.',
            'favorites.*.type.in' => 'The type field must be one of the valid types: ' . implode(', ', FavoriteTypes::keys()) . '.',
            'favorites.*.value.required' => 'The value field is required for each favorite.',
            'favorites.*.value.string' => 'The value field must be a string.',
        ];
    }
}
