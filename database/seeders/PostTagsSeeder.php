<?php

namespace Database\Seeders;

use App\Models\Posts;
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
        Posts::all()->each(function ($post) {
            $tags = $post->tags;
            foreach ($tags as $tag) {
                PostTags::factory()->create([
                    'post_id' => $post->id,
                    'tag_name' => $tag
                ]);
            }
        });
    }
}