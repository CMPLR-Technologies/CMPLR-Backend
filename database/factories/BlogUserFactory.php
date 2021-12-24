<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlogUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $id = $this->faker->numberBetween(1, 10);
        return [
            'user_id' => $id,
            'blog_id' => $id,
        ];
    }
}
