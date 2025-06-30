<?php

namespace App\Http\Resources\Api\SchoolStaff\V1\StoreManagement\StoreItemLog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FetchStoreItemLogsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'school_store_item' => $this->schoolStoreItem->item->name,
            'quantity_before' => $this->quantity_before,
            'quantity_change' => $this->quantity_change,
            'quantity_after' => $this->quantity_after,
            'operation_type' => $this->operation_type,
            'remark' => $this->remark,
        ];
    }
}
