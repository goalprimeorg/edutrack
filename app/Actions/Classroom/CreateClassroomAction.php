<?php

namespace App\Actions\Classroom;

use App\Models\Classroom;

class CreateClassroomAction
{
    public function __construct(
        private Classroom $classroom
    ) {}

    public function execute(array $createClassroomRecordOptions)
    {
        return $this->classroom->create(
            $createClassroomRecordOptions
        );
    }
}
