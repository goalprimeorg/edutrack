<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        State::create(['id' => (string) Str::uuid(), 'name' => 'Katsina']);
        State::create(['id' => (string) Str::uuid(), 'name' => 'Zamfara']);
    }
}