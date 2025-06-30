<?php

namespace App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Referral;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetReferralResource extends JsonResource
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
            'student' => [
                'id' => $this->student->id,
                'first_name' => $this->student->first_name,
                'middle_name' => $this->student->middle_name,
                'last_name' => $this->student->last_name,
            ],
            'referral_service_type' => [
                'id' => $this->referralServiceType->id,
                'name' => $this->referralServiceType->name,
            ],
            'status' => $this->status,
            'remarks' => $this->remarks,
        ];
    }
}
