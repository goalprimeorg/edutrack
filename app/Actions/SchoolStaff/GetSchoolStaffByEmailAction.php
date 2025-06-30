<?php

namespace App\Actions\SchoolStaff;

use App\Models\SchoolStaff;

class GetSchoolStaffByEmailAction
{
    public function __construct(
        private SchoolStaff $schoolStaff
    ) {}

    public function execute(string $email, array $relationships = [])
    {
        return $this->schoolStaff->with(
            $relationships
        )->where([
            'email' => $email,
        ])->first();
    }
}
