<?php

namespace App\Http\Requests\Api\SuperAdmin\V1\SchoolManagement\Student;

use Illuminate\Foundation\Http\FormRequest;

class FetchStudentsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'school_id' => ['nullable', 'uuid', 'exists:schools,id'],
            'current_classroom_id' => ['nullable', 'uuid', 'exists:classrooms,id'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'school_id.uuid' => 'The school must be a valid UUID.',
            'school_id.exists' => 'The selected school does not exist.',

            'current_classroom_id.uuid' => 'The classroom must be a valid UUID.',
            'current_classroom_id.exists' => 'The selected classroom does not exist.',

            'page.integer' => 'The page number must be an integer.',
            'page.min' => 'The page number must be at least 1.',

            'per_page.integer' => 'The per-page value must be an integer.',
            'per_page.min' => 'The per-page value must be at least 1.',
            'per_page.max' => 'The per-page value must not exceed 100.',
        ];
    }
}
