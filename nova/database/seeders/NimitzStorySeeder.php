<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Stories\Models\Story;

class NimitzStorySeeder extends Seeder
{
    public function run()
    {
        $timeline = Story::whereIsRoot()->first();

        $timeline->children()->createMany([
            Story::factory()->ongoing()->make(['title' => 'USS Sojourner', 'description' => ''])->toArray(),
        ]);

        $season1 = Story::whereTitle('USS Sojourner')->first();
        $season1->children()->createMany([
            Story::factory()->current()->make([
                'title' => 'To Boldly Go',
                'description' => "The crew of the Nimitz, still reeling from the resignation of Will Reardon, find out they've been assigned to a new ship with secrets and dangers none of them can imagine...",
            ])->toArray(),
            Story::factory()->upcoming()->make([
                'title' => 'Sojourner vs the Gods',
                'description' => "When a shuttle accident leaves several Sojourner crew stranded on a planet, the planet's residents think they're deities, but an alien race doesn't appreciate the intrusion.",
            ])->toArray(),
            Story::factory()->upcoming()->make([
                'title' => 'Salvaged',
                'description' => "A catastrophic accident on the Nimitz during her upgrades prompts Admiral Reardon to send the Sojourner back to a place the crew swore they'd never go again to salvage their dying ship.",
            ])->toArray(),
            Story::factory()->upcoming()->make([
                'title' => 'Search and Rescue',
                'description' => 'Following the cataclysmic events of the Hobus star supernova, the crew of the Sojourner rush to the aid of the Romulan Star Empire.',
            ])->toArray(),
        ]);
    }
}
