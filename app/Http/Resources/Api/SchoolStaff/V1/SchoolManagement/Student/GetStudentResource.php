<?php

namespace App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetStudentResource extends JsonResource
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
            'current_classroom' => [
                'id' => $this->currentClassroom->id,
                'name' => $this->currentClassroom->name,
                'form_teacher' => $this->currentClassroom->formTeacher ? "{$this->currentClassroom->formTeacher->first_name} {$this->currentClassroom->formTeacher->last_name}" : 'Not Set',
            ],
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'registration_number' => $this->registration_number,
            'gender' => $this->gender,
            'is_student_disabled' => $this->is_student_disabled,
            'disability' => $this->disability,
            'guardian_first_name' => $this->guardian_first_name,
            'guardian_last_name' => $this->guardian_last_name,
            'guardian_phone_number' => $this->guardian_phone_number,
        ];
    }
}
