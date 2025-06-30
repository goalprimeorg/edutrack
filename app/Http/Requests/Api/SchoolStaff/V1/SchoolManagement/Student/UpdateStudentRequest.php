<?php

namespace App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'current_classroom_id' => ['required', 'uuid', 'exists:classrooms,id'],
            'first_name' => ['required', 'between:3,100'],
            'middle_name' => ['nullable', 'between:3,100'],
            'last_name' => ['required', 'between:3,100'],
            'registration_number' => ['required', Rule::unique('students', 'registration_number')->ignore($this->route('studentId'))],
            'gender' => ['required', 'in:male,female'],
            'is_student_disabled' => ['required', 'boolean'],
            'disability' => ['required_if:is_student_disabled,true', 'string', 'max:255'],
            'guardian_first_name' => ['required', 'between:3,100'],
            'guardian_last_name' => ['required', 'between:3,100'],
            'guardian_phone_number' => ['required', 'digits:11'],
        ];
    }


    public function messages(): array
    {
        return [
            'current_classroom_id.required' => 'The current classroom is required.',
            'current_classroom_id.uuid' => 'The current classroom ID must be a valid UUID.',
            'current_classroom_id.exists' => 'The selected classroom does not exist.',

            'first_name.required' => 'First name is required.',
            'first_name.between' => 'First name must be between 3 and 100 characters.',

            'middle_name.between' => 'Middle name must be between 3 and 100 characters.',

            'last_name.required' => 'Last name is required.',
            'last_name.between' => 'Last name must be between 3 and 100 characters.',

            'registration_number.required' => 'Registration number is required.',
            'registration_number.unique' => 'The registration number has already been taken.',

            'gender.required' => 'Gender is required.',
            'gender.in' => 'Gender must be either male or female.',

            'is_student_disabled.required' => 'Please indicate if the student has a disability.',
            'is_student_disabled.boolean' => 'The disability status must be true or false.',

            'disability.required_if' => 'Disability details are required when the student has a disability.',
            'disability.string' => 'Disability details must be a valid text.',
            'disability.max' => 'Disability details may not exceed 255 characters.',

            'guardian_first_name.required' => 'Guardian\'s first name is required.',
            'guardian_first_name.between' => 'Guardian\'s first name must be between 3 and 100 characters.',

            'guardian_last_name.required' => 'Guardian\'s last name is required.',
            'guardian_last_name.between' => 'Guardian\'s last name must be between 3 and 100 characters.',

            'guardian_phone_number.required' => 'Guardian\'s phone number is required.',
            'guardian_phone_number.digits' => 'Guardian\'s phone number must be exactly 11 digits.',
        ];
    }
}
