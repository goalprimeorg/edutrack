<?php

namespace App\Http\Resources\Api\SchoolStaff\V1\Authentication;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessfulAuthenticationResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'last_login_date' => $this->last_login_date,
            'role' => $this->role,
            'current_classroom' => $this->currentClassroom ? [
                'id' => $this->currentClassroom->id,
                'name' => $this->currentClassroom->name,
                'form_teacher' => $this->currentClassroom->formTeacher ? "{$this->currentClassroom->formTeacher->first_name} {$this->currentClassroom->formTeacher->last_name}" : 'Not Set',
            ] : null,
            'has_system_generated_password' => $this->has_system_generated_password,
        ];
    }
}
