<?php

namespace App\Http\Requests\Api\SuperAdmin\V1\SchoolManagement\Profile;

use Illuminate\Foundation\Http\FormRequest;

class FetchSchoolsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'local_government_area_id' => ['nullable', 'uuid', 'exists:local_government_areas,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'page.integer' => 'The page number must be an integer.',
            'page.integer' => 'The page number must be at least 1.',
            'per_page.integer' => 'The per-page value must be an integer.',
            'per_page.min' => 'The per-page value must be at least 1.',
            'per_page.max' => 'The per-page value may not be greater than 100.',
            'local_government_area_id.uuid' => 'The local government area ID must be a valid UUID.',
            'local_government_area_id.exists' => 'The selected local government area does not exist in our records.',
        ];
    }
}
