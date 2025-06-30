<?php

namespace App\Actions\Student;

use App\Models\Student;

class ListStudentsAction
{
    public function __construct(
        private Student $student
    ) {}

    public function execute(array $listStudentsRecordOptions, array $relationships = [])
    {
        $schoolId = $listStudentsRecordOptions['school_id'] ?? null;
        $classroomId = $listStudentsRecordOptions['classroom_id'] ?? null;
        $perPage = $listStudentsRecordOptions['per_page'] ?? 100;

        return $this->student->with(
            $relationships
        )->when($schoolId, function ($model, $schoolId) {
            $model->where([
                'school_id' => $schoolId,
            ]);
        })->when($classroomId, function ($model, $classroomId) {
            $model->where([
                'current_classroom_id' => $classroomId,
            ]);
        })->orderBy('first_name', 'ASC')->paginate($perPage);
    }
}
