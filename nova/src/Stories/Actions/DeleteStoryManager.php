<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Story;

class DeleteStoryManager
{
    use AsAction;

    protected $deleteStory;

    protected $deleteStoryPosts;

    protected $moveStory;

    protected $moveStoryPosts;

    public function __construct(
        DeleteStory $deleteStory,
        DeleteStoryPosts $deleteStoryPosts,
        MoveStory $moveStory,
        MoveStoryPosts $moveStoryPosts
    ) {
        $this->deleteStory = $deleteStory;
        $this->deleteStoryPosts = $deleteStoryPosts;
        $this->moveStory = $moveStory;
        $this->moveStoryPosts = $moveStoryPosts;
    }

    public function handle(Request $request): void
    {
        $stories = collect(json_decode($request->actions, true));

        $stories->where('story.action', 'move')->each(function ($item, $id) {
            MoveStory::run(
                Story::find($id),
                Story::find(data_get($item, 'story.actionId'))
            );
        });

        $stories->where('posts.action', 'move')->each(function ($item, $id) {
            MoveStoryPosts::run(
                Story::find($id),
                Story::find(data_get($item, 'posts.actionId'))
            );
        });

        $stories->where('posts.action', 'delete')->each(function ($item, $id) {
            DeleteStoryPosts::run(Story::find($id));
        });

        /**
         * Stories being deleted need to be reversed so the parent isn't deleted
         * first which will cascade delete all descendants.
         */
        $stories->where('story.action', 'delete')->reverse()->each(function ($item, $id) {
            DeleteStory::run(Story::find($id));
        });
    }
}
