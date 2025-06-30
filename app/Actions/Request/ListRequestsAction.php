<?php

namespace App\Actions\Request;

use App\Models\Request;

class ListRequestsAction
{
    public function __construct(
        private Request $Request
    ) {}

    public function execute(array $listRequestsRecordOptions, array $relationships = [])
    {
        $perPage = $listRequestsRecordOptions['per_page'] ?? 100;
        $schoolId = $listRequestsRecordOptions['school_id'] ?? null;
        $requestTypeId = $listRequestsRecordOptions['request_type_id'] ?? null;

        return $this->Request->with($relationships)->when($schoolId, function ($model, $schoolId) {
            $model->where([
                'school_id' => $schoolId,
            ]);
        })->when($requestTypeId, function ($model, $requestTypeId) {
            $model->where([
                'request_type_id' => $requestTypeId,
            ]);
        })->paginate($perPage);
    }
}
