<?php

namespace App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSchoolProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'between:3,100'],
            'address' => ['required', 'string', 'between:3,200'],
            'total_no_male_students' => ['required', 'integer', 'min:0'],
            'total_no_female_students' => ['required', 'integer', 'min:0'],
            'total_no_disabled_male_students' => ['required', 'integer', 'min:0'],
            'total_no_disabled_female_students' => ['required', 'integer', 'min:0'],
            'total_no_male_staff' => ['required', 'integer', 'min:0'],
            'total_no_female_staff' => ['required', 'integer', 'min:0'],
            'total_no_disabled_male_staff' => ['required', 'integer', 'min:0'],
            'total_no_disabled_female_staff' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
