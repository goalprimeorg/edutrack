<?php

namespace App\Imports;

use App\Models\State;
use App\Models\LocalGovernmentArea;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LgaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[0] && $row[1]){
            return new LocalGovernmentArea([
                'name' => $row[0],
                'state_id' =>  $row[1],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
