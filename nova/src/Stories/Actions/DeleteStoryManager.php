<?php

namespace Nova\Stories\Actions;

use Illuminate\Http\Request;
use Nova\Stories\Models\Story;

class DeleteStoryManager
{
    protected $deleteStory;

    public function __construct(DeleteStory $deleteStory)
    {
        $this->deleteStory = $deleteStory;
    }

    public function execute(Request $request, Story $story): Story
    {
        // $story->stories->each->update(['parent_id' => $story->parent_id]);

        $story->posts->each->delete();

        $story = $this->deleteStory->execute($story);

        return $story;
    }
}
