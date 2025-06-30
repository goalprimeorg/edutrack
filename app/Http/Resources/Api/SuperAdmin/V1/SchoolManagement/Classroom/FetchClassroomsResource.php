<?php

namespace App\Http\Resources\Api\SuperAdmin\V1\SchoolManagement\Classroom;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FetchClassroomsResource extends JsonResource
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
            'name' => $this->name,
            'form_teacher' => $this->formTeacher ? "{$this->formTeacher->first_name} {$this->formTeacher->last_name}" : 'Not Set',
        ];
    }
}
