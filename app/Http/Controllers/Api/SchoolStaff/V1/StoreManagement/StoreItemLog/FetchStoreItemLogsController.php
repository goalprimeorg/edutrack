<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\StoreManagement\StoreItemLog;

use App\Actions\SchoolStoreItemLog\ListSchoolStoreItemLogsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\StoreManagement\StoreItemLog\FetchStoreItemLogsRequest;
use App\Http\Resources\Api\SchoolStaff\V1\StoreManagement\StoreItemLog\FetchStoreItemLogsResource;

class FetchStoreItemLogsController extends Controller
{
    public function __construct(
        private ListSchoolStoreItemLogsAction $listSchoolStoreItemLogsAction
    ) {}

    public function __invoke(FetchStoreItemLogsRequest $request)
    {
        $loggedInStaff = auth('school-staff')->user();

        $listSchoolStoreItemLogsRecordOptions = $request->safe()->merge([
            'school_id' => $loggedInStaff->school_id
        ])->all();

        $relationships = [
            'schoolStoreItem.item'
        ];

        $schoolStoreItemLogs = $this->listSchoolStoreItemLogsAction->execute(
            $listSchoolStoreItemLogsRecordOptions,
            $relationships
        );

        $links = generatePaginationLinks($schoolStoreItemLogs);
        $meta = generatePaginationMeta($schoolStoreItemLogs);

        $mutatedStoreItemLogs = FetchStoreItemLogsResource::collection($schoolStoreItemLogs);

        $responsePayload = [
            'school_store_item_logs' => $mutatedStoreItemLogs,
            'links' => $links,
            'meta' => $meta
        ];

        return generateSuccessApiMessage('Fetched school store item logs record successfully', 200, $responsePayload);
    }
}
