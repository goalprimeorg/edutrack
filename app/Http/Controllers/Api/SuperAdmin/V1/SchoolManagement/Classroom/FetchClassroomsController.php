<?php

namespace App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Classroom;

use App\Actions\Classroom\ListClassroomsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SuperAdmin\V1\SchoolManagement\Classroom\FetchClassroomsRequest;
use App\Http\Resources\Api\SuperAdmin\V1\SchoolManagement\Classroom\FetchClassroomsResource;

class FetchClassroomsController extends Controller
{
    public function __construct(
        public ListClassroomsAction $listClassroomsAction
    ) {}

    public function __invoke(FetchClassroomsRequest $request)
    {
        $listClassroomsRecordOptions = $request->validated();

        $relationships = [
            'school',
            'formTeacher',
        ];

        $classrooms = $this->listClassroomsAction->execute(
            $listClassroomsRecordOptions,
            $relationships
        );

        $mutatedClassrooms = FetchClassroomsResource::collection($classrooms);

        return generateSuccessApiMessage('Classrooms record was retrieved successfully', 200, $mutatedClassrooms);
    }
}
