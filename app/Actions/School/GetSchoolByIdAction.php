<?php

namespace App\Actions\School;

use App\Models\School;

class GetSchoolByIdAction
{
    public function __construct(
        private School $school
    ) {}

    public function execute(string $id, array $relationship = [])
    {
        return $this->school->with(
            $relationship
        )->where([
            'id' => $id,
        ])->first();
    }
}
