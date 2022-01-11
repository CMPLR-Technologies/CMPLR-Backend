<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PostNotes;
use App\Models\Posts;
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
        User::inRandomOrder()->limit(rand(10, 30))->get()->each(function ($user) {
            $posts = Posts::all();
            $posts->each(function ($post) use ($user) {
                PostNotes::factory()->create([
                    'user_id' => $user->id,
                    'post_id' => $post->id
                ]);
            });
        });
    }
}