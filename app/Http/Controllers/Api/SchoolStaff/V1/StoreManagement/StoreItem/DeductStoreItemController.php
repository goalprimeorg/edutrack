<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\StoreManagement\StoreItem;

use App\Actions\SchoolStoreItem\GetSchoolStoreItemByIdAction;
use App\Actions\SchoolStoreItem\UpdateSchoolStoreItemAction;
use App\Actions\SchoolStoreItemLog\CreateSchoolStoreItemLogAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\StoreManagement\StoreItem\DeductStoreItemRequest;
use Illuminate\Support\Facades\DB;

class DeductStoreItemController extends Controller
{
    public function __construct(
        private GetSchoolStoreItemByIdAction $getSchoolStoreItemByIdAction,
        private UpdateSchoolStoreItemAction $updateSchoolStoreItemAction,
        private CreateSchoolStoreItemLogAction $createSchoolStoreItemLogAction,
    ) {}

    public function __invoke(DeductStoreItemRequest $request)
    {
        $loggedInStaff = auth('school-staff')->user();

        $storeItem = $this->getSchoolStoreItemByIdAction->execute($request->school_store_item_id);

        if (is_null($storeItem) || $storeItem->school_id !== $loggedInStaff->school_id) {
            return generateErrorApiMessage('Item does not exists');
        }

        if ($storeItem->current_quantity < $request->quantity) {
            return generateErrorApiMessage('The requested quantity exceeds the available items in the store. Kindly contact admin or make a request');
        }

        DB::transaction(function () use($request, $storeItem, $loggedInStaff) {

            $currentQuantity = $storeItem->current_quantity - $request->quantity;

            $updateSchoolStoreItemRecordOptions = [
                'id' => $storeItem->id,
                'data' => [
                    'current_quantity' => $currentQuantity
                ]
            ];

            $this->updateSchoolStoreItemAction->execute(
                $updateSchoolStoreItemRecordOptions
            );

            $createSchoolStoreItemLogRecordOptions = [
                'school_id' => $loggedInStaff->school_id,
                'school_store_item_id' => $storeItem->id,
                'school_staff_id' => $loggedInStaff->id,
                'quantity_before' => $storeItem->current_quantity,
                'quantity_change' => $request->quantity,
                'quantity_after' => $currentQuantity,
                'operation_type' => 'remove',
                'remark' => $request->remark,
            ];

            $this->createSchoolStoreItemLogAction->execute(
                $createSchoolStoreItemLogRecordOptions
            );
        });


        return generateSuccessApiMessage('Item has been deducted successfully');
    }
}
