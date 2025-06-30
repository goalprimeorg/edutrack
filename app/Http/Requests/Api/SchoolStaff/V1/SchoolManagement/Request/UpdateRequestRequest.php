<?php

namespace App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Request;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequestRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'request_type_id' => ['required', 'uuid', 'exists:request_types,id'],
            'requested_quantity' => ['required', 'numeric', 'between:1,100'],
            'priority' => ['required', 'string', 'in:low,medium,high'],
            'remarks' => ['required', 'string', 'between:1,1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'request_type_id.required' => 'The request type ID is required.',
            'request_type_id.uuid' => 'The request type ID must be a valid UUID.',
            'request_type_id.exists' => 'The specified request type ID does not exist in our records.',

            'requested_quantity.required' => 'The requested quantity is required.',
            'requested_quantity.numeric' => 'The requested quantity must be a number.',
            'requested_quantity.between' => 'The requested quantity must be between 1 and 100.',

            'priority.required' => 'The priority field is required.',
            'priority.string' => 'The priority must be a valid string.',
            'priority.in' => 'The priority must be one of the following values: low, medium, or high.',

            'remarks.required' => 'Remarks are required.',
            'remarks.string' => 'Remarks must be a valid string.',
            'remarks.between' => 'Remarks must be between 1 and 1000 characters long.',
        ];
    }
}
