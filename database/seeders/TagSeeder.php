<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function __construct(public $count = 20) {}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::factory($this->count)->create();
    }
}
