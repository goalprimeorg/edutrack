<?php

namespace Database\Seeders;

use App\Models\ReferralServiceType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferralServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $referralServiceTypes = [
            ['name' => 'Award'],
            ['name' => 'Health'],
        ];

        DB::transaction(function () use ($referralServiceTypes) {
            foreach ($referralServiceTypes as $referralServiceType) {
                ReferralServiceType::create($referralServiceType);
            }
        });
    }
}
