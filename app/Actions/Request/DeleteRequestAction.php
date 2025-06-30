<?php

namespace App\Actions\Request;

use App\Models\Request;

class DeleteRequestAction
{
    public function __construct(
        private Request $request
    ) {}

    public function execute(array $deleteRequestRecordOptions)
    {
        $id = $deleteRequestRecordOptions['id'];

        return $this->request->where([
            'id' => $id,
        ])->delete();
    }
}
