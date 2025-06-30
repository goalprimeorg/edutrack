<?php

namespace App\Actions\LocalGovernmentArea;

use App\Models\LocalGovernmentArea;

class ListLocalGovernmentAreasAction
{
    public function __construct(
        private LocalGovernmentArea $localGovernmentArea
    ) {}

    public function execute(array $relationships = [])
    {
        return $this->localGovernmentArea->with($relationships)->orderBy('name', 'ASC')->get();
    }
}
