<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use App\Models\Follow;
use Illuminate\Database\Seeder;

class FollowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function ($user) {
            $blogs = Blog::where('id', '!=', $user->id)->inRandomOrder()->limit(20)->get();
            $blogs->each(function ($blog) use ($user) {
                Follow::factory()->create([
                    'user_id' => $user->id,
                    'blog_id' => $blog->id
                ]);
            });
        });
    }
}