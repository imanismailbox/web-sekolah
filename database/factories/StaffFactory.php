<?php

namespace Database\Factories;

use App\Enums\StaffType;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Staff>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'nip' => fake()->numerify('##################'),
            'type' => fake()->randomElement(StaffType::cases()),
            'position' => fake()->jobTitle(),
            'subject' => fake()->word(),
            'education' => 'S1',
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'sort' => 0,
            'is_active' => true,
        ];
    }
}
