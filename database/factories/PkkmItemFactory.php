<?php

namespace Database\Factories;

use App\Models\PkkmComponent;
use App\Models\PkkmItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PkkmItem>
 */
class PkkmItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pkkm_component_id' => PkkmComponent::factory(),
            'code' => fake()->numerify('#.#'),
            'name' => fake()->sentence(8),
            'sort' => 0,
        ];
    }
}
