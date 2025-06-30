<?php

namespace App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Referral;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FetchReferralsResource extends JsonResource
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
            'student_name' => "{$this->student->first_name} {$this->student->middle_name} {$this->student->last_name}",
            'referral_service_type' => $this->referralServiceType->name,
            'status' => $this->status,
        ];
    }
}
