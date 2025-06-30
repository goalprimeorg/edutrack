<?php

namespace App\Actions\Import;

use App\Imports\InventoryImport;
use Maatwebsite\Excel\Facades\Excel;

class InventoryImportAction
{

    public function execute(array $data)
    {
        Excel::import(new InventoryImport(), $data['inventories'], 'public');
    }
}
