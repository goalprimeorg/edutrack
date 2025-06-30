<?php

namespace App\Http\Resources\Api\SuperAdmin\V1\SchoolManagement\Staff;

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
            'school' => [
                'id' => $this->school->id,
                'name' => $this->school->name,
            ],
            'current_classroom' => $this->currentClassroom ? [
                'id' => $this->currentClassroom->id,
                'name' => $this->currentClassroom->name,
                'form_teacher' => $this->currentClassroom->formTeacher ? "{$this->currentClassroom->formTeacher->first_name} {$this->currentClassroom->formTeacher->last_name}" : 'Not Set',
            ] : 'Not Set',
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone_number' => $this->phone_number,
            'role' => $this->role,
            'email' => $this->email,
        ];
    }
}
