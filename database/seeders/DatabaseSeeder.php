<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(BlogSeeder::class);
        $this->call(BlogUserSeeder::class);
        $this->call(BlogSettingsSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(PostsSeeder::class);
        $this->call(ChatSeeder::class);
        $this->call(PostNotesSeeder::class);
        $this->call(FollowSeeder::class);
        $this->call(NotificationSeeder::class);
        $this->call(BlockSeeder::class);
    }
}
