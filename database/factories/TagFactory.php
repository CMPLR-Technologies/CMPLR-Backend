<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tag_name = $this->faker->unique()->word;

        return [
            'name' => $tag_name,
            'slug' => Str::slug($tag_name, '-'),
        ];
    }
}
