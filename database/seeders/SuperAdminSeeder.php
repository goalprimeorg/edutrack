<?php

namespace Database\Seeders;

use App\InfrastructureProviders\Internal\CipherClient;
use App\Models\SuperAdmin;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SuperAdmin::create([
            'first_name' => 'Vuetify',
            'last_name' => 'Engineers',
            'email' => 'admin@admin.com',
            'phone_number' => '07081149777',
            'password' => CipherClient::hash('password'),
            'last_login_date' => Carbon::now(),
        ]);
    }
}
