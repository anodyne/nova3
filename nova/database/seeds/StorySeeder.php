<?php

use Illuminate\Database\Seeder;
use Nova\Stories\Models\States\Stories\Completed;
use Nova\Stories\Models\States\Stories\Current;
use Nova\Stories\Models\States\Stories\Upcoming;
use Nova\Stories\Models\Story;

class StorySeeder extends Seeder
{
    public function run()
    {
        factory(Story::class)->create([
            'title' => 'Season 1',
            'status' => Completed::class,
            'sort' => 1,
        ]);

        factory(Story::class)->create([
            'title' => 'Episode 1',
            'status' => Current::class,
            'sort' => 0,
            'story_id' => 1,
        ]);

        factory(Story::class)->create([
            'title' => 'Episode 2',
            'status' => Upcoming::class,
            'sort' => 1,
            'story_id' => 1,
        ]);

        factory(Story::class)->create([
            'title' => 'Season 0',
            'status' => Upcoming::class,
            'sort' => 0,
        ]);
    }
}
