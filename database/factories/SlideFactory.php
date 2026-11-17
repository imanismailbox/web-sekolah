<?php

namespace Database\Factories;

use App\Models\Slide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Slide>
 */
class SlideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image' => 'slides/'.fake()->uuid().'.jpg',
            'title' => fake()->sentence(4),
            'caption' => fake()->sentence(),
            'sort' => fake()->numberBetween(0, 10),
            'is_active' => true,
        ];
    }
}
