<?php

declare(strict_types=1);

namespace Database\Factories;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Nova\Characters\Models\Character;
use Nova\Stories\Enums\ContentRatingValue;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;
use Nova\Stories\Models\States\PostStatus\Draft;
use Nova\Stories\Models\States\PostStatus\Pending;
use Nova\Stories\Models\States\PostStatus\Published;
use Nova\Stories\Models\Story;
use Nova\Users\Models\User;

/** @extends Factory<Post> */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function configure(): static
    {
        return $this->afterCreating(function (Post $post): void {
            $maxAuthors = min(5, max(1, Character::with('users')->count()));
            $numberOfAuthors = random_int(1, $maxAuthors);

            $distributedWords = $this->distributeWordsRandomly($post->word_count, $numberOfAuthors);

            $users = [];

            for ($i = 0; $i < $numberOfAuthors; $i++) {
                $character = Character::with('users')->inRandomOrder()->first();

                if (! $character) {
                    $character = Character::factory()->create();
                }

                $user = $character->users->first();

                if (! $user) {
                    $user = User::active()->inRandomOrder()->first();

                    if (! $user) {
                        $user = User::factory()->active()->create();
                    }

                    $character->users()->attach($user->id, [
                        'primary' => true,
                    ]);
                }

                $users[] = $user->id;

                $post->characterAuthors()->attach($character->id, [
                    'user_id' => $user->id,
                    'word_count' => $distributedWords[$i],
                ]);
            }

            $post->participants = collect($users)->filter()->unique()->values()->all();
            $post->save();
        });
    }

    public function definition(): array
    {
        return [
            'title' => ucwords(rtrim(fake()->sentence(mt_rand(2, 8), variableNbWords: false), '.')),

            'post_type_id' => fn () => Arr::randomWeightedElement([
                1 => 50,
                2 => 30,
                3 => 5,
                4 => 15,
            ]),

            'story_id' => fn () => Story::factory(),

            'status' => fn () => Arr::randomWeightedElement([
                Draft::class => 25,
                Published::class => 75,
            ]),

            'content' => function (array $attributes) {
                $paragraphCount = match ($attributes['post_type_id'] ?? '') {
                    1 => mt_rand(100, 200),
                    2 => mt_rand(50, 100),
                    4 => mt_rand(3, 6),
                    default => mt_rand(1, 3),
                };

                return collect(range(1, $paragraphCount))
                    ->map(fn (): string => '<p>'.fake()->paragraph().'</p>')
                    ->implode('');
            },

            'word_count' => fn (array $attributes): int => str_word_count(strip_tags($attributes['content'])),

            'rating_language' => fn () => fake()->randomElement(ContentRatingValue::casesForRatings()),

            'rating_sex' => fn () => fake()->randomElement(ContentRatingValue::casesForRatings()),

            'rating_violence' => fn () => fake()->randomElement(ContentRatingValue::casesForRatings()),

            'published_at' => fn (array $attributes): ?CarbonInterface => $attributes['status'] === Published::class ? now() : null,

            'location' => fake()->randomElement([
                'Main Bridge',
                'Main Engineering',
                'Mess Hall',
                'Crew Quarters',
                'Armory',
                'Shuttlebay',
                'Earth',
                'Jupiter Station',
                'Sickbay',
                'Science Lab 2',
                'Jeffries Tubes',
            ]),

            'day' => str('Day ')->append((string) fake()->numberBetween(1, 5)),

            'time' => str(' hours')->prepend((string) fake()->time('Hi')),
        ];
    }

    public function draft(): static
    {
        return $this->state([
            'status' => Draft::class,
            'published_at' => null,
        ]);
    }

    public function markerPost(): static
    {
        return $this->state([
            'post_type_id' => PostType::where('key', 'marker')->first()->id,
        ]);
    }

    public function notePost(): static
    {
        return $this->state([
            'post_type_id' => PostType::where('key', 'note')->first()->id,
        ]);
    }

    public function pending(): static
    {
        return $this->state([
            'status' => Pending::class,
            'published_at' => null,
        ]);
    }

    public function personalPost(): static
    {
        return $this->state([
            'post_type_id' => PostType::where('key', 'personal')->first()->id,
            'day' => 'Day {fake()->numberBetween(1, 5)}',
            'time' => fake()->time('Hi').' hours',
            'location' => ucfirst(rtrim(fake()->sentence(3, variableNbWords: false), '.')),
        ]);
    }

    public function published(): static
    {
        return $this->state([
            'status' => Published::class,
            'published_at' => now(),
        ]);
    }

    public function storyPost(): static
    {
        return $this->state([
            'post_type_id' => PostType::where('key', 'post')->first()->id,
            'day' => 'Day {fake()->numberBetween(1, 5)}',
            'time' => fake()->time('Hi').' hours',
            'location' => ucfirst(rtrim(fake()->sentence(3, variableNbWords: false), '.')),
        ]);
    }

    public function withStory(?Story $story): static
    {
        return $this->state([
            'story_id' => $story->id ?? Story::factory(),
        ]);
    }

    /** @return list<int> */
    protected function distributeWordsRandomly(int $words, int $count): array
    {
        if ($count === 1) {
            return [$words];
        }

        // Generate random split points between 0 and total words
        $splitPoints = array_map(fn (): int => random_int(1, $words - 1), range(1, $count - 1));

        // Sort the points to create segments
        sort($splitPoints);

        // Compute segment sizes
        $distributedWords = [];
        $previous = 0;

        foreach ($splitPoints as $splitPoint) {
            $distributedWords[] = $splitPoint - $previous;
            $previous = $splitPoint;
        }

        // Add the last segment
        $distributedWords[] = $words - $previous;

        return $distributedWords;
    }
}
