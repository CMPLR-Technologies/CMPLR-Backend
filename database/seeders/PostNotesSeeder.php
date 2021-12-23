<?php

namespace Database\Seeders;

use App\Models\PostNotes;
use Illuminate\Database\Seeder;

class PostNotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PostNotes::factory()->count(1000)->create();
    }
}
