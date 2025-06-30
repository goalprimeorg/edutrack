<?php

namespace App\Actions\Classroom;

use App\Models\Classroom;

class ListClassroomsAction
{
    public function __construct(
        private Classroom $classroom
    ) {}

    public function execute(array $listClassroomsRecordOptions, array $relationships = [])
    {
        $schoolId = $listClassroomsRecordOptions['school_id'] ?? null;
        $formTeacherId = $listClassroomsRecordOptions['form_teacher_id'] ?? null;

        return $this->classroom->with(
            $relationships
        )->when($schoolId, function ($model, $schoolId) {
            $model->where([
                'school_id' => $schoolId,
            ]);
        })->when($formTeacherId, function ($model, $formTeacherId) {
            $model->where([
                'form_teacher_id' => $formTeacherId,
            ]);
        })->orderBy('name', 'ASC')->get();
    }
}
