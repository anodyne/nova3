<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Stories\Models\Story;

class StorySeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $season1 = Story::factory()->ongoing()->create(['title' => 'Season 1', 'order_column' => 1]);
        Story::factory()->upcoming()->create(['title' => 'Season 2', 'order_column' => 2]);

        $episode1 = Story::factory()->completed()->create(['title' => 'Episode 1', 'parent_id' => $season1->id, 'order_column' => 1]);
        Story::factory()->current()->create(['title' => 'Episode 2', 'parent_id' => $season1->id, 'order_column' => 2]);
        Story::factory()->upcoming()->create(['title' => 'Episode 3', 'parent_id' => $season1->id, 'order_column' => 3]);

        Story::factory()->completed()->create(['title' => 'Sub-Episode 1', 'parent_id' => $episode1->id, 'order_column' => 1]);
        Story::factory()->completed()->create(['title' => 'Sub-Episode 2', 'parent_id' => $episode1->id, 'order_column' => 2]);

        activity()->enableLogging();
    }
}
