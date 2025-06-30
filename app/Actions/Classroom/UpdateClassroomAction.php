<?php

namespace App\Actions\Classroom;

use App\Models\Classroom;

class UpdateClassroomAction
{
    public function __construct(
        private Classroom $classroom
    ) {}

    public function execute(array $updateClassroomRecordOptions)
    {
        $id = $updateClassroomRecordOptions['id'];
        $data = $updateClassroomRecordOptions['data'];

        return $this->classroom->where([
            'id' => $id,
        ])->update($data);
    }
}
