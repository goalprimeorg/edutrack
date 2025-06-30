<?php

namespace App\Imports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\ToModel;

class InventoryImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[0] && $row[1]){
            return new Inventory([
                'item_id' => $row[0],
                'partner_id' => auth()->user()->id,
                'quantity' => $row[1],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
