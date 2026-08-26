<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\States\StoryStatus\Current;
use Nova\Stories\Models\Story;

class CurrentStoriesPostSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();
        activity()->disableLogging();

        $storyIds = Story::query()
            ->whereState('status', [Current::class])
            ->pluck('id')
            ->all();

        if (! $storyIds) {
            activity()->enableLogging();

            return;
        }

        DB::transaction(function () use ($storyIds): void {
            $buffer = [];

            $flush = function () use (&$buffer): void {
                DB::table('posts')->insert($buffer);
                $buffer = [];
            };

            foreach ($storyIds as $storyId) {
                for ($d = 0; $d < 30; $d++) {
                    $ts = Date::now()->subDays($d)->setMicrosecond(0)->toDateTimeString();

                    $count = mt_rand(0, 10);
                    if ($count === 0) {
                        continue;
                    }

                    $rows = Post::factory()
                        ->count($count)
                        ->make([
                            'story_id' => $storyId,
                            'created_at' => $ts,
                            'updated_at' => $ts,
                        ])
                        ->map(function ($post) use ($storyId, $ts) {
                            $attrs = $post->getAttributes();
                            $attrs['id'] = Str::uuid7()->toString();
                            $attrs['story_id'] = $storyId;
                            $attrs['created_at'] = $ts;
                            $attrs['updated_at'] = $ts;

                            return $attrs;
                        })
                        ->all();

                    array_push($buffer, ...$rows);

                    if (count($buffer) >= 1000) {
                        $flush();
                    }
                }
            }

            $flush();
        });

        activity()->enableLogging();
    }
}
