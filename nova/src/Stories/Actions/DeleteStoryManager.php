<?php

namespace Nova\Stories\Actions;

use Illuminate\Http\Request;
use Nova\Stories\Models\Story;
use Nova\Stories\Exceptions\StoryException;

class DeleteStoryManager
{
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

    public function execute(Request $request): void
    {
        $stories = collect(json_decode($request->actions, true));

        throw_if(
            $stories->keys()->contains(1),
            StoryException::cannotDeleteMainTimeline()
        );

        $stories->where('story.action', 'move')->each(function ($item, $id) {
            $this->moveStory->execute(
                Story::find($id),
                data_get($item, 'story.actionId')
            );
        });

        $stories->where('posts.action', 'move')->each(function ($item, $id) {
            $this->moveStoryPosts->execute(
                Story::find($id),
                Story::find(data_get($item, 'posts.actionId'))
            );
        });

        $stories->where('posts.action', 'delete')->each(function ($item, $id) {
            $this->deleteStoryPosts->execute(Story::find($id));
        });

        /**
         * Stories being deleted need to be reversed so the parent isn't deleted
         * first which will cascade delete all descendants.
         */
        $stories->where('story.action', 'delete')->reverse()->each(function ($item, $id) {
            $this->deleteStory->execute(Story::find($id));
        });

        Story::rebuildTree([]);
    }
}
