<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Migration;

use Illuminate\Support\Facades\Date;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Posts\Models\Post;
use Nova\Posts\Models\States\Draft;
use Nova\Posts\Models\States\Pending;
use Nova\Posts\Models\States\Published;
use Nova\PostTypes\Models\PostType;
use Nova\Setup\Models\Legacy\Mission as LegacyMission;
use Nova\Setup\Models\Legacy\MissionGroup as LegacyMissionGroup;
use Nova\Setup\Models\Legacy\Post as LegacyPost;
use Nova\Setup\Models\Upgrade;
use Nova\Stories\Models\States\Completed;
use Nova\Stories\Models\States\Ongoing;
use Nova\Stories\Models\States\Upcoming;
use Nova\Stories\Models\Story;

class MigrateMissionsAndPosts
{
    use AsAction;

    public function handle(): void
    {
        Post::truncate();
        Story::truncate();

        $notePostTypeId = PostType::where('key', 'note')->first()->id;
        $postPostTypeId = PostType::where('key', 'post')->first()->id;

        LegacyMissionGroup::orderBy('misgroup_order')
            ->cursor()
            ->each(function (LegacyMissionGroup $group) use ($notePostTypeId, $postPostTypeId) {
                $parent = Story::create([
                    'title' => $group->misgroup_name,
                    'description' => $group->misgroup_desc,
                    'status' => Completed::class,
                    'order_column' => $group->misgroup_order,
                ]);

                Upgrade::create([
                    'type' => 'mission-group',
                    'old_id' => $group->misgroup_id,
                    'new_id' => $parent->id,
                ]);

                $currentMissions = 0;
                $upcomingMissions = 0;

                $group->missions()
                    ->orderBy('mission_order')
                    ->cursor()
                    ->each(function (LegacyMission $mission) use ($parent, &$currentMissions, &$upcomingMissions, $notePostTypeId, $postPostTypeId) {
                        if ($mission->mission_status === 'current') {
                            $currentMissions += 1;
                        }

                        if ($mission->mission_status === 'upcoming') {
                            $upcomingMissions += 1;
                        }

                        $story = Story::create([
                            'title' => $mission->mission_title,
                            'description' => $mission->mission_desc,
                            'status' => $mission->mission_status,
                            'parent_id' => $parent->id,
                            'order_column' => $mission->mission_order,
                            'summary' => $mission->mission_summary,
                            'started_at' => $mission->mission_start ? Date::createFromTimestamp($mission->mission_start) : null,
                            'ended_at' => $mission->mission_end ? Date::createFromTimestamp($mission->mission_end) : null,
                        ]);

                        Upgrade::create([
                            'type' => 'mission',
                            'old_id' => $mission->mission_id,
                            'new_id' => $story->id,
                        ]);

                        $posts = [];

                        if (filled($mission->mission_notes)) {
                            $posts[] = [
                                'title' => 'Mission notes',
                                'story_id' => $story->id,
                                'post_type_id' => $notePostTypeId,
                                'status' => Published::class,
                                'content' => $mission->mission_notes,
                                'word_count' => str($mission->mission_notes)->pipe('strip_tags')->wordCount(),
                            ];

                            // TODO: need to set the author
                        }

                        $mission->posts()->orderBy('post_date')->cursor()->each(function (LegacyPost $post) use ($story, $postPostTypeId) {
                            $post = Post::create([
                                'title' => $post->post_title,
                                'location' => $post->post_location,
                                'time' => $post->post_timeline,
                                'story_id' => $story->id,
                                'post_type_id' => $postPostTypeId,
                                'status' => match ($post->post_status) {
                                    'saved' => Draft::class,
                                    'pending' => Pending::class,
                                    default => Published::class,
                                },
                                'content' => $post->post_content,
                                'word_count' => str($post->post_content)->pipe('strip_tags')->wordCount(),
                                'published_at' => $post->post_published,
                            ]);

                            // TODO: need to set the character and user authors

                            Upgrade::create([
                                'type' => 'post',
                                'old_id' => $post->post_id,
                                'new_id' => $post->id,
                            ]);
                        });
                    });

                if ($upcomingMissions > 0 && $currentMissions === 0) {
                    $parent->forceFill(['status' => Upcoming::class])->save();
                }

                if ($currentMissions > 0) {
                    $parent->forceFill(['status' => Ongoing::class])->save();
                }
            });
    }
}
