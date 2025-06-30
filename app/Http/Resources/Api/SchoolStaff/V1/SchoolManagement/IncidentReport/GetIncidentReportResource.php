<?php

namespace App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\IncidentReport;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetIncidentReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name_of_reporter' => $this->name_of_reporter,
            'date_of_incident' => $this->date_of_incident,
            'tracking_code' => $this->tracking_code,
            'type_of_incident' => [
                'id' => $this->incidentType->id,
                'name' => $this->incidentType->name,
            ],
            'description' => $this->description,
        ];
    }
}
