<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'school_id' => '9d988dd3-ae22-4ac5-80cf-9b9d127bb99f',
            'current_classroom_id' => fake()->randomAscii(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'middle_name' => $this->faker->lastName(),
            'registration_number' => $this->faker->randomAscii(),
            'guardian_first_name' => $this->faker->firstName(),
            'guardian_phone_number' => $this->faker->phoneNumber(),
            'guardian_last_name' => $this->faker->lastName(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'is_student_disabled' => $this->faker->boolean(),
        ];
    }
}
