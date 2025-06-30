<?php

namespace App\Http\Resources\Api\Common\V1\Item;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FetchItemsResource extends JsonResource
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
            'request_resource_type' => $this->request_resource_type,
            'name' => $this->name,
        ];
    }
}
