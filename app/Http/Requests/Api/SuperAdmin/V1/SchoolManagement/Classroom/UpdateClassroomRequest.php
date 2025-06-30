<?php

namespace App\Http\Requests\Api\SuperAdmin\V1\SchoolManagement\Classroom;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClassroomRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'school_id' => ['required', 'uuid', 'exists:schools,id'],
            'form_teacher_id' => ['nullable', 'uuid', 'exists:school_staff,id'],
            'name' => ['required', 'string', 'between:3,100'],
        ];
    }

    public function messages(): array
    {
        return [
            'school_id.required' => 'The school is required.',
            'school_id.uuid' => 'The school must be a valid UUID.',
            'school_id.exists' => 'The selected school does not exist in our records.',

            'form_teacher_id.uuid' => 'The form teacher ID must be a valid UUID.',
            'form_teacher_id.exists' => 'The selected form teacher ID does not exist in our records.',

            'name.required' => 'The name is required.',
            'name.string' => 'The name must be a valid string.',
            'name.between' => 'The name must be between 3 and 100 characters long.',
        ];
    }
}
