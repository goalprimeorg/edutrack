<?php

namespace Database\Seeders;

use App\Models\RequestType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $requestTypes = [
            ['name' => 'Learning Materials'],
            ['name' => 'Teaching Materials'],
        ];

        DB::transaction(function () use ($requestTypes) {
            foreach ($requestTypes as $requestType) {
                RequestType::create($requestType);
            }
        });
    }
}
