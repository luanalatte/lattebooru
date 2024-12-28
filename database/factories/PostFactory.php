<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'user_id' => User::factory(),
            'md5' => fake()->unique()->md5(),
            'ext' => array_rand(['jpg', 'png', 'gif']),
            'filename' => Str::random(10),
            'filesize' => rand(1024, 10485760),
            'width' => rand(400, 2000),
            'height' => rand(400, 2000),
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
