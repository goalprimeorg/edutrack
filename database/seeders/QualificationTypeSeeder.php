<?php

namespace Database\Seeders;

use App\Models\QualificationType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QualificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $qualificationTypes = [
            ['name' => 'SSCE'],
            ['name' => 'Diploma'],
            ['name' => 'National Certificate Examinations'],
            ['name' => 'Higher National Diploma'],
            ['name' => 'Degree'],
            ['name' => 'Masters'],
        ];

        DB::transaction(function () use ($qualificationTypes) {
            foreach ($qualificationTypes as $qualificationType) {
                QualificationType::create($qualificationType);
            }
        });
    }
}
