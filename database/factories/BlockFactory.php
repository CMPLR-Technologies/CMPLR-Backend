<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlockFactory extends Factory
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
            'blog_id'=>$seedId,
            'blocked_blog_id'=>$seedId,
        ];
    }
}
