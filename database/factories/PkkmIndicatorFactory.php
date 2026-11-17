<?php

namespace Database\Factories;

use App\Models\PkkmIndicator;
use App\Models\PkkmItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PkkmIndicator>
 */
class PkkmIndicatorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pkkm_item_id' => PkkmItem::factory(),
            'number' => (string) fake()->numberBetween(1, 9),
            'description' => fake()->sentence(10),
            'expected_evidence' => fake()->sentence(6),
            'sort' => 0,
        ];
    }
}
