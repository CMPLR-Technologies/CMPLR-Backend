<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fromBlogId = $this->faker->numberBetween(1, 50);
        $toBlogId = $this->faker->numberBetween(1, 50);
        while ($fromBlogId ==  $toBlogId) {
            $fromBlogId = $this->faker->numberBetween(1, 50);
            $toBlogId = $this->faker->numberBetween(1, 50);
        }
        return [
            'from_blog_id' => $fromBlogId,
            'to_blog_id' => $toBlogId,
            'content' => $this->faker->sentence(4),
        ];
    }
}