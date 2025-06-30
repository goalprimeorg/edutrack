<?php

namespace App\Actions\RequestType;

use App\Models\RequestType;

class ListRequestTypesAction
{
    public function __construct(
        private RequestType $requestType
    ) {}

    public function execute(array $relationships = [])
    {
        return $this->requestType->with($relationships)->orderBy('name', 'ASC')->get();
    }
}
