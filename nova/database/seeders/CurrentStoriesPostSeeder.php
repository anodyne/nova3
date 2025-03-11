<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\States\StoryStatus\Current;
use Nova\Stories\Models\Story;

class CurrentStoriesPostSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $stories = Story::query()->whereState('status', [Current::class])->get();

        foreach ($stories as $story) {
            for ($d = 0; $d < 30; $d++) {
                Date::setTestNow(Date::now()->subDays($d));

                Post::factory()
                    ->count(mt_rand(0, 10))
                    ->withStory($story)
                    ->create();
            }
        }

        activity()->enableLogging();
    }
}
