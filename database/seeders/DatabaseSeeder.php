<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            $this->call(UserSeeder::class);
            $this->call(TagSeeder::class);
            $this->call(PostSeeder::class);
        });
    }
}
