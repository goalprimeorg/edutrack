<?php

namespace App\Actions\StudentAttendanceMeta;

use App\Models\StudentAttendanceMeta;

class ListStudentAttendanceMetasAction
{
    public function __construct(
        private StudentAttendanceMeta $studentAttendanceMeta
    ) {}

    public function execute(array $listStudentAttendanceMetas, array $relationships = [])
    {
        $perPage = $listStudentAttendanceMetas['per_page'] ?? 100;
        $schoolId = $listStudentAttendanceMetas['school_id'] ?? null;
        $classroomId = $listStudentAttendanceMetas['classroom_id'] ?? null;
        $markedBySchoolStaffId = $listStudentAttendanceMetas['marked_by_school_staff_id'] ?? null;
        $dateOfAttendance = $listStudentAttendanceMetas['date_of_attendance'] ?? null;

        return $this->studentAttendanceMeta->with($relationships)->when($schoolId, function ($model, $schoolId) {
            $model->where([
                'school_id' => $schoolId,
            ]);
        })->when($classroomId, function ($model, $classroomId) {
            $model->where([
                'classroom_id' => $classroomId,
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
