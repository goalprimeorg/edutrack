<?php

namespace App\Actions\Request;

use App\Models\Request;

class CreateRequestAction
{
    public function __construct(
        private Request $request
    ) {}

    public function execute(array $createRequest)
    {
        return $this->request->create($createRequest);
    }
}
