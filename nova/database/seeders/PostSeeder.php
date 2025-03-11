<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\States\StoryStatus\Completed;
use Nova\Stories\Models\States\StoryStatus\Current;
use Nova\Stories\Models\Story;

class PostSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        Story::query()
            ->whereState('status', [Current::class, Completed::class])
            ->get()
            ->each(function (Story $story): void {
                $factory = Post::factory()
                    ->count(mt_rand(10, 100))
                    ->withStory($story);

                $factory = match (true) {
                    $story->status->equals(Completed::class) => $factory->published(),
                    default => $factory,
                };

                $factory->create();
            });

        activity()->enableLogging();
    }
}
