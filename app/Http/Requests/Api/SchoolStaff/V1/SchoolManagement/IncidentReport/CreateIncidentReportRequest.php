<?php

namespace App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\IncidentReport;

use Illuminate\Foundation\Http\FormRequest;

class CreateIncidentReportRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'incident_type_id' => ['required', 'uuid', 'exists:incident_types,id'],
            'name_of_reporter' => ['required', 'between:3,100'],
            'date_of_incident' => ['required', 'date_format:Y-m-d'],
            'description' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'incident_type_id.required' => 'The incident type is required.',
            'incident_type_id.uuid' => 'The incident type must be a valid UUID.',
            'incident_type_id.exists' => 'The selected incident type does not exist.',

            'name_of_reporter.required' => 'Please provide the name of the reporter.',
            'name_of_reporter.between' => 'The name of the reporter must be between :min and :max characters.',

            'date_of_incident.required' => 'The date of the incident is required.',
            'date_of_incident.date_format' => 'The date of the incident must be in the format YYYY-MM-DD.',

            'description.required' => 'Please provide a description of the incident.',
            'description.string' => 'The description must be a valid string.',
        ];
    }
}
