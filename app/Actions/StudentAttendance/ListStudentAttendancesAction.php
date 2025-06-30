<?php

namespace App\Actions\StudentAttendance;

use App\Models\StudentAttendance;

class ListStudentAttendancesAction
{
    public function __construct(
        private StudentAttendance $studentAttendance
    ) {}

    public function execute(array $listStudentAttendances, array $relationships = [])
    {
        $perPage = $listStudentAttendances['per_page'] ?? 100;
        $schoolId = $listStudentAttendances['school_id'] ?? null;
        $studentId = $listStudentAttendances['student_id'] ?? null;
        $markedBySchoolStaffId = $listStudentAttendances['marked_by_school_staff_id'] ?? null;
        $dateOfAttendance = $listStudentAttendances['date_of_attendance'] ?? null;

        return $this->studentAttendance->with($relationships)->when($schoolId, function ($model, $schoolId) {
            $model->where([
                'school_id' => $schoolId,
            ]);
        })->when($studentId, function ($model, $studentId) {
            $model->where([
                'student_id' => $studentId,
            ]);
        })->when($markedBySchoolStaffId, function ($model, $markedBySchoolStaffId) {
            $model->where([
                'marked_by_school_staff_id' => $markedBySchoolStaffId,
            ]);
        })->when($dateOfAttendance, function ($model, $dateOfAttendance) {
            $model->where([
                'date_of_attendance' => $dateOfAttendance,
            ]);
        })->paginate($perPage);
    }
}
