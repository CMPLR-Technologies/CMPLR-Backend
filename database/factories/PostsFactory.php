<?php

namespace Database\Factories;

use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class PostsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $paragraphs = $this->faker->paragraphs(rand(2, 6));
        $title = $this->faker->realText(30);
        $content = "<h1>{$title}</h1>";
        foreach ($paragraphs as $para) {
            $content .= "<p>{$para}</p>";
        }
        $blog = Blog::inRandomOrder()->first();

        return [
            'type' => $this->faker->randomElement(['text', 'photos','quotes','chats','audio','videos']),
            'content' => $content,
            'date' => Carbon::now()->toRfc850String(),
            'state' => $this->faker->randomElement(['publish', 'private','draft']),
            'source_content' => Str::random(10),
            'blog_id'=>$blog->id,
            'blog_name'=>$blog->blog_name,
            'tags' => ['summer','winter']
        ];
    }
}
