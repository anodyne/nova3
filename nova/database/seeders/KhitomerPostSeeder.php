<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;

class KhitomerPostSeeder extends Seeder
{
    public function run(): void
    {
        activity()->disableLogging();

        $this->seedCompletedStories();

        activity()->enableLogging();
    }

    protected function seedCompletedStories(): void
    {
        Story::query()
            ->completed()
            ->whereNotNull('parent_id')
            ->get()
            ->each(function (Story $story): void {
                Post::factory()
                    ->count(mt_rand(500, 1_000))
                    ->published()
                    ->withStory($story)
                    ->create();
            });
    }
}
