<?php

namespace App\Http\Resources\Api\SuperAdmin\V1\SchoolManagement\Student;

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
            'school' => [
                'id' => $this->school->id,
                'name' => $this->school->name,
            ],
            'current_classroom' => [
                'id' => $this->currentClassroom->id,
                'name' => $this->currentClassroom->name,
                'form_teacher' => $this->currentClassroom->formTeacher ? "{$this->currentClassroom->formTeacher->first_name} {$this->currentClassroom->formTeacher->last_name}" : 'Not Set',
            ],
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'registration_number' => $this->registration_number,
            'guardian_first_name' => $this->guardian_first_name,
            'guardian_last_name' => $this->guardian_last_name,
            'guardian_phone_number' => $this->guardian_phone_number,
        ];
    }
}
