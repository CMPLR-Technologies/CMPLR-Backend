<?php

namespace Database\Seeders;

use App\Models\PostTags;
use Illuminate\Database\Seeder;

class PostTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PostTags::factory()->count(50)->create();
    }
}