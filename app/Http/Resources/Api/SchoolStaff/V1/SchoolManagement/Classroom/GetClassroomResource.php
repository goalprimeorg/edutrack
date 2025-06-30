<?php

namespace App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Classroom;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetClassroomResource extends JsonResource
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
            'name' => $this->name,
            'school' => [
                'id' => $this->school->id,
                'name' => $this->school->name,
            ],
            'form_teacher' => $this->formTeacher ? [
                'id' => $this->formTeacher->id,
                'first_name' => $this->formTeacher->first_name,
                'last_name' => $this->formTeacher->last_name,
            ] : 'Not set',
        ];
    }
}
