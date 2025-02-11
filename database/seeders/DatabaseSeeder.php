<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $this->call(RoleSeeder::class);

            User::factory()->create([
                'username' => 'admin',
                'email' => 'admin@example.com',
            ])->syncRoles(['admin']);

            (new UserSeeder(100))->run();
            (new TagSeeder(100))->run();
            (new PostSeeder(1000))->run();
        });
    }
}
