<?php

namespace App\Http\Requests\Api\SchoolStaff\V1\StoreManagement\StoreItemLog;

use Illuminate\Foundation\Http\FormRequest;

class FetchStoreItemLogsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'school_store_item_id' => ['nullable', 'uuid'],
            'per_page' => ['nullable', 'integer', 'between:1,100'],
            'page' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'per_page.integer' => 'The per-page value must be an integer.',
            'per_page.between' => 'The per-page value must be between 1 and 100.',

            'page.integer' => 'The page number must be an integer.',
            'page.min' => 'The page number must be at least 1.',
        ];
    }
}
