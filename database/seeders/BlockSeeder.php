<?php

namespace Database\Seeders;

use App\Models\Block;
use Illuminate\Database\Seeder;

class BlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Block::factory()->count(10)->create();
    }
}
