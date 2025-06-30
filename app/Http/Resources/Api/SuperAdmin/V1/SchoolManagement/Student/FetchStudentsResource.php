<?php

namespace App\Http\Resources\Api\SuperAdmin\V1\SchoolManagement\Student;

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
            'school_name' => $this->school->name,
            'classroom_name' => $this->currentClassroom->name,
            'classroom_form_teacher' => $this->currentClassroom->formTeacher ? "{$this->currentClassroom->formTeacher->first_name} {$this->currentClassroom->formTeacher->last_name}" : 'Not Set',
            'student_full_name' => "{$this->first_name} {$this->last_name}",
            'registration_number' => $this->registration_number,
            'guardian_full_name' => "{$this->guardian_first_name} {$this->guardian_last_name}",
            'guardian_phone_number' => $this->guardian_phone_number,
        ];
    }
}
