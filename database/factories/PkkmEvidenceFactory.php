<?php

namespace Database\Factories;

use App\Enums\EvidenceType;
use App\Models\PkkmEvidence;
use App\Models\PkkmIndicator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PkkmEvidence>
 */
class PkkmEvidenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pkkm_indicator_id' => PkkmIndicator::factory(),
            'label' => 'Lihat',
            'type' => EvidenceType::Link,
            'url' => fake()->url(),
            'sort' => 0,
        ];
    }
}
