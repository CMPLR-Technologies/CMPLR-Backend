<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tags = Tag::all()->pluck('name');
        $paragraphs = $this->faker->paragraphs(rand(2, 6));
        $title = $this->faker->realText(30);
        $content = "<h1>{$title}</h1>";
        foreach ($paragraphs as $para) {
            $content .= "<p>{$para}</p>";
        }
        $content .= "<img src=\"" . $this->faker->imageUrl() . "\">";
        $blog = Blog::inRandomOrder()->first();

        return [
            'type' => $this->faker->randomElement(['text', 'photos']),
            'content' => $content,
            'date' => Carbon::now()->toRfc850String(),
            'state' => 'publish',
            'source_content' => Str::random(10),
            'blog_id' => $blog->id,
            'blog_name' => $blog->blog_name,
            'tags' => $this->faker->randomElements($tags, 4),
            'post_ask_submit' => $this->faker->randomElement(['post', 'ask', 'submit'])
        ];
    }
}