<?php

namespace App\Actions\Import;

use App\Imports\SchoolImport;
use Maatwebsite\Excel\Facades\Excel;

class SchoolImportAction
{

    public function execute(array $data)
    {
        Excel::import(new SchoolImport(), $data['schools'], 'public');
    }
}
