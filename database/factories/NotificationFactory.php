<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    protected $id =1 ;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $seedId = $this->id++ ;
        return [
            'from_blog_id'=>$seedId,
            'to_blog_id'=>$seedId,
            'type'=>$this->faker->randomElement(['follow','like' ,'reblog','ask','answer','reply']),
            'post_ask_answer_id'=> $seedId,
            'date'=>now()->subDays(rand(0,50)),
            'seen'=>$this->faker->randomElement([true,false]),
        ];
    }
}
