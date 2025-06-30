<?php

namespace App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Staff;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStaffRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'current_classroom_id' => ['nullable', 'uuid', 'exists:classrooms,id'],
            'first_name' => ['required', 'between:3,100'],
            'middle_name' => ['nullable', 'between:3,100'],
            'last_name' => ['required', 'between:3,100'],
            'phone_number' => ['required', 'string', 'digits:11'],
            'gender' => ['required', 'in:male,female'],
            'is_staff_disabled' => ['required', 'boolean'],
            'disability' => ['required_if:is_staff_disabled,true', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', Rule::unique('students', 'registration_number')->ignore($this->route('staffId'))],
        ];
    }

    public function messages(): array
    {
        return [
            'current_classroom_id.uuid' => 'The classroom must be a valid UUID.',
            'current_classroom_id.exists' => 'The selected classroom does not exist.',

            'first_name.required' => 'The first name is required.',
            'first_name.between' => 'The first name must be between 3 and 100 characters.',

            'middle_name.between' => 'The middle name must be between 3 and 100 characters.',

            'gender.required' => 'Gender is required.',
            'gender.in' => 'Gender must be either male or female.',

            'is_staff_disabled.required' => 'Please indicate if the staff has a disability.',
            'is_staff_disabled.boolean' => 'The disability status must be true or false.',

            'disability.required_if' => 'Disability details are required when the staff has a disability.',
            'disability.string' => 'Disability details must be a valid text.',
            'disability.max' => 'Disability details may not exceed 255 characters.',

            'last_name.required' => 'The last name is required.',
            'last_name.between' => 'The last name must be between 3 and 100 characters.',

            'email.required' => 'The email is required.',
            'email.unique' => 'The email has already been taken.',

            'phone_number.required' => 'The phone number is required.',
            'phone_number.between' => 'The phone number must be exactly 11 digits.',
        ];
    }
}
