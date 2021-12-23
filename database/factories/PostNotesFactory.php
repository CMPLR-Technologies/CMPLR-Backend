<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostNotesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = $this->faker->randomElement(array('like', 'reply', 'reblog'));
        $content =($type =='reply')?$this->faker->sentence(4): null;
        return [
            'user_id' => $this->faker->numberBetween(1 , 10),
            'post_id' => $this->faker->numberBetween(1 , 50),
            'type' => $this->faker->randomElement(array('like', 'reply', 'reblog')),
            'content'=>  $content ,
        ];
    }
}
