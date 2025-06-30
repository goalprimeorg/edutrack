<?php

namespace App\Imports;

use App\Models\School;
use App\Models\State;
use App\Models\LocalGovernmentArea;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SchoolImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[0] && $row[1]){
            return new School([
                'name' => $row[0],
                'state_id' =>  $row[1],
                'local_government_area_id' => $row[2],
                'ward' => $row[3],
                'community' => $row[4],
                'address' => $row[5],
                'latitude' => $row[6],
                'longitude' => $row[7],
                'has_completed_profile' => $row[8],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
