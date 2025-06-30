<?php

namespace App\Actions\SchoolStaff;

use App\Models\SchoolStaff;

class GetSchoolStaffByIdAction
{
    public function __construct(
        private SchoolStaff $schoolStaff
    ) {}

    public function execute(string $id, array $relationships = [])
    {
        return $this->schoolStaff->with(
            $relationships
        )->where([
            'id' => $id,
        ])->first();
    }
}
