<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $blog_name = $this->faker->unique()->word();
        $privacy = $this->faker->boolean();

        return [
            'blog_name' => $blog_name,
            'url' => env('APP_URL') . '/api/blog/' . $blog_name,
            'title' => $this->faker->name(),
            'public' => $this->faker->boolean(),
            'privacy' => $privacy,
            'password' => $privacy ? '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' : null, // password
        ];
    }
}