<?php

namespace Database\Seeders;

use App\Enums\PartnerType;
use App\Models\LocalGovernmentArea;
use App\Models\Partner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Partner::create([
            "org_type" =>PartnerType::NGO->value,
            'org_name' => "Vuetify Solutions",
            "first_name" => "Vuetify ",
//            "middle_name" => "Solutions",
            "last_name" => "Solutions",
            "email" => "ngo@tech.com",
            "phone_number" => "09061887329",
            "password" => Hash::make('09061887329'),
            "local_government_area_id" => LocalGovernmentArea::all()->random(1)->first()->id,
        ]);

        Partner::create([
            "org_type" =>PartnerType::Government->value,
            'org_name' => "Vuetify Solutions",
            "first_name" => "Government",
//            "middle_name" => "Solutions",
            "last_name" => "Solutions",
            "email" => "gov@tech.com",
            "phone_number" => "09061887329",
            "password" => Hash::make('09061887329'),
            "local_government_area_id" => LocalGovernmentArea::all()->random(1)->first()->id,
        ]);
    }
}
