<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FollowFactory extends Factory
{
    protected $id = 1;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // // Get all the roles attaching up to 3 random roles to each user
        // $blogs = Blog::all();

        // // Populate the pivot table
        // User::all()->each(function ($user) use ($blogs) {
        //     $user->blogs()->attach(
        //         $blogs->random(rand(1, 50))->pluck('id')->toArray()
        //     );
        // });

        return [
            'user_id' => $this->id++,
            'blog_id' => $this->faker->numberBetween(1, 50),
        ];
    }
}