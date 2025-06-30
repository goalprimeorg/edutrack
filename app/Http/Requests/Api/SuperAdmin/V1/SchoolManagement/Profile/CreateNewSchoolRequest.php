<?php

namespace App\Http\Requests\Api\SuperAdmin\V1\SchoolManagement\Profile;

use Illuminate\Foundation\Http\FormRequest;

class CreateNewSchoolRequest extends FormRequest
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
            'local_government_area_id' => ['required', 'uuid', 'exists:local_government_areas,id'],
            'school_admin.first_name' => ['required', 'string', 'between:3,100'],
            'school_admin.last_name' => ['required', 'string', 'between:3,100'],
            'school_admin.email' => ['required', 'email', 'between:3,100', 'unique:school_staff,email'],
            'school_admin.phone_number' => ['required', 'string', 'between:11,11'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The school name is required.',
            'name.string' => 'The school name must be a valid string.',
            'name.between' => 'The school name must be between 3 and 100 characters.',

            'address.required' => 'The school address is required.',
            'address.string' => 'The school address must be a valid string.',
            'address.between' => 'The school address must be between 3 and 200 characters.',

            'local_government_area_id.required' => 'The Local Government Area ID is required.',
            'local_government_area_id.uuid' => 'The Local Government Area ID must be a valid UUID.',
            'local_government_area_id.exists' => 'The selected Local Government Area does not exist.',

            'school_admin.first_name.required' => 'The first name of the school admin is required.',
            'school_admin.first_name.string' => 'The first name of the school admin must be a valid string.',
            'school_admin.first_name.between' => 'The first name of the school admin must be between 3 and 100 characters.',

            'school_admin.last_name.required' => 'The last name of the school admin is required.',
            'school_admin.last_name.string' => 'The last name of the school admin must be a valid string.',
            'school_admin.last_name.between' => 'The last name of the school admin must be between 3 and 100 characters.',

            'school_admin.email.required' => 'The email address of the school admin is required.',
            'school_admin.email.email' => 'The email address of the school admin must be a valid email address.',
            'school_admin.email.between' => 'The email address of the school admin must be between 3 and 100 characters.',

            'school_admin.phone_number.required' => 'The phone number of the school admin is required.',
            'school_admin.phone_number.string' => 'The phone number of the school admin must be a valid string.',
            'school_admin.phone_number.between' => 'The phone number of the school admin must be exactly 11 characters.',
        ];
    }
}
