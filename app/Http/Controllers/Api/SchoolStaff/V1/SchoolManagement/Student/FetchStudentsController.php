<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Student;

use App\Actions\Student\ListStudentsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Student\FetchStudentsRequest;
use App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Student\FetchStudentsResource;

class FetchStudentsController extends Controller
{
    public function __construct(
        public ListStudentsAction $listStudentsAction
    ) {}

    public function __invoke(FetchStudentsRequest $request)
    {
        $loggedInStaff = auth('school-staff')->user();

        $listStudentsRecordOptions = $request->safe()->merge([
            'school_id' => $loggedInStaff->school_id,
        ])->all();

        $relationships = [
            'school',
            'currentClassroom.formTeacher',
        ];

        $students = $this->listStudentsAction->execute(
            $listStudentsRecordOptions,
            $relationships
        );

        $mutatedStudents = FetchStudentsResource::collection($students);

        $links = generatePaginationLinks($students);
        $meta = generatePaginationMeta($students);

        $responsePayload = [
            'students' => $mutatedStudents,
            'meta' => $meta,
            'links' => $links,
        ];

        return generateSuccessApiMessage('Students record was retrieved successfully', 200, $responsePayload);
    }
}
