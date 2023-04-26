<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
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
            'title' => $this->faker->unique()->sentence(3),
            'excerpt' => $this->faker->realText($maxNbChars = 50),
            'body' => $this->faker->text(),
            'min_to_read' => $this->faker->numberBetween(1, 10),
            'image_path' => $this->faker->imageUrl(640, 480),
            'user_id' => $this->faker->numberBetween(2, 6),
        ];
    }
}
