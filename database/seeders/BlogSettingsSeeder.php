<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogSettings;
use Illuminate\Database\Seeder;

class BlogSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BlogSettings::factory()->count(10)->create();
    }
}