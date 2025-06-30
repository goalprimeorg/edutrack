<?php

namespace App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FetchStudentAttendancesResource extends JsonResource
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
            'date_of_attendance' => $this->date_of_attendance,
            'classroom' => $this->classroom->name,
            'marked_by_staff_full_name' => "{$this->markedBySchoolStaff->first_name} {$this->markedBySchoolStaff->middle_name} {$this->markedBySchoolStaff->last_name}",
        ];
    }
}
