<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\LocalGovernmentArea;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StudentImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[0] && $row[1]){
            return new Student([
                'state_id' => $row[0],
                'local_government_area_id' => $row[1],
                'school_id' => $row[2],
                'current_classroom_id' => $row[3],
                'first_name' => $row[4],
                'middle_name' => $row[5],
                'last_name' => $row[6],
                'gender' => $row[7],
                'guardian_first_name' => $row[8],
                'guardian_phone_number' => $row[9],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
