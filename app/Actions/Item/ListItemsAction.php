<?php

namespace App\Actions\Item;

use App\Models\Item;

class ListItemsAction
{
    public function __construct(
        private Item $item
    )
    {
        
    }
    public function execute(array $listItemsRecordOptions, array $relationships = [])
    {
        $requestResourceType = $listItemsRecordOptions['request_resource_type'] ?? null;
        
        return $this->item->with($relationships)->when($requestResourceType, function($model, $requestResourceType) {
            $model->where([
                'request_resource_type' => $requestResourceType
            ]);
        })->orderBy('name', 'asc')->get();
    }
}