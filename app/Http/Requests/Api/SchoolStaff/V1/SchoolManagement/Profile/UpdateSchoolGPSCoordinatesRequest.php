<?php

namespace App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSchoolGPSCoordinatesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'latitude' => ['required'],
            'longitude' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'latitude.required' => 'Latitude is required',
            'longitude.required' => 'Longitude is required',
        ];
    }
}
