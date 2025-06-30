<?php

namespace App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class MarkStudentAttendanceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'classroom_id' => ['required', 'uuid', 'exists:classrooms,id'],
            'date_of_attendance' => ['required', 'date_format:Y-m-d'],
            'student_attendances' => ['required', 'array'],
            'student_attendances.*.student_id' => ['required', 'uuid', 'exists:students,id'],
            'student_attendances.*.attendance_status' => ['required', 'string', 'in:present,absent,sick'],
        ];
    }

    public function messages(): array
    {
        return [
            'classroom_id.required' => 'The classroom is required.',
            'classroom_id.uuid' => 'The classroom must be a valid UUID.',
            'classroom_id.exists' => 'The selected classroom does not exist.',

            'date_of_attendance.required' => 'The date of attendance is required.',
            'date_of_attendance.date_format' => 'The date of attendance must be in the format YYYY-MM-DD.',

            'student_attendances.required' => 'Student attendance records are required.',
            'student_attendances.array' => 'Student attendance records must be provided as an array.',

            'student_attendances.*.student_id.required' => 'Each student attendance entry must have a student ID.',
            'student_attendances.*.student_id.uuid' => 'Each student ID must be a valid UUID.',
            'student_attendances.*.student_id.exists' => 'Each student ID must exist in the students table.',

            'student_attendances.*.attendance_status.required' => 'Each student attendance entry must indicate if the student is present, absent or sick.',
            'student_attendances.*.attendance_status.in' => 'The presence indicator for each student must be present, absent or sick',
        ];
    }
}
