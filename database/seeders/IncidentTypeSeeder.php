<?php

namespace Database\Seeders;

use App\Models\IncidentType;
use Illuminate\Database\Seeder;

class IncidentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $incidentTypes = [
            [
                'name' => 'Demo',
            ],
        ];
        foreach ($incidentTypes as $incidentType) {
            IncidentType::create($incidentType);
        }
    }
}
