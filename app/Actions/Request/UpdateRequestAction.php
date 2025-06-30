<?php

namespace App\Actions\Request;

use App\Models\Request;

class UpdateRequestAction
{
    public function __construct(
        private Request $request
    ) {}

    public function execute(array $updateRequestRecordOptions)
    {
        $id = $updateRequestRecordOptions['id'];
        $data = $updateRequestRecordOptions['data'];

        return $this->request->where([
            'id' => $id,
        ])->update($data);
    }
}
