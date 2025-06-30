<?php

namespace App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FetchStudentsResource extends JsonResource
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
            'classroom_name' => $this->currentClassroom->name,
            'classroom_form_teacher' => $this->currentClassroom->formTeacher ? "{$this->currentClassroom->formTeacher->first_name} {$this->currentClassroom->formTeacher->last_name}" : 'Not Set',
            'student_full_name' => "{$this->first_name} {$this->middle_name} {$this->last_name}",
            'registration_number' => $this->registration_number,
            'gender' => $this->gender,
            'guardian_full_name' => "{$this->guardian_first_name} {$this->guardian_last_name}",
            'guardian_phone_number' => $this->guardian_phone_number,
        ];
    }
}
