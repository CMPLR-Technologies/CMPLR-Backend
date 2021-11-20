<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TagUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tag_id' => rand(1, 100),
            'user_id' => rand(1, 11),
        ];
    }
}
