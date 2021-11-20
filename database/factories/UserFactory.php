<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'age' => $this->faker->randomDigitNotZero(),
            'following_count' => $this->faker->randomDigit(),
            'likes_count' => $this->faker->randomDigit(),
            'login_options' => 'google',
            'email_activity_check' => $this->faker->boolean(),
            'TFA' => $this->faker->boolean(),
            'filtered_tags' => json_encode($this->faker->words()),
            'endless_scrolling' => $this->faker->boolean(),
            'show_badge' => $this->faker->boolean(),
            'text_editor' => $this->faker->randomElement(array('rich', 'plain/HTML', 'markdown')),
            'msg_sound' => $this->faker->boolean(),
            'best_stuff_first' => $this->faker->boolean(),
            'include_followed_tags' => $this->faker->boolean(),
            'conversational_notification' => $this->faker->boolean(),
            'filtered_content' => json_encode($this->faker->words()),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
