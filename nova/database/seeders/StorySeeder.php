<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Stories\Models\Story;

class StorySeeder extends Seeder
{
    public function run()
    {
        $season1 = Story::factory()->ongoing()->create(['title' => 'Season 1', 'sort' => 0]);
        Story::factory()->upcoming()->create(['title' => 'Season 2', 'sort' => 1]);

        $episode1 = Story::factory()->completed()->create(['title' => 'Episode 1', 'parent_id' => $season1->id, 'sort' => 0]);
        Story::factory()->current()->create(['title' => 'Episode 2', 'parent_id' => $season1->id, 'sort' => 1]);
        Story::factory()->upcoming()->create(['title' => 'Episode 3', 'parent_id' => $season1->id, 'sort' => 2]);

        Story::factory()->completed()->create(['title' => 'Sub-Episode 1', 'parent_id' => $episode1->id, 'sort' => 0]);
        Story::factory()->completed()->create(['title' => 'Sub-Episode 2', 'parent_id' => $episode1->id, 'sort' => 1]);
    }
}
