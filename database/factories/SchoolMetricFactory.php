<?php

namespace Database\Factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SchoolMetric>
 */
class SchoolMetricFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'school_id' => School::factory(),
            'total_no_male_students' => $this->faker->randomNumber(),
            'total_no_female_students' => $this->faker->randomNumber(),
            'total_no_disabled_male_students' => $this->faker->randomNumber(),
            'total_no_disabled_female_students' => $this->faker->randomNumber(),
            'total_no_male_staff' => $this->faker->randomNumber(),
            'total_no_female_staff' => $this->faker->randomNumber(),
            'total_no_disabled_male_staff' => $this->faker->randomNumber(),
            'total_no_disabled_female_staff' => $this->faker->randomNumber(),
        ];
    }
}
