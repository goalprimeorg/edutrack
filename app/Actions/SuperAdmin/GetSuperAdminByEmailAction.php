<?php

namespace App\Actions\SuperAdmin;

use App\Models\SuperAdmin;

class GetSuperAdminByEmailAction
{
    public function __construct(
        private SuperAdmin $superAdmin
    ) {}

    public function execute(string $email, array $relationships = [])
    {
        return $this->superAdmin->with($relationships)->where([
            'email' => $email,
        ])->first();
    }
}
