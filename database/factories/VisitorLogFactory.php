<?php

namespace Database\Factories;

use App\Models\VisitorLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VisitorLog>
 */
class VisitorLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'visitor_hash' => hash('sha256', fake()->unique()->ipv4().'|'.fake()->userAgent()),
            'visited_on' => now()->toDateString(),
            'last_seen_at' => now(),
            'hits' => 1,
        ];
    }
}
