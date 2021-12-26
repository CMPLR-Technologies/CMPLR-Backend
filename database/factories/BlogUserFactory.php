<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlogUserFactory extends Factory
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
            'user_id' => $seedId,
            'blog_id' => $seedId,
        ];
    }
}
