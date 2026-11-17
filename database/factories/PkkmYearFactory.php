<?php

namespace Database\Factories;

use App\Models\PkkmYear;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PkkmYear>
 */
class PkkmYearFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'year' => $year = fake()->unique()->numberBetween(2000, 2099),
            'title' => "Penilaian Kinerja Kepala Madrasah {$year}",
            'slug' => "pkkm-{$year}",
            'is_published' => true,
        ];
    }
}
