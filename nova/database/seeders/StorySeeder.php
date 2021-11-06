<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Stories\Models\Story;

class StorySeeder extends Seeder
{
    public function run()
    {
        $timeline = Story::whereIsRoot()->first();

        $timeline->children()->createMany([
            Story::factory()->ongoing()->make(['title' => 'Season 1'])->toArray(),
            Story::factory()->upcoming()->make(['title' => 'Season 2'])->toArray(),
        ]);

        $season1 = Story::whereTitle('Season 1')->first();
        $season1->children()->createMany([
            Story::factory()->completed()->make(['title' => 'Episode 1'])->toArray(),
            Story::factory()->current()->make(['title' => 'Episode 2'])->toArray(),
            Story::factory()->upcoming()->make(['title' => 'Episode 3'])->toArray(),
        ]);

        $episode1 = Story::whereTitle('Episode 1')->first();
        $episode1->children()->createMany([
            Story::factory()->completed()->make(['title' => 'Sub-Episode 1'])->toArray(),
            Story::factory()->completed()->make(['title' => 'Sub-Episode 2'])->toArray(),
        ]);
    }
}
