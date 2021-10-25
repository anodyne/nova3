<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Concerns;

use Nova\Stories\Models\Story;

trait HasStories
{
    public $allStories;

    public $story;

    public function setStory($value)
    {
        $this->story = Story::find($value);
    }

    protected function setInitialStory()
    {
        $this->story = $this->allStories->first();
    }
}
