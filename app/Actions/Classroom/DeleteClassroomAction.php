<?php

namespace App\Actions\Classroom;

use App\Models\Classroom;

class DeleteClassroomAction
{
    public function __construct(
        private Classroom $classroom
    ) {}

    public function execute(array $deleteClassroomRecordOptions)
    {
        $id = $deleteClassroomRecordOptions['id'];

        return $this->classroom->where([
            'id' => $id,
        ])->delete();
    }
}
