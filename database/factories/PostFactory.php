<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

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
            'body' => $this->faker->paragraph(50),
            'min_to_read' => $this->faker->numberBetween(1, 10),
            'image_path' => function () {
                $imagePath = 'images/sample.jpeg';
                $fileContents = Storage::disk('public')->get($imagePath);
                Storage::disk('public')->put('images/' . $imagePath, $fileContents);
                return $imagePath;
            },
            'user_id' => $this->faker->numberBetween(2, 6),
        ];
    }
}
