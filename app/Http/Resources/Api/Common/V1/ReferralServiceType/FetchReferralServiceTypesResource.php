<?php

namespace App\Http\Resources\Api\Common\V1\ReferralServiceType;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FetchReferralServiceTypesResource extends JsonResource
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
            'name' => $this->name,
        ];
    }
}
