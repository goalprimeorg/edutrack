<?php

namespace App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Profile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetSchoolProfileResource extends JsonResource
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
            'name' => $this->name,
            'address' => $this->address,
            'local_government_area' => $this->localGovernmentArea->name,
            'contact_person' => [
                'name' => "{$this->schoolAdmin->first_name} {$this->schoolAdmin->last_name}",
                'email' => $this->schoolAdmin->email,
                'phone_number' => $this->schoolAdmin->phone_number,
            ],
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'has_completed_profile' => $this->has_completed_profile,
            'total_no_male_students' => $this->metric->total_no_male_students,
            'total_no_female_students' => $this->metric->total_no_female_students,
            'total_no_disabled_male_students' => $this->metric->total_no_disabled_male_students,
            'total_no_disabled_female_students' => $this->metric->total_no_disabled_female_students,
            'total_no_male_staff' => $this->metric->total_no_male_staff,
            'total_no_female_staff' => $this->metric->total_no_female_staff,
            'total_no_disabled_male_staff' => $this->metric->total_no_disabled_male_staff,
            'total_no_disabled_female_staff' => $this->metric->total_no_disabled_female_staff,
        ];
    }
}
