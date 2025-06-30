<?php

namespace App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\IncidentReport;

use Illuminate\Foundation\Http\FormRequest;

class FetchIncidentReportsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'incident_type_id' => ['nullable', 'uuid', 'exists:incident_types,id'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'incident_type_id.uuid' => 'The classroom must be a valid UUID.',
            'incident_type_id.exists' => 'The selected classroom does not exist.',

            'page.integer' => 'The page number must be an integer.',
            'page.min' => 'The page number must be at least 1.',

            'per_page.integer' => 'The per-page value must be an integer.',
            'per_page.min' => 'The per-page value must be at least 1.',
            'per_page.max' => 'The per-page value must not exceed 100.',
        ];
    }
}
