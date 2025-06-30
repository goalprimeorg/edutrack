<?php

namespace App\Http\Requests\Api\SchoolStaff\V1\ProfileManagement;

use Illuminate\Foundation\Http\FormRequest;

class UploadProfilePhotoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'profile_photo' => ['required', 'file', 'mimes:png,jpg,jpeg'],
        ];
    }

    public function messages(): array
    {
        return [
            'profile_photo.required' => 'Profile photo is required',
            'profile_photo.file' => 'Profile photo must be a file',
            'profile_photo.mimes' => 'Only png, jpg and jpeg photo types are allowed',
            'profile_photo.size' => 'Profile photo must not exceed 1mb',
        ];
    }
}
