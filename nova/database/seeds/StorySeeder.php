<?php

use Nova\Stories\Models\Story;
use Illuminate\Database\Seeder;
use Nova\Stories\Models\States\Current;
use Nova\Stories\Models\States\Upcoming;
use Nova\Stories\Models\States\Completed;

class StorySeeder extends Seeder
{
    public function run()
    {
        $timeline = Story::whereIsRoot()->first();

        $timeline->children()->createMany([
            factory(Story::class)->make(['title' => 'Season 1', 'status' => Current::class])->toArray(),
            factory(Story::class)->make(['title' => 'Season 2', 'status' => Upcoming::class])->toArray(),
        ]);

        $season1 = Story::whereTitle('Season 1')->first();
        $season1->children()->createMany([
            factory(Story::class)->make(['title' => 'Episode 1', 'status' => Completed::class])->toArray(),
            factory(Story::class)->make(['title' => 'Episode 2', 'status' => Current::class])->toArray(),
            factory(Story::class)->make(['title' => 'Episode 3', 'status' => Upcoming::class])->toArray(),
        ]);

        $episode1 = Story::whereTitle('Episode 1')->first();
        $episode1->children()->createMany([
            factory(Story::class)->make(['title' => 'Sub-Episode 1', 'status' => Completed::class])->toArray(),
            factory(Story::class)->make(['title' => 'Sub-Episode 2', 'status' => Completed::class])->toArray(),
        ]);
    }
}
