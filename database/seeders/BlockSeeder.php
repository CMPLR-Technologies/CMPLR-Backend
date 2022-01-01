<?php

namespace Database\Seeders;

use App\Models\Blog;
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
        Blog::inRandomOrder()->limit(10)->get()->each(function ($blog) {
            $blockedBlog = Blog::where('id', '!=', $blog->id)->inRandomOrder()->first();
            Block::factory()->create([
                'blog_id' => $blog->id,
                'blocked_blog_id' => $blockedBlog->id
            ]);
        });
    }
}