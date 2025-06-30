<?php

namespace App\Http\Controllers\Filament\Import;

use App\Http\Controllers\Controller;
use App\Imports\InventoryImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InventoryImportController extends Controller
{
    public function import(Request $request)
    {
        dd($request->all());
        Excel::import(new InventoryImport, $request->file('inventories'));

        dd("Worked");
    }
}
