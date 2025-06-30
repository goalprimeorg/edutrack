<?php

namespace App\Http\Resources\Api\SuperAdmin\V1\SchoolManagement\Profile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FetchSchoolsResource extends JsonResource
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
        ];
    }
}
