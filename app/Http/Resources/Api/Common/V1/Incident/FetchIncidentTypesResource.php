<?php

namespace App\Http\Resources\Api\Common\V1\Incident;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FetchIncidentTypesResource extends JsonResource
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
