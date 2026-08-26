<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\States\StoryStatus\Completed;
use Nova\Stories\Models\Story;

class CompletedStoriesPostSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();
        activity()->disableLogging();

        $storyIds = Story::query()
            ->whereState('status', [Completed::class])
            ->pluck('id')
            ->all();

        if (! $storyIds) {
            activity()->enableLogging();

            return;
        }

        $ts = Date::now()->subMonths(2)->setMicrosecond(0)->toDateTimeString();

        DB::transaction(function () use ($storyIds, $ts): void {
            $buffer = [];

            $flush = function () use (&$buffer): void {
                collect($buffer)->chunk(1000)->each(
                    fn ($chunk) => DB::table('posts')->insert($chunk->toArray())
                );
                $buffer = [];
            };

            foreach ($storyIds as $storyId) {
                $count = mt_rand(10, 100);

                $rows = Post::factory()
                    ->count($count)
                    ->published()
                    ->make([
                        'story_id' => $storyId,
                        'created_at' => $ts,
                        'updated_at' => $ts,
                        'published_at' => $ts,
                    ])
                    ->map(function ($post) use ($storyId, $ts): array {
                        $attributes = $post->getAttributes();
                        $attributes['id'] = Str::uuid7()->toString();
                        $attributes['story_id'] = $storyId;
                        $attributes['created_at'] = $ts;
                        $attributes['updated_at'] = $ts;

                        if (array_key_exists('published_at', $attributes)) {
                            $attributes['published_at'] = $ts;
                        }

                        return $attributes;
                    })
                    ->all();

                array_push($buffer, ...$rows);

                if (count($buffer) >= 2000) {
                    $flush();
                }
            }

            $flush();
        });

        activity()->enableLogging();
    }
}
