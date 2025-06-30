<?php

namespace App\Http\Resources\Api\SchoolStaff\V1\StoreManagement\StoreItem;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FetchStoreItemsResource extends JsonResource
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
            'item' => $this->item->name,
            'current_quantity' => $this->current_quantity
        ];
    }
}
