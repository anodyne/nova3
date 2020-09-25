<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Posts\Models\Post;
use Nova\Posts\Models\States\Draft;
use Nova\Posts\Models\States\Pending;
use Nova\Posts\Models\States\Published;
use Nova\PostTypes\Models\PostType;
use Nova\Stories\Models\Story;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        $word = $this->faker->word;

        $content = $this->faker->paragraphs(
            $this->faker->numberBetween(1, 10),
            true
        );

        return [
            'title' => ucwords($this->faker->words(3, true)),
            'post_type_id' => $this->faker->numberBetween(1, PostType::count()),
            'story_id' => fn () => Story::factory(),
            'content' => $content,
            'status' => Published::class,
            'word_count' => str_word_count($content),
            'published_at' => $this->faker->dateTimeThisYear(),
        ];
    }

    public function draft()
    {
        return $this->state([
            'status' => Draft::class,
            'published_at' => null,
        ]);
    }

    public function pending()
    {
        return $this->state([
            'status' => Pending::class,
            'published_at' => null,
        ]);
    }

    public function published()
    {
        return $this->state([
            'status' => Published::class,
            'published_at' => now(),
        ]);
    }

    public function post()
    {
        return $this->state([
            'post_type_id' => PostType::where('key', 'post')->first()->id,
            'day' => "Day {$this->faker->numberBetween(1, 5)}",
            'time' => $this->faker->time('Hi').' hours',
            'location' => ucfirst($this->faker->words(3, true)),
        ]);
    }

    public function personal()
    {
        return $this->state([
            'post_type_id' => PostType::where('key', 'personal')->first()->id,
            'day' => "Day {$this->faker->numberBetween(1, 5)}",
            'time' => $this->faker->time('Hi').' hours',
            'location' => ucfirst($this->faker->words(3, true)),
        ]);
    }

    public function marker()
    {
        return $this->state([
            'post_type_id' => PostType::where('key', 'marker')->first()->id,
        ]);
    }

    public function note()
    {
        return $this->state([
            'post_type_id' => PostType::where('key', 'note')->first()->id,
        ]);
    }
}
