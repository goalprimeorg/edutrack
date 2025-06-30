<?php

namespace App\Actions\Import;

use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;

class StudentImportAction
{

    public function execute(array $data)
    {
        Excel::import(new StudentImport(), $data['students'], 'public');
    }
}
