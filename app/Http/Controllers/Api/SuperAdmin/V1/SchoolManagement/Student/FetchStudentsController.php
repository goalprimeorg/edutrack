<?php

namespace App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Student;

use App\Actions\Student\ListStudentsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SuperAdmin\V1\SchoolManagement\Student\FetchStudentsRequest;
use App\Http\Resources\Api\SuperAdmin\V1\SchoolManagement\Student\FetchStudentsResource;

class FetchStudentsController extends Controller
{
    public function __construct(
        public ListStudentsAction $listStudentsAction
    ) {}

    public function __invoke(FetchStudentsRequest $request)
    {
        $listStudentsRecordOptions = $request->validated();

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
