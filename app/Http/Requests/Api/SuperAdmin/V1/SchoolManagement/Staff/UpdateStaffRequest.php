<?php

namespace App\Http\Requests\Api\SuperAdmin\V1\SchoolManagement\Staff;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'school_id' => ['required', 'uuid', 'exists:schools,id'],
            'current_classroom_id' => ['nullable', 'uuid', 'exists:classrooms,id'],
            'first_name' => ['required', 'between:3,100'],
            'middle_name' => ['nullable', 'between:3,100'],
            'last_name' => ['required', 'between:3,100'],
            'phone_number' => ['required', 'string', 'digits:11'],
            'email' => ['required', 'string', 'email', 'unique:school_staff,email'],
        ];
    }

    public function messages(): array
    {
        return [
            'school_id.required' => 'The school is required.',
            'school_id.uuid' => 'The school must be a valid UUID.',
            'school_id.exists' => 'The selected school does not exist.',

            'current_classroom_id.uuid' => 'The classroom must be a valid UUID.',
            'current_classroom_id.exists' => 'The selected classroom does not exist.',

            'first_name.required' => 'The first name is required.',
            'first_name.between' => 'The first name must be between 3 and 100 characters.',

            'middle_name.between' => 'The middle name must be between 3 and 100 characters.',

            'last_name.required' => 'The last name is required.',
            'last_name.between' => 'The last name must be between 3 and 100 characters.',

            'email.required' => 'The email is required.',
            'email.unique' => 'The email has already been taken.',

            'phone_number.required' => 'The phone number is required.',
            'phone_number.between' => 'The phone number must be exactly 11 digits.',
        ];
    }
}
