<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Classroom;

use App\Actions\Classroom\ListClassroomsAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Classroom\FetchClassroomsResource;

class FetchClassroomsController extends Controller
{
    public function __construct(
        public ListClassroomsAction $listClassroomsAction
    ) {}

    public function __invoke()
    {
        $loggedInSchoolStaff = auth('school-staff')->user();

        $listClassroomsRecordOptions = [
            'school_id' => $loggedInSchoolStaff->school_id,
        ];

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
