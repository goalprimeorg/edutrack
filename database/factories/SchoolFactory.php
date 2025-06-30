<?php

namespace Database\Factories;

use App\Models\LocalGovernmentArea;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\School>
 */
class SchoolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'local_government_area_id' => LocalGovernmentArea::inRandomOrder()->first()->id,
            'address' => $this->faker->address(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'has_completed_profile' => $this->faker->boolean(),
        ];
    }
}
