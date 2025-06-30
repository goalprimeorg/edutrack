<?php

namespace App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Referral;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetStudentByRegistrationNumberResource extends JsonResource
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
            'student_name' => "{$this->first_name} {$this->middle_name} {$this->last_name}",
            'classroom' => $this->currentClassroom->name,
        ];
    }
}
