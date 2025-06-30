<?php

namespace App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Request;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequestRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'requests' => ['required', 'array', 'min:1'],
            'requests.*.request_resource_type' => ['required', 'string', 'in:Learning Material,Teaching Material'],
            'requests.*.item_id' => ['required', 'uuid', 'exists:items,id'],
            'requests.*.priority' => ['required', 'string', 'in:low,medium,high'],
            'requests.*.requested_quantity' => ['required', 'numeric', 'between:1,100'],
            'requests.*.remarks' => ['required', 'string', 'between:1,1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'requests.required' => 'At least one request is required.',
            'requests.array' => 'The requests field must be an array of requests.',
            'requests.min' => 'Please include at least one request.',

            'requests.*.request_resource_type.required' => 'Each request must have a request type.',
            'requests.*.request_resource_type.string' => 'The request type must be a string.',
            'requests.*.request_resource_type.in' => 'The request type must be either "Learning Material" or "Teaching Material".',

            'requests.*.item_id.required' => 'Each request must include an item ID.',
            'requests.*.item_id.uuid' => 'The item ID must be a valid UUID.',
            'requests.*.item_id.exists' => 'The specified item ID does not exist in the items list.',

            'requests.*.priority.required' => 'Each request must specify a priority level.',
            'requests.*.priority.string' => 'The priority must be a string.',
            'requests.*.priority.in' => 'The priority must be one of the following: low, medium, or high.',

            'requests.*.requested_quantity.required' => 'Each request must have a specified quantity.',
            'requests.*.requested_quantity.numeric' => 'The requested quantity must be a number.',
            'requests.*.requested_quantity.between' => 'The requested quantity must be between 1 and 100.',

            'requests.*.remarks.required' => 'Remarks are required for each request.',
            'requests.*.remarks.string' => 'Remarks must be a string.',
            'requests.*.remarks.between' => 'Remarks must be between 1 and 1000 characters.',
        ];
    }
}
