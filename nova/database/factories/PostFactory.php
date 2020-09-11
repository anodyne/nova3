<?php

namespace Database\Factories;

use Nova\Posts\Models\Post;
use Nova\Stories\Models\Story;
use Nova\PostTypes\Models\PostType;
use Nova\Posts\Models\States\Published;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        $word = $this->faker->word;

        return [
            'title' => $this->faker->words(3, true),
            'post_type_id' => fn () => PostType::factory(),
            'story_id' => fn () => Story::factory(),
            'content' => $this->faker->paragraphs(5, true),
            'status' => Published::class,
        ];
    }
}
