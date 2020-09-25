<?php

namespace Nova\Posts\Livewire\Concerns;

use Nova\Stories\Models\Story;

trait HasStories
{
    public $allStories;

    public $story;

    public function setStory($storyId = null)
    {
        $this->dispatchBrowserEvent('dropdown-close');

        $this->story = Story::find($storyId);

        $this->getSuggestedPost();
    }

    protected function setInitialStory()
    {
        $this->story = $this->allStories->first();
    }
}
