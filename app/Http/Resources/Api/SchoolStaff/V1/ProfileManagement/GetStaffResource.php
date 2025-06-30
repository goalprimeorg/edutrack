<?php

namespace App\Http\Resources\Api\SchoolStaff\V1\ProfileManagement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetStaffResource extends JsonResource
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
            'current_classroom' => $this->currentClassroom ? [
                'id' => $this->currentClassroom->id,
                'name' => $this->currentClassroom->name,
                'form_teacher' => $this->currentClassroom->formTeacher ? "{$this->currentClassroom->formTeacher->first_name} {$this->currentClassroom->formTeacher->last_name}" : 'Not Set',
            ] : null,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'phone_number' => $this->phone_number,
            'role' => $this->role,
            'email' => $this->email,
            'gender' => $this->gender,
            'is_staff_disabled' => $this->is_staff_disabled,
            'disability' => $this->disability,
            'profile_photo_url' => $this->profile_photo_url,
            'level' => $this->level,
            'highest_qualification' => $this->highestQualification ? [
                'id' => $this->highestQualification->id,
                'name' => $this->highestQualification->name,
            ] : null,
            'trainings_attended' => $this->trainings_attended ? json_decode($this->trainings_attended) : [],
        ];
    }
}
