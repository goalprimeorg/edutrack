<?php

namespace App\Actions\Classroom;

use App\Models\Classroom;

class GetClassroomByIdAction
{
    public function __construct(
        private Classroom $classroom
    ) {}

    public function execute(string $id, array $relationships = [])
    {
        return $this->classroom->with(
            $relationships
        )->where([
            'id' => $id,
        ])->first();
    }
}
