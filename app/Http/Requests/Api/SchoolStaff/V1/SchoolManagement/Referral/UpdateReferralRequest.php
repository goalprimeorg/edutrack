<?php

namespace App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Referral;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReferralRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'student_id' => ['required', 'uuid', 'exists:students,id'],
            'referral_service_type_id' => ['required', 'uuid', 'exists:referral_service_types,id'],
            'remarks' => ['required', 'string', 'between:1,1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required' => 'The student ID is required.',
            'student_id.uuid' => 'The student ID must be a valid UUID.',
            'student_id.exists' => 'The specified student ID does not exist in our records.',
            'referral_service_type_id.required' => 'The referral service type ID is required.',
            'referral_service_type_id.uuid' => 'The referral service type ID must be a valid UUID.',
            'referral_service_type_id.exists' => 'The specified referral service type ID does not exist in our records.',
            'remarks.required' => 'The remark is required',
            'remarks.string' => 'The remark must be a valid string',
            'remarks.between' => 'The remark must be between 1 to 1000 characters',
        ];
    }
}
