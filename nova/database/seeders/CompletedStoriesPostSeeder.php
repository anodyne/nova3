<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\States\StoryStatus\Completed;
use Nova\Stories\Models\Story;

class CompletedStoriesPostSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        Story::query()
            ->whereState('status', [Completed::class])
            ->get()
            ->each(function (Story $story): void {
                Date::setTestNow(Date::now()->subMonths(2));

                Post::factory()
                    ->count(mt_rand(10, 100))
                    ->withStory($story)
                    ->published()
                    ->create();
            });

        activity()->enableLogging();
    }
}
