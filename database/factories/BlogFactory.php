<?php

namespace Database\Factories;

use Illuminate\Support\Str;
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

        return [
            'blog_name' => $blog_name,
            'url' => 'http://localhost:8000/api/blog/' . $blog_name,
            'title' => $this->faker->name(),
            'public' => $this->faker->boolean(),
            'privacy' => $this->faker->boolean(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }
}