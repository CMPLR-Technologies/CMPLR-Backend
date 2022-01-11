<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
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
        User::all()->each(function ($user) {
            $tags = Tag::inRandomOrder()->limit(20)->get();
            $tags->each(function ($tag) use ($user) {
                TagUser::factory()->create([
                    'user_id' => $user->id,
                    'tag_name' => $tag->name
                ]);
            });
        });
    }
}