<?php

namespace App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Classroom;

use Illuminate\Foundation\Http\FormRequest;

class CreateClassroomRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'form_teacher_id' => ['nullable', 'uuid', 'exists:school_staff,id'],
            'name' => ['required', 'string', 'between:3,100'],
        ];
    }

    public function messages(): array
    {
        return [
            'form_teacher_id.uuid' => 'The form teacher ID must be a valid UUID.',
            'form_teacher_id.exists' => 'The selected form teacher ID does not exist in our records.',

            'name.required' => 'The name is required.',
            'name.string' => 'The name must be a valid string.',
            'name.between' => 'The name must be between 3 and 100 characters long.',
        ];
    }
}
