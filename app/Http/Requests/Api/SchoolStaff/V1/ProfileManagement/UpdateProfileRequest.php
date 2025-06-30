<?php

namespace App\Http\Requests\Api\SchoolStaff\V1\ProfileManagement;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'between:3,100'],
            'middle_name' => ['nullable', 'between:3,100'],
            'last_name' => ['required', 'between:3,100'],
            'phone_number' => ['required', 'string', 'digits:11'],
            'level' => ['required', 'string'],
            'highest_qualification_id' => ['required', 'uuid', 'exists:qualification_types,id'],
            'trainings_attended' => ['nullable', 'array'],
            'trainings_attended.*.name' => ['nullable', 'string'],
            'trainings_attended.*.date' => ['nullable', 'date_format:Y-m-d'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'first_name.between' => 'First name must be between 3 and 100 characters.',

            'middle_name.between' => 'Middle name must be between 3 and 100 characters.',

            'last_name.required' => 'Last name is required.',
            'last_name.between' => 'Last name must be between 3 and 100 characters.',

            'phone_number.required' => 'Phone number is required.',
            'phone_number.string' => 'Phone number must be a valid string.',
            'phone_number.digits' => 'Phone number must be exactly 11 digits.',

            'level.required' => 'Level is required.',
            'level.string' => 'Level must be a valid string.',

            'highest_qualification_id.required' => 'Highest qualification is required.',
            'highest_qualification_id.uuid' => 'Highest qualification ID must be a valid UUID.',
            'highest_qualification_id.exists' => 'The selected highest qualification is invalid.',

            'trainings_attended.array' => 'Trainings attended must be an array.',

            'trainings_attended.*.name.string' => 'Training name must be a valid string.',

            'trainings_attended.*.date.date_format' => 'Training date must be in the format YYYY-MM-DD.',
        ];
    }
}
