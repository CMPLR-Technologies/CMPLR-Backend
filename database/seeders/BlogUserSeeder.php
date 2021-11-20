<?php

namespace Database\Seeders;

use App\Models\BlogUser;
use Illuminate\Database\Seeder;

class BlogUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BlogUser::factory()->count(10)->create();
    }
}