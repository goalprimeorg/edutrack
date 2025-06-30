<?php

namespace App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Staff;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FetchStaffResource extends JsonResource
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
            'full_name' => "{$this->first_name} {$this->middle_name} {$this->last_name}",
            'current_classroom' => $this->currentClassroom ? $this->currentClassroom->name : 'Not Set',
            'phone_number' => $this->phone_number,
            'gender' => $this->gender,
            'role' => $this->role,
            'email' => $this->email,
            'profile_photo_url' => $this->profile_photo_url,
        ];
    }
}
