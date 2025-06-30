<?php

namespace App\Actions\Request;

use App\Models\Request;

class GetRequestByIdAction
{
    public function __construct(
        private Request $request
    ) {}

    public function execute($requestId, array $relationships = [])
    {
        return $this->request->with($relationships)->where([
            'id' => $requestId,
        ])->first();
    }
}
