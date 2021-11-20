<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlogSettingsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'blog_id' => $this->faker->unique()->numberBetween(1, 10),
            'show_navigation' => $this->faker->boolean()
        ];
    }
}