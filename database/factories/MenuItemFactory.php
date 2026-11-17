<?php

namespace Database\Factories;

use App\Enums\MenuItemType;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MenuItem>
 */
class MenuItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'label' => fake()->words(2, true),
            'type' => MenuItemType::Url,
            'url' => fake()->url(),
            'open_in_new_tab' => false,
            'sort' => 0,
            'is_active' => true,
        ];
    }
}
