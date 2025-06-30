<?php

namespace App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Request;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetRequestResource extends JsonResource
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
            'item' => [
                'id' => $this->item->id,
                'name' => $this->item->name,
            ],
            'request_resource_type' => $this->request_resource_type,
            'requested_quantity' => $this->requested_quantity,
            'status' => $this->status,
            'priority' => $this->priority,
            'remarks' => $this->remarks,
        ];
    }
}
