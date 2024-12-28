<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevSeeder extends Seeder
{
    /**
     * This seeder is for development purposes.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Post::factory(100)->existingUser()->create();
    }
}
