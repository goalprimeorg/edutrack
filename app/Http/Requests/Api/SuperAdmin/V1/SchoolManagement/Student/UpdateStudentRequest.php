<?php

namespace App\Http\Requests\Api\SuperAdmin\V1\SchoolManagement\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'school_id' => ['required', 'uuid', 'exists:schools,id'],
            'current_classroom_id' => ['required', 'uuid', 'exists:classrooms,id'],
            'first_name' => ['required', 'between:3,100'],
            'last_name' => ['required', 'between:3,100'],
            'registration_number' => [
                'required',
                Rule::unique('students', 'registration_number')->ignore($this->route('studentId')),
            ],
            'guardian_first_name' => ['required', 'between:3,100'],
            'guardian_last_name' => ['required', 'between:3,100'],
            'guardian_phone_number' => ['required', 'between:11,11'],
        ];
    }

    public function messages(): array
    {
        return [
            'school_id.required' => 'The school is required.',
            'school_id.uuid' => 'The school must be a valid UUID.',
            'school_id.exists' => 'The selected school does not exist.',

            'current_classroom_id.required' => 'The classroom is required.',
            'current_classroom_id.uuid' => 'The classroom must be a valid UUID.',
            'current_classroom_id.exists' => 'The selected classroom does not exist.',

            'first_name.required' => 'The first name is required.',
            'first_name.between' => 'The first name must be between 3 and 100 characters.',

            'last_name.required' => 'The last name is required.',
            'last_name.between' => 'The last name must be between 3 and 100 characters.',

            'registration_number.required' => 'The registration number is required.',
            'registration_number.unique' => 'The registration number has already been taken.',

            'guardian_first_name.required' => 'The guardian\'s first name is required.',
            'guardian_first_name.between' => 'The guardian\'s first name must be between 3 and 100 characters.',

            'guardian_last_name.required' => 'The guardian\'s last name is required.',
            'guardian_last_name.between' => 'The guardian\'s last name must be between 3 and 100 characters.',

            'guardian_phone_number.required' => 'The guardian\'s phone number is required.',
            'guardian_phone_number.between' => 'The guardian\'s phone number must be exactly 11 digits.',
        ];
    }
}
