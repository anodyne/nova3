<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;
use Nova\Stories\Models\States\PostStatus\Draft;
use Nova\Stories\Models\States\PostStatus\Pending;
use Nova\Stories\Models\States\PostStatus\Published;
use Nova\Stories\Models\Story;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        $word = $this->faker->word;

        $content = collect($this->faker->paragraphs($this->faker->numberBetween(10, 25)))
            ->map(fn ($line) => "<p>{$line}</p>")
            ->implode('');

        return [
            'title' => ucwords($this->faker->words(3, asText: true)),
            'post_type_id' => $this->faker->numberBetween(1, PostType::count()),
            'story_id' => fn () => Story::factory(),
            'content' => $content,
            'status' => Draft::class,
            'word_count' => str_word_count($content),
        ];
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

    public function storyPost()
    {
        return $this->state([
            'post_type_id' => PostType::where('key', 'post')->first()->id,
            'day' => "Day {$this->faker->numberBetween(1, 5)}",
            'time' => $this->faker->time('Hi').' hours',
            'location' => ucfirst($this->faker->words(3, true)),
        ]);
    }

    public function personalPost()
    {
        return $this->state([
            'post_type_id' => PostType::where('key', 'personal')->first()->id,
            'day' => "Day {$this->faker->numberBetween(1, 5)}",
            'time' => $this->faker->time('Hi').' hours',
            'location' => ucfirst($this->faker->words(3, true)),
        ]);
    }

    public function markerPost()
    {
        return $this->state([
            'post_type_id' => PostType::where('key', 'marker')->first()->id,
        ]);
    }

    public function notePost()
    {
        return $this->state([
            'post_type_id' => PostType::where('key', 'note')->first()->id,
        ]);
    }

    public function withStory(?Story $story)
    {
        return $this->state([
            'story_id' => $story?->id ?? Story::factory(),
        ]);
    }
}
