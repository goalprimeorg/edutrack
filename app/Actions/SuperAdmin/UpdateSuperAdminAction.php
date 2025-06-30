<?php

namespace App\Actions\SuperAdmin;

use App\Models\SuperAdmin;

class UpdateSuperAdminAction
{
    public function __construct(
        private SuperAdmin $superAdmin
    ) {}

    public function execute(array $updateSuperAdminRecordOptions)
    {
        $id = $updateSuperAdminRecordOptions['id'];
        $data = $updateSuperAdminRecordOptions['data'];

        return $this->superAdmin->where([
            'id' => $id,
        ])->update($data);
    }
}
