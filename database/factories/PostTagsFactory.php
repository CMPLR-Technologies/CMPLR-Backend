<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostTagsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tag = Tag::inRandomOrder()->first();

        return [
            'post_id' => $this->faker->unique()->numberBetween(1, 50),
            'tag_name' => $tag['name']
        ];
    }
}