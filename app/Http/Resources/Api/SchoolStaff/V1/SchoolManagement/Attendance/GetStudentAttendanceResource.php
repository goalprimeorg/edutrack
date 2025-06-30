<?php

namespace App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetStudentAttendanceResource extends JsonResource
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
            'classroom' => [
                'id' => $this->classroom->id,
                'name' => $this->classroom->name,
            ],
            'marked_by_staff' => [
                'id' => $this->markedBySchoolStaff->id,
                'first_name' => $this->markedBySchoolStaff->first_name,
                'middle_name' => $this->markedBySchoolStaff->middle_name,
                'last_name' => $this->markedBySchoolStaff->last_name,
            ],
            'student_attendances' => $this->studentAttendances->map(function($studentAttendance) {
                return [
                    'student' => "{$studentAttendance->student->first_name} {$studentAttendance->student->last_name}",
                    'attendance_status' => $studentAttendance->attendance_status
                ];
            }),
        ];
    }
}
