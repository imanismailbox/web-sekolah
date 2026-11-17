<?php

namespace Database\Factories;

use App\Models\PkkmComponent;
use App\Models\PkkmYear;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PkkmComponent>
 */
class PkkmComponentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pkkm_year_id' => PkkmYear::factory(),
            'code' => fake()->randomLetter(),
            'name' => fake()->sentence(3),
            'sort' => 0,
        ];
    }
}
