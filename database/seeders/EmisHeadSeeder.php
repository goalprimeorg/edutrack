<?php

namespace Database\Seeders;

use App\InfrastructureProviders\Internal\CipherClient;
use App\Models\EmisHead;
use App\Models\LocalGovernmentArea;
use Illuminate\Database\Seeder;

class EmisHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmisHead::create([
            'first_name' => fake()->firstName(),
            //            'middle_name' => $this->faker()->middleName(),
            'last_name' => fake()->lastName(),
            'email' => 'emishead@gmail.com',
            'phone_number' => fake()->phoneNumber(),
            'password' => CipherClient::hash('password'),
            'local_government_area_id' => LocalGovernmentArea::all()->first()->id,
        ]);
    }
}
