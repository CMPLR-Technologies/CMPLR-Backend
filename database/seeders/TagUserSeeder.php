<?php

namespace Database\Seeders;

use App\Models\TagUser;
use Illuminate\Database\Seeder;

class TagUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TagUser::factory()->count(200)->create();
    }
}
