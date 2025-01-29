<?php

namespace App\Http\Requests\News;

use App\Enums\GetNewsTypes;
use App\Filters\Types\NewsFilterFactory;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return array_merge([
            'type' => ['required', 'string', Rule::in(GetNewsTypes::cases())],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ], NewsFilterFactory::getValidationRules());
    }
}
