<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\User;
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
        $image = Image::factory()->create();

        return [
            'user_id' => User::factory(),
            'image_id' => $image->id,
            'source' => fake()->imageUrl()
        ];
    }

    public function existingUser()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_id' => User::pluck('id')->random(),
            ];
        });
    }
}
