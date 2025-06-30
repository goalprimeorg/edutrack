<?php

namespace App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class FetchStudentAttendanceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date_of_attendance' => ['nullable', 'date_format:Y-m-d'],
            'marked_by_school_staff_id' => ['nullable', 'uuid'],
            'classroom_id' => ['nullable', 'uuid'],
            'per_page' => ['nullable', 'integer', 'between:1,100'],
            'page' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'date_of_attendance.date_format' => 'The date of attendance must be in the format YYYY-MM-DD.',

            'marked_by_school_staff_id.uuid' => 'The school staff ID must be a valid UUID.',

            'classroom_id.uuid' => 'The classroom ID must be a valid UUID.',

            'per_page.integer' => 'The per-page value must be an integer.',
            'per_page.between' => 'The per-page value must be between 1 and 100.',

            'page.integer' => 'The page number must be an integer.',
            'page.min' => 'The page number must be at least 1.',
        ];
    }
}
