<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\StoreManagement\StoreItem;

use App\Actions\SchoolStoreItem\ListSchoolStoreItemsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\StoreManagement\StoreItem\FetchStoreItemsRequest;
use App\Http\Resources\Api\SchoolStaff\V1\StoreManagement\StoreItem\FetchStoreItemsResource;

class FetchStoreItemsController extends Controller
{
    public function __construct(
        private ListSchoolStoreItemsAction $listSchoolStoreItemsAction
    ) {}

    public function __invoke(FetchStoreItemsRequest $request)
    {
        $loggedInStaff = auth('school-staff')->user();

        $listSchoolStoreRecordOptions = $request->safe()->merge([
            'school_id' => $loggedInStaff->school_id
        ])->all();

        $relationships = [
            'item'
        ];

        $schoolStores = $this->listSchoolStoreItemsAction->execute(
            $listSchoolStoreRecordOptions,
            $relationships
        );
        
        $links = generatePaginationLinks($schoolStores);
        $meta = generatePaginationMeta($schoolStores);

        $mutatedStoreItems = FetchStoreItemsResource::collection($schoolStores);

        $responsePayload = [
            'school_store_items' => $mutatedStoreItems,
            'links' => $links,
            'meta' => $meta
        ];

        return generateSuccessApiMessage('Fetched school store items record successfully', 200, $responsePayload);
    }
}
