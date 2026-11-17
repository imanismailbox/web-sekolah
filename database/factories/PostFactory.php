<?php

namespace Database\Factories;

use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
            'title' => $title = fake()->unique()->sentence(6),
            'slug' => Str::slug($title),
            'excerpt' => fake()->sentence(15),
            'content' => '<p>'.fake()->paragraphs(4, true).'</p>',
            'status' => PostStatus::Published,
            'published_at' => now()->subDay(),
            'is_featured' => false,
            'views' => 0,
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => PostStatus::Draft,
            'published_at' => null,
        ]);
    }
}
