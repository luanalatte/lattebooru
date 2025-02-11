<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function __construct(public $count = 100) {}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory($this->count)->existingUser()->create()->each(function ($post) {
            $n = rand(0, 10);
            if ($n > 0) {
                $post->tags()->attach(
                    Tag::inRandomOrder()->take($n)->pluck('id')
                );
            }
        });
    }
}
