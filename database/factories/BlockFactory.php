<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlockFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'blog_id'=>rand(10,20),
            'blocked_blog_id'=>rand(10,20),
        ];
    }
}
