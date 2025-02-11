<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function __construct(public $count = 10) {}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory($this->count)->create();
    }
}
